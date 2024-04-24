<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes reservations') }}
        </h2>
    </x-slot>
<h1>Récapitulatif de mes réservations</h1>

@if($reservation->isEmpty())
    <p>Vous n'avez aucune réservation pour le moment.</p>
@else
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Statut</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->start_time }}</td>
                <td>{{ $reservation->end_time }}</td>
                <td>{{ $reservation->status }}</td>
            </tr>
        @endforeach
        
        </tbody>
    </table>
@endif
</x-app-layout>