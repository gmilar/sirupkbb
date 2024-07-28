<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Paket / Penyedia / Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <h1 class=" text-2xl font-medium text-gray-900 dark:text-white">

                    <div
                        class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

                        <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
                            {{-- @dump($data) --}}
                            @if (!empty($data))
                                @if (count($data) > 1)
                                    @foreach ($data as $item)
                                        <p>Data RUP <span class="font-bold">{{ $item['paket_terkonsolidasi'] }}</span>
                                            konsolidasi berhasil disimpan ke
                                            database.</p>
                                    @endforeach
                                @else
                                    Data RUP <span class="font-bold">{{ $data['kode_rup'] }}</span> berhasil disimpan ke
                                    database.
                                @endif
                            @else
                                Data Kosong.
                            @endif
                        </h1>
                    </div>
                </h1>
            </div>
        </div>
    </div>
</x-app-layout>
