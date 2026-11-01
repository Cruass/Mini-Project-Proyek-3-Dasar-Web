<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pemantauan Laporan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @include('reports._filter', ['action' => route('monitor.reports.index')])
            <div class="bg-white shadow rounded overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="p-3">Judul</th>
                            <th class="p-3">Pelapor</th>
                            <th class="p-3">Wilayah</th>
                            <th class="p-3">Tingkat</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Waktu kejadian</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr class="border-t">
                                <td class="p-3">{{ $report->judul }}</td>
                                <td class="p-3">{{ $report->pelapor->name }}</td>
                                <td class="p-3">{{ $report->area->nama }}</td>
                                <td class="p-3">{{ ucfirst($report->tingkat) }}</td>
                                <td class="p-3">{{ ucfirst($report->status) }}</td>
                                <td class="p-3">{{ $report->waktu_kejadian->format('d M Y H:i') }}</td>
                                <td class="p-3">
                                    <a href="{{ route('monitor.reports.show', $report) }}" class="text-blue-600 underline">Periksa</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="p-4 text-center text-gray-500">Belum ada laporan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $reports->links() }}</div>
        </div>
    </div>
</x-app-layout>