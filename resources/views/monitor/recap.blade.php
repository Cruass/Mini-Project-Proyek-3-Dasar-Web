<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rekap Laporan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <form method="GET" action="{{ route('monitor.recap') }}" class="bg-white shadow rounded p-4 flex flex-wrap items-end gap-3">
                <div>
                    <x-input-label for="tingkat" value="Tingkat kondisi" />
                    <select id="tingkat" name="tingkat" class="mt-1 block border-gray-300 rounded-md shadow-sm">
                        <option value="">Semua tingkat</option>
                        @foreach (['ringan', 'sedang', 'berat'] as $t)
                            <option value="{{ $t }}" @selected($tingkat === $t)>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <x-primary-button>Terapkan</x-primary-button>
                <a href="{{ route('monitor.recap') }}" class="text-sm text-gray-600 underline pb-2">Reset</a>
            </form>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white shadow rounded p-4">
                    <p class="text-sm text-gray-500">Total laporan</p>
                    <p class="text-3xl font-semibold">{{ $ringkasan['total'] }}</p>
                </div>
                <div class="bg-white shadow rounded p-4">
                    <p class="text-sm text-gray-500">Laporan aktif</p>
                    <p class="text-3xl font-semibold">{{ $ringkasan['aktif'] }}</p>
                </div>
                <div class="bg-white shadow rounded p-4">
                    <p class="text-sm text-gray-500">Laporan selesai</p>
                    <p class="text-3xl font-semibold">{{ $ringkasan['selesai'] }}</p>
                </div>
                <div class="bg-white shadow rounded p-4">
                    <p class="text-sm text-gray-500">Belum ditinjau</p>
                    <p class="text-3xl font-semibold">{{ $ringkasan['baru'] }}</p>
                </div>
            </div>

            <div class="bg-white shadow rounded overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="p-3">Wilayah</th>
                            <th class="p-3">Baru</th>
                            <th class="p-3">Ditinjau</th>
                            <th class="p-3">Diteruskan</th>
                            <th class="p-3">Selesai</th>
                            <th class="p-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekap as $baris)
                            <tr class="border-t">
                                <td class="p-3">{{ $baris['wilayah'] }}</td>
                                <td class="p-3">{{ $baris['baru'] }}</td>
                                <td class="p-3">{{ $baris['ditinjau'] }}</td>
                                <td class="p-3">{{ $baris['diteruskan'] }}</td>
                                <td class="p-3">{{ $baris['selesai'] }}</td>
                                <td class="p-3 font-semibold">{{ $baris['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold border-t">
                        <tr>
                            <td class="p-3">Jumlah</td>
                            <td class="p-3">{{ $rekap->sum('baru') }}</td>
                            <td class="p-3">{{ $rekap->sum('ditinjau') }}</td>
                            <td class="p-3">{{ $rekap->sum('diteruskan') }}</td>
                            <td class="p-3">{{ $rekap->sum('selesai') }}</td>
                            <td class="p-3">{{ $rekap->sum('total') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>