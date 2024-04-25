<x-app-layout>
    <div class="flex justify-center ">
    <div class="grid grid-cols-6 gap-6  w-9/12">
        @forelse ($appartements as $appartement)
            <div class="mt-9 ml-11">
                <article>
                    <img class="rounded-md" src="{{ Storage::url($appartement->images->first()->image) }}" width="200px">
                    <h1 class="text-2xl font-extrabold">{{ $appartement->name }}</h1>
                    <p>{{ $appartement->address }}</p>
                    <p>Loué par {{ $appartement->user->name }}</p>
                    <p><span class="font-extrabold">{{ $appartement->price }}€</span> par nuit</p>
                    @foreach ($appartement->tags as $tag)
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{$tag->name}}</span>
                @endforeach
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
            </div>
        @empty
            <p>Vous n'avez aucun appartement</p>
            <a href="{{ route('appart.create') }}" class="font-bold">Mettez votre bien à disposition dès maintenant</a>
        @endforelse
    </div>
    </div>
</x-app-layout>
