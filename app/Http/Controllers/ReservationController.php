<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; 
use Illuminate\Support\Facades\Auth; 

class ReservationController extends Controller
{
    public function index()
    {
        
        $reservation = Reservation::where('client_id', Auth::id())->get();
        

        return view('reservation', ['reservation' => $reservation]);
    }
}
