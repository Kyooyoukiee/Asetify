<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;

class AsetController extends Controller
{
    public function simpan(request $req){
        Aset::create([
            'nama_aset' => $req->nama_aset,
            'harga_aset' => $req->harga_aset,
            'tanggal_pembelian' => $req->tanggal_pembelian,
        ]);
        return redirect('/');
    }
    public function tampil(){
        $asets = Aset::all();
        return view('welcome', compact('asets'));
    }
}   







