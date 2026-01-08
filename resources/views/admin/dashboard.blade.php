<x-app-layout>
    <div class="py-8 md:py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-blue-900">Dashboard Admin</h1>
                <p class="text-blue-600 mt-1">Kelola data pendaftar calon mahasiswa</p>
            </div>

            <!-- Livewire Component -->
            <livewire:admin.pendaftaran-table />

        </div>
    </div>
</x-app-layout>
