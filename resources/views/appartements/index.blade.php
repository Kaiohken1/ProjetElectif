<x-app-layout>
    <div class="flex justify-center">
        @forelse ($appartements as $appartement)
            <div class="mt-9 ml-11">
                <a href="{{ route('appart.show', $appartement->id) }}" class="block">
                    <article>
                        <img class="rounded-md" src="{{ Storage::url($appartement->image) }}" width="200px">
                        <h1 class="text-2xl font-extrabold">{{ $appartement->name }}</h1>
                        <p>{{ $appartement->address }}</p>
                        <p>Loué par {{ $appartement->user->name }}</p>
                        <p><span class="font-extrabold">{{ $appartement->price }}€</span> par nuit</p>
                    </article>
                </a>
            </div>
        @empty
            Aucun appartement disponible..
            <a href="{{route('appart.create')}}">Et si vous proposiez le votre ?</a>
        @endforelse
    </div>
</x-app-layout>
