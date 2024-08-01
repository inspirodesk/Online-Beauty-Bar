<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use App\Models\News;
use App\Models\Obituary;
use App\Models\Rememberence;
use App\Models\Advertisement;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $obs_sum = Obituary::sum('id');
        $rems_sum = Rememberence::sum('id');
        $ads_sum = Advertisement::sum('id');
        $nws_sum = News::sum('id');

        return view('dashboard',
        ['newses' => News::latest()->paginate(5),
        'obs' => Obituary::latest()->paginate(5),
        'rems' => Rememberence::latest()->paginate(5),
        'ads' => Advertisement::latest()->paginate(5), ],compact('obs_sum', 'rems_sum', 'ads_sum', 'nws_sum'));
    }

    public function nav()
    {
        $setting = Setting::findOrFail(1);
        return view('layouts.nav',compact('setting'));
    }

}
