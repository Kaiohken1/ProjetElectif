<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Tag;
use App\Models\AppartementImage;
use Illuminate\Http\Request;
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
            ->with(['tags' => function ($query) {
                $query->select('tags.*');   //pour filtrer si des appartements ont des tag ou non
            }])
            ->with(['images:*'])
            ->paginate(10);

        return view('appartements.index', [
            'appartements' => $appartements
        ]);
        

       /* $appartements = Appartement::with('tags','images','user');
        return view('appartements.index', [
            'appartements' => $appartements
        ]);
        */
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
        $tags = Tag::all();
        return view('appartements.create',[
            'tags' => $tags
        ]);
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
            'tag_id' => ['array']
        ]);

        unset($validateData['image']);
    
        $validateData['user_id'] = Auth()->id();
    
        $appartement = new Appartement($validateData);
        
        $appartement->user()->associate($validateData['user_id']);
        $appartement->save();
        if(isset($validateData['tag_id'])){
            $appartement->tags()->sync($validateData['tag_id']);
        }

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

        Gate::authorize('update', $appartement);


        $appartement = Appartement::findOrFail($id);
        $tags = Tag::all();
        return view('appartements.edit', [
            'appartement' => $appartement,
            'tags' => $tags
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
            'surface' => ['required', 'numeric'],   
            'guestCount' => ['required', 'numeric'],   
            'roomCount' => ['required', 'numeric'],   
            'description' => ['required', 'max:255'],   
            'price' => ['required', 'numeric'],
            'image' => ['array'],
            'image.*' => ['image'],
            'tag_id' => ['array'],
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

        if(isset($validatedData['tag_id'])){
            $appartement->tags()->sync($validatedData['tag_id']);
        }
    
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
