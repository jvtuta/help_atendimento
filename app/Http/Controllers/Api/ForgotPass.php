<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class ForgotPass extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index() {
        return view('app.reset_password');
    }

    public function resetPass(Request $request, $id) {
        $this->user = $this->user->find($id);
        if($this->user) {
            $this->user->password = Hash::make($request->password);
            $this->user->save();
        }

        return response()->json(['sucesso'=>'reset efetuado com sucesso']);
        
        
        
    }
}
