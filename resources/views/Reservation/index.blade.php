<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes réservations') }}
        </h2>
    </x-slot>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert" style="margin: auto; width: 50%;">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($reservations->isEmpty())
        <div class="py-8">
            <h1 class="text-2xl font-semibold mb-4">Récapitulatif de mes réservations</h1>
            <p class="text-gray-600">Vous n'avez aucune réservation pour le moment.</p>
        </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <table class="w-full bg-white shadow-md rounded my-4">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Appartement</th>
                            <th class="py-3 px-6 text-left">Prix</th>
                            <th class="py-3 px-6 text-left">Date de début</th>
                            <th class="py-3 px-6 text-left">Date de fin</th>
                            <th class="py-3 px-6 text-left">Date de réservation</th>
                            <th class="py-3 px-6 text-left">Statut</th>
                            <th class="py-3 px-6 text-left"></th> 
                        </tr>
                    </thead>
                    @foreach ($reservations as $reservation)
             <tbody class="text-gray-600 text-sm font-light">
                            <tr class="border-b border-gray-200">
                                <td class="py-3 px-6 text-left">{{ $reservation->appartement->name }}</td>
                                <td class="py-3 px-6 text-left">{{ $reservation->prix }}€</td>
                                <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y') }}</td>
                                <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y') }}</td>
                                <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y H:i:s') }}</td>
                                <td class="py-3 px-6 text-left">{{ $reservation->status }}</td>
                                <td class="py-3 px-6 text-left">
                                    @if (\Carbon\Carbon::now()->subHours(48)->isBefore($reservation->start_time)) 
                                        <form action="{{ route('reservation.cancel', $reservation->id) }}" method="POST">
                                            @csrf
                         <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                                Annuler
                                            </button>
                     </form>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
                {{ $reservations->links() }}
            </div>
        </div>
    @endif
</x-app-layout>
