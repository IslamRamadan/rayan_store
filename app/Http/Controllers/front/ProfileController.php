<?php

namespace App\Http\Controllers\front;

use App\CateringOrder;
use App\HallOrder;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    public function halls()
    {
        $data = HallOrder::where('user_id', auth()->id())->get();
        return view('front.myHalls', compact('data'));
    }

    public function caterings()
    {
        $data = CateringOrder::where('user_id', auth()->id())->get();
        return view('front.myCaterings', compact('data'));
    }
}
