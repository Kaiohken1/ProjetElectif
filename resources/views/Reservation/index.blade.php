<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes réservations') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <h1 class="text-2xl font-semibold mb-4">Récapitulatif de mes réservations</h1>

        @if($reservations->isEmpty())
            <p class="text-gray-600">Vous n'avez aucune réservation pour le moment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full bg-white shadow-md rounded my-4">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Appartement</th>
                            <th class="py-3 px-6 text-left">Date de début</th>
                            <th class="py-3 px-6 text-left">Date de fin</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($reservations as $reservation)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">{{ $reservation->appartement->name }}</td>
                                <td class="py-3 px-6 text-left">{{ $reservation->start_time }}</td>
                                <td class="py-3 px-6 text-left">{{ $reservation->end_time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
