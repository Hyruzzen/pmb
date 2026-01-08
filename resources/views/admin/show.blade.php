<x-app-layout>
    <div class="py-8 md:py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-blue-900">Detail Pendaftar #{{ $pendaftaran->id }}</h1>
                <p class="text-blue-600 mt-1">Informasi lengkap calon mahasiswa</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border-b pb-4 md:border-b-0 md:border-r md:pr-6">
                        <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wide mb-2">Informasi Pribadi</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Nama Lengkap</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $pendaftaran->nama_lengkap }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">NIK</p>
                                <p class="text-gray-700">{{ $pendaftaran->nik }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Email</p>
                                <p class="text-gray-700">{{ $pendaftaran->user->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wide mb-2">Detail Kelahiran & Alamat</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Tempat Lahir</p>
                                <p class="text-gray-700">{{ $pendaftaran->tempat_lahir ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Tanggal Lahir</p>
                                <p class="text-gray-700">{{ $pendaftaran->tanggal_lahir ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Alamat</p>
                                <p class="text-gray-700">{{ $pendaftaran->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t mt-6 pt-6">
                    <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wide mb-4">Akademik</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Fakultas</p>
                            <p class="text-gray-700 font-medium">{{ $pendaftaran->fakultas->nama_fakultas ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Program Studi</p>
                            <p class="text-gray-700 font-medium">{{ $pendaftaran->programStudi->nama_prodi ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Status Pendaftaran</p>
                            <p><span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">{{ $pendaftaran->status_pendaftaran }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('admin.pendaftaran.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition">Kembali</a>
                <a href="{{ route('admin.pendaftaran.edit', $pendaftaran) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">Edit</a>
            </div>
        </div>
    </div>
</x-app-layout>
