<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fermetures') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <h1 class="text-2xl font-semibold mb-4">Fermetures de l'appartement</h1>

        <div class="mt-6">
            <a href="{{ route('fermeture.create', ['appartement' => $appartement->id]) }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-600">
                Choisir une période de fermeture
            </a>
        </div>

            <div class="overflow-x-auto">
                <table class="w-full bg-white shadow-md rounded my-4">
                    <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Date de début</th>
                        <th class="py-3 px-6 text-left">Date de fin</th>
                        <th class="py-3 px-6 text-left"></th>
                        <th class="py-3 px-6 text-left"></th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                    @foreach($fermetures as $fermeture)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <form action="{{ route('fermeture.update', ['appartement' => $appartement->id, 'fermeture' => $fermeture->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <td class="py-3 px-6 text-left">
                                    <input type="date" name="start_time" id="start_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ date('Y-m-d', strtotime($fermeture->start_time)) }}">
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <input type="date" name="end_time" id="end_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ date('Y-m-d', strtotime($fermeture->end_time)) }}">
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <!-- Bouton pour sauvegarder les modifications -->
                                    <button type="submit" class="text-green-600 hover:text-green-900">Sauvegarder</button>
                                </td>
                            </form>
                            <td class="py-3 px-6 text-left">
                                <!-- Formulaire pour supprimer la fermeture -->
                                <form action="{{ route('fermeture.destroy', ['appartement' => $appartement->id, 'fermeture' => $fermeture->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>



                    </tbody>
                </table>
            </div>
    </div>
</x-app-layout>
<script>

    var demain = new Date();
    demain.setDate(demain.getDate() + 1);

    flatpickr('#start_time', {
        dateFormat: 'Y-m-d', // Format de la date
        minDate: demain // Limiter la sélection aux dates postérieures à aujourd'hui
    });

    flatpickr('#end_time', {
        dateFormat: 'Y-m-d', // Format de la date
        minDate: demain // Limiter la sélection aux dates postérieures à aujourd'hui
    });
</script>
