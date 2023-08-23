<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseExport;
use App\Exports\PaymentExport;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    //
    public function expense()
    {
        return view("expense.index");
    }
    public function addExpense()
    {
        return view("expense.add-expense");
    }
    public function editExpense($id)
    {
        $data = Expense::find($id);
        return view("expense.edit-expense" , compact('data'));
    }

    // saveExpense

    public function saveExpense(Request $request)
    {
        $rules = [
            'type'      =>        'required',
            'currency'          =>        'required',
            'date'              =>        'required',
            'amount'            =>        'required',
        ];
        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $expense = new Expense();
            $data =[
                'type'        =>        $request->type,
                'date'        =>        date('Y-m-d',strtotime($request->date)),
                'currency'    =>        $request->currency,
                'amount'      =>        $request->amount,
                'remarks'      =>       $request->remarks,
            ];
            $insert = $expense->insert($data);
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.expense'),'msg' => 'Expense created successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

    public function updateExpense(Request $request ,Expense $expense)
    {
        $rules = [
            'id'  =>'required',
        ];
        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $expense = Expense::find($request->id);
            $data =[
                'type'        =>  $request->type,
                'date'        =>  $request->date,
                'currency'    =>  $request->currency,
                'amount'      =>  $request->amount,
                'remarks'     =>  $request->remarks,
            ];
            $updated = $expense->update($data);
            if ($updated) {
                return response()->json(array('status' => true,  'location' => route('admin.expense'),   'msg' => 'Expense Updated successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

//     public function updateExpense(Request $request ,Expense $expense)
// {
//     $rules = [
//         'id'  =>'required',
//     ];

//     $val = Validator::make($request->all(), $rules);
//     if ($val->fails()) {
//         return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
//         exit;
//     } else {
//         $user = Expense::findorFail($request->id);
//         $data = [
//             'type'        =>  $request->type,
//                 'date'        =>  $request->date,
//                 'currency'    =>  $request->currency,
//                 'amount'      =>  $request->amount
//         ];
//         $insert = $user->update($data);
//         if ($insert) {
//             return response()->json(array('status' => true,  'location' => route('admin.expense'),   'msg' => 'Profile updated successfully!!'));
//         } else {
//             return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
//         }
//     }
// }

    

    public function expenseList(Request $request)
    {
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
        
        
        $total_amount = Expense::select('amount')->sum('amount');
        
        $total = Expense::select('expenses.*')
        ->Where(function ($query) use ($search) {
            $query->orWhere('expenses.type', 'like', $search . '%');
            $query->orWhere('expenses.date', 'like', $search . '%');
            $query->orWhere('expenses.amount', 'like', $search . '%');
            $query->orWhere('expenses.currency', 'like', $search . '%');
        });
        $total= $total->count();

        $expenses = Expense::select('expenses.*')
            ->Where(function ($query) use ($search) {
                $query->orWhere('expenses.type', 'like', $search . '%');
                $query->orWhere('expenses.date', 'like', $search . '%');
                $query->orWhere('expenses.amount', 'like', $search . '%');
                $query->orWhere('expenses.currency', 'like', $search . '%');
            });

            if ($request->data['from_date'] != null) {
                $expenses = $expenses->where('expenses.date', '>=', $request->data['from_date']);
            }
            if ($request->data['to_date'] != null) {
                $expenses = $expenses->where('expenses.date', '<=', $request->data['to_date']);
            }
        $expenses = $expenses->orderBy('expenses.id',$orderType)->limit($limit)->offset($ofset)->get();

        $i = 1 + $ofset;
        $data = [];

        foreach ($expenses as $key => $expense) {
            $action = '<a href="' . route('admin.editExpense', $expense->id) . '" class="px-3 py-2 rounded btn-sm bg-info mb-2 text-white" id="editClient"><i class="fas fa-edit"></i></a>
            <button class="px-3 py-1 rounded btn-sm btn-danger deleteExpense" id="" data-id="' . $expense->id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            
             $data[] = array(
                $expense->type,
                date("d-m-Y", strtotime($expense->date)),
                $expense->currency,
                $expense->amount,
                $expense->remarks,
                $action,
            );
        }
        $records['recordsTotal'] =$total;
        $records['recordsFiltered'] =$total;
        $records['data'] = $data;
          $records['total_amount'] =$total_amount;
        echo json_encode($records);
    }


    public function delete_expense(Request $request)
    {
        $delete = Expense::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'msg' => "Expense Deleted Successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error Occurred, Please try again"]);
            exit;
        }
    }

    public function expenseExport()
    {
        return Excel::download(new ExpenseExport, 'expense.xlsx');
    }

}
