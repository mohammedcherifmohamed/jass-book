<?php

if (!function_exists('versioned_asset')) {
    function versioned_asset($path)
    {
        $full = public_path($path);
        $url = asset($path);
        if (file_exists($full)) {
            $url .= '?v=' . filemtime($full);
        }
        return $url;
    }
}

if (!function_exists('versioned_storage')) {
    function versioned_storage($path)
    {
        $full = storage_path('app/public/' . $path);
        $url = asset('storage/' . $path);
        if (file_exists($full)) {
            $url .= '?v=' . filemtime($full);
        }
        return $url;
    }
}


