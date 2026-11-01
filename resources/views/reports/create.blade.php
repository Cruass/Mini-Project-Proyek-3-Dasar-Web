<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Laporan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('reports.store') }}">
                    @csrf
                    @include('reports._form')

                    <div class="mt-6 flex items-center gap-3">
                        <x-primary-button>Kirim Laporan</x-primary-button>
                        <a href="{{ route('reports.index') }}" class="text-sm text-gray-600 underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>