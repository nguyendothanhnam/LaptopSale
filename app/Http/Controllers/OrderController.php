<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function manage_order(){
        return view('admin.manage_order');
    }
}
