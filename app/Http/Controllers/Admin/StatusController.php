<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\State;
use Brian2694\Toastr\Facades\Toastr;
use DB;

class StatusController extends Controller
{
    public function index(){

        $states=State::orderBy('dr','asc')->get();
        return view('admin.status.manage',['states'=>$states]);
    }


    public function create(){
     return view('admin.status.add');
    }

     public function store(Request $request)
    {
       $this->validate($request,[
            'status_name' => 'required'
          
        ]);
        $category = new State();
        $category->status_name= $request->status_name;
        $category->save();
        Toastr::success('Successfully Saved :)' ,'Success');
        return redirect()->route('admin.status.create');
    }

    public function destroy($id)
    {
         State::find($id)->delete();
         Toastr::warning('Successfully Deleted :)','Success');
         return redirect()->back();
    }
}
