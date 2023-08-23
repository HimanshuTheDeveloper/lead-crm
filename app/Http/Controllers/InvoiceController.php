<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoice.index');
    }
    public function invoice_list(Request $request)
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

        $total = Invoice::all()->count();

        $invoices = Invoice::select('invoices.*')
        ->Where(function ($query) use ($search) {
            $query->orWhere('invoices.invoice_number', 'like', $search . '%');
            // $query->orWhere('roles.slug', 'like', $search . '%');
        }
        );
            $invoices = $invoices->orderBy('id', $orderType)->limit($limit)->offset($ofset)
            ->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($invoices as $key => $invoice) {

            $action = '<a href="' . route('admin.edit_role', $invoice->id) . '" class="px-3 py-2 rounded btn-sm bg-info mb-2 text-white" id="editUser"><i class="fas fa-edit"></i></a> <button class="px-3 py-1 rounded btn-danger" id="DeleteRole" data-id="' . $invoice->id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $data[] = array(
                $invoice->invoice_number,
                $invoice->payment_status, // $category->parent_name->category_name,
                date("d-m-Y", strtotime( $invoice->created_at)),
                // $action,
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }
}
