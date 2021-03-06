<?php

namespace App\Http\Controllers\Backend;

use App\Hall;
use App\HallImg;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class HallController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Hall::latest()->get();
            return DataTables::of($data)
                ->addColumn('image', function ($artist) {
                    $url = asset('/storage/' . $artist->img);
                    return $url;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {


                    $action = '
                    <a class="btn btn-success"  href="' . route('halls.edit', $row->id) . '" >' . \Lang::get('site.edit') . ' </a>

                        <a class="btn btn-outline-dark"  href="' . route('hall_galaries.index', $row->id) . '" >' . \Lang::get('site.images') . ' </a>
                      <meta name="csrf-token" content="{{ csrf_token() }}">
                         <a  href="' . route('halls.destroy', $row->id) . '" class="btn btn-danger">' . \Lang::get('site.delete') . '</a>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.halls.index');
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('dashboard.halls.create');
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //    dd($request->all());


        $messeges = [


            'photo.required' => "???????? ???????????? ????????????",
            'photo.mimes' => " ?????? ???? ???????? ???????????? jpg ???? jpeg ???? png  ",
            'photo.max' => " ???????? ???????????? ???????????? 4 ???????? ",
            'img.required'=>" ???????????? ????????????",
            'img.mimes'=>" ?????? ???? ???????? ???????????? jpg ???? jpeg ???? png ",
            'img.max'=>" ???????? ???????????? ???????????? 4 ???????? ",
            'description_en.required'=>'?????????? ???????????? ???????????????????? ??????????',
            'description_ar.required'=>'?????????? ???????????? ?????????????? ??????????',
            'title_ar.required'=>'?????????? ???????????? ?????????????? ??????????',
            'title_en.required'=>'?????????? ???????????? ???????????????????? ??????????',



        ];


        $validator = Validator::make($request->all(), [
            'title_en'=>'required',
            'title_ar'=>'required',
            'description_en'=>'required',
            'description_ar'=>'required',
            "price" => "required|Numeric|between:0.1,9999.99",
            "over_price" => "required|Numeric|between:0.1,9999.99",
            'photo' => 'required|mimes:jpg,jpeg,png|max:4100',
            'img.*' => 'mimes:jpg,jpeg,png|max:4100',
            "img"=>"required"

        ], $messeges);


        if ($validator->fails()) {
            Alert::error('error', $validator->errors()->first());
            return back()->withInput();
        }
        if (!$request->hasfile('img')){

            Alert::success('error ', '???? ?????? ???????????? ???? ????????');
            return back();
        }

        $imgs = $request->img ;

        if(count($imgs) >10 ){

            Alert::success('error ', '???????? ???????????? ?????????????? ???? ?????????? ?????????????? 10 ??????');
            return back();

        }



        $image = $request->photo;
        $original_name = strtolower(trim($image->getClientOriginalName()));
        $file_name = time() . rand(100, 999) . $original_name;
        $path = 'uploads/halls/images/';

        if (!Storage::exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }
        $img = \Image::make($image)->resize(480,320);
        $img->save(public_path('storage/' . $path . $file_name), 90);


        $hall = Hall::create([

            'title_ar' => $request['title_ar'] ?: '',
            'title_en' => $request['title_en'] ?: '',
            'description_en' => $request['description_en'] ?: '',
            'description_ar' => $request['description_ar'] ?: '',
            'over_price' => $request['over_price'] ?: 0,
            'price' => $request['price'],
            'img' => $path . $file_name,
        ]);



        if ($request->has('img') ) {
            if (count($request->img) > 0) {
                foreach($imgs as $img){
                    //add new name for img
                    $new_name_img = time().uniqid().".".$img->getClientOriginalExtension();

                    //move img to folder
                    $img1 = \Image::make($img)->resize(480,320);
                    $img1->save(public_path('upload/advertising/'.$new_name_img),90);
                    // $img->move(public_path("upload/advertising"), $new_name_img);

                    $post= HallImg::create([
                        "img"=>  "upload/advertising/".$new_name_img ,
                        "hall_id"=>$hall->id

                    ]);

                }


            }
        }

        if (session()->has("success")) {
            Alert::success('Success ', 'Success Message');
        }

        return redirect()->route('halls.index');
    }

      /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $hall = Hall::findOrFail($id);

             return view('/dashboard/halls/edit', compact('hall'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateHall(Request $request, $id)
    {
        //    dd($request->all());
        $messeges = [
            'description_en.required'=>'?????????? ???????????? ???????????????????? ??????????',
            'description_ar.required'=>'?????????? ???????????? ?????????????? ??????????',
            'title_ar.required'=>'?????????? ???????????? ?????????????? ??????????',
            'title_en.required'=>'?????????? ???????????? ???????????????????? ??????????',
            'photo.mimes' => " ?????? ???? ???????? ???????????? jpg ???? jpeg ???? png  ",
            'photo.max' => " ???????? ???????????? ???????????? 4 ???????? ",

        ];

        $validator = Validator::make($request->all(), [
            'photo' => 'mimes:jpg,jpeg,png|max:4100',

            'title_en'=>'required',
            'title_ar'=>'required',
            'description_en'=>'required',
            'description_ar'=>'required',
            "price" => "required|Numeric|between:0.1,9999.99",
            "over_price" => "required|Numeric|between:0.1,9999.99",

        ], $messeges);


        if ($validator->fails()) {
            Alert::error('error', $validator->errors()->first());
            return back();
        }

        $hall = Hall::findOrFail($id);


        if (!$hall) {
            Alert::error('error', '?????? ???????????? ?????? ???????? ??????????????');
            return back();
        }

        if ($request->hasFile('photo')) {

            $image = $request->file('photo');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/halls/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

            if (file_exists(storage_path('app/public/' . $hall->img))) {
                unlink(storage_path('app/public/' . $hall->img));
            }
            $img = \Image::make($image)->resize(480,320);
            $img->save(public_path('storage/' . $path . $file_name), 90);



            $hall = $hall->update([

                'title_ar' => $request['title_ar'] ?: '',
                'title_en' => $request['title_en'] ?: '',
                'description_en' => $request['description_en'] ?: '',
                'description_ar' => $request['description_ar'] ?: '',
                'price' => $request['price'],
                'over_price' => $request['over_price'] ?: 0,
                'img' => $path . $file_name,

            ]);
        }



        else {
            $hall = $hall->update([
                'title_ar' => $request['title_ar'] ?: '',
                'title_en' => $request['title_en'] ?: '',
                'description_en' => $request['description_en'] ?: '',
                'description_ar' => $request['description_ar'] ?: '',
                'over_price' => $request['over_price'] ?: 0,

                'price' => $request['price'],

            ]);
        }



        //TODO :: -----------------------------//

        //        dd($new_sizes);
        //        dd($removed_sizes);

        //        dd($vv);
        session()->flash('success', "success");
        if (session()->has("success")) {
            Alert::success('Success ', 'Success Message');
        }

        return redirect()->route('halls.index', $id);
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hall = Hall::where('id', $id)->first();

        if ($hall) {
            if (file_exists(storage_path('app/public/' . $hall->img))) {
                unlink(storage_path('app/public/' . $hall->img));
            }

            $img = HallImg::where("hall_id", $id)->get();

            if ($img) {
                foreach ($img as $one) {
                    if (file_exists(public_path($one->img))) {
                        unlink(public_path($one->img));
                    }
                    $one->delete();
                }
            }


            $hall->delete();
            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('??????', ' ???? ?????? ????????????');
            }
        }

        //        return Response::json($user);
        return redirect()->route('halls.index');
    }





}
