<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        return view('pages.about-us')->with([
            'title' => 'About Us',
            'teams' => User::where('position','!=',null)
        ]);
    }
}
