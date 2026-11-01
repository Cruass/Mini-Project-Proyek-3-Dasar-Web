<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Peninjauan Laporan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow rounded p-6 space-y-3">
                <h3 class="text-lg font-semibold">{{ $report->judul }}</h3>
                <p><span class="text-gray-500">Status:</span> {{ ucfirst($report->status) }}</p>
                <p><span class="text-gray-500">Pelapor:</span> {{ $report->pelapor->name }}</p>
                <p><span class="text-gray-500">Wilayah:</span> {{ $report->area->nama }}</p>
                <p><span class="text-gray-500">Koordinat:</span> {{ $report->latitude }}, {{ $report->longitude }}</p>
                <p><span class="text-gray-500">Tingkat:</span> {{ ucfirst($report->tingkat) }}</p>
                <p><span class="text-gray-500">Waktu kejadian:</span> {{ $report->waktu_kejadian->format('d M Y H:i') }}</p>
                <p><span class="text-gray-500">Kondisi:</span> {{ $report->kondisi }}</p>

                @if ($report->evidence_path)
                    @php $ext = strtolower(pathinfo($report->evidence_path, PATHINFO_EXTENSION)); @endphp
                    <div>
                        <span class="text-gray-500">Bukti pendukung:</span>
                        @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('storage/' . $report->evidence_path) }}" alt="Bukti pendukung" class="mt-2 max-h-64 rounded border">
                        @else
                            <a href="{{ asset('storage/' . $report->evidence_path) }}" target="_blank" class="text-blue-600 underline">Buka file PDF</a>
                        @endif
                    </div>
                @endif

                @if ($report->reviewer)
                    <p><span class="text-gray-500">Ditinjau oleh:</span> {{ $report->reviewer->name }}</p>
                @endif
                @if ($report->catatan_relawan)
                    <p><span class="text-gray-500">Catatan relawan:</span> {{ $report->catatan_relawan }}</p>
                @endif
                @if ($report->diteruskan_ke)
                    <p><span class="text-gray-500">Diteruskan ke:</span> {{ $report->diteruskan_ke }}
                        ({{ $report->diteruskan_pada?->format('d M Y H:i') }})</p>
                @endif

                <div class="pt-3">
                    <a href="{{ route('monitor.reports.index') }}" class="text-sm text-gray-600 underline">&larr; Kembali</a>
                    @if ($report->statusLogs->isNotEmpty())
    <div class="bg-white shadow rounded p-6">
        <h4 class="font-semibold mb-3">Riwayat status</h4>
        <ul class="text-sm space-y-1">
            @foreach ($report->statusLogs->sortByDesc('created_at') as $log)
                <li>
                    {{ $log->created_at->format('d M Y H:i') }}:
                    {{ $log->status_lama ?? '-' }} &rarr; {{ $log->status_baru }}
                    oleh {{ $log->user?->name ?? 'sistem' }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
                </div>
            </div>

            @can('forward', $report)
                @if ($report->bisaDiteruskan())
                    <div class="bg-white shadow rounded p-6">
                        <h4 class="font-semibold mb-3">Catat penerusan informasi</h4>
                        @unless ($report->punyaCatatanRelawan())
                            <p class="mb-3 text-sm text-red-700">Laporan belum memiliki catatan relawan, sehingga belum dapat diteruskan.</p>
                        @endunless
                        <form method="POST" action="{{ route('monitor.reports.forward', $report) }}">
                            @csrf
                            <x-input-label for="diteruskan_ke" value="Diteruskan kepada (pihak terkait)" />
                            <x-text-input id="diteruskan_ke" name="diteruskan_ke" type="text" class="mt-1 block w-full"
                                :value="old('diteruskan_ke')" placeholder="Contoh: BPBD setempat" required />
                            <x-input-error :messages="$errors->get('diteruskan_ke')" class="mt-2" />

                            <div class="mt-4">
                                <x-primary-button>Catat Diteruskan</x-primary-button>
                            </div>
                        </form>
                    </div>
                @endif
            @endcan

            @can('finish', $report)
                @if ($report->bisaDiselesaikan())
                    <div class="bg-white shadow rounded p-6">
                        <h4 class="font-semibold mb-3">Selesaikan laporan</h4>
                        <p class="mb-3 text-sm text-gray-600">Selesai berarti proses pada aplikasi komunitas telah selesai, bukan pernyataan resmi bahwa kebakaran telah padam.</p>
                        <form method="POST" action="{{ route('monitor.reports.finish', $report) }}">
                            @csrf
                            <x-primary-button>Tandai Selesai</x-primary-button>
                        </form>
                    </div>
                @endif
            @endcan

            @can('review', $report)
                @if ($report->bisaDitinjau())
                    <div class="bg-white shadow rounded p-6">
                        <h4 class="font-semibold mb-3">Tinjau laporan</h4>
                        <form method="POST" action="{{ route('monitor.reports.review', $report) }}">
                            @csrf
                            <x-input-label for="catatan_relawan" value="Catatan peninjauan (kelengkapan dan kewajaran informasi)" />
                            <textarea id="catatan_relawan" name="catatan_relawan" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('catatan_relawan') }}</textarea>
                            <x-input-error :messages="$errors->get('catatan_relawan')" class="mt-2" />

                            <div class="mt-4">
                                <x-primary-button>Tandai Ditinjau</x-primary-button>
                            </div>
                        </form>
                    </div>
                @endif
            @endcan
        </div>
    </div>
</x-app-layout>