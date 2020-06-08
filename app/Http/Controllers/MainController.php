<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Brian2694\Toastr\Facades\Toastr;
use DB;
use App\Address;
use App\State;
use App\District;


class MainController extends Controller
{
    public function index(){

      
    	return view('admin.login');
    }


    public function updateItems2(Request $request)
    {
        

        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));
            
            foreach($arr as $sortOrder => $id){
                $menu = Address::find($id);
                $menu->dr = $sortOrder;
                $menu->save();
            }
            return ['success'=>true,'message'=>'Updated'];
        }
  
    }

       public function updateItems(Request $request)
    {
        

        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));
            
            foreach($arr as $sortOrder => $id){
                $menu = State::find($id);
                $menu->dr = $sortOrder;
                $menu->save();
            }
            return ['success'=>true,'message'=>'Updated'];
        }
  
    }

     public function updateItems1(Request $request)
    {
        

        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));
            
            foreach($arr as $sortOrder => $id){
                $menu = District::find($id);
                $menu->dr = $sortOrder;
                $menu->save();
            }
            return ['success'=>true,'message'=>'Updated'];
        }
  
    }

  
}
