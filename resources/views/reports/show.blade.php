<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Laporan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6 space-y-3">
                <h3 class="text-lg font-semibold">{{ $report->judul }}</h3>
                <p><span class="text-gray-500">Status:</span> {{ ucfirst($report->status) }}</p>
                <p><span class="text-gray-500">Wilayah:</span> {{ $report->area->nama }}</p>
                <p><span class="text-gray-500">Koordinat:</span> {{ $report->latitude }}, {{ $report->longitude }}</p>
                <p><span class="text-gray-500">Tingkat:</span> {{ ucfirst($report->tingkat) }}</p>
                <p><span class="text-gray-500">Waktu kejadian:</span> {{ $report->waktu_kejadian->format('d M Y H:i') }}</p>
                <p><span class="text-gray-500">Kondisi:</span> {{ $report->kondisi }}</p>

                @if ($report->catatan_relawan)
                    <p><span class="text-gray-500">Catatan relawan:</span> {{ $report->catatan_relawan }}</p>
                @endif

                <div class="pt-3">
                    @if ($report->bisaDiedit())
                        <a href="{{ route('reports.edit', $report->id) }}" class="mr-3 px-3 py-1 bg-yellow-500 text-gray-600 underline">Edit</a>
                    @endif
                    <a href="{{ route('reports.index') }}" class="text-sm text-gray-600 underline">&larr; Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>