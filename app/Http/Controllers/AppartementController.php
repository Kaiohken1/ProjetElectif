<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use Illuminate\Http\Request;

class AppartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appartements = Appartement::query()
            ->select(['name', 'address', 'price', 'image', 'user_id'])
            ->latest()
            ->with(['user:id,name'])
            ->paginate(10);

        return view('appartements.index', [
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
            'image' => ['image'],   
        ]);

        $validateData['user_id'] = Auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('imagesAppart', 'public');
            $validateData['image'] = $path;
        }

        $appartement = new Appartement($validateData);

        $appartement->user()->associate($validateData['user_id']);

        $appartement->save();

        return redirect()->route('appart.index')
        ->with('success', "Appartement créé avec succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(Appartement $appartement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appartement $appartement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appartement $appartement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appartement $appartement)
    {
        //
    }
}
