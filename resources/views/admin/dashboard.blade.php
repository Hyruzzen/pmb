<x-app-layout>
    <div class="py-8 md:py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-blue-900">Dashboard Admin</h1>
                <p class="text-blue-600 mt-1">Kelola data pendaftar calon mahasiswa</p>
            </div>

            <div id="flash"></div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full" id="pendaftar-table">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">ID</th>
                            <th class="px-6 py-4 text-left font-semibold">Nama</th>
                            <th class="px-6 py-4 text-left font-semibold">Email</th>
                            <th class="px-6 py-4 text-left font-semibold">NIK</th>
                            <th class="px-6 py-4 text-left font-semibold">Fakultas / Prodi</th>
                            <th class="px-6 py-4 text-left font-semibold">Status</th>
                            <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200"></tbody>
                </table>
            </div>
            </table>
        </div>
    </div>

    <script>
async function fetchData(){
    const res = await fetch("{{ route('admin.pendaftaran.data') }}", {headers:{'Accept':'application/json'}});
    if (!res.ok) return;
    const rows = await res.json();
    const tbody = document.querySelector('#pendaftar-table tbody');
    tbody.innerHTML = '';
    for (const r of rows) {
        const tr = document.createElement('tr');
        const statusColors = {data_diri:'bg-yellow-100 text-yellow-800', prodi:'bg-blue-100 text-blue-800', berkas:'bg-purple-100 text-purple-800', selesai:'bg-green-100 text-green-800'};
        const statusBg = statusColors[r.status_pendaftaran] || 'bg-gray-100 text-gray-800';
        tr.innerHTML = `
            <td class="px-6 py-4 text-sm font-medium text-gray-900">${r.id}</td>
            <td class="px-6 py-4 text-sm text-gray-700">${r.nama_lengkap || '-'}</td>
            <td class="px-6 py-4 text-sm text-gray-600">${r.user?.email || '-'}</td>
            <td class="px-6 py-4 text-sm text-gray-700">${r.nik || '-'}</td>
            <td class="px-6 py-4 text-sm text-gray-700">${r.fakultas?.nama_fakultas || '-'} / ${r.program_studi?.nama_prodi || '-'}</td>
            <td class="px-6 py-4 text-sm"><span class="px-3 py-1 rounded-full text-xs font-medium ${statusBg}">${r.status_pendaftaran || '-'}</span></td>
            <td class="px-6 py-4 text-center text-sm space-x-2">
                <a class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs" href="/admin/pendaftarans/${r.id}">Lihat</a>
                <a class="inline-block bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs" href="/admin/pendaftarans/${r.id}/edit">Edit</a>
                <form style="display:inline" method="POST" action="/admin/pendaftarans/${r.id}">` +
                `@csrf` + `@method('DELETE')` + `
                    <button class="inline-block bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </td>
        `;
        tbody.appendChild(tr);
    }
}

fetchData();
setInterval(fetchData, 5000);
    </script>
</x-app-layout>
