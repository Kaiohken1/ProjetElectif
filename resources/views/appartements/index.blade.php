<x-app-layout>
    @forelse ($appartements as $appartement)
        <div class="mb-3">
            <article>
                <h1>{{ $appartement->name }}</h1>
                <img src="{{ Storage::url($appartement->image) }}" width="200px"></a>
                <p>{{ $appartement->address }}</p>
                <p>{{ $appartement->price }}</p>
                <p>Loué par {{ $appartement->user->name }}</p>
            </article>
        </div>
    @empty
        Aucun appartement disponible
    @endforelse
</x-app-layout>
