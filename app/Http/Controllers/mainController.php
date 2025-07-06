<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class mainController extends Controller
{
    public function index(){
        return Inertia::render('Welcome');
    }

    public function collection(){
        return Inertia::render('Collection');
    }

    public function friends(){
        return Inertia::render('Friends');
    }

    public function comments(){
        return Inertia::render('Comments');
    }
}
