<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Room;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with(['category', 'room'])->latest()->get();
        return view('assets.index', compact('assets'));
    }

    public function show(Asset $asset)
    {
        $asset->load(['category', 'room', 'maintenanceLogs.performer']);
        return view('assets.show', compact('asset'));
    }
}
