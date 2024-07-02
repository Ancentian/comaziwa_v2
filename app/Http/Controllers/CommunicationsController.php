<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunicationsController extends Controller
{
    public function index()
    {
        return view('communications.index');
    }
}
