<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Aset - Asetify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-6 sm:py-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Edit Aset</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">Perbarui informasi aset</p>
                </div>
                <a href="/" class="inline-flex items-center px-3.5 py-2 sm:px-4 sm:py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-scale-in" style="animation-delay: 0.2s;">
            <form action="/update_aset/{{ $aset->id }}" method="POST" class="p-5 sm:p-8 space-y-5 sm:space-y-6">
                @csrf

                <!-- Nama Aset -->
                <div>
                    <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                        Nama Aset <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_aset"
                        name="nama_aset"
                        value="{{ $aset->nama_aset }}"
                        required
                        class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none"
                        placeholder="Contoh: Laptop Dell XPS 13">
                </div>

                <!-- Harga dan Jumlah -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="harga_aset" class="block text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                            Harga Aset (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="harga_aset"
                            name="harga_aset"
                            value="{{ $aset->harga_aset }}"
                            required
                            min="0"
                            class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none"
                            placeholder="15000000">
                    </div>

                    <div>
                        <label for="jumlah_aset" class="block text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                            Jumlah Aset <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="jumlah_aset"
                            name="jumlah_aset"
                            value="{{ $aset->jumlah_aset }}"
                            required
                            min="1"
                            class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none"
                            placeholder="1">
                    </div>
                </div>

                <!-- Tanggal Pembelian -->
                <div>
                    <label for="tanggal_pembelian" class="block text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                        Tanggal Pembelian <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="tanggal_pembelian"
                        name="tanggal_pembelian"
                        value="{{ $aset->tanggal_pembelian }}"
                        required
                        class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none">
                </div>

                <!-- Kondisi dan Kategori -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="kondisi_aset" class="block text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                            Kondisi Aset <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="kondisi_aset"
                            name="kondisi_aset"
                            required
                            class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none bg-white">
                            <option value="">Pilih kondisi...</option>
                            <option value="Baru" {{ $aset->kondisi_aset == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Bekas" {{ $aset->kondisi_aset == 'Bekas' ? 'selected' : '' }}>Bekas</option>
                            <option value="Rusak" {{ $aset->kondisi_aset == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>

                    <div>
                        <label for="kategori_aset" class="block text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                            Kategori Aset <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="kategori_aset"
                            name="kategori_aset"
                            value="{{ $aset->kategori_aset }}"
                            required
                            class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none"
                            placeholder="Contoh: Elektronik">
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
                        Update Aset
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
