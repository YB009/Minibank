<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['account_number', 'account_balance', 'user_id'])]


class Account extends Model
{
    protected $table = 'accounts';
}
