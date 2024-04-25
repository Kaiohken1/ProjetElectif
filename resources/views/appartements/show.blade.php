<x-app-layout>
    <div class="flex justify-center">
        <div class="mt-9 ml-11">
            <article>
                <h1 class="text-3xl font-extrabold">{{ $appartement->name }}</h1>
                @if (count($appartement->images) == 1)
                    <img class="rounded-md" src="{{ Storage::url($appartement->images->first()->image) }}"
                        width="100%">
                @else
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($appartement->images as $image)
                            <div class="w-full">
                                <img class="h-72 max-w-full rounded-lg" src="{{ Storage::url($image->image) }}"
                                    width="100%">
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="flex justify-between mt-5">
                    <div class="mt-1">
                        @foreach ($appartement->tags as $tag)
                        <span class="bg-blue-900 text-blue-300 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-100 dark:text-blue-800">{{$tag->name}}</span>                    
                        @endforeach
                        <p class="text-xl"><span>{{ $appartement->guestCount }} voyageurs</span> ·
                            <span>{{ $appartement->roomCount }} chambres</span>
                        </p>
                        <p class="text-xl">{{ $appartement->address }}</p>
                        <p class="text-xl">Loué par {{ $appartement->user->name }}</p>
                    </div>
                    <div class="p-4 sm:p-8 ml-20 bg-white sm:rounded-lg shadow-xl">
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
                                    class="block text-gray-700 text-sm font-bold mb-2">Nombre de personnes :</label>
                                <input type="number" name="nombre_de_personne" id="nombre_de_personne"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    min="1" max="{{ $appartement->guestCount }}">
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
                <p class="mt-10">Description</p>
                <div class="border-t-2 border-grey bg-white">
                    <p class="text-2xl">{{ $appartement->description }}</p>
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

        document.getElementById("start_time").addEventListener('focus', function(event) {
            event.target.showPicker();
        });

        document.getElementById("end_time").addEventListener('focus', function(event) {
            event.target.showPicker();
        });

        function updateTotalPrice() {
            var startTime = new Date(document.getElementById('start_time').value);
            var endTime = new Date(document.getElementById('end_time').value);
            var numberOfPersons = parseInt(document.getElementById('nombre_de_personne').value);
            var pricePerNight = parseFloat("{{ $appartement->price }}");

            if (!isNaN(startTime) && !isNaN(endTime) && startTime < endTime && numberOfPersons > 0 && !isNaN(
                    pricePerNight)) {
                var numberOfNights = Math.ceil((endTime - startTime) / (1000 * 3600 * 24));
                var totalPrice = numberOfNights * pricePerNight;

                if (numberOfPersons > 1) {
                    totalPrice += (numberOfPersons - 1) * 0.1 * pricePerNight * numberOfNights;
                }

                document.getElementById('total_price').innerText = totalPrice.toFixed(2) + ' €';
                document.getElementById('prix').value = totalPrice;
                document.getElementById('total_price_container').style.display = 'block';
            } else {
                document.getElementById('total_price').innerText = '0€';
                document.getElementById('prix').value = '';
                document.getElementById('total_price_container').style.display = 'none';
            }
        }

        document.getElementById('start_time').addEventListener('change', disableReservedDates);
        document.getElementById('end_time').addEventListener('change', disableReservedDates);

        function disableReservedDates() {
            var start = new Date(document.getElementById('start_time').value);
            var end = new Date(document.getElementById('end_time').value);

            if (end < start) {
                alert("La date de fin ne peut pas être antérieure à la date de début.");
                document.getElementById('end_time').value = '';
                return;
            }
        }
    });
</script>
