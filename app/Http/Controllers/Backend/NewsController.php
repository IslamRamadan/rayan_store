<?php

namespace App\Http\Controllers\Backend;


use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = News::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $action = '
                        <a class="btn btn-success"  href="'.route('news.edit' , $row->id).'" id="edit-user" >'.\Lang::get('site.edit').' </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a href="'.url('news/destroy' , $row->id).'" class="btn btn-danger">'.\Lang::get('site.delete').'</a>
                        ';
//

                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.news.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $news = News::all();

        return view('dashboard.news.create' , compact('news'));
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

            'content_ar.required'=>"الخبر باللغه العربيه مطلوب",
            'content_en.required'=>"الخبر باللغه الانجليزيه مطلوب",

        ];

        $validator =  Validator::make($request->all(), [

            'content_ar' => ['required'],

            'content_en' => ['required'],

        ], $messeges);

        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back()->withInput();;
        }


        $news = null;





            $news = News::create([
                'content_ar' => $request['content_ar'],
                'content_en' => $request['content_en'],
                'appearance' => $request['appearance']?:0,

            ]);




        if ($news){

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تمت إضافة دوله');
            }

        }

        return redirect()->route('news.index');

    }

    public function updateNews(Request $request ,$id){


        $messeges = [

            'content_ar.required'=>"الخبر باللغه العربيه مطلوب",
            'content_en.required'=>"الخبر باللغه الانجليزيه مطلوب",

        ];

        $validator =  Validator::make($request->all(), [


            'content_ar' => ['required'],

            'content_en' => ['required'],

        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $news = News::find($id);

        if(!$news){
            Alert::error('خطأ', 'الخبر غير موجود');
            return back();
        }


            $news = $news->update([
                'content_ar' => $request['content_ar'],
                'content_en' => $request['content_en'],
                'appearance' => $request['appearance']?:0,
            ]);





        if($news){
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم تعديل بيانات الخبر');
            }
        }

        return redirect()->route('news.index');

    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('hh');
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
        $news = News::where($where)->first();
        if(!$news){
            Alert::error('خطأ', 'الدوله غير موجوده بالنظام');
            return back();
        }

        return view('dashboard.news.edit' , compact('news' ));

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
        // dd('dd');
        $news = News::where('id',$id)->first();

        if($news){

            $news->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', ' تم حذف الخبر');
            }

        }

//        return Response::json($user);
        return redirect()->route('news.index');
    }


}
