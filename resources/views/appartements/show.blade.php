<x-app-layout>
    <div class="flex justify-center">
        <div class="mt-9 ml-11">
            <article>
                <h1 class="text-3xl font-extrabold">{{ $appartement->name }}</h1>
                <img class="rounded-md" src="{{ Storage::url($appartement->images->first()->image) }}">
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

                        <form method="POST" action="{{ route('reservation.store') }}">
                            @csrf

                            <input type="hidden" name="appartement_id" value="{{ $appartement->id }}">


                            <div class="mb-4">
                                <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Date de début
                                    :</label>
                                <input type="date" name="start_time" id="start_time"
                                    min="{{ \Carbon\Carbon::now()->toDateString() }}"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('start_time')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">Date de fin
                                    :</label>
                                <input type="date" name="end_time" id="end_time"
                                    min="{{ \Carbon\Carbon::now()->addDay()->toDateString() }}"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('end_time')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="nombre_de_personne"
                                    class="block text-gray-700 text-sm font-bold mb-2">Nombre de personne :</label>
                                <input type="number" name="nombre_de_personne" id="nombre_de_personne"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    min="1">
                                @error('nombre_de_personne')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4" id="total_price_container" style="display: none;">
                                <p>Total : <span id="total_price">0 €</span></p>
                                <input type="hidden" name="prix" id="prix">
                            </div>


                            <div class="mb-4">
                                <x-primary-button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Réserver</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.getElementById('start_time').addEventListener('change', updateTotalPrice);
        document.getElementById('end_time').addEventListener('change', updateTotalPrice);
        document.getElementById('nombre_de_personne').addEventListener('input', updateTotalPrice);


        function updateTotalPrice() {
            var startTime = new Date(document.getElementById('start_time').value);
            var endTime = new Date(document.getElementById('end_time').value);
            var numberOfPersons = parseInt(document.getElementById('nombre_de_personne').value);
            var pricePerNight = parseFloat("{{ $appartement->price }}");

            if (!isNaN(startTime) && !isNaN(endTime) && startTime < endTime && numberOfPersons > 0 && !isNaN(
                    pricePerNight)) {
                var numberOfNights = Math.ceil((endTime - startTime) / (1000 * 3600 * 24));
                var totalPrice = numberOfNights * pricePerNight * numberOfPersons;

                document.getElementById('total_price').innerText = totalPrice.toFixed(2) + ' €';
                document.getElementById('prix').value = totalPrice;
                document.getElementById('total_price_container').style.display =
                'block'; // Afficher le conteneur du prix total
            } else {
                document.getElementById('total_price').innerText = '0€';
                document.getElementById('prix').value = '';
                document.getElementById('total_price_container').style.display =
                'none'; // Masquer le conteneur du prix total
            }
        }

    });
</script>
