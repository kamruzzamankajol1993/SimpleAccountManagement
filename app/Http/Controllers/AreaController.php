<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\City;
use App\District;
use App\Thana;
use App\Ljob;
use App\Ejob;
use Brian2694\Toastr\Facades\Toastr;
use DB;
class AreaController extends Controller
{
    public function index(){

    	$states=State::latest()->get();
    	return view('admin.state.manage',['states'=>$states]);
    }


    public function create(){
     return view('admin.state.add');
    }

     public function store(Request $request)
    {
       $this->validate($request,[
            'state_name' => 'required'
          
        ]);
        $category = new State();
        $category->state_name = $request->state_name;
        $category->save();
        Toastr::success('Successfully Saved :)' ,'Success');
        return redirect()->route('state.create');
    }

    public function destroy($id)
    {
         State::find($id)->delete();
         Toastr::warning('Successfully Deleted :)','Success');
         return redirect()->back();
    }

     public function indexcity(){

    	$states=City::latest()->get();
    	return view('admin.city.manage',['states'=>$states]);
    }



    public function createcity(){

        $states=State::latest()->get();
    	return view('admin.city.add',['states'=>$states]);
    }

     public function storecity(Request $request)
    {
       $this->validate($request,[
            'state_id' => 'required',
             'city_name' => 'required'
        ]);
        $category = new City();
        $category->state_id = $request->state_id;
        $category->city_name = $request->city_name;
        $category->save();
        Toastr::success('Successfully Saved :)' ,'Success');
        return redirect()->route('city.create');
    }

    public function destroycity($id)
    {
         City::find($id)->delete();
         Toastr::warning('Successfully Deleted :)','Success');
         return redirect()->back();
    }

    public function indexdistrict(){

    	$states=District::latest()->get();
    	return view('admin.dis.manage',['states'=>$states]);
    }


    public function createdistrict(){
     return view('admin.dis.add');
    }

     public function storedistrict(Request $request)
    {
       $this->validate($request,[
            'dis_name' => 'required'
          
        ]);
        $category = new District();
        $category->dis_name = $request->dis_name;
        $category->save();
        Toastr::success('Successfully Saved :)' ,'Success');
        return redirect()->route('district.create');
    }

    public function destroydistrict($id)
    {
         District::find($id)->delete();
         Toastr::warning('Successfully Deleted :)','Success');
         return redirect()->back();
    }


    public function indexthana(){

    	$states=Thana::latest()->get();
    	return view('admin.thana.manage',['states'=>$states]);
    }



    public function createthana(){

        $states=District::latest()->get();
    	return view('admin.thana.add',['states'=>$states]);
    }

     public function storethana(Request $request)
    {
       $this->validate($request,[
            'dis_id' => 'required',
             'thana_name' => 'required'
        ]);
        $category = new Thana();
        $category->dis_id = $request->dis_id;
        $category->thana_name = $request->thana_name;
        $category->save();
        Toastr::success('Successfully Saved :)' ,'Success');
        return redirect()->route('thana.create');
    }

    public function destroythana($id)
    {
         Thana::find($id)->delete();
         Toastr::warning('Successfully Deleted :)','Success');
         return redirect()->back();
    }


     public function indexljob(){

        $states=Ljob::latest()->get();
        return view('admin.ljob.manage',['states'=>$states]);
    }


    public function createljob(){
     return view('admin.ljob.add');
    }

     public function storeljob(Request $request)
    {
       $this->validate($request,[
            'l_job' => 'required'
          
        ]);
        $category = new Ljob();
        $category->l_job = $request->l_job;
        $category->save();
        Toastr::success('Successfully Saved :)' ,'Success');
        return redirect()->route('ljob.create');
    }

    public function destroyljob($id)
    {
         Ljob::find($id)->delete();
         Toastr::warning('Successfully Deleted :)','Success');
         return redirect()->back();
    }

     

     public function findCityName(Request $request){

        $data=City::select('city_name')->where('state_id',$request->id)->get();
        return response()->json($data);
    }


    public function findThanaName(Request $request){

        $data=Thana::select('thana_name')->where('dis_id',$request->id)->get();
        return response()->json($data);
    }
}
