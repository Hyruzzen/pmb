<x-app-layout>
    <div class="py-8 md:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white p-6 md:p-10 rounded-xl shadow-md">

                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">
                        Formulir Pendaftaran
                    </h1>
                    <p class="text-gray-600">
                        Lengkapi data diri calon mahasiswa
                    </p>
                </div>

                {{-- Step indicator --}}
                <x-step-pmb step="1" />

                <form method="POST" action="{{ route('pendaftaran.store') }}">
                    @csrf

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Nama Lengkap --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Nama Lengkap
                            </label>
                            <input
            type="text"
            name="nama_lengkap"
            value="{{ old('nama_lengkap') }}"
            class="w-full rounded-lg border"
        >
        @error('nama_lengkap')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
                        </div>

                        {{-- NIK --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                NIK
                            </label>
                             <input
            type="text"
            name="nik"
            value="{{ old('nik') }}"
            class="w-full rounded-lg border"
        >
        @error('nik')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
                        </div>

                        {{-- Tempat Lahir --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Tempat Lahir
                            </label>
                            <input type="text" name="tempat_lahir"
                                   value="{{ old('tempat_lahir') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 transition duration-200">
                            @error('tempat_lahir')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Tanggal Lahir
                            </label>
                            <input type="date" name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 transition duration-200">
                            @error('tanggal_lahir')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Jenis Kelamin
                            </label>
                            <select name="jenis_kelamin"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 transition duration-200">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- No. HP / WhatsApp --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                No. HP / WhatsApp
                            </label>
                            <input type="text" name="no_hp"
                                   value="{{ old('no_hp') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 transition duration-200">
                            @error('no_hp')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Alamat
                            </label>
                            <textarea name="alamat" rows="3"
                                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 transition duration-200">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit"
                                class="bg-blue-800 hover:bg-blue-900 text-white
                                       px-8 py-3 rounded-lg font-semibold transition duration-200
                                       transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-offset-2
                                       shadow-md hover:shadow-lg">
                            Simpan & Lanjutkan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
