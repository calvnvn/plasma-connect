<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index()
    {
        $farmers = Farmer::latest()->paginate(10);
        return view('farmers.index', compact('farmers'));
    }

    public function show(Farmer $farmer)
    {
        $farmer->load('farmLocation');
        return view('farmers.show', compact('farmer'));
    }
}
