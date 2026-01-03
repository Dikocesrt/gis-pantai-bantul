<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKecamatanRequest;
use App\Http\Requests\UpdateKecamatanRequest;
use App\Models\Kecamatan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::with(['creator', 'updater'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kecamatan.index', compact('kecamatans'));
    }

    public function store(StoreKecamatanRequest $request)
    {
        try {
            $data = [
                'id' => (string) Str::uuid(),
                'name' => $request->name,
                'color' => $request->color ?? '#10b981',
                'center_lat' => $request->center_lat,
                'center_lng' => $request->center_lng,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ];

            // Handle GeoJSON file upload
            if ($request->hasFile('boundary_file')) {
                $file = $request->file('boundary_file');
                $geojsonContent = file_get_contents($file->getRealPath());
                
                // Validate JSON format
                $decoded = json_decode($geojsonContent);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return redirect()->route('kecamatan.index')
                        ->with('error', 'File GeoJSON tidak valid. Pastikan format JSON benar.');
                }

                $data['boundary_geojson'] = $geojsonContent;

                // Auto-calculate center point if not provided
                if (!$request->center_lat || !$request->center_lng) {
                    $center = $this->calculateCenter($decoded);
                    if ($center) {
                        $data['center_lat'] = $center['lat'];
                        $data['center_lng'] = $center['lng'];
                    }
                }
            }

            Kecamatan::create($data);

            return redirect()->route('kecamatan.index')
                ->with('success', 'Kecamatan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('kecamatan.index')
                ->with('error', 'Gagal menambahkan kecamatan: ' . $e->getMessage());
        }
    }

    public function update(UpdateKecamatanRequest $request, $id)
    {
        try {
            $kecamatan = Kecamatan::findOrFail($id);

            $data = [
                'name' => $request->name,
                'updated_by' => Auth::id(),
            ];

            // Update color if provided
            if ($request->filled('color')) {
                $data['color'] = $request->color;
            }

            // Update center coordinates if provided
            if ($request->filled('center_lat')) {
                $data['center_lat'] = $request->center_lat;
            }
            if ($request->filled('center_lng')) {
                $data['center_lng'] = $request->center_lng;
            }

            // Handle GeoJSON file upload
            if ($request->hasFile('boundary_file')) {
                $file = $request->file('boundary_file');
                $geojsonContent = file_get_contents($file->getRealPath());
                
                // Validate JSON format
                $decoded = json_decode($geojsonContent);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return redirect()->route('kecamatan.index')
                        ->with('error', 'File GeoJSON tidak valid. Pastikan format JSON benar.');
                }

                $data['boundary_geojson'] = $geojsonContent;

                // Auto-calculate center point if not provided
                if (!$request->filled('center_lat') || !$request->filled('center_lng')) {
                    $center = $this->calculateCenter($decoded);
                    if ($center) {
                        $data['center_lat'] = $center['lat'];
                        $data['center_lng'] = $center['lng'];
                    }
                }
            }

            $kecamatan->update($data);

            return redirect()->route('kecamatan.index')
                ->with('success', 'Kecamatan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('kecamatan.index')
                ->with('error', 'Gagal memperbarui kecamatan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $kecamatan = Kecamatan::findOrFail($id);
            $kecamatan->delete();

            return redirect()->route('kecamatan.index')
                ->with('success', 'Kecamatan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('kecamatan.index')
                ->with('error', 'Gagal menghapus kecamatan. Silakan coba lagi.');
        }
    }

    /**
     * Calculate center point from GeoJSON
     */
    private function calculateCenter($geojson)
    {
        try {
            $coordinates = null;

            // Handle FeatureCollection (multiple features)
            if (isset($geojson->type) && $geojson->type === 'FeatureCollection' && isset($geojson->features)) {
                // Collect all coordinates from all features
                $allPoints = [];
                foreach ($geojson->features as $feature) {
                    if (isset($feature->geometry->coordinates)) {
                        $featurePoints = [];
                        $this->flattenCoordinates($feature->geometry->coordinates, $featurePoints);
                        $allPoints = array_merge($allPoints, $featurePoints);
                    }
                }
                
                if (!empty($allPoints)) {
                    return $this->calculateAveragePoint($allPoints);
                }
            }
            
            // Handle single Feature
            if (isset($geojson->geometry->coordinates)) {
                $coordinates = $geojson->geometry->coordinates;
            } 
            // Handle Geometry only
            elseif (isset($geojson->coordinates)) {
                $coordinates = $geojson->coordinates;
            }

            if (!$coordinates) {
                return null;
            }

            // Flatten coordinates array
            $points = [];
            $this->flattenCoordinates($coordinates, $points);

            if (empty($points)) {
                return null;
            }

            return $this->calculateAveragePoint($points);
        } catch (\Exception $e) {
            Log::error('Error calculating center: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Calculate average point from array of coordinates
     */
    private function calculateAveragePoint($points)
    {
        $latSum = 0;
        $lngSum = 0;
        $count = count($points);

        foreach ($points as $point) {
            $lngSum += $point[0]; // GeoJSON uses [lng, lat]
            $latSum += $point[1];
        }

        return [
            'lat' => round($latSum / $count, 7),
            'lng' => round($lngSum / $count, 7),
        ];
    }

    /**
     * Flatten nested coordinates array
     */
    private function flattenCoordinates($coordinates, &$result = [])
    {
        foreach ($coordinates as $item) {
            if (is_array($item) && count($item) === 2 && is_numeric($item[0]) && is_numeric($item[1])) {
                $result[] = $item;
            } elseif (is_array($item)) {
                $this->flattenCoordinates($item, $result);
            }
        }
        return $result;
    }
}
