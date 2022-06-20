<?php

namespace App\Http\Controllers;

use App\Models\Joc;

class WelcomeController
{
    public function index()
    {
        return Joc::all();
    }

    public function welcome()
    {
        return view('welcome')->with('jocs', Joc::all());
    }
}