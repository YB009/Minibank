<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login(Request $request){
        $incomingField = $request->validate([
            'loginname' => ['required', 'min:3', 'max:15'],
            'loginpassword' => ['required', 'min:8', 'max:200']
        ]);
        if(auth()->attempt(['name' => $incomingField['loginname'], 'password' => $incomingField['loginpassword']])){
            $request->session()->regenerate();
            return redirect('/');
        }
    }
    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    public function register(Request $request)
    {
        $incomingField = $request->validate([
            'name' => ['required', 'min:3', 'max:15', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users','email')],
            'password'=> ['required', 'min:8', 'max:200']
        ]);

        $incomingField['password'] = bcrypt($incomingField['password']);
        $user = User::create($incomingField);
        Account::create([
            'user_id' => $user->id,
            'account_number' => $this->nextAccountNumber(),

        ]);
        auth()->login($user);
        return redirect('/');

    }

    public function nextAccountNumber()
    {
        $last = Account::max('account_number');
        // First account ever starts at 1000000001
        if (!$last) {
            return 1000000001;
        }
        return $last + 1;
    }


}
