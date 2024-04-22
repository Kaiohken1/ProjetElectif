<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifer les informations de votre appartement') }}
        </h2>
        @if (session('success'))
            <div class="p-4 mb-3 mt-3 text-center text-sm text-green-800 rounded-lg bg-green-50 dark:text-green-600"
                role="alert">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="p-4 mb-3 mt-3 text-center text-sm text-red-800 rounded-lg bg-red-50 dark:text-red-600"
                role="alert">
                {{ session('error') }}
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
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="multiple_files">Vos images</label>
                            <div class="flex space-x-8">
                                @foreach ($appartement->images as $image)
                                    <div class="relative">
                                        <img class="rounded-md mb-3" src="{{ Storage::url($image->image) }}"
                                            width="200px">
                                        @if ($appartement->images->count() > 1)    
                                        <form action="{{ route('appart.image.delete', ['id' => $image->id]) }}"
                                            method="POST" class="absolute top-0 right-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 focus:outline-none">
                                                Supprimer
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if ($appartement->images->count() <= 5)
                                <input class="file-input w-full max-w-xs" id="image" type="file" name='image[]'
                                    multiple>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            @endif
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
