<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Fasilitas;
use App\Models\TipeTempat;
use App\Models\TempatWisata;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'kecamatan' => Kecamatan::count(),
            'fasilitas' => Fasilitas::count(),
            'tipe_tempat' => TipeTempat::count(),
            'tempat_wisata' => TempatWisata::count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
