<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;

class InvoiceController extends Controller
{
    public function index(Request $request){
        $authUser = Auth::user();

        $invoices = Payment::with('user', 'service');

        if($authUser->hasRole(['sadmin'])){
            
            if($request->page){
                $perPage = (integer) $request->page;
            }else{
                $perPage = 10;
            }
    
            if(!empty($request->search)){
                $search = $request->search;
                $invoices = $invoices->where(function($q) use ($search){
                    $q->where('order_id', 'like', '%' .$search. '%');
                    // $q->orWhere('code', 'like', '%' .$search. '%');
                });
            }
            $invoices = $invoices->latest()->paginate($perPage);

        }else if($authUser->hasRole(['vendor'])){

            $invoices = $invoices->latest()->where('vendor_id', $authUser->id)->get();
        }

        return view('invoice.index', compact('invoices'));
    }

    public function show($id){
        $authUser = Auth::user();

        $invoice = Payment::with('user', 'service.netFees', 'application.batch')->where('id', $id);

        if($authUser->hasRole(['sadmin'])){
            $invoice = $invoice->first();
        }else if($authUser->hasRole(['vendor'])){
            $invoice = $invoice->where('vendor_id', $authUser->id)->first();
        }

        return view('invoice.show', compact('invoice'));
    }
}
