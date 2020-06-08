<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Labour;
use App\Executive;
use App\Document;
use Brian2694\Toastr\Facades\Toastr;
use DB;
use PDF;
use App\Address;

class CustomerController extends Controller
{
    public function index(){

    	$users=Customer::latest()->get();

    	return view('admin.user.manage',['users'=>$users]);
    }


    public function store(Request $request){

    	$request->validate([
        'fname'=>'required',
        'lname'=>'required',
        'phone'=>'required',
        'Wanumber'=>'required',
        'email'=>'required',
        'fb_id'=>'required',
        'pn'=>'required',
        'status_visa'=>'required',
        'city'=>'required',
        'dob'=>'required',
        'state'=>'required',
        'thana'=>'required',
        'district'=>'required',
        'vex'=>'nullable',
        'es'=>'nullable',
        'pex'=>'nullable',
        'labour_job'=>'nullable',
        'executive_job'=>'nullable',
        'experience'=>'required',
        'refrence_uae_name'=>'required',
        'refrence_uae_number'=>'required',
        'refrence_bd_name'=>'required',
        'refrence_bd_number'=>'required',
        ]);

    	$reg = new Customer();
        $reg->fname = $request->fname;
        $reg->lname = $request->lname;
        $reg->phone = $request->phone;
        $reg->fb_id = $request->fb_id;
        $reg->status_visa = $request->status_visa;
        $reg->Wanumber = $request->Wanumber;
        $reg->city = $request->city;
        $reg->es = $request->es;
        $reg->pn = $request->pn;
        $reg->created_at = $request->created_at;
        $reg->dob = $request->dob;
        $reg->state = $request->state;
        $reg->email = $request->email;
        $reg->thana = $request->thana;
        $reg->district = $request->district;
        $reg->vex = $request->vex;
        $reg->pex = $request->pex;
        $reg->experience = $request->experience;
        $reg->refrence_uae_name = $request->refrence_uae_name;
        $reg->refrence_uae_number = $request->refrence_uae_number;
        $reg->refrence_bd_name= $request->refrence_bd_name;
        $reg->refrence_bd_number= $request->refrence_bd_number;
        $reg->save();
        $regid=$reg->id;
        if($request->labour_job != Null){
            foreach($request->labour_job as $cat){
            $postCat=new Labour;
            $postCat->user_id=$regid;
            $postCat->labour_post_name=$cat;
            $postCat->save();
        }
        }
         
if($request->executive_job != Null){
         foreach($request->executive_job as $cat1){
            $postCat1=new Executive;
            $postCat1->user_id=$regid;
            $postCat1->executive_post_name=$cat1;
            $postCat1->save();
        }
    }
        Toastr::success('You Have Successully Registered,If you Have any Document Please Add :)' ,'Success');
        $info=Customer::where('id',$regid)->first();
        
            return view('front.file',['info'=>$info]);
        
          
    }

    public function createfile(){

    	$info=Customer::all();
        $addes=Address::limit(1)->orderBy('id','desc')->get();
            return view('front.file',['info'=>$info,'addes'=>$addes]);
    }

     protected function imageUpload($request){
     	if($request->hasfile('image')){
        $imagefile = $request->file('image');
        $imageName = $imagefile->getClientOriginalName();
        $extension = $imagefile->getClientOriginalExtension();
        //$imageName = $productImage->getClientOriginalName();
       
        $directory = 'public/user-file/';
        $imageUrl = $directory.$imageName;
    
        $imagefile->move($directory, $imageUrl);

        //Image::make($productImage)->resize(300,300)->save($imageUrl);

       return  $imageName;
   }else{
   	      $imageName= "Image not Found";
             return $imageName;
   }
    }


      protected function passUpload($request){
     	if($request->hasfile('passport_id')){
        $passfile = $request->file('passport_id');
        $passName = $passfile->getClientOriginalName();
        $extension = $passfile->getClientOriginalExtension();
        //$imageName = $productImage->getClientOriginalName();
       
        $directory = 'public/user-file/';
        $passUrl = $directory.$passName;
    
        $passfile->move($directory, $passUrl);

        //Image::make($productImage)->resize(300,300)->save($imageUrl);

       return  $passName;
   }else{
   	      $passName= "Passport not Found";
             return $passName;
   }
    }

     protected function doc1Upload($request){
     	if($request->hasfile('doc1')){
        $doc1file = $request->file('doc1');
        $doc1Name = $doc1file->getClientOriginalName();
        $extension = $doc1file->getClientOriginalExtension();
        //$imageName = $productImage->getClientOriginalName();
       
        $directory = 'public/user-file/';
        $doc1Url = $directory.$doc1Name;
    
        $doc1file->move($directory, $doc1Url);

        //Image::make($productImage)->resize(300,300)->save($imageUrl);

       return  $doc1Name;
   }else{
   	      $doc1Name= "Document1 not Found";
             return $doc1Name;
   }
    }

     protected function doc2Upload($request){
     	if($request->hasfile('doc2')){
        $doc2file = $request->file('doc2');
        $doc2Name = $doc2file->getClientOriginalName();
        $extension = $doc2file->getClientOriginalExtension();
        //$imageName = $productImage->getClientOriginalName();
       
        $directory = 'public/user-file/';
        $doc2Url = $directory.$doc2Name;
    
        $doc2file->move($directory, $doc2Url);

        //Image::make($productImage)->resize(300,300)->save($imageUrl);

       return  $doc2Name;
   }else{
   	      $doc2Name= "Document1 not Found";
             return $doc2Name;
   }
    }



     protected function savefile($request, $imagefile,$passfile,$doc1file,$doc2file){
     	$audio = new Document();
        $audio->user_id=$request->user_id;
        $audio->image = $imagefile;
        $audio->passport_id = $passfile;
        $audio->doc1 = $doc1file;
        $audio->doc2 = $doc2file;
        if($audio->save()){
        	Toastr::success('Document Successully Added :)' ,'Success');
            return redirect('/success');

        }

    }

    public function storefile(Request $request){
        $request->validate([
            'user_id'=>'required',
            'image'=>'nullable',
            'passport_id'=>'nullable',
            'doc1'=>'nullable',
             'doc2'=>'nullable',
        ]);
         $imagefile = $this->imageUpload($request);
         $passfile = $this->passUpload($request);
         $doc1file = $this->doc1Upload($request);
         $doc2file = $this->doc2Upload($request);
        $this->savefile($request, $imagefile,$passfile,$doc1file,$doc2file);

       return redirect('/success');
    }

    public function success(){
        $addes=Address::limit(1)->orderBy('id','desc')->get();
    	return view('front.success',['addes'=>$addes]);
    }


    public function show($id){
    	     $info=Customer::where('id',$id)->first();
             $labours=Labour::where('user_id',$id)->get();
             $executives=Executive::where('user_id',$id)->get();
             $files=Document::all();
            return view('admin.user.datashow',['files'=>$files,'info'=>$info,'labours'=>$labours,'executives'=>$executives]);
    }

    public function destroy($id)
    {
        DB::table('customers')->where('id',$id)->delete();
        Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('user');
    }


     public function print($id){
             $info=Customer::where('id',$id)->first();
             $labours=Labour::where('user_id',$id)->get();
             $executives=Executive::where('user_id',$id)->get();
             $files=Document::all();
            $pdf=PDF::loadView('admin.user.print',['files'=>$files,'info'=>$info,'labours'=>$labours,'executives'=>$executives]);

            return $pdf->stream('Applicant_Information.pdf');
    }


}
