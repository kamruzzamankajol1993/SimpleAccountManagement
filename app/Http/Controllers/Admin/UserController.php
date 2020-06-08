<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Agent;
use App\Labour;
use App\Executive;
use App\Document;
use App\Payment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;

class UserController extends Controller
{
     public function das()
    {
        $countUser=Customer::count();
        return view('user.home.home',['countUser'=>$countUser]);
    }

     public function dasad()
    {
        $totalcontract = Customer::sum('contact_amount');
        $totalad = Payment::sum('payment_amount');
        $totalpre = Payment::sum('previos_payment');
        $total=$totalad + $totalpre;
        $totaladpn = Customer::sum('advance_pending');
        $totaldue=$totalcontract - $total;
        $countUser=Customer::count();
        $urgents=Customer::all();
        return view('admin.home.home',['countUser'=>$countUser,'totalcontract'=>$totalcontract,'totalad'=>$totalad,'totaladpn'=>$totaladpn,'totaldue'=>$totaldue,'urgents'=>$urgents]);
    }


    public function index(){

        $states=User::all();

        return view('admin.agent.manage',['states'=>$states]);
    }

    public function indexa(){

        $states=User::where('role_id',2)->get();
        $users=Customer::where('status',0)->orderBy('id','desc')->get();
        return view('admin.agent.applist',['states'=>$states,'users'=>$users]);
    }


    public function destroy($id)
    {
         User::find($id)->delete();
         Toastr::warning('User Successfully Deleted :)','Warning');
         return redirect()->back();
    }

    public function approval($id)
              {
        $agent = User::find($id);
        if ($agent->role_id   == 0)
           {
            $agent->role_id = 2;
            $agent->save();
            Toastr::info('User Successfully Approved :)','Info');
           }
           
           return redirect()->back();
    }

     public function inactive($id)
              {
        $agent = User::find($id);
        if ($agent->role_id   == 2)
           {
            $agent->role_id = 0;
            $agent->save();
            Toastr::info('User Successfully Inactive :)','Info');
           }
           
           return redirect()->back();
    }


    public function create(){

        return view('admin.agent.add');
    }

    public function store(Request $request){
     
      $request->validate([
             'name'=>'required',
             'email'=>'required',
             'password'=>'required',
             'phone'=>'required',
             

              ]);

        $agent = new User();
        $agent->name=$request->name;
        $agent->phone = $request->phone;
        $agent->email = $request->email;
        $agent->password = Hash::make($request->password);
       
        $agent->save();

        Toastr::success('User Successully Added :)' ,'Success');
             return redirect()->back();
    }


    public function edit($id){
       
        $agent=User::find($id);
        return view('admin.agent.edit',['agent'=>$agent]);

    }

    public function update(Request $request){

      DB::table('users')->where('id',$request->id)->update(['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'password'=>Hash::make($request->password)]);
      Toastr::success('User Successfully Updated :)','Success');
        return redirect()->route('admin.user');
    }


    public function showa($id){
             $info=Customer::where('id',$id)->first();
             $labours=Labour::where('user_id',$id)->get();
             $executives=Executive::where('user_id',$id)->get();
             $files=Document::all();
            return view('admin.agent.datashow',['files'=>$files,'info'=>$info,'labours'=>$labours,'executives'=>$executives]);
    }

    public function destroya($id)
    {
        DB::table('customers')->where('id',$id)->delete();
        Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('admin.agent.user');
    }


     public function printa($id){
             $info=Customer::where('id',$id)->first();
             $labours=Labour::where('user_id',$id)->get();
             $executives=Executive::where('user_id',$id)->get();
             $files=Document::all();
            $pdf=PDF::loadView('admin.agent.print',['files'=>$files,'info'=>$info,'labours'=>$labours,'executives'=>$executives]);

            return $pdf->stream('Applicant_Information.pdf');
    }


}
