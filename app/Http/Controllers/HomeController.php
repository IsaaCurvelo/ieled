<?php

namespace sisco\Http\Controllers;

use Illuminate\Http\Request;
use sisco\Notificacao;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth', ['only'=>['timeline']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $notifications = Notificacao::where('user_id', auth()->id())->where('visto', 0)->take(3)->get();
        $totalNotifications = Notificacao::where('user_id', auth()->id())->where('visto', 0)->count();

        return view('home', compact('notifications', 'totalNotifications'));
    }
}
