<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\UserRepository;
use App\Models\Departamento;

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
        $user = User::find(Auth::user()->id);
        // dd(Departamento::with('users:id')->find($user));
        
        
        // session(['departamento'=>strtolower(User::with('departamento')->find(Auth::user())->nome_departamento)]);
        $dp = User::where('id',Auth::user()->id)->with('departamento')->get()->pluck('id_departamento');
        $dp = Departamento::find($dp[0]);
        $dp = $dp->nome_departamento;
        
        session(['departamento'=>$dp]);

        return view('home');
    }
}
