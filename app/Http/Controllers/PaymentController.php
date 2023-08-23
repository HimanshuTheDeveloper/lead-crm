<?php

namespace App\Http\Controllers;
use App\Exports\PaymentExport;
use App\Models\Amc;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Services;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
// use App\Models\Payment as ModelsPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    
    // created by @himanshuTheDeveloper

    function generateUniqueInvoiceCode($payment_id)
    {
        $payment = Payment::find($payment_id);
        $paymentYearNumber  = date("y", strtotime($payment->invoice_date));
        $paymentMonthNumber  = date("m", strtotime($payment->invoice_date));
        $post_invoice_code = $paymentYearNumber."-".$paymentMonthNumber. "-".$payment->id;  
        if($payment->invoice_type == 'gst'){
             $invoice_code = "B-".$post_invoice_code;  
        }
        if($payment->invoice_type == 'non_gst'){
            $invoice_code = "N-".$post_invoice_code;  
        }
        if($payment->invoice_type == 'export'){
            $invoice_code = "E-".$post_invoice_code;  
        }
        return  $invoice_code;
    }



    // created by @nishantTheProgrammer

    // function generateUniqueInvoiceCodeUpdated($payment_id)
    // {
    //     $payment = Payment::find($payment_id);
    //     $date = strtotime($payment->payment_date);
    //     $y = date('y', $date);
    //     $m = date('m', $date);
    //     return (['gst' => 'B-','non_gst' => 'N-','export' => 'E-'][$payment->invoice_type] ?? '').$y.'-'.$m.'-'.$payment->id;
    // }


    public function index()
    {
        $users= User::all();
        return view('payments.index',compact('users'));
    }
    public function add_payments()
    {
        $bdmUser = false;
        $bdeUser = false;
        foreach (Auth::user()->roles as $role) {
            if ($role->slug == "bdm") {
                $bdmUser = true;
            }
            if ($role->slug == "bde") {
                $bdeUser = true;
            }
        }
        $clients = Client::query();
        if($bdmUser){
            $clients = $clients->where('created_by', Auth::user()->id);
        }

        $clients =   $clients->get();
        $users = User::where("id" , "!=", Auth::user()->id)->get();
        return view('payments.add-payment', compact('clients','users'));
    }

    public function edit_payments($id)
    {
        $clients  = Client::all();
        $payment  = Payment::find($id);
        $services = Services::where('payment_fk_id',$id)->get();
        $users = User::where("id" , "!=", Auth::user()->id)->get();
        return view('payments.edit-payment', compact('payment','clients' ,'services' , 'users'));
    }

    public function save_payments(Request $request)
    {
        // return $request->all(); 

        $rules = [
            // 'invoice_id'  => 'required',
            'client' => 'required',
            'job_description' => 'required',
            'payment_date' => 'required',
            'invoice_date' => 'required',
            'invoice_type' => 'required',
        ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $payment = new Payment();

            if(Auth::user()->role == "admin"){
                $request->created_by != "none" ?  $created_by = $request->created_by : $created_by = Auth::user()->id;   
            }else{
                $created_by = Auth::user()->id;
            }


            $data = [
                // 'invoice_id'     => $request->invoice_id,
                'client'         => $request->client,
                'job_description'=> $request->job_description,
                'remarks'        => $request->remarks,
                'payment_date'   => $request->payment_date,
                'invoice_date'   => $request->invoice_date,
                'invoice_type'   => $request->invoice_type,
                'created_by'     => $created_by,
            ];

            $insert = $payment->insert($data);
            $lastInserted = Payment::orderBy('id', 'desc')->first();
            $dataservice = [];

            $total_amount = 0;

            foreach ($request->service_name as $key => $item) {
                $dataservice[] = [
                    'service_name'      => $request->service_name[$key],
                    'currency'          => $request->currency[0],
                    'amount'            => $request->amount[$key],
                    'service_remarks'   => $request->service_remarks[$key],
                    'payment_fk_id'     => $lastInserted->id
                ];
            
                $total_amount  = $total_amount + $request->amount[$key];
            }
            $pay = Payment::find($lastInserted->id);
            $pay->total_amount = $total_amount;
            $pay->currency = $request->currency[0];
            $pay->save();

            $lastInserted = Services::insert($dataservice);

            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.payments'),   'msg' => 'Payment created successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

    public function payment_list(Request $request)
    {

        // return $request->all();

        // dd($request->data['invoice_from_date']  . $request->data['invoice_to_date'] );
        // return $request->all();

        if (isset($request->search['value'])) {
            $search = $request->search['value'];
        } else {
            $search = '';
        }
        if (isset($request->length)) {
            $limit = $request->length;
        } else {
            $limit = 10;
        }
        if (isset($request->start)) {
            $ofset = $request->start;
        } else {
            $ofset = 0;
        }
        $orderType = $request->order[0]['dir'];
        $nameOrder = $request->columns[$request->order[0]['column']]['name'];

        $bdmUser = false;
        $bdeUser = false;

        foreach (Auth::user()->roles as $role) {
            if ($role->slug == "bdm") {
                $bdmUser = true;
            }
            if ($role->slug == "bde") {
                $bdeUser = true;
            }
        }
        $total = Payment::select('payments.*','clients.name', 'clients.email', 'users.status' ,'payments.remarks as payment_remark')
        ->join('clients', 'clients.id', '=', 'payments.client')
        ->join('users', 'payments.created_by', '=', 'users.id')
        ->Where(function ($query) use ($search) {
            $query->orWhere('payments.invoice_id', 'like', $search . '%');
            $query->orWhere('payments.job_description', 'like', $search . '%');
            $query->orWhere('payments.payment_status', 'like', $search . '%');
            $query->orWhere('payments.remarks', 'like', $search . '%');
            $query->orWhere('payments.payment_date', 'like', $search . '%');
            $query->orWhere('payments.invoice_date', 'like', $search . '%');
            $query->orWhere('payments.invoice_type', 'like', $search . '%');
            $query->orWhere('payments.currency', 'like', $search . '%');
            $query->orWhere('payments.total_amount', 'like', $search . '%');
            $query->orWhere('clients.name', 'like', $search . '%');
            $query->orWhere('users.name', 'like','%'. $search . '%');
            $query->orWhere('clients.email', 'like', $search . '%');
        });

        if ($bdmUser) {
            $total = $total->where('payments.created_by', Auth::user()->id);
        }

        if ($request->data['invoice_type'] != null  ) {
            $total = $total->where('payments.invoice_type', $request->data['invoice_type']);
        }
        if ($request->data['created_by'] != null) {
            $total = $total->where('payments.created_by', $request->data['created_by']);
        }
        if ($request->data['payment_status'] != null) {
            $total = $total->where('payments.payment_status', $request->data['payment_status']);
        }
        if ($request->data['invoice_from_date'] != null) {
            $total = $total->where('payments.invoice_date', '>', $request->data['invoice_from_date']);
        }
        if ($request->data['invoice_to_date'] != null) {
            $total = $total->where('payments.invoice_date', '<', $request->data['invoice_to_date']);
        }

        $total= $total->where('users.status', 'ACTIVE')->count();

        $payments = Payment::select('payments.*', 'payments.id as payment_id', 'clients.*' ,'clients.name', 'clients.email' , 'payments.remarks as payment_remark' , 'users.status','users.name as created_by_name')
                    ->join('clients', 'clients.id', '=', 'payments.client')
                    ->join('users', 'payments.created_by', '=', 'users.id')
                    ->Where(function ($query) use ($search) {
                        $query->orWhere('payments.invoice_id', 'like', $search . '%');
                        $query->orWhere('payments.job_description', 'like', $search . '%');
                        $query->orWhere('payments.payment_status', 'like', $search . '%');
                        $query->orWhere('payments.remarks', 'like', $search . '%');
                        $query->orWhere('payments.payment_date', 'like', $search . '%');
                        $query->orWhere('payments.invoice_date', 'like', $search . '%');
                        $query->orWhere('payments.invoice_type', 'like', $search . '%');
                        $query->orWhere('payments.currency', 'like', $search . '%');
                        $query->orWhere('payments.total_amount', 'like', $search . '%');
                        $query->orWhere('clients.name', 'like', $search . '%');
                        $query->orWhere('users.name', 'like', '%' .$search . '%');
                        $query->orWhere('clients.email', 'like', $search . '%');
                    });
                    

            if ($bdmUser) {
                $payments = $payments->where('payments.created_by', Auth::user()->id);
            }
            if ($request->data['invoice_type'] != null ) {
                $payments = $payments->where('payments.invoice_type', $request->data['invoice_type']);
            }
            if ($request->data['created_by'] != null  ) {
                $payments = $payments->where('payments.created_by', $request->data['created_by']);
            }
            if ($request->data['payment_status'] != null)  {
                $payments = $payments->where('payments.payment_status', $request->data['payment_status']);
            }
            if ($request->data['invoice_from_date'] != null) {
                $payments = $payments->where('payments.invoice_date', '>', $request->data['invoice_from_date']);
            }
            if ($request->data['invoice_to_date'] != null) {
                $payments = $payments->where('payments.invoice_date', '<', $request->data['invoice_to_date']);
            }

            if($orderType === 'desc' && $nameOrder === 'invoice_id'){
                $nameOrder = 'payments.id';
            }
            
        $payments = $payments->where('users.status', 'ACTIVE')->orderBy($nameOrder,$orderType)->limit($limit)->offset($ofset)->get();

        //   if($bdmUser){
        //         $payments = $payments->where('created_by', Auth::user()->id);
        //      }
        // if($bdeUser){
        //     $payments = $payments->where('created_by', Auth::user()->id);
        //  }

        $i = 1 + $ofset;
        $data = [];

        foreach ($payments as $key => $payment) {

            $user = User::find($payment->created_by);
            
            $invoice_id  = $this->generateUniqueInvoiceCode($payment->payment_id);

            $invoiceCreated =  Invoice::where("payment_fk_id", $payment->payment_id)->first();

            if($payment->invoice_id != null){
                $invoiceButton = '<a href="' . route('admin.invoice',$payment->payment_id) . '"class="px-3 py-1 btn-sm bg-success mb-2 text-white" ><i class="fa fa-file "></i></a>';
            }else{
                $invoiceButton = '<button type="button" class="px-3 py-1 btn-primary modalButton"  data-invoice_type="'.$payment->invoice_type.'"   data-payment_id="'.$payment->payment_id.'"  data-invoice_id="'.$invoice_id.'"    >Generate Invoice</button>';
            }
            
            $action = $invoiceButton .'<a href="' . route('admin.edit_payments', $payment->payment_id) . '"class="px-3 py-2 ml-2 btn-sm bg-info mb-2 text-white" id="editPayment"><i class="fas fa-edit"></i></a>
             <button class="px-3 py-1 ml-2 btn-sm btn-danger DeletePayment" id="DeletePayment" data-id="' . $payment->payment_id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $data[] = array(
                $payment->invoice_id != null ? $payment->invoice_id  : "N/A",
                '<p>'.$payment->name.'</p>'.'('.$payment->email.')',
                substr($payment->job_description ,0 , 15),
                substr( $payment->payment_remark ,0 , 15),
                date("d-m-Y", strtotime($payment->payment_date)),
                date("d-m-Y", strtotime($payment->invoice_date)),
                $payment->invoice_type,
                $payment->currency,
                $payment->total_amount,
                $payment->created_by_name,
                $payment->payment_status,
                $action,
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function update_payments(Request $request)
    {
        // return $request->all();
        $rules = [
            'payments_id'       => 'required',
            'client'            => 'required',
            'job_description'   => 'required',
            'payment_date'      => 'required',
            'invoice_date'      => 'required',
            'invoice_id'        => 'required|unique:payments,invoice_id,'.$request->payments_id,
        ];
        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
        return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
        exit;
    } else {
        $payment = Payment::find($request->payments_id);
        $delete = Services::where('payment_fk_id',$request->payments_id)->delete();

       

        $data = [
            'invoice_id'     => $request->invoice_id,
            'client'         => $request->client,
            'job_description'=> $request->job_description,
            'remarks'        => $request->remarks,
            'payment_date'   => $request->payment_date,
            'invoice_date'   => $request->invoice_date,
            'payment_status' => $request->payment_status,
        ];
        // dd($data);
        $insert = $payment->update($data);
        // return $lastInserted->id;
        $dataservice = [];
        if($delete)
        {
            $total_amount = 0;
            foreach ($request->service_name as $key=>$item) {
                $dataservice[] = [
                    'service_name'      => $request->service_name[$key],
                    'currency'          => $request->currency[$key],
                    'amount'            => $request->amount[$key],
                    'service_remarks'   => $request->service_remarks[$key],
                    'payment_fk_id'     => $request->payments_id
                ];

                $total_amount  = $total_amount + $request->amount[$key];
            }
            $insert = Services::insert($dataservice);  

            $pay = Payment::find($request->payments_id);
            $pay->total_amount = $total_amount;
            $pay->currency = $request->currency[0];
            $pay->save();

        }
        if ($insert) {
            return response()->json(array('status' => true,  'location' => route('admin.payments'),   'msg' => 'Payment updated successfully!!'));
        } else {
            return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
        }
    }
}

    public function payment_delete(Request $request)
    {
        $delete = Payment::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'msg' => "Payment Deleted successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error Occurred, Please try again"]);
            exit;
        }
    }

    public function invoice($id)
    {
        $payment    =   Payment::select('payments.*', 'clients.*')
                        ->join('clients', 'clients.id', '=', 'payments.client')
                        ->where("payments.id" , $id)->first(); 
        $services   =   Services::where('payment_fk_id',$id)->get();
        $currency   =   $services[0]->currency;
        $sum        =   $services->sum('amount');
        $payment['total_amount'] =  $sum;
        $data = array(
            'title' => 'Invoice' . $payment->invoice_id,
            'date' => date('d/m/Y'),
            'services' =>  $services,
            'currency' =>  $currency,
            'payment' => $payment,
        );

        $pdf = Pdf::loadView('payments.invoice', $data);
        return $pdf->download($payment->invoice_id.'.pdf');
    }


    public function saveInvoiceData(Request $request)
    {
        $rules = [
            'payment_id'       => 'required',
            'invoice_id'       => 'unique:payments,invoice_id',
            'payment_status'   => 'required',
            'invoice_type'     => 'required',
        ];
        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
             
                $payment = Payment::find($request->payment_id);
                $payment->invoice_id        =      $request->invoice_id;
                $payment->payment_status    =      $request->payment_status;
                $updated = $payment->save();
            }
            if ($updated) {
                return response()->json(array('status' => true,  'location' => route('admin.payments'), 'msg' => 'Invoice generated successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }

    
    public function getPaymentData()
    {
        return Excel::download(new PaymentExport, 'payments.xlsx');
    }

}
