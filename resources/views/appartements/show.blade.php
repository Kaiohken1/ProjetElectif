<x-app-layout>
    <div class="flex justify-center">
        <div class="mt-9 ml-11">
            <article>
                @if (count($appartement->images) == 1)
                    <img class="rounded-md" src="{{ Storage::url($appartement->images->first()->image) }}" width="100%">
                @else
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($appartement->images as $image)
                            <div class="w-full">
                                <img class="h-72 max-w-full rounded-lg" src="{{ Storage::url($image->image) }}"
                                    width="100%">
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="flex justify-between mt-2">
                    <div class="mt-1">
                        <h1 class="text-3xl font-extrabold">{{ $appartement->name }}</h1>
                        <p class="text-xl"><span>{{ $appartement->guestCount }} voyageurs</span> ·
                            <span>{{ $appartement->roomCount }} chambres</span>
                        </p>
                        <p class="text-xl">{{ $appartement->address }}</p>
                        <p class="text-xl">Loué par {{ $appartement->user->name }}</p>
                    </div>
                    <div class="p-4 sm:p-8 bg-white sm:rounded-lg shadow-xl">
                        <p class="text-xl"><span class="font-extrabold">{{ $appartement->price }}€</span> par nuit</p>
                     
                        <a href="{{ route('reservation.create', ['appartement_id' => $appartement->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 inline-block">Réserver</a>
                    </div>
                </div>

                <div class="border-t-2 border-grey mt-10">
                    <p class="text-2xl">{{ $appartement->description }}</p>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
