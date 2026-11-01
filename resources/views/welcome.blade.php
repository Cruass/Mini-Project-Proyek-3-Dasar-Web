<x-guest-layout>
    <div class="text-center">
        <h1 class="text-2xl font-semibold text-gray-800">Lapor Karhutla</h1>
        <p class="mt-2 text-sm text-gray-600">
            Aplikasi komunitas untuk melaporkan, meninjau, dan memantau
            indikasi kebakaran hutan dan lahan.
        </p>

        <div class="mt-6 flex flex-col gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Ke Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                    Daftar sebagai Pelapor
                </a>
            @endauth
        </div>

        <p class="mt-4 text-xs text-gray-500">
            Akun baru otomatis terdaftar sebagai Pelapor. Akun Relawan dan Koordinator disiapkan oleh admin.
        </p>
    </div>
</x-guest-layout>