<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $reservations = Reservation::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Passer les réservations à la vue
        return view('Reservation.index', ['reservations' => $reservations]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $appartement_id = $request->route('appartement_id');

        // if (!$appartement_id) {
        // }

        $selectedAppartement = Appartement::find($appartement_id);
        $appartements = Appartement::all();
        $prixAppartement = $selectedAppartement->prix;

        return view('Reservation.create', [
            'appartements' => $appartements,
            'selectedAppartement' => $selectedAppartement,
            'appartement_id' => $appartement_id,
            'prixAppartement' => $prixAppartement,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  dd($request->all());
        $validatedData = $request->validate([
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date'],
            'nombre_de_personne' => ['required', 'numeric'],
            // 'commentaire' => ['max:255'],
            'appartement_id' => ['required', 'exists:appartements,id'],
            'prix' => ['required', 'numeric'],
        ]);

        $reservation = new Reservation();
        $reservation->appartement_id = $request->input('appartement_id');
        $userId = Auth::id();
        $reservation->user_id = $userId;
        $reservation->start_time = $validatedData['start_time'];
        $reservation->end_time = $validatedData['end_time'];
        $reservation->nombre_de_personne = $validatedData['nombre_de_personne'];
        $reservation->prix = $validatedData['prix'];
        // $reservation->commentaire = $validatedData['commentaire'];

        $reservation->save();
        return redirect()->route('reservation.index')->with('success', "Réservation bien prise en compte");
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view('Reservation.index', ['reservation' => $reservation]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view('Reservation.edit', ['reservation' => $reservation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date'],
            'nombre_de_personne' => ['required', 'numeric'],
            'prix' => ['required', 'numeric'],
        ]);


        $reservation = Reservation::findOrFail($id);

        $reservation->start_time = $validatedData['start_time'];
        $reservation->end_time = $validatedData['end_time'];
        $reservation->nombre_de_personne = $validatedData['nombre_de_personne'];
        $reservation->prix = $validatedData['prix'];
        $reservation->save();


        return redirect()->route('reservations.show', ['reservation' => $reservation->id])
            ->with('success', 'Reservation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        $reservation = Reservation::findOrFail($id);

        $reservation->delete();

        return redirect()->route('reservation.index')
            ->with('success', 'Reservation deleted successfully');
    }

    public function validate($id)
    {
        Reservation::where('id', $id)->update(['status' => 'Validé']);

        return redirect()->back()
            ->with('success', 'La reservation a été validée avec succès');
    }

    public function refused($id)
    {
        Reservation::where('id', $id)->update(['status' => 'Refusé']);

        return redirect()->back()
            ->with('success', 'La reservation a été refusée avec succès');
    }


    public function showAll($appartement_id)
    {
        $reservations = Reservation::where('appartement_id', $appartement_id)
            ->latest('created_at')
            ->paginate(15);

        $appartement_name = Appartement::findOrFail($appartement_id)->name;

        return view('Reservation.showAll', compact('reservations', 'appartement_name'));
    }
}
