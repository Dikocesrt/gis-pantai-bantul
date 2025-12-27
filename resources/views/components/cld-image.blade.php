@php
    use Illuminate\Support\Facades\Storage;

    $cloudName = config('filesystems.disks.cloudinary.cloud');

    // Build URL manual tanpa tambahan prefix
    // $publicId sudah include full path dari database (gis-pantai-bantul/fasilitas/xyz.svg)
    $transformations = [];

    // Width and height
    if (isset($width) && isset($height)) {
        $transformations[] = "w_{$width},h_{$height}";
    } elseif (isset($width)) {
        $transformations[] = "w_{$width}";
    } elseif (isset($height)) {
        $transformations[] = "h_{$height}";
    }

    // Crop mode
    if (isset($crop)) {
        $transformations[] = "c_{$crop}";
    }

    // Gravity
    if (isset($gravity)) {
        $transformations[] = "g_{$gravity}";
    }

    // Build URL
    $transformationString = !empty($transformations) ? implode(',', $transformations) . '/' : '';
    $imageUrl = "https://res.cloudinary.com/{$cloudName}/image/upload/{$transformationString}{$publicId}";
@endphp

<img src="{{ $imageUrl }}" alt="{{ $alt ?? '' }}" class="{{ $class ?? '' }}" {{ $attributes }}>
