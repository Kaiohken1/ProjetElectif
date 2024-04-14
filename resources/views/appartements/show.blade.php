<x-app-layout>
    <div class="flex justify-center">
        <div class="mt-9 ml-11">
            <article>
                <h1 class="text-3xl font-extrabold">{{ $appartement->name }}</h1>
                <img class="rounded-md" src="{{ Storage::url($appartement->image) }}">
                <div class="flex justify-between mt-2">
                    <div class="mt-1">
                        <p class="text-xl"><span>{{ $appartement->guestCount }} voyageurs</span> ·
                            <span>{{ $appartement->roomCount }} chambres</span>
                        </p>
                        <p class="text-xl">{{ $appartement->address }}</p>
                        <p class="text-xl">Loué par {{ $appartement->user->name }}</p>
                    </div>
                    <div class="p-4 sm:p-8 bg-white sm:rounded-lg shadow-xl">
                        <p class="text-xl"><span class="font-extrabold">{{ $appartement->price }}€</span> par nuit</p>
                    </div>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
