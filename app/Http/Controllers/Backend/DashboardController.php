<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB; 

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.index');   
    }

    public function configurator( )
    {   
        return view('backend.botMachine', [
            'bots' => DB::table("bots")->get()
        ]);
    }
    
}
