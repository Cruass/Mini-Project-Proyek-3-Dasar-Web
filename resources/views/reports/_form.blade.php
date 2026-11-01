@php $r = $report ?? null; @endphp

<div class="space-y-4">
    <div>
        <x-input-label for="area_id" value="Wilayah" />
        <select id="area_id" name="area_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="" disabled @selected(old('area_id', $r?->area_id) == '')>-- Pilih wilayah --</option>
            @foreach ($areas as $area)
                <option value="{{ $area->id }}" @selected(old('area_id', $r?->area_id) == $area->id)>{{ $area->nama }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('area_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="judul" value="Judul laporan" />
        <x-text-input id="judul" name="judul" type="text" class="mt-1 block w-full" :value="old('judul', $r?->judul)" required />
        <x-input-error :messages="$errors->get('judul')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="kondisi" value="Kondisi yang dilihat" />
        <textarea id="kondisi" name="kondisi" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('kondisi', $r?->kondisi) }}</textarea>
        <x-input-error :messages="$errors->get('kondisi')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="tingkat" value="Tingkat kondisi" />
        <select id="tingkat" name="tingkat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            @foreach (['ringan', 'sedang', 'berat'] as $t)
                <option value="{{ $t }}" @selected(old('tingkat', $r?->tingkat ?? 'ringan') === $t)>{{ ucfirst($t) }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('tingkat')" class="mt-2" />
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="latitude" value="Latitude" />
            <x-text-input id="latitude" name="latitude" type="number" step="any" class="mt-1 block w-full" :value="old('latitude', $r?->latitude)" required />
            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="longitude" value="Longitude" />
            <x-text-input id="longitude" name="longitude" type="number" step="any" class="mt-1 block w-full" :value="old('longitude', $r?->longitude)" required />
            <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="waktu_kejadian" value="Waktu kejadian" />
        <x-text-input id="waktu_kejadian" name="waktu_kejadian" type="datetime-local" class="mt-1 block w-full"
            :value="old('waktu_kejadian', $r?->waktu_kejadian?->format('Y-m-d\TH:i'))" required />
        <x-input-error :messages="$errors->get('waktu_kejadian')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="evidence" value="Bukti pendukung (JPG, PNG, atau PDF, maksimal 2 MB)" />
        <input id="evidence" name="evidence" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm" />
        @if ($r?->evidence_path)
            <p class="mt-1 text-sm text-gray-500">
                File saat ini:
                <a href="{{ asset('storage/' . $r->evidence_path) }}" target="_blank" class="text-blue-600 underline">lihat</a>.
                Pilih file baru untuk menggantinya.
            </p>
        @endif
        <x-input-error :messages="$errors->get('evidence')" class="mt-2" />
    </div>
</div>