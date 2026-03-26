<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fund;

class FundController extends Controller
{
    public function index() {
        $funds = Fund::all();
        return view('user.home', compact('funds'));
    }

    public function admin() {
        $funds = Fund::all();
        return view('admin.dashboard', compact('funds'));
    }

    public function store(Request $request) {
        Fund::create($request->all());
        return back();
    }
}
