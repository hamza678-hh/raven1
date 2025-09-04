<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Themecontroller extends Controller
{
    public function index(){
        return view('theme.index');
    }
    public function category(){
        return view('theme.category');
    }
    public function contact(){
        return view('theme.contact');
    }
      public function login(){
        return view('theme.login');
    }
    public function singleblog(){
        return view('theme.singleblog');
    }
  public function register(){
        return view('theme.register');
    }
  
  
}
