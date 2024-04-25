<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Fermeture;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FermetureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Appartement $appartement)
    {
        $fermetures = Fermeture::where('appartement_id', $appartement->id)->get();
        return view('fermetures.index', ['fermetures' => $fermetures,
            'appartement' => $appartement]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($appartement)
    {

        $intervalle = Reservation::where("appartement_id", $appartement)
            ->select("start_time","end_time")
            ->get();


        return view('fermetures.create', ['appartement'=>$appartement,
                                                'intervalle'=>$intervalle]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $appartement)

    {

        $validatedData = $request->validate([
            'start_dtime' => ['required', 'date'],
            'end_time' => ['required', 'date'],
            'appartement_id' => $appartement,
        ]);

        $fermeture = new Fermeture($validatedData);
        $fermeture->save();

        $appartement = Appartement::findOrFail($appartement);

        return redirect()->route('fermeture.index', ['appartement' => $appartement])->with('success', "Réservation bien prise en compte");
    }

    /**
     * Display the specified resource.
     */
    public function show(Fermeture $fermeture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fermeture $fermeture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $appartement, $fermeture)

    {

        $fermetures = Fermeture::findOrFail($fermeture);

        $fermetures->update($request->only(['start_time', 'end_time']));

        return redirect()->route('fermeture.index', $appartement)
            ->with('success', 'Reservation deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($appartement, $fermeture)
    {
        $fermetures = Fermeture::findOrFail($fermeture);

        $fermetures->delete();

        return redirect()->route('fermeture.index', $appartement)
            ->with('success', 'Reservation deleted successfully');
    }
}