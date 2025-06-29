<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyakit;
use Illuminate\Http\Request;

class ObatMappingController extends Controller
{
    public function getObatMapping($penyakit_id)
    {
        $obats = Penyakit::findOrFail($penyakit_id)->medicines()->select('id', 'name')->get();
        return response()->json($obats);
    }
}
