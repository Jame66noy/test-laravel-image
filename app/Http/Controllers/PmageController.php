<?php

namespace App\Http\Controllers;

use App\Models\Pmage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PmageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pmages = Pmage::latest()->get();
        return ["pmages"=>"ການລາຍງານຂໍ້ມູນທັງໝົດ",$pmages];
        //return ["connect successfully"];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        //
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //dd($request);
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'about'   => 'required',
            'email' => 'required',
            'phone' => 'required',
            'name' => 'required',
        ],
        [

            'image.mimes' =>'ການລຸນາປ່ອນຟາຍປະເພດ: jpg, jpeg, png',
            'image.required' =>'ຮູບພາບຕ້ອງເປັນຮູບພາບ',
            'title.required'=>"ການລຸນາປ່ອນຂໍ້ມູນກ່ອນ",
            'about.required' => "ການລຸນປ່ອນລາຍລະອຽດກ່ອນ",
            'email.required' => "ການລຸນປ່ອນອີເມວກ່ອນ",
            'phone.required' => "ການລຸນປ່ອນເບີໂທກ່ອນ",
            'name.required' => "ການລຸນປ່ອນຊື່ກ່ອນ",

       ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        //ການເຂົ້າລະຫັດຮູບພາບ
        $image = $request->file('image');
       //dd($image);
        //Generate ຊີ່ຮູບພາບ
        $name_gen=hexdec(uniqid());
        //ຄຳສັ່ງດຶງນາມສະກຸນຟາຍພາບ
        $img_ext = strtolower($image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;

        //upload ແລະ ບັນທືກຂໍ້ມູນ
        $upload_location = 'image/picture/';
        $full_path = $upload_location.$img_name;

        //create
        $pmag = Pmage::create([
            'image' =>$full_path,
            'title' => $request->title,
            'about'   => $request->about,
            'email' =>$request->email,
            'phone' =>$request->phone,
            'name'  =>$request->name,
        ]);
        //return
        //return new TodoResource(true, 'Data Post Berhasil Ditambahkan!', $todos);
        $image->move($upload_location,$img_name);

        return ["pmag"=>"ການບັນທືກຂໍ້ມູນສຳເລັດ", $pmag, $image];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pmage  $pmage
     * @return \Illuminate\Http\Response
     */
    public function show(Pmage $pmage)
    {
        return ["pmage" => "ລາຍລະອຽດຂອງຂໍ້ມູນ", $pmage];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pmage  $pmage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)   //Pmage $pmage
    {
       $pmages = Pmage::find($id);
       return ["edit" => "ລາຍລະອຽດຂໍ້ມູນການແກ້ໄຂ", $pmages];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pmage  $pmage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Pmage $pmag, $id) //Request $request, Pmage $pmage
    {
       $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'about'   => 'required',
            'email' => 'required',
            'phone' => 'required',
            'name' => 'required',
        ],
        [
            'image.mimes' =>'ການລຸນາປ່ອນຟາຍປະເພດ: jpg, jpeg, png',
            'image.required' =>'ຮູບພາບຕ້ອງເປັນຮູບພາບ',
            'title.required'=>"ການລຸນາປ່ອນຂໍ້ມູນກ່ອນ",
            'about.required' => "ການລຸນປ່ອນລາຍລະອຽດກ່ອນ",
            'email.required' => "ການລຸນປ່ອນອີເມວກ່ອນ",
            'phone.required' => "ການລຸນປ່ອນເບີໂທກ່ອນ",
            'name.required' => "ການລຸນປ່ອນຊື່ກ່ອນ",
       ]);
      //dd($id);
        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        //ການເຂົ້າລະຫັດຮູບພາບ
        $image = $request->file('image');
       //dd($image);

       if($image != ''){
        //Generate ຊີ່ຮູບພາບ
        $name_gen=hexdec(uniqid());
        //ຄຳສັ່ງດຶງນາມສະກຸນຟາຍພາບ
        $img_ext = strtolower($image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;

        //upload ແລະ ບັນທືກຂໍ້ມູນ
        $upload_location = 'image/picture/';
        $full_path = $upload_location.$img_name;

        //create
        $pmag = Pmage::find($id)->update([
            'image' =>$full_path,
            'title' => $request->title,
            'about'   => $request->about,
            'email' =>$request->email,
            'phone' =>$request->phone,
            'name'  =>$request->name,
        ]);

        //error
        //dd($pmag);
         //ລົບພາບເກົ່າແລະລົບພາບໃໝ່ແທນທີ່
         //$old_image =$request->image;
         //$old_image2 = Pmage::find($id)->image;
         //dd($old_image);
        //$imp = unlink($oldd);
        //dd($imp);
         //unlink(storage_path('public/image/picture/'.$old_image));
         //error

         //$image->move($upload_location,$img_name);

         Storage::delete('public/image/picture'.$request->image);
        return ["pmag"=>"ການອັບເດດຂຂໍ້ມູນສຳເລັດ", $pmag,$image];
    }else{
        //ອັບເດດສະເພາະຊື່
              $pmages = Pmage::find($id)->update([
                'title' => $request->title,
                'about'   => $request->about,
                'email' =>$request->email,
                'phone' =>$request->phone,
                'name'  =>$request->name,
               ]);
               return ["pmages"=>"ການບັນທືກຂໍ້ມູນສຳເລັດ", $pmages];
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pmage  $pmage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)    //Pmage $pmage,
    {
        //ລົບພາບ
        $img = Pmage::find($id)->image;
        //dd($img);
        unlink($img);

        $delete = Pmage::find($id)->delete(); //ຄຳສັ່ງການລົບຂໍ້ມູນຈາກຖານຂໍ້ມູນ
        //$pmage->delete();

        return ["delete"=>"ລົບຂໍ້ມູນສຳເລັດ", $delete];
    }
}
