<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Aset - Asetify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-6 sm:py-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Tambah Aset Baru</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">Lengkapi informasi aset yang akan ditambahkan</p>
                </div>
                <a href="/" class="inline-flex items-center px-3.5 py-2 sm:px-4 sm:py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 animate-scale-in">
                <div class="flex items-center gap-2 font-semibold text-sm mb-1">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Ada beberapa kolom yang belum terisi dengan benar:
                </div>
                <ul class="list-disc list-inside text-xs sm:text-sm text-red-600 pl-2 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-scale-in" style="animation-delay: 0.2s;">
            <form id="assetForm" action="/simpan_aset" method="POST" novalidate class="p-5 sm:p-8 space-y-5 sm:space-y-6">
                @csrf

                <!-- Nama Aset -->
                <div class="field-group">
                    <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Aset <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_aset"
                        name="nama_aset"
                        value="{{ old('nama_aset') }}"
                        required
                        class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border @error('nama_aset') border-red-400 bg-red-50/30 focus:ring-red-500 @else border-gray-300 focus:ring-blue-500 @enderror rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 outline-none"
                        placeholder="Contoh: Laptop Dell XPS 13">
                    <p class="error-msg text-xs text-red-500 mt-1.5 hidden items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Nama aset wajib diisi</span>
                    </p>
                    @error('nama_aset')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Harga dan Jumlah -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="field-group">
                        <label for="harga_aset" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Harga Aset (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="harga_aset"
                            name="harga_aset"
                            value="{{ old('harga_aset') }}"
                            required
                            min="0"
                            class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border @error('harga_aset') border-red-400 bg-red-50/30 focus:ring-red-500 @else border-gray-300 focus:ring-blue-500 @enderror rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 outline-none"
                            placeholder="15000000">
                        <p class="error-msg text-xs text-red-500 mt-1.5 hidden items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Harga aset wajib diisi angka valid</span>
                        </p>
                        @error('harga_aset')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="jumlah_aset" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Jumlah Aset <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="jumlah_aset"
                            name="jumlah_aset"
                            value="{{ old('jumlah_aset', 1) }}"
                            required
                            min="1"
                            class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border @error('jumlah_aset') border-red-400 bg-red-50/30 focus:ring-red-500 @else border-gray-300 focus:ring-blue-500 @enderror rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 outline-none"
                            placeholder="1">
                        <p class="error-msg text-xs text-red-500 mt-1.5 hidden items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Jumlah aset minimal 1 unit</span>
                        </p>
                        @error('jumlah_aset')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Tanggal Pembelian -->
                <div class="field-group">
                    <label for="tanggal_pembelian" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Tanggal Pembelian <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="tanggal_pembelian"
                        name="tanggal_pembelian"
                        value="{{ old('tanggal_pembelian') }}"
                        required
                        class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border @error('tanggal_pembelian') border-red-400 bg-red-50/30 focus:ring-red-500 @else border-gray-300 focus:ring-blue-500 @enderror rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 outline-none">
                    <p class="error-msg text-xs text-red-500 mt-1.5 hidden items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Pilih tanggal pembelian aset</span>
                    </p>
                    @error('tanggal_pembelian')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Kondisi dan Kategori -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="field-group">
                        <label for="kondisi_aset" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Kondisi Aset <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="kondisi_aset"
                            name="kondisi_aset"
                            required
                            class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border @error('kondisi_aset') border-red-400 bg-red-50/30 focus:ring-red-500 @else border-gray-300 focus:ring-blue-500 @enderror rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 outline-none bg-white">
                            <option value="">Pilih kondisi...</option>
                            <option value="Baru" {{ old('kondisi_aset') == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Bekas" {{ old('kondisi_aset') == 'Bekas' ? 'selected' : '' }}>Bekas</option>
                            <option value="Rusak" {{ old('kondisi_aset') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                        <p class="error-msg text-xs text-red-500 mt-1.5 hidden items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Silakan pilih salah satu kondisi aset</span>
                        </p>
                        @error('kondisi_aset')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="kategori_aset" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Kategori Aset <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="kategori_aset"
                            name="kategori_aset"
                            value="{{ old('kategori_aset') }}"
                            required
                            class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border @error('kategori_aset') border-red-400 bg-red-50/30 focus:ring-red-500 @else border-gray-300 focus:ring-blue-500 @enderror rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 outline-none"
                            placeholder="Contoh: Elektronik">
                        <p class="error-msg text-xs text-red-500 mt-1.5 hidden items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Kategori aset wajib diisi</span>
                        </p>
                        @error('kategori_aset')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-3 sm:gap-4 pt-4 border-t border-gray-200">
                    <button
                        type="submit"
                        class="w-full sm:w-auto px-5 py-2.5 sm:px-6 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm sm:text-base font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Aset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Interactive Client-side Validation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('assetForm');
            const inputs = form.querySelectorAll('input, select');

            function validateField(input) {
                const group = input.closest('.field-group');
                if (!group) return true;
                const errorMsg = group.querySelector('.error-msg');
                let isValid = true;

                if (input.hasAttribute('required') && !input.value.trim()) {
                    isValid = false;
                } else if (input.type === 'number') {
                    if (input.id === 'harga_aset' && Number(input.value) < 0) isValid = false;
                    if (input.id === 'jumlah_aset' && Number(input.value) < 1) isValid = false;
                }

                if (!isValid) {
                    input.classList.remove('border-gray-300', 'focus:ring-blue-500');
                    input.classList.add('border-red-400', 'bg-red-50/30', 'focus:ring-red-500');
                    if (errorMsg) {
                        errorMsg.classList.remove('hidden');
                        errorMsg.classList.add('flex');
                    }
                } else {
                    input.classList.remove('border-red-400', 'bg-red-50/30', 'focus:ring-red-500');
                    input.classList.add('border-gray-300', 'focus:ring-blue-500');
                    if (errorMsg) {
                        errorMsg.classList.add('hidden');
                        errorMsg.classList.remove('flex');
                    }
                }
                return isValid;
            }

            inputs.forEach(input => {
                input.addEventListener('input', () => validateField(input));
                input.addEventListener('change', () => validateField(input));
            });

            form.addEventListener('submit', function(e) {
                let formValid = true;
                let firstInvalid = null;

                inputs.forEach(input => {
                    if (!validateField(input)) {
                        formValid = false;
                        if (!firstInvalid) firstInvalid = input;
                    }
                });

                if (!formValid) {
                    e.preventDefault();
                    if (firstInvalid) {
                        firstInvalid.focus();
                    }
                }
            });
        });
    </script>
</body>
</html>
