<?php

namespace App\Http\Controllers;

use App\Models\TempatWisata;
use App\Models\Kecamatan;
use App\Models\Fasilitas;
use App\Models\Layanan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $cloudName = config('filesystems.disks.cloudinary.cloud');

        // Query untuk MAP (dengan filter)
        $mapQuery = TempatWisata::with([
            'kecamatan',
            'tipeTempat',
            'fasilitas',
            'layanans',
            'images' => function($query) {
                $query->where('is_primary', true);
            }
        ])->where('is_active', true);

        if ($request->has('kecamatan') && $request->kecamatan != '') {
            $mapQuery->where('kecamatan_id', $request->kecamatan);
        }

        if ($request->has('fasilitas') && is_array($request->fasilitas) && count($request->fasilitas) > 0) {
            $mapQuery->whereHas('fasilitas', function($q) use ($request) {
                $q->whereIn('fasilitas.id', $request->fasilitas);
            });
        }

        if ($request->has('layanan') && is_array($request->layanan) && count($request->layanan) > 0) {
            $mapQuery->whereHas('layanans', function($q) use ($request) {
                $q->whereIn('layanans.id', $request->layanan);
            });
        }

        $tempatWisata = $mapQuery->get();

        $tempatWisata->each(function ($item) use ($cloudName) {
            if ($item->images->isNotEmpty()) {
                $item->primary_image_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->images->first()->path}";
            }
            
            $item->fasilitas->each(function ($fas) use ($cloudName) {
                $fas->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$fas->icon}";
            });
        });

        // Query untuk LIST SECTION (tanpa filter, random 3)
        $randomWisata = TempatWisata::with([
            'kecamatan',
            'tipeTempat',
            'fasilitas',
            'layanans',
            'images' => function($query) {
                $query->where('is_primary', true);
            }
        ])
        ->where('is_active', true)
        ->inRandomOrder()
        ->take(3)
        ->get();

        $randomWisata->each(function ($item) use ($cloudName) {
            if ($item->images->isNotEmpty()) {
                $item->primary_image_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->images->first()->path}";
            }
            
            $item->fasilitas->each(function ($fas) use ($cloudName) {
                $fas->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$fas->icon}";
            });
        });

        $kecamatans = Kecamatan::orderBy('name')->get();
        $fasilitas = Fasilitas::orderBy('name')->get();
        $layanans = Layanan::orderBy('name')->get();

        $fasilitas->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });

        $layanans->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });

        return view('home.index', compact('tempatWisata', 'randomWisata', 'kecamatans', 'fasilitas', 'layanans'));
    }

    public function list(Request $request)
    {
        $query = TempatWisata::with([
            'kecamatan',
            'tipeTempat',
            'fasilitas',
            'layanans',
            'images' => function($query) {
                $query->where('is_primary', true);
            }
        ])->where('is_active', true);

        if ($request->has('kecamatan') && $request->kecamatan != '') {
            $query->where('kecamatan_id', $request->kecamatan);
        }

        if ($request->has('fasilitas') && is_array($request->fasilitas) && count($request->fasilitas) > 0) {
            $query->whereHas('fasilitas', function($q) use ($request) {
                $q->whereIn('fasilitas.id', $request->fasilitas);
            });
        }

        if ($request->has('layanan') && is_array($request->layanan) && count($request->layanan) > 0) {
            $query->whereHas('layanans', function($q) use ($request) {
                $q->whereIn('layanans.id', $request->layanan);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('address', 'like', '%' . $request->search . '%');
            });
        }

        $tempatWisata = $query->orderBy('name')->get();

        $cloudName = config('filesystems.disks.cloudinary.cloud');
        
        $tempatWisata->each(function ($item) use ($cloudName) {
            if ($item->images->isNotEmpty()) {
                $item->primary_image_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->images->first()->path}";
            }
            
            $item->fasilitas->each(function ($fas) use ($cloudName) {
                $fas->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$fas->icon}";
            });
        });

        $kecamatans = Kecamatan::orderBy('name')->get();
        $fasilitas = Fasilitas::orderBy('name')->get();
        $layanans = Layanan::orderBy('name')->get();

        $fasilitas->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });

        $layanans->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });

        return view('home.list', compact('tempatWisata', 'kecamatans', 'fasilitas', 'layanans'));
    }

    public function show($slug)
    {
        $tempatWisata = TempatWisata::with([
            'kecamatan',
            'tipeTempat',
            'fasilitas',
            'layanans',
            'images',
            'openingHours' => function($query) {
                $query->orderBy('day_of_week');
            }
        ])
        ->where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();

        $cloudName = config('filesystems.disks.cloudinary.cloud');
        
        $tempatWisata->images->each(function ($item) use ($cloudName) {
            $item->image_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->path}";
        });

        $tempatWisata->fasilitas->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });

        $tempatWisata->layanans->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });

        return view('home.show', compact('tempatWisata'));
    }
}
