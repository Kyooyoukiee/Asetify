<?php

use Livewire\Volt\Component;
use App\Models\Aset;
use Livewire\Attributes\Computed;

new class extends Component {
    public $query = '';
    public $kategori = '';

    #[Computed]
    public function asets()
    {
        return Aset::query()
            ->when($this->query, function ($q) {
                $q->where('nama_aset', 'like', '%' . $this->query . '%');
            })
            ->when($this->kategori, function ($q) {
                $q->where('kategori_aset', $this->kategori);
            })
            ->get();
    }

    #[Computed]
    public function totalHarga()
    {
        return $this->asets->sum(function ($aset) {
            return $aset->harga_aset * $aset->jumlah_aset;
        });
    }

    #[Computed]
    public function totalJumlah()
    {
        return $this->asets->sum('jumlah_aset');
    }

    #[Computed]
    public function daftarKategori()
    {
        return Aset::query()
            ->whereNotNull('kategori_aset')
            ->distinct()
            ->orderBy('kategori_aset')
            ->pluck('kategori_aset');
    }

    #[Computed]
    public function dataChartBulanan()
    {
        return Aset::query()
            ->selectRaw("strftime('%Y-%m', tanggal_pembelian) as bulan, COUNT(*) as total")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');
    }

    #[Computed]
    public function statistikKondisi()
    {
        return Aset::query()
            ->selectRaw('kondisi_aset, COUNT(*) as total')
            ->groupBy('kondisi_aset')
            ->pluck('total', 'kondisi_aset');
    }
} ?>

<div class="min-h-screen bg-gray-50">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Asetify</h1>
                    <span class="ml-2.5 sm:ml-3 px-2.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Dashboard</span>
                </div>
                <a href="/tambah_aset" class="inline-flex items-center px-3.5 py-2 sm:px-4 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Aset</span>
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        @if (session('success'))
            <div id="flashSuccess" class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-fade-in-up">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('flashSuccess').remove()" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg hover:bg-emerald-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Total Aset -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Aset</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">{{ $this->totalJumlah }}</p>
                        <p class="text-xs text-gray-500 mt-1">Unit aset terdaftar</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full animate-bounce-subtle text-blue-600">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Nilai -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Nilai Aset</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">Rp {{ number_format($this->totalHarga / 1000000, 1) }}M</p>
                        <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($this->totalHarga, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-full animate-bounce-subtle text-green-600" style="animation-delay: 0.1s;">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Kategori -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate-fade-in-up sm:col-span-2 md:col-span-1" style="animation-delay: 0.3s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Kategori Aset</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">{{ $this->daftarKategori->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Kategori berbeda</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-full animate-bounce-subtle text-purple-600" style="animation-delay: 0.2s;">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Chart Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 sm:mb-8">
            <!-- Filters Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 animate-slide-in-right" style="animation-delay: 0.4s;">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">Filter Aset</h3>
                <div class="space-y-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1.5">Cari Nama Aset</label>
                        <div class="relative">
                            <input
                                type="text"
                                id="search"
                                wire:model.live.debounce.300ms="query"
                                placeholder="Ketik untuk mencari..."
                                class="w-full pl-10 pr-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                        <select
                            id="kategori"
                            wire:model.live="kategori"
                            class="w-full px-3.5 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach ($this->daftarKategori as $k)
                                <option value="{{ $k }}">{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($this->query || $this->kategori)
                        <button
                            wire:click="$set('query', ''); $set('kategori', '')"
                            class="w-full px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                            Reset Filter
                        </button>
                    @endif
                </div>

                <!-- Kondisi Statistics -->
                <div class="mt-5 pt-5 border-t border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Statistik Kondisi</h4>
                    <div class="space-y-2">
                        @foreach($this->statistikKondisi as $kondisi => $jumlah)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center">
                                    @if($kondisi == 'Baru')
                                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full mr-2"></span>
                                    @elseif($kondisi == 'Bekas')
                                        <span class="w-2.5 h-2.5 bg-yellow-500 rounded-full mr-2"></span>
                                    @else
                                        <span class="w-2.5 h-2.5 bg-red-500 rounded-full mr-2"></span>
                                    @endif
                                    <span class="text-gray-600">{{ $kondisi }}</span>
                                </div>
                                <span class="font-semibold text-gray-900">{{ $jumlah }} unit</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Chart Card -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 animate-scale-in" style="animation-delay: 0.5s;">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">Pembelian Aset Bulanan</h3>
                <div class="h-60 sm:h-64">
                    <canvas id="chartBulanan" wire:ignore></canvas>
                </div>
            </div>
        </div>

        <!-- Asset Table & Mobile Cards -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden animate-fade-in-up" style="animation-delay: 0.6s;">
            <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Daftar Aset</h2>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Menampilkan {{ $this->asets->count() }} aset</p>
                </div>
            </div>

            <!-- Mobile View: Modern Cards (Tampil otomatis di HP / Layar Kecil) -->
            <div class="block md:hidden divide-y divide-gray-100">
                @forelse ($this->asets as $aset)
                    <div class="p-4 space-y-3 hover:bg-gray-50/80 transition-colors">
                        <!-- Header: Nama, Kategori, Badge Kondisi -->
                        <div class="flex items-start justify-between gap-2">
                            <div class="space-y-0.5">
                                <h3 class="font-semibold text-gray-900 text-base leading-snug">{{ $aset->nama_aset }}</h3>
                                <span class="inline-block px-2.5 py-0.5 text-xs font-medium rounded-md bg-blue-50 text-blue-700 border border-blue-100/60">
                                    {{ $aset->kategori_aset }}
                                </span>
                            </div>
                            <div>
                                @if($aset->kondisi_aset == 'Baru')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Baru
                                    </span>
                                @elseif($aset->kondisi_aset == 'Bekas')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Bekas
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Rusak
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Mid Box: Detail Harga & Jumlah -->
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Harga Satuan</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($aset->harga_aset, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Jumlah Unit</span>
                                <span class="font-medium text-gray-800">{{ $aset->jumlah_aset }} unit</span>
                            </div>
                            <div class="pt-1.5 border-t border-gray-200/60 flex items-center justify-between text-xs">
                                <span class="text-gray-500">Tgl Beli: {{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d M Y') }}</span>
                                <span class="font-bold text-blue-600">Total: Rp {{ number_format($aset->harga_aset * $aset->jumlah_aset, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Bottom: Action Buttons -->
                        <div class="flex items-center justify-end gap-2 pt-0.5">
                            <a href="/edit_aset/{{ $aset->id }}" class="flex-1 text-center py-2 px-3 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <button onclick="confirmDelete({{ $aset->id }}, '{{ addslashes($aset->nama_aset) }}')" class="flex-1 text-center py-2 px-3 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-10 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-gray-500 text-sm font-medium">Tidak ada aset ditemukan</p>
                        <p class="text-gray-400 text-xs mt-1">Coba ubah filter atau tambah aset baru</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop View: Table (Tampil di Layar Tablet & Komputer / Layar Lebar) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Aset</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Beli</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kondisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($this->asets as $aset)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $aset->nama_aset }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Rp {{ number_format($aset->harga_aset, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-900">{{ $aset->jumlah_aset }} unit</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($aset->kondisi_aset == 'Baru')
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Baru
                                        </span>
                                    @elseif($aset->kondisi_aset == 'Bekas')
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Bekas
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rusak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $aset->kategori_aset }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="/edit_aset/{{ $aset->id }}" class="text-blue-600 hover:text-blue-900 p-1.5 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <button onclick="confirmDelete({{ $aset->id }}, '{{ addslashes($aset->nama_aset) }}')" class="text-red-600 hover:text-red-900 p-1.5 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-gray-500 text-sm font-medium">Tidak ada aset ditemukan</p>
                                        <p class="text-gray-400 text-xs mt-1">Coba ubah filter atau tambah aset baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 transition-opacity duration-200" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 transform transition-all animate-scale-in border border-gray-100">
                <!-- Icon -->
                <div class="flex items-center justify-center w-14 h-14 mx-auto mb-4 bg-red-50 rounded-full text-red-600">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>

                <!-- Content -->
                <div class="text-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Hapus Aset?</h3>
                    <p class="text-sm text-gray-500">Anda yakin ingin menghapus aset <span class="font-semibold text-gray-800" id="assetName"></span>?</p>
                    <p class="text-xs text-red-500 mt-2 bg-red-50 py-1.5 px-3 rounded-lg inline-block">⚠️ Tindakan ini tidak dapat dibatalkan</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button
                        type="button"
                        onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-all duration-150">
                        Batal
                    </button>
                    <button
                        type="button"
                        id="confirmDeleteBtn"
                        class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-all duration-150 shadow-sm hover:shadow flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    @assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endassets

    @script
    <script>
        // Delete Modal Functions
        window.confirmDelete = function(id, name) {
            const modal = document.getElementById('deleteModal');
            const assetName = document.getElementById('assetName');
            const confirmBtn = document.getElementById('confirmDeleteBtn');

            assetName.textContent = name;
            modal.style.display = 'block';

            confirmBtn.onclick = function() {
                window.location.href = '/hapus_aset/' + id;
            };
        }

        window.closeDeleteModal = function() {
            const modal = document.getElementById('deleteModal');
            modal.style.display = 'none';
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Close modal on backdrop click
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('deleteModal');
            if (e.target === modal) {
                closeDeleteModal();
            }
        });

        // Chart.js Configuration
        let dataBulanan = @json($this->dataChartBulanan);
        let ctxLine = document.getElementById('chartBulanan').getContext('2d');
        let chartLine = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: Object.keys(dataBulanan),
                datasets: [{
                    label: 'Jumlah Aset Dibeli',
                    data: Object.values(dataBulanan),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        Livewire.hook('morph.updated', () => {
            let dataBulananBaru = @json($this->dataChartBulanan);
            chartLine.data.labels = Object.keys(dataBulananBaru);
            chartLine.data.datasets[0].data = Object.values(dataBulananBaru);
            chartLine.update();
        });
    </script>
    @endscript
</div>
