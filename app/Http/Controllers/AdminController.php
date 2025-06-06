<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        $menuItems = DB::table('menus')
            ->select('name', 'description', 'category', 'price', 'most_ordered', 'img_url')
            ->get();
            
        return view('dashboard', ['menuItems' => $menuItems]);
    }
}
