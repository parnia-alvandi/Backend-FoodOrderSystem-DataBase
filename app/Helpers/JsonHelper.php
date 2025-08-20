<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class JsonHelper {
    public static function read($file) {
        if (!Storage::disk('jsondata')->exists($file)) {
            return [];
        }
        return json_decode(Storage::disk('jsondata')->get($file), true);
    }

    public static function write($file, $data) {
        Storage::disk('jsondata')->put($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
