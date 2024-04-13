<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function show($id)
    {
        $appartement = Appartement::findOrFail($id);

        return view('appartements.show', [
            'appartement' => $appartement
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
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
    
        $validatedData = $request->validate([
            'name' => ['required', 'string'],
            'address' => ['required', 'max:255'],
            'surface' => ['required', 'numeric'],   
            'guestCount' => ['required', 'numeric'],   
            'roomCount' => ['required', 'numeric'],   
            'description' => ['required', 'max:255'],   
            'price' => ['required', 'numeric'],
            'image' => ['image'],   
        ]);
    
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($appartement->image);
            $path = $request->file('image')->store('imagesAppart', 'public');
            $validatedData['image'] = $path;
        }
    
        $appartement->update($validatedData);
    
        return redirect()->route('appart.edit', $appartement->id)
            ->with('success', "Appartement mis à jour avec succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appartement $appartement)
    {
        //
    }
}
