<?php

namespace App\Http\Controllers\Backend;

use App\HallOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class HallOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = HallOrder::latest()->get();
            return DataTables::of($data)
                ->editColumn('hall_id', function ($item) {
                    return $item->hall['title_' . app()->getLocale()];
                })
                ->editColumn('user_id', function ($item) {
                    return $item->user->name;
                })
                ->addColumn('total_price', function ($item) {
                    return $item->day_price * $item->days;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {


                    $action = '
                      <meta name="csrf-token" content="{{ csrf_token() }}">
                         <a  href="' . route('hallOrders.show', $row->id) . '" class="btn btn-danger">' . \Lang::get('site.delete') . '</a>';
                    return $action;
                })
                ->rawColumns(['action', 'hall_id', 'user_id', 'total_price',])
                ->make(true);
        }

        return view('dashboard.hallOrders.index');
    }

    public function show($id)
    {
        HallOrder::findOrFail($id)->delete();
        session()->flash('success', "success");
        Alert::success('نجح', ' تم حذف الطلب');
        //        return Response::json($user);
        return redirect()->route('hallOrders.index');
    }
}
