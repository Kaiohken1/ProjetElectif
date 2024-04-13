<x-auth-session-status class="mb-4" :status="session('status')" />
<form method="POST" action="{{ route('appart.store') }}" enctype="multipart/form-data">
    @csrf

    <div>
        <x-input-label for="name" :value="__('Titre')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="address" :value="__('Addresse')" />
        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" />
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="surface" :value="__('Surface (Au mètre carré)')" />
        <x-text-input id="surface" class="block mt-1 w-full" type="number" name="surface" />
        <x-input-error :messages="$errors->get('surface')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="guestCount" :value="__('Nombre de personnes')" />
        <x-text-input id="guestCount" class="block mt-1 w-full" type="number" name="guestCount" />
        <x-input-error :messages="$errors->get('guestCount')" class="mt-2" />
    </div>


    <div>
        <x-input-label for="roomCount" :value="__('Nombre de pièces')" />
        <x-text-input id="roomCount" class="block mt-1 w-full" type="number" name="roomCount" />
        <x-input-error :messages="$errors->get('roomCount')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="price" :value="__('Prix par nuit')" />
        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" />
        <x-input-error :messages="$errors->get('price')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea name="description" class="block mt-1 w-full"></textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
    
    <div>
        <x-input-label for="image" :value="__('Image')" />
        <input type="file" id="image" name="image"/>
        <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </div>


    <x-primary-button class="ms-3 mt-5 ml-0">
        {{ __('Créer un appartement') }}
    </x-primary-button>
    </div>
</form>
