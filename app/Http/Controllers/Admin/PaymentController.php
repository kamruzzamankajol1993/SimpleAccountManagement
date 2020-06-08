<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\State;
use App\Address;
use App\District;
use App\Document;
use App\Payment;
use App\Receipt;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;

class PaymentController extends Controller
{
    public function index(){


     	$totalcontract = Customer::sum('contact_amount');
     	$totalad = Customer::sum('advance');
     	$totaladpns = Customer::latest()->get();

        $states=Payment::latest()->get();

     return view('admin.payment.manage',['states'=>$states,'totalcontract'=>$totalcontract,'totalad'=>$totalad,'totaladpns'=>$totaladpns ]);
    }


    public function create(){
        $sts=State::orderBy('dr','asc')->get();
        $products=Customer::orderBy('id','desc')->get();
        $cons=District::orderBy('dr','asc')->get();
        return view('admin.payment.add',['sts'=>$sts,'products'=>$products,'cons'=>$cons]);
    }


       public function store(Request $request){

    	$request->validate([
        'client_name'=>'required',
        'phone_number'=>'required',
        'previos_payment'=>'nullable',
        'payment_amount'=>'required',
        'contact_amount'=>'required',
        'payment_type'=>'required',
        'des'=>'required',
         ]);

    	$reg = new Payment();
        $reg->client_name = $request->client_name;
        $reg->phone_number = $request->phone_number;
        $reg->previos_payment = $request->previos_payment;
        $reg->payment_amount= $request->payment_amount;
        $reg->contact_amount = $request->contact_amount;
        $reg->payment_type= $request->payment_type;
        $reg->des = $request->des;
        $reg->save();
       
     Toastr::success('Successfully Saved :)' ,'Success');
        return redirect()->route('admin.payment');
        
          
    }


    public function destroy($id)
    {
        DB::table('payments')->where('id',$id)->delete();
        Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('admin.payment');
    }

    public function destroyr($id)
    {
        DB::table('receipts')->where('id',$id)->delete();
        Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('admin.payment');
    }

    public function edit($id){
        $sts=State::orderBy('dr','asc')->get();
        $products=Customer::orderBy('id','desc')->get();
        $cons=District::orderBy('dr','asc')->get();
        $post=Payment::find($id);
        return view('admin.payment.edit')->with(['post'=>$post,'sts'=>$sts,'products'=>$products,'cons'=>$cons]);

    }


      public function update(Request $request){
    	$reg = Payment::find($request->id);
        $reg->client_name = $request->client_name;
        $reg->phone_number = $request->phone_number;
        $reg->previos_payment = $request->previos_payment;
        $reg->payment_amount= $request->payment_amount;
        $reg->contact_amount = $request->contact_amount;
        $reg->payment_type= $request->payment_type;
        $reg->des = $request->des;
        $reg->save();
        Toastr::success('Successully Updated :)' ,'Success');
   	     return redirect('/admin/payment')->with('message','Updated Successfully');
    }

     public function findProductName(Request $request){

        $data=Customer::select('contact_amount')->where('id',$request->id)->get();
        return response()->json($data);
    }


    public function show($id){

        $totaladpns = Customer::latest()->get();
    	$contractAmount =Payment::where('id',$id)->value('contact_amount');
    	$previous_Amount =Payment::where('id',$id)->value('previos_payment');
    	$payment_Amount =Payment::where('id',$id)->value('payment_amount');
    	$total_Receive_Amount=$previous_Amount + $payment_Amount;
    	$total_Due=$contractAmount - $total_Receive_Amount;

        $post=Payment::find($id);
        return view('admin.payment.show')->with(['post'=>$post,'total_Receive_Amount'=>$total_Receive_Amount,'total_Due'=>$total_Due,'totaladpns'=>$totaladpns]);


    }


      public function print(Request $request){

      	$request->validate([
        'client_name'=>'required',
        'phone_number'=>'required',
        'previos_payment'=>'nullable',
        'payment_amount'=>'required',
        'contact_amount'=>'required',
        'due_amount'=>'required',
        'payment_type'=>'required',
        'des'=>'required',
         ]);

    	$reg = new Receipt();
        $reg->client_name = $request->client_name;
        $reg->c_id = $request->c_id;
        $reg->phone_number = $request->phone_number;
        $reg->previos_payment = $request->previos_payment;
        $reg->payment_amount= $request->payment_amount;
        $reg->contact_amount = $request->contact_amount;
        $reg->due_amount= $request->due_amount;
        $reg->receipt_number= rand(5,10);
         $reg->date= date('d-m-Y');
        $reg->payment_type= $request->payment_type;
        $reg->des = $request->des;
        $reg->save();
        $regid=$reg->id;
            $info=Receipt::where('id',$regid)->first();
            $pdf=PDF::loadView('admin.payment.print',['info'=>$info]);

            return $pdf->stream('Customer_Receipt.pdf');
    }


    public function rece($id){


      $receipts =Receipt::where('c_id',$id)->get();

      return view('admin.payment.rece')->with(['receipts'=>$receipts,]);



    }
}
