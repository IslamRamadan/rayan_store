<?php

namespace App\Http\Controllers\Backend;

use App\Catering;
use App\CateringImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CateringController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Catering::latest()->get();
            return DataTables::of($data)
                ->addColumn('image', function ($artist) {
                    $url = asset('/storage/' . $artist->image);
                    return $url;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {


                    $action = '
                    <a class="btn btn-success"  href="' . route('caterings.edit', $row->id) . '" >' . \Lang::get('site.edit') . ' </a>
                    <a class="btn btn-info"  href="' . route('caterings.show', $row->id) . '" >' . \Lang::get('site.show') . ' </a>

                        <a class="btn btn-outline-dark"  href="' . route('catering_galaries.index', $row->id) . '" >' . \Lang::get('site.images') . ' </a>
                      <meta name="csrf-token" content="{{ csrf_token() }}">
                         <a  href="' . route('caterings.delete', $row->id) . '" class="btn btn-danger">' . \Lang::get('site.delete') . '</a>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.caterings.index');
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.caterings.create');
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messeges = [
            'image.required' => "صورة الخدمة مطلوبة",
            'image.mimes' => " يجب ان تكون الصورة jpg او jpeg او png  ",
            'image.max' => " الحد الاقصي للصورة 4 ميجا ",
            'img.required'=>" الصورة مطلوبة",
            'img.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png ",
            'img.max'=>" الحد الاقصي للصورة 4 ميجا ",
            'desc_en.required'=>'الوصف باللغه الانجليزيه مطلوب',
            'desc_ar.required'=>'الوصف باللغه العربيه مطلوب',
            'title_ar.required'=>'الاسم باللغه العربيه مطلوب',
            'title_en.required'=>'الاسم باللغه الانجليزيه مطلوب',
        ];

        $validator = Validator::make($request->all(), [
            'title_en'=>'required',
            'title_ar'=>'required',
            'desc_en'=>'required',
            'desc_ar'=>'required',
            'hint_ar'=>'required',
            'hint_en'=>'required',
            'requirement_ar'=>'required',
            'requirement_en'=>'required',
            'persons_no'=>'required',
            'price'=>'required',
            'setup_time'=>'required',
            'max_time'=>'required',
            'ad_hour_price'=>'required',
            'ad_person_price'=>'required',
            'ad_service_price'=>'required',
            'ad_service_ar'=>'required',
            'ad_service_en'=>'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:4100',
            "img"=>"required",
            'img.*' => 'mimes:jpg,jpeg,png|max:4100',
        ], $messeges);

        if ($validator->fails()) {
            Alert::error('error', $validator->errors()->first());
            return back()->withInput();
        }
        if (!$request->hasfile('image')){
            Alert::success('error ', 'لم تقم بتحميل اي صورة');
            return back();
        }
        $imgs = $request->img ;
        if(count($imgs) >10 ){
            Alert::success('error ', 'الحد الاقصي للتحميل في المرة الواحدة 10 صور');
            return back();
        }

        $image = $request->image;
        $original_name = strtolower(trim($image->getClientOriginalName()));
        $file_name = time() . rand(100, 999) . $original_name;
        $path = 'uploads/caterings/images/';

        if (!Storage::exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }
        $img = \Image::make($image)->resize(480 , 320);
        $img->save(public_path('storage/' . $path . $file_name), 90);

        $inputs = $request->all();
        $inputs['image'] = $path . $file_name;
        $catering = Catering::create($inputs);

        if ($request->has('img') ) {
            if (count($request->img) > 0) {
                foreach($imgs as $img){
                    $new_name_img = time().uniqid().".".$img->getClientOriginalExtension();
                    $img1 = \Image::make($img)->resize(480,320);
                    $img1->save(public_path('upload/advertising/'.$new_name_img),90);
                    CateringImage::create([
                        "image"=>  "upload/advertising/".$new_name_img ,
                        "catering_id"=>$catering->id
                    ]);
                }
            }
        }

        if (session()->has("success")) {
            Alert::success('Success ', 'Success Message');
        }
        return redirect()->route('caterings.index');
    }

      /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $catering = Catering::findOrFail($id);

             return view('/dashboard/caterings/edit', compact('catering'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //    dd($request->all());
        $messeges = [
            'desc_en.required'=>'الوصف باللغه الانجليزيه مطلوب',
            'desc_ar.required'=>'الوصف باللغه العربيه مطلوب',
            'title_ar.required'=>'الاسم باللغه العربيه مطلوب',
            'title_en.required'=>'الاسم باللغه الانجليزيه مطلوب',
            'image.mimes' => " يجب ان تكون الصورة jpg او jpeg او png  ",
            'image.max' => " الحد الاقصي للصورة 4 ميجا ",

        ];

        $validator = Validator::make($request->all(), [
            'title_en'=>'required',
            'title_ar'=>'required',
            'desc_en'=>'required',
            'desc_ar'=>'required',
            'hint_ar'=>'required',
            'hint_en'=>'required',
            'requirement_ar'=>'required',
            'requirement_en'=>'required',
            'persons_no'=>'required',
            'price'=>'required',
            'setup_time'=>'required',
            'max_time'=>'required',
            'ad_hour_price'=>'required',
            'ad_person_price'=>'required',
            'ad_service_price'=>'required',
            'ad_service_ar'=>'required',
            'ad_service_en'=>'required',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:4100',
            "img"=>"nullable",
            'img.*' => 'mimes:jpg,jpeg,png|max:4100',
        ], $messeges);

        if ($validator->fails()) {
            Alert::error('error', $validator->errors()->first());
            return back();
        }

        $catering = Catering::findOrFail($id);
        if (!$catering) {
            Alert::error('error', 'هذا الخدمة غير مسجل بالنظام');
            return back();
        }

        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/caterings/images/';
            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            if (file_exists(storage_path('app/public/' . $catering->image))) {
                unlink(storage_path('app/public/' . $catering->image));
            }
            $img = \Image::make($image)->resize(480 , 320);
            $img->save(public_path('storage/' . $path . $file_name), 90);
            $inputs['image'] = $path . $file_name;
        }

        $catering->update($inputs);

        session()->flash('success', "success");
        if (session()->has("success")) {
            Alert::success('Success ', 'Success Message');
        }

        return redirect()->route('caterings.index', $id);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $catering = Catering::where('id', $id)->first();
        return view('/dashboard/caterings/show', compact('catering'));
    }

    public function destroy($id)
    {
        $catering = Catering::where('id', $id)->first();

        if ($catering) {
            if (file_exists(storage_path('app/public/' . $catering->image))) {
                unlink(storage_path('app/public/' . $catering->image));
            }

            $img = CateringImage::where("catering_id", $id)->get();

            if ($img) {
                foreach ($img as $one) {
                    if (file_exists(public_path($one->image))) {
                        unlink(public_path($one->image));
                    }
                    $one->delete();
                }
            }


            $catering->delete();
            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', ' تم حذف الخدمة');
            }
        }

        //        return Response::json($user);
        return redirect()->route('caterings.index');
    }
}
