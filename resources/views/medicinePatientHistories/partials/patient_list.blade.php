@php
    function formatTanggalIndonesia($date) {
        if (!$date) return 'Tanggal tidak tersedia';

        $bulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $tanggal = \Carbon\Carbon::parse($date);
        return $tanggal->format('d') . ' ' . $bulan[$tanggal->format('m')] . ' ' . $tanggal->format('Y');
    }
@endphp

<!-- Modal Filter -->
<div id="filterModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Filter Data</h3>
            <button onclick="toggleFilterModal()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="filterForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rentang Tanggal</label>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
                        <input type="date"
                               id="start_date"
                               name="start_date"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Sampai Tanggal</label>
                        <input type="date"
                               id="end_date"
                               name="end_date"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-2 pt-4">
                <button type="button"
                        onclick="resetFilter()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Reset
                </button>
                <button type="button"
                        onclick="applyFilter()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Terapkan
                </button>
            </div>
        </form>
    </div>
</div>

<div class="overflow-hidden rounded-xl border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center">
                        <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                        Informasi Pasien
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                        Tanggal Pengambilan
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center">
                        <i class="fas fa-notes-medical text-blue-500 mr-2"></i>
                        Status
                    </div>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($patients as $index => $patient)
                @foreach($patient->medicinePatientHistories->groupBy('prescription_id') as $prescriptionHistories)
                    @php
                        $firstRow = true;
                        $rowspan = $prescriptionHistories->count();
                    @endphp
                    @foreach($prescriptionHistories as $history)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer"
                            @if(isset($history->patient_id) && $history->patient_id)
                                onclick="window.location.href='{{ route('patients.show', $history->patient_id) }}'"
                            @endif
                        >
                            @if($firstRow)
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" rowspan="{{ $rowspan }}">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $rowspan }}">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-user text-blue-500"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $patient->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                <i class="fas fa-id-card text-blue-400 mr-1"></i>
                                                BPJS: {{ $patient->no_bpjs ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $rowspan }}">
                                    <div class="text-sm text-gray-900">{{ formatTanggalIndonesia($history->taken_at) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $rowspan }}">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Selesai
                                    </span>
                                </td>
                                @php $firstRow = false; @endphp
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center">
                        <div class="flex flex-col items-center">
                            <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-folder-open text-gray-400 text-2xl"></i>
                            </div>
                            <div class="text-gray-500 text-lg font-medium">Tidak ada data</div>
                            <p class="text-gray-400 text-sm mt-1">Belum ada riwayat pengambilan obat yang tercatat</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $patients->links('pagination::tailwind') }}
</div>

@push('styles')
<style>
    /* Hover effect untuk baris tabel */
    .hover\:bg-gray-50:hover {
        background-color: rgba(249, 250, 251, 1);
    }

    /* Transisi smooth untuk hover */
    .transition-colors {
        transition: background-color 0.2s ease-in-out;
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle Filter Modal
    function toggleFilterModal() {
        const modal = document.getElementById('filterModal');
        modal.classList.toggle('hidden');
    }

    // Reset Filter
    function resetFilter() {
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
        applyFilter();
    }

    // Apply Filter
    function applyFilter() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const query = document.getElementById('patient_name').value;

        let url = new URL(window.location.href);
        url.searchParams.set('start_date', startDate);
        url.searchParams.set('end_date', endDate);
        if (query) {
            url.searchParams.set('query', query);
        }

        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('patient-list').innerHTML = html;
                toggleFilterModal();
            });
    }

    // Update button click handler
    document.querySelector('button[onclick="toggleFilterModal()"]')?.addEventListener('click', toggleFilterModal);
</script>
@endpush
