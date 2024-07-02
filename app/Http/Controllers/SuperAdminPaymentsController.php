<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminPaymentsController extends Controller
{
    //
    public function index(){
        $data = array();
        return view('superadmin.payments.index', compact('data'));
    }

    public function payment_methods(){
        $data = array();
        return view('superadmin.payments.payment_methods', compact('data'));
    }
}
