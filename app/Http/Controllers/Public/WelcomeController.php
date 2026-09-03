<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index(){
        $categories = Category::whereNotNull('parent_id')
        ->where('parent_id', '!=','')
        ->take(8)
        ->get();
        return view('welcome',compact('categories'));
    }
}
