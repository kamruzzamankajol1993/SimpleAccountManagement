<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\District;
use Brian2694\Toastr\Facades\Toastr;
use DB;

class CountryController extends Controller
{
    public function index(){

        $states=District::orderBy('dr','asc')->get();
        return view('admin.country.manage',['states'=>$states]);
    }


    public function create(){
     return view('admin.country.add');
    }

     public function store(Request $request)
    {
       $this->validate($request,[
            'country_name' => 'required'
          
        ]);
        $category = new District();
        $category->country_name = $request->country_name;
        $category->save();
        Toastr::success('Successfully Saved :)' ,'Success');
        return redirect()->route('admin.country.create');
    }

    public function destroy($id)
    {
         District::find($id)->delete();
         Toastr::warning('Successfully Deleted :)','Success');
         return redirect()->back();
    }
}
