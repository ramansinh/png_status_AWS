<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    private $data = array(
        'route' => 'admin.home.',
        'title' => 'Dashboard',
        'menu' => 'home',
        'submenu' => '',
    );

    public function home(){
        return view('admin.dashboard',$this->data);
    }
}
