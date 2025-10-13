<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportDisputeController extends Controller
{
    public function index()
    {
        return view('support.disputes.index');
    }

    public function show($id)
    {
        return view('support.disputes.show');
    }
}
