<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function deposit(Request $request){
        $incomingField = $request->validate([
            'amount' => ['required', 'integer', 'min:1']
        ]);
        $account = auth()->user()->account;
        if (!$account) {
            return redirect('/')->withErrors(['amount' => 'Only users with an account can do this']);
        }
        $account->increment('account_balance', $incomingField['amount']);
        return redirect('/');
    }
    public function withdraw(Request $request){
        $incomingField = $request->validate([
            'amount' => ['required', 'integer', 'min:1']
        ]);
        $account = auth()->user()->account;
        if (!$account) {
            return redirect('/')->withErrors(['amount' => 'Only users with an account can do this']);
        }
        if($account->account_balance < $incomingField['amount']){
            return redirect('/')->withErrors(['amount' => 'Insufficient balance']);
        }
        $account->decrement('account_balance', $incomingField['amount']);
        return redirect('/');
    }
}
