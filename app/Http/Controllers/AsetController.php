<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;

class AsetController extends Controller
{
    public function index()
    {
        $asets = Aset::all();
        return view('welcome', compact('asets',));
    }
    public function tambah()
    {
        return view('tambah-aset');
    }
    public function simpan_aset(Request $simpan_aset)
    {
        Aset::create([
            'nama_aset' => $simpan_aset->nama_aset,
            'harga_aset' => $simpan_aset->harga_aset,
            'tanggal_pembelian' => $simpan_aset->tanggal_pembelian,
            'jumlah_aset' => $simpan_aset->jumlah_aset,
            'kondisi_aset' => $simpan_aset->kondisi_aset,
            'kategori_aset' => $simpan_aset->kategori_aset,
        ]);
        return redirect('/');
    }
    public function hapus_aset($id)
    {
        $aset = Aset::find($id);
        $aset->delete();
        return redirect('/');
    }
    public function edit_aset($id)
    {
        $aset = Aset::find($id);
        return view('edit-aset', compact('aset'));
    }
    public function update_aset(Request $update_aset, $id)
    {
        $aset = Aset::find($id);
        $aset->update([
            'nama_aset' => $update_aset->nama_aset,
            'harga_aset' => $update_aset->harga_aset,
            'tanggal_pembelian' => $update_aset->tanggal_pembelian,
            'jumlah_aset' => $update_aset->jumlah_aset,
            'kondisi_aset' => $update_aset->kondisi_aset,
            'kategori_aset' => $update_aset->kategori_aset,
        ]);
        return redirect('/');
    }
}








