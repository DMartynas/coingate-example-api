<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['price_amount', 'price_currency', 'receive_currency', 'title', 'token', 'description'];
}
