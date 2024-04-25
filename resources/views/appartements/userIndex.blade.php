<x-app-layout>
    <div class="flex justify-center">
        <div class="grid grid-cols-6 gap-6">
            @forelse ($appartements as $appartement)
                <div class="mt-9 ml-11">
                    <article>
{{--                        <img class="rounded-md" src="{{ Storage::url($appartement->images->first()->image) }}" width="200px">--}}
                        <h1 class="text-2xl font-extrabold">{{ $appartement->name }}</h1>
                        <p>{{ $appartement->address }}</p>
                        <p>Loué par {{ $appartement->user->name }}</p>
                        <p><span class="font-extrabold">{{ $appartement->price }}€</span> par nuit</p>
                    </article>

                    <div class="flex">
                    <a href="{{ route('appart.edit', $appartement) }}" class="mr-2">
                        <x-primary-button>Editer</x-primary-button>
                    </a>

                    <form action="{{ route('appart.destroy', $appartement) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-danger-button> Supprimer</x-danger-button>
                    </form>
                </div>

                <a href="{{ route('reservation.showAll', $appartement) }}" class="mr-2">
                    <x-primary-button>Réservations</x-primary-button>
                </a>
            </div>
        @empty
            <p>Vous n'avez aucun appartement</p>
            <a href="{{ route('appart.create') }}" class="font-bold">Mettez votte bien à disposition dès maintenant</a>
        @endforelse
    </div>
</x-app-layout>
