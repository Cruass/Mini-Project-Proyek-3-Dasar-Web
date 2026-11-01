<form method="GET" action="{{ $action }}" class="mb-4 bg-white shadow rounded p-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <div>
            <x-input-label for="q" value="Cari" />
            <x-text-input id="q" name="q" type="text" class="mt-1 block w-full"
                :value="request('q')" placeholder="Judul atau kondisi" />
        </div>

        <div>
            <x-input-label for="area_id" value="Wilayah" />
            <select id="area_id" name="area_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Semua wilayah</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" @selected(request('area_id') == $area->id)>{{ $area->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Semua status</option>
                @foreach (['baru', 'ditinjau', 'diteruskan', 'selesai'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <x-input-label for="tingkat" value="Tingkat" />
            <select id="tingkat" name="tingkat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Semua tingkat</option>
                @foreach (['ringan', 'sedang', 'berat'] as $t)
                    <option value="{{ $t }}" @selected(request('tingkat') === $t)>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-3 flex items-center gap-3">
        <x-primary-button>Terapkan</x-primary-button>
        <a href="{{ $action }}" class="text-sm text-gray-600 underline">Reset</a>
    </div>
</form>