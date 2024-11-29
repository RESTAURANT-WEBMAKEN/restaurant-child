<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SettingsController extends Controller
{
    public function index()
    {
        // $settings = Setting::all();
        // return view('settings', compact('settings'));

        $childRestaurant = auth()->user()->childRestaurant;
        $response = Http::get("https://restaurant-super-admin.test/api/super-admin/settings/{$childRestaurant->id}");

        $settings = json_decode($response->body(), true);

        return view('settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // foreach ($request->all() as $key => $value) {
        //     $setting = Setting::firstOrCreate(['key' => $key]);
        //     $setting->value = $value;
        //     $setting->save();
        // }

        // return redirect()->back()->with('success', 'Settings updated successfully!');

        $childRestaurant = auth()->user()->childRestaurant;

        $response = Http::post("https://restaurant-super-admin.test/api/super-admin/settings/{$childRestaurant->id}", $request->all());

        $message = json_decode($response->body(), true)['message'];

        return redirect()->back()->with('success', $message);
    }
}