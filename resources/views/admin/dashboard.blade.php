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
{{-- Grafik Jumlah Mahasiswa per Prodi --}}
            <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
            Grafik Jumlah Mahasiswa per Program Studi
            </h2>
            <div class="relative h-56">
    <canvas id="chartProdi"></canvas>
</div>
            </div>

{{-- Grafik Gender --}}
<div class="bg-white rounded-xl shadow p-6 mb-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">
        Grafik Gender Mahasiswa
    </h2>

    <div class="relative h-64">
        <canvas id="chartGender"></canvas>
    </div>
</div>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let chartProdi = null;
let chartGender = null;

// ================= PRODI =================
function loadChartProdi() {
    fetch('/admin/dashboard/chart')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(i => i.nama_prodi);
const totals = data.map(i => i.total);


            if (chartProdi) {
                chartProdi.data.labels = labels;
                chartProdi.data.datasets[0].data = totals;
                chartProdi.update();
            } else {
                chartProdi = new Chart(document.getElementById('chartProdi'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Mahasiswa',
                            data: totals,
                            backgroundColor: '#3b82f6'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
        });
}

// ================= GENDER =================
function loadChartGender() {
    fetch('/admin/dashboard/gender-chart')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(i => i.jenis_kelamin);
            const totals = data.map(i => i.total);

            if (chartGender) {
                chartGender.data.labels = labels;
                chartGender.data.datasets[0].data = totals;
                chartGender.update();
            } else {
                chartGender = new Chart(document.getElementById('chartGender'), {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: totals,
                            backgroundColor: ['#60a5fa', '#f472b6']
                        }]
                    }
                });
            }
        });
}

// load awal
loadChartProdi();
loadChartGender();

// realtime polling
setInterval(() => {
    loadChartProdi();
    loadChartGender();
}, 5000);
</script>

</x-app-layout>
