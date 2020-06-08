<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Address;

use Brian2694\Toastr\Facades\Toastr;
use DB;


class ProductController extends Controller
{
     public function index(){

        $states=Address::orderBy('dr','asc')->get();
        return view('admin.product.manage',['states'=>$states]);
    }


    public function create(){
     return view('admin.product.add');
    }

     public function store(Request $request)
    {
       $this->validate($request,[
            'product_type' => 'required'
          
        ]);
        $category = new Address();
        $category->product_type = $request->product_type;
        $category->save();
        Toastr::success('Successfully Saved :)' ,'Success');
        return redirect()->route('admin.product.create');
    }

    public function destroy($id)
    {
         Address::find($id)->delete();
         Toastr::warning('Successfully Deleted :)','Success');
         return redirect()->back();
    }
}
