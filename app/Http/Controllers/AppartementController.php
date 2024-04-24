<?php

namespace App\Http\Controllers;

use id;
use Carbon\Carbon;
use App\Models\Appartement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\AppartementImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AppartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appartements = Appartement::query()
            ->select(['id', 'name', 'address', 'price', 'image', 'user_id'])
            ->latest()
            ->with(['user:id,name'])
            ->paginate(10);

        return view('appartements.index', [
            'appartements' => $appartements
        ]);
    }

    public function userIndex()
{
    $user = Auth::user();

    $appartements = $user->appartement;

    return view('appartements.userIndex', [
        'appartements' => $appartements
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appartements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'alpha'],
            'address' => ['required', 'max:255'],
            'surface' => ['required', 'numeric'],   
            'guestCount' => ['required', 'numeric'],   
            'roomCount' => ['required', 'numeric'],   
            'description' => ['required', 'max:255'],   
            'price' => ['required', 'numeric'],
            'image' => ['array'],
            'image.*' => ['image'],  
        ]);

        unset($validateData['image']);
    
        $validateData['users_id'] = Auth()->id();
    
        $appartement = new Appartement($validateData);
    
        $appartement->user()->associate($validateData['users_id']);
    
        $appartement->save();
    
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            
            foreach ($images as $image) {
                $path = $image->store('imagesAppart', 'public');
                
                $appartementImage = new AppartementImage();
                $appartementImage->image = $path;
                $appartementImage->appartement_id = $appartement->id; 
                $appartementImage->save();
            }
        }
         
    
        return redirect()->route('appart.index')
            ->with('success', "Appartement créé avec succès");
    }    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $appartement = Appartement::findOrFail($id);
    
        // Récupérer les dates déjà réservées pour cet appartement
        $reservedDates = Reservation::where('appartement_id', $id)
            ->get() // Récupérez toutes les réservations
            ->map(function ($reservation) {
                return [
                    'start' => Carbon::parse($reservation->start_time)->toDateString(),
                    'end' => Carbon::parse($reservation->end_time)->toDateString(),
                ];
            })
            ->toArray();
    
        return view('appartements.show', compact('appartement', 'reservedDates'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $appartement = Appartement::findOrFail($id);

        Gate::authorize('update', $appartement);


        $appartement = Appartement::findOrFail($id);
        return view('appartements.edit', [
            'appartement' => $appartement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $appartement = Appartement::findOrFail($id);

        Gate::authorize('update', $appartement);

        $validatedData = $request->validate([
            'name' => ['required', 'string'],
            'address' => ['required', 'max:255'],
            'surface' => ['required', 'numeric', 'min:0'], 
            'guestCount' => ['required', 'numeric', 'min:0'], 
            'roomCount' => ['required', 'numeric', 'min:0'], 
            'description' => ['required', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'], 
            'image' => ['array'],
            'image.*' => ['image'],
        ]);
        

        unset($validatedData['image']);

        if ($request->hasFile('image')) {
            $images = $request->file('image');
            
            foreach ($images as $image) {
                $path = $image->store('imagesAppart', 'public');
                
                $appartementImage = new AppartementImage();
                $appartementImage->image = $path;
                $appartementImage->appartement_id = $appartement->id;
                $appartementImage->save();
            }
        }  
    
        $appartement->update($validatedData);
    
        return redirect()->route('appart.edit', $appartement->id)
            ->with('success', "Appartement mis à jour avec succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : RedirectResponse
    {
        $appartement = Appartement::findOrFail($id);

        Gate::authorize('delete', $appartement);

        $appartement->delete();

        return redirect(url('/'));
    }
}
