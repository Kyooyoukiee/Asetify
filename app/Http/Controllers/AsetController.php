<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;

class AsetController extends Controller
{
    public function index()
    {
        $asets = Aset::all();
        return view('welcome', compact('asets'));
    }

    public function tambah()
    {
        return view('tambah-aset');
    }

    public function simpan_aset(Request $request)
    {
        $validated = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'harga_aset' => 'required|numeric|min:0',
            'tanggal_pembelian' => 'required|date',
            'jumlah_aset' => 'required|integer|min:1',
            'kondisi_aset' => 'required|in:Baru,Bekas,Rusak',
            'kategori_aset' => 'required|string|max:100',
        ], [
            'nama_aset.required' => 'Nama aset wajib diisi.',
            'harga_aset.required' => 'Harga aset wajib diisi.',
            'harga_aset.numeric' => 'Harga aset harus berupa angka.',
            'harga_aset.min' => 'Harga aset tidak boleh kurang dari 0.',
            'tanggal_pembelian.required' => 'Tanggal pembelian wajib dipilih.',
            'jumlah_aset.required' => 'Jumlah aset wajib diisi.',
            'jumlah_aset.min' => 'Jumlah aset minimal 1 unit.',
            'kondisi_aset.required' => 'Silakan pilih kondisi aset.',
            'kategori_aset.required' => 'Kategori aset wajib diisi.',
        ]);

        Aset::create($validated);

        return redirect('/')->with('success', 'Aset baru berhasil ditambahkan!');
    }

    public function hapus_aset($id)
    {
        $aset = Aset::findOrFail($id);
        $aset->delete();

        return redirect('/')->with('success', 'Aset berhasil dihapus!');
    }

    public function edit_aset($id)
    {
        $aset = Aset::findOrFail($id);
        return view('edit-aset', compact('aset'));
    }

    public function update_aset(Request $request, $id)
    {
        $aset = Aset::findOrFail($id);

        $validated = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'harga_aset' => 'required|numeric|min:0',
            'tanggal_pembelian' => 'required|date',
            'jumlah_aset' => 'required|integer|min:1',
            'kondisi_aset' => 'required|in:Baru,Bekas,Rusak',
            'kategori_aset' => 'required|string|max:100',
        ], [
            'nama_aset.required' => 'Nama aset wajib diisi.',
            'harga_aset.required' => 'Harga aset wajib diisi.',
            'harga_aset.numeric' => 'Harga aset harus berupa angka.',
            'harga_aset.min' => 'Harga aset tidak boleh kurang dari 0.',
            'tanggal_pembelian.required' => 'Tanggal pembelian wajib dipilih.',
            'jumlah_aset.required' => 'Jumlah aset wajib diisi.',
            'jumlah_aset.min' => 'Jumlah aset minimal 1 unit.',
            'kondisi_aset.required' => 'Silakan pilih kondisi aset.',
            'kategori_aset.required' => 'Kategori aset wajib diisi.',
        ]);

        $aset->update($validated);

        return redirect('/')->with('success', 'Data aset berhasil diperbarui!');
    }
}
