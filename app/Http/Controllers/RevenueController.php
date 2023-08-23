<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    //
    public function revenue()
    {
        $users= User::whereIn('role',["bdm","admin"])->get();
        return view('dashboard.revenue',compact('users'));
    }

    public function revenueData(Request $request)
    {  

        // return $request->payment_status;
        $payments = Payment::select('payments.*' , 'clients.email', 'users.name as created_by_name')
        ->join('clients', 'payments.client', '=', 'clients.id')
        ->join('users', 'payments.created_by', '=', 'users.id');

        if($request->from_date)
        {
            $payments = $payments->where('payments.payment_date','>',$request->from_date);
        }
        if($request->to_date)
        {
            $payments = $payments->where('payments.payment_date','<',$request->to_date);
        }
        if($request->payment_status)
        {
            $payments = $payments->where('payments.payment_status',$request->payment_status);
        }
        if($request->user !="0")
        {
            $payments = $payments->where('payments.created_by',$request->user);
        }
       
        $payments = $payments->get();

        // return $payments;

        $groupedCurrencies = Payment::select('payments.*');
        if($request->from_date)
        {
            $groupedCurrencies = $groupedCurrencies->where('payments.payment_date','>',$request->from_date);
        }
        if($request->to_date)
        {
            $groupedCurrencies = $groupedCurrencies->where('payments.payment_date','<',$request->to_date);
        }
        if($request->user !="0")
        {
            $groupedCurrencies = $groupedCurrencies->where('payments.created_by',$request->user);
        }
        
        $groupedCurrencies = $groupedCurrencies->distinct('currency')->pluck('currency','currency');

        // return  $groupedCurrencies ;

        $revenue = array();
            foreach( $groupedCurrencies  as $key=>$groupedCurreny ){
                $total = Payment::query();
                if($request->from_date)
                {
                    $total = $total->where('payments.payment_date','>',$request->from_date);
                }
                if($request->to_date)
                {
                    $total = $total->where('payments.payment_date','<',$request->to_date);
                }
                if($request->user !="0")
                {
                    $total = $total->where('payments.created_by',$request->user);
                }
                $total = $total->where('currency',$groupedCurreny)->sum('total_amount');

                $revenue[$key]['revenueAmount']= $total;
                $revenue[$key]['currency'] = $groupedCurreny;
            }
            $data = array();
            $data['revenue'] = $revenue;
            $data['payments'] = $payments;

            //    return  $data;
   
        if(count($data['payments']) > 0){
            return response()->json(array('status' => true,  'data' => $data));
        } else {
            return response()->json(array('status' => false, 'msg' => 'No Payments Details Available!'));
        }
    }


}
