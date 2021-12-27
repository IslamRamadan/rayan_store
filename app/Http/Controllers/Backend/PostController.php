<?php

namespace App\Http\Controllers\Backend;

use App\Post;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Post::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image1', function ($artist) {
                    $url = asset('/storage/' . $artist->img1);
                    return $url;
                })
                ->addColumn('image2', function ($artist) {
                    $url = asset('/storage/' . $artist->img2);
                    return $url;
                })

                ->addColumn('action', function($row){

                    $action = '
                        <a class="btn btn-success"  href="'.route('posts.edit' , $row->id).'" id="edit-user" >'.\Lang::get('site.edit').' </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a href="'.url('posts/destroy' , $row->id).'" class="btn btn-danger">'.\Lang::get('site.delete').'</a>
                        ';
//

                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.posts.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        return view('dashboard.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $messeges = [

            'title_ar.required'=>"عنوان الخبر باللغه العربيه مطلوب",
            'title_en.required'=>"عنوان الخبر باللغه الانجليزيه مطلوب",
            'description_ar.required'=>"محتوي الجزء الاول باللغه العربيه مطلوب",
            'description_en.required'=>"محتوي الجزء الاول باللغه الانجليزيه مطلوب",
            'description_ar1.required'=>"محتوي الجزء الثانى باللغه العربيه مطلوب",
            'description_en1.required'=>"محتوي الجزء الثانى باللغه الانجليزيه مطلوب",
            'img1.required'=>"صورة الخبر الرئيسيه مطلوبة",
            'img1.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png  ",
            'img1.max'=>" الحد الاقصي للصورة 4 ميجا ",
            'img2.required'=>"صورة الجزء الثاني مطلوبة",
            'img2.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png  ",
            'img2.max'=>" الحد الاقصي للصورة 4 ميجا ",
        ];

        $validator =  Validator::make($request->all(), [

            'title_ar' => ['required'],

            'title_en' => ['required'],

            'description_ar' => ['required'],

            'description_en' => ['required'],

            'description_ar1' => ['required'],

            'description_en1' => ['required'],

            'img1' =>  'required|mimes:jpg,jpeg,png|max:4100',

            'img2' =>  'required|mimes:jpg,jpeg,png|max:4100',



        ], $messeges);

        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back()->withInput();;
        }


        $country = null;
        $country = Post::create($request->except('img1','img2'));


        if ($request->hasfile('img1')) {
            // $images .= 'yes';

            $image = $request->file('img1');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/posts/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            $img = \Image::make($image);
            $img->save(public_path('storage/'.$path.$file_name),30);
//
//            if(file_exists(storage_path('app/public/'.$path.$file_name)))
//            {
//                unlink(storage_path('app/public/'.$path.$file_name));
//            }

            $country->img1 = $path.$file_name;
            $country->save();

        } else {
            Alert::error('خطأ', 'برجاء اختيار صورة الخبر');
            return back()->withInput();;
        }
        if ($request->hasfile('img2')) {
            // $images .= 'yes';

            $image = $request->file('img2');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/posts/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            $img = \Image::make($image)->resize(320,400);
            $img->save(public_path('storage/'.$path.$file_name),60);
//
//            if(file_exists(storage_path('app/public/'.$path.$file_name)))
//            {
//                unlink(storage_path('app/public/'.$path.$file_name));
//            }

            $country->img2 = $path.$file_name;
            $country->save();

        } else {
            Alert::error('خطأ', 'برجاء اختيار صورة الخبر ');
            return back()->withInput();;
        }

        if ($country){

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تمت إضافة الخبر');
            }

        }

        return redirect()->route('posts.index');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('show');
    }


    public function updatePost(Request $request ,$id){

// dd($request->all());
        $messeges = [

            'title_ar.required'=>"عنوان الخبر باللغه العربيه مطلوب",
            'title_en.required'=>"عنوان الخبر باللغه الانجليزيه مطلوب",
            'description_ar.required'=>"محتوي الجزء الاول باللغه العربيه مطلوب",
            'description_en.required'=>"محتوي الجزء الاول باللغه الانجليزيه مطلوب",
            'description_ar1.required'=>"محتوي الجزء الثانى باللغه العربيه مطلوب",
            'description_en1.required'=>"محتوي الجزء الثانى باللغه الانجليزيه مطلوب",
            'img1.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png  ",
            'img1.max'=>" الحد الاقصي للصورة 4 ميجا ",
            'img2.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png  ",
            'img2.max'=>" الحد الاقصي للصورة 4 ميجا ",

        ];

        $validator =  Validator::make($request->all(), [

            'title_ar' => ['required'],

            'title_en' => ['required'],

            'description_ar' => ['required'],

            'description_en' => ['required'],

            'description_ar1' => ['required'],

            'description_en1' => ['required'],

            'img1' =>  'mimes:jpg,jpeg,png|max:4100',

            'img2' =>  'mimes:jpg,jpeg,png|max:4100',

        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $post = Post::find($id);


        if(!$post){
            Alert::error('خطأ', 'الدوله غير موجوده');
            return back();
        }


        if ($request->hasfile('img1')) {
            // $images .= 'yes';

            $image = $request->file('img1');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/posts/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            // dd($post->img1);

//            return (storage_path('app/public/'.$cat->img1));
            if(file_exists(storage_path('app/public/'.$post->img1)))
            {
                unlink(storage_path('app/public/'.$post->img1));
            }
            $img = \Image::make($image);
            $img->save(public_path('storage/'.$path.$file_name),30);


            $post->img1 = $path.$file_name;
            $post->save();

        }
        if ($request->hasfile('img2')) {
            // $images .= 'yes';

            $image = $request->file('img2');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/posts/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

//            return (storage_path('app/public/'.$cat->img2));

            if(file_exists(storage_path('app/public/'.$post->img2)))
            {
                unlink(storage_path('app/public/'.$post->img2));
            }
            $img = \Image::make($image)->resize(320,400);
            $img->save(public_path('storage/'.$path.$file_name),60);

            $post->img2 = $path.$file_name;
            $post->save();

        }
        $post = $post->update($request->except('img1','img2'));



        if($post){
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم تعديل بيانات الخبر');
            }
        }

        return redirect()->route('posts.index');



//        $uId = $request->user_id;
//        User::updateOrCreate(['id' => $uId],['name' => $request->name, 'email' => $request->email]);
//        if(empty($request->user_id))
//            $msg = 'User created successfully.';
//        else
//            $msg = 'User data is updated successfully';
//        return redirect()->route('users.index')->with('success',$msg);


    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $post = Post::where($where)->first();
        if(!$post){
            Alert::error('خطأ', 'الخبر غير موجود بالنظام');
            return back();
        }

        return view('dashboard.posts.edit' , compact('post'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();
        // dd($post);
        if(file_exists(storage_path('app/public/'.$post->img1)))
        {
            unlink(storage_path('app/public/'.$post->img1));
        }
        if(file_exists(storage_path('app/public/'.$post->img2)))
        {
            unlink(storage_path('app/public/'.$post->img2));
        }

        $post->delete();
        session()->flash('success', "success");
        if (session()->has("success")) {
            Alert::success('نجح', ' تم حذف الخبر');
        }

        return redirect()->route('posts.index');

    }
}
