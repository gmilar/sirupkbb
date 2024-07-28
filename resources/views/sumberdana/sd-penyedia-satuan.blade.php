<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Paket / Penyedia / Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div
                    class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

                    @if (!empty($data))
                        <p>Data RUP <span class="font-bold">{{ $data[0]['kode_rup'] }}</span> yang memiliki
                            <span class="font-bold">{{ count($data) }}</span> uraian pekerjaan berhasil
                            disimpan ke database.
                        </p>
                    @else
                        Data Kosong.
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>