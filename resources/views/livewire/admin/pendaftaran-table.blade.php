<div class="space-y-4">
    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Mahasiswa</label>
                <input type="text" 
                       wire:model.debounce.300ms="search"
                       placeholder="Cari nama, NIK, atau email..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tampilkan</label>
                <select wire:model="perPage" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold cursor-pointer hover:bg-blue-700" wire:click="sort('id')">
                        ID
                        @if($sortBy === 'id')
                            <span class="float-right">{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left font-semibold cursor-pointer hover:bg-blue-700" wire:click="sort('nama_lengkap')">
                        Nama
                        @if($sortBy === 'nama_lengkap')
                            <span class="float-right">{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left font-semibold cursor-pointer hover:bg-blue-700" wire:click="sort('nik')">
                        NIK
                        @if($sortBy === 'nik')
                            <span class="float-right">{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left font-semibold">Email</th>
                    <th class="px-6 py-4 text-left font-semibold">Fakultas / Prodi</th>
                    <th class="px-6 py-4 text-left font-semibold cursor-pointer hover:bg-blue-700" wire:click="sort('status_pendaftaran')">
                        Status
                        @if($sortBy === 'status_pendaftaran')
                            <span class="float-right">{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pendaftaran as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $p->nama_lengkap }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $p->nik }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->user?->email ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $p->fakultas?->nama_fakultas ?? '-' }} / {{ $p->programStudi?->nama_prodi ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @php
                                $statusBg = [
                                    'data_diri' => 'bg-yellow-100 text-yellow-800',
                                    'prodi' => 'bg-blue-100 text-blue-800',
                                    'berkas' => 'bg-purple-100 text-purple-800',
                                    'selesai' => 'bg-green-100 text-green-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusBg[$p->status_pendaftaran] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $p->status_pendaftaran)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm space-x-2">
                            <a href="{{ route('admin.pendaftaran.show', $p) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">Lihat</a>
                            <a href="{{ route('admin.pendaftaran.edit', $p) }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.pendaftaran.destroy', $p) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="inline-block bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada data pendaftaran ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="bg-white rounded-lg shadow p-4">
        {{ $pendaftaran->links() }}
    </div>
</div>
