<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fermetures') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <h1 class="text-2xl font-semibold mb-4">Choisir une période de fermeture</h1>
            <div class="overflow-x-auto">
                <form action="{{ route('fermeture.store', $appartement) }}" method="POST">
                    @csrf
                    <input type="date" name="start_time" id="start_time" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <input type="date" name="end_time" id="end_time" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <button type="submit" class="text-green-600 hover:text-green-900">Création</button>
                </form>
            </div>
    </div>
</x-app-layout>
<script>
    function estDansIntervalle(date, intervalles, fermetures) {

        var currentDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        for (var i = 0; i < intervalles.length; i++) {
            var startDate = new Date(intervalles[i].start_time);
            var endDate = new Date(intervalles[i].end_time);
            var intervalleStartDate = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
            var intervalleEndDate = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
            if (currentDate >= intervalleStartDate && currentDate <= intervalleEndDate) {
                return true;
            }
        }
        for (var i = 0; i < fermetures.length; i++) {
            var fermetureStart = new Date(fermetures[i].start_time);
            var fermetureEnd = new Date(fermetures[i].end_time);
            var trueFermetureStart = new Date(fermetureStart.getFullYear(), fermetureStart.getMonth(), fermetureStart.getDate());
            var trueFermetureEnd = new Date(fermetureEnd.getFullYear(), fermetureEnd.getMonth(), fermetureEnd.getDate());
            if (currentDate >= trueFermetureStart && currentDate <= trueFermetureEnd) {
                return true;
            }
        }
        return false;
    }

    var intervallesADesactiver = @json($intervalles);
    var fermeturesADesactiver = @json($fermetures);

    var demain = new Date();
    demain.setDate(demain.getDate() + 1);

    flatpickr('#start_time', {
        dateFormat: 'Y-m-d', // Format de la date
        minDate: demain, // Limiter la sélection aux dates postérieures à aujourd'hui
        function(date) {

            // Désactiver les dates dans les intervalles spécifiés
            return estDansIntervalle(date, intervallesADesactiver, fermeturesADesactiver);
        }
    });

    flatpickr('#end_time', {
        dateFormat: 'Y-m-d', // Format de la date
        minDate: demain,
        disable:[
            function(date) {

                // Désactiver les dates dans les intervalles spécifiés
                return estDansIntervalle(date, intervallesADesactiver, fermeturesADesactiver);
            }
        ]// Limiter la sélection aux dates postérieures à aujourd'hui
    });
</script>
