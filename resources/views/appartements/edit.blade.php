<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifer les informations de votre appartement') }}
        </h2>
        @if(session('success'))
        <div class="p-4 mb-3 mt-3 text-center text-sm text-green-800 rounded-lg bg-green-50 dark:text-green-600" role="alert">
            {{ session('success') }}
        </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <form method="post" action="{{ route('appart.update', $appartement) }}" class="mt-6 space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div>
                            <x-input-label for="name" :value="__('Titre')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $appartement->name)" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Addresse')" />
                            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                                :value="old('address', $appartement->address)" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="surface" :value="__('Surface (Au mètre carré)')" />
                            <x-text-input id="surface" class="block mt-1 w-full" type="number" name="surface"
                                :value="old('surface', $appartement->surface)" />
                            <x-input-error :messages="$errors->get('surface')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="guestCount" :value="__('Nombre de personnes')" />
                            <x-text-input id="guestCount" class="block mt-1 w-full" type="number" name="guestCount"
                                :value="old('guestCount', $appartement->guestCount)" />
                            <x-input-error :messages="$errors->get('guestCount')" class="mt-2" />
                        </div>


                        <div>
                            <x-input-label for="roomCount" :value="__('Nombre de pièces')" />
                            <x-text-input id="roomCount" class="block mt-1 w-full" type="number" name="roomCount"
                                :value="old('roomCount', $appartement->roomCount)" />
                            <x-input-error :messages="$errors->get('roomCount')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('Prix par nuit')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price"
                                :value="old('price', $appartement->price)" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" class="block mt-1 w-full">{{ $appartement->description }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Image')" />
                            <img class="rounded-md mb-3" src="{{ Storage::url($appartement->image) }}" width="200px">
                            <input type="file" id="image" name="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <x-primary-button class="ms-3 mt-5 ml-0">
                            {{ __('Modifier mon appartement') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
