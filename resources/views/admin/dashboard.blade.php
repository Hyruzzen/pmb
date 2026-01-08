<x-app-layout>
    <div class="py-8 md:py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-blue-900">Dashboard Admin</h1>
                <p class="text-blue-600 mt-1">Kelola data pendaftar calon mahasiswa</p>
            </div>

            <div class="mb-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('admin.pendaftaran.export.post') }}" class="inline-block">
                        @csrf
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Ekspor CSV</button>
                    </form>

                    <form action="{{ route('admin.pendaftaran.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                        @csrf
                        <input type="file" name="file" accept=".csv" class="text-sm">
                        <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded">Impor CSV</button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="text-green-700 bg-green-100 px-4 py-2 rounded">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="text-red-700 bg-red-100 px-4 py-2 rounded">{{ session('error') }}</div>
                @endif
            </div>

            @if(session('import_errors'))
                <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <strong class="block mb-2">Peringatan impor:</strong>
                    <ul class="list-disc pl-6 text-sm text-gray-700">
                        @foreach(session('import_errors') as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Livewire Component -->
            <livewire:admin.pendaftaran-table />

        </div>
    </div>
</x-app-layout>
