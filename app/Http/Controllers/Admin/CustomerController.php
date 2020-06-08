<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\State;
use App\Address;
use App\District;
use App\Document;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;

class CustomerController extends Controller
{
     public function index(){


     	$totalcontract = Customer::sum('contact_amount');
     	$totalad = Customer::sum('advance');
     	$totaladpn = Customer::sum('advance_pending');

        $states=Customer::latest()->get();

     return view('admin.customer.manage',['states'=>$states,'totalcontract'=>$totalcontract,'totalad'=>$totalad,'totaladpn'=>$totaladpn ]);
    }


    public function create(){
        $sts=State::orderBy('dr','asc')->get();
        $products=Address::orderBy('dr','asc')->get();
        $cons=District::orderBy('dr','asc')->get();
        return view('admin.customer.add',['sts'=>$sts,'products'=>$products,'cons'=>$cons]);
    }


       public function store(Request $request){

    	$request->validate([
        'product_type'=>'required',
        'content_type'=>'required',
        'name'=>'required',
        'country'=>'required',
        'contact_amount'=>'required',
        'advance'=>'required',
        
        'o_date'=>'nullable',
        'h_o_date'=>'nullable',
        'status'=>'required',
        'domain_name'=>'required',
        'mail'=>'required',
        'cname'=>'required',
        'com'=>'nullable',
        
        ]);

    	$reg = new Customer();
        $reg->product_type = $request->product_type;
        $reg->content_type = $request->content_type;
        $reg->name = $request->name;
        $reg->country = $request->country;
        $reg->contact_amount = $request->contact_amount;
        $reg->advance = $request->advance;
        $reg->alert_date = $request->alert_date;
        $reg->o_date = $request->o_date;
        $reg->h_o_date = $request->h_o_date;
        $reg->status = $request->status;
        $reg->domain_name= $request->domain_name;
        $reg->mail = $request->mail;
        $reg->cname = $request->cname;
        $reg->com = $request->com;
        $reg->save();
       
     Toastr::success('Successfully Saved :)' ,'Success');
        return redirect()->route('admin.customer');
        
          
    }


    public function destroy($id)
    {
        DB::table('customers')->where('id',$id)->delete();
        Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('admin.customer');
    }

    public function edit($id){
        $sts=State::orderBy('dr','asc')->get();
        $products=Address::orderBy('dr','asc')->get();
        $cons=District::orderBy('dr','asc')->get();
        $post=Customer::find($id);
        return view('admin.customer.edit')->with(['post'=>$post,'sts'=>$sts,'products'=>$products,'cons'=>$cons]);

    }


      public function update(Request $request){
    	$reg = Customer::find($request->id);
        $reg->product_type = $request->product_type;
        $reg->content_type = $request->content_type;
        $reg->name = $request->name;
        $reg->country = $request->country;
        $reg->contact_amount = $request->contact_amount;
        $reg->advance = $request->advance;
        $reg->advance_pending = $request->advance_pending;
        $reg->o_date = $request->o_date;
        $reg->h_o_date = $request->h_o_date;
        $reg->status = $request->status;
        $reg->domain_name= $request->domain_name;
        $reg->mail = $request->mail;
        $reg->cname = $request->cname;
        $reg->com = $request->com;
        $reg->save();
        Toastr::success('Successully Updated :)' ,'Success');
   	     return redirect('/admin/customer')->with('message','Updated Successfully');
    }
}
