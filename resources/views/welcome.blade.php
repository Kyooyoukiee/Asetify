<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asetify - Kelola Aset Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10 font-sans text-gray-800">

    <div class="max-w-4xl mx-auto px-4">
        <header class="mb-8 text-center">
            <h1 class="text-4xl font-extrabold text-blue-600">Asetify</h1>
            <p class="text-sm text-gray-500 mt-1">Dibuat oleh <span class="font-semibold text-gray-700">Aditya</span></p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1 bg-white p-6 rounded-xl shadow-md border border-gray-100 h-fit">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Tambah Aset Baru</h2>
                
                <form action="/simpan_aset" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Aset</label>
                        <input type="text" name="nama_aset" required placeholder="Contoh: Laptop" 
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Harga Aset (Rp)</label>
                        <input type="number" name="harga_aset" required placeholder="0" 
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Pembelian</label>
                        <input type="date" name="tanggal_pembelian" required 
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    </div>

                    <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                        Simpan Data
                    </button>
                </form>
            </div>

            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-md border border-gray-100">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Daftar Aset</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
                                <th class="py-3 px-4">Nama Aset</th>
                                <th class="py-3 px-4">Harga</th>
                                <th class="py-3 px-4">Tanggal Beli</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse ($asets as $aset)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 font-medium text-gray-800">{{ $aset->nama_aset }}</td>
                                    <td class="py-3 px-4 text-green-600 font-semibold">
                                        Rp {{ number_format($aset->harga_aset, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-500">{{ $aset->tanggal_pembelian }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-gray-400">
                                        Belum ada data aset yang tersimpan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>