<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        // Get all settings grouped by category
        $settings = [
            'general' => Setting::getAll('general'),
            'email' => Setting::getAll('email'),
            'payment' => Setting::getAll('payment'),
            'streaming' => Setting::getAll('streaming'),
            'security' => Setting::getAll('security'),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function switchLanguage(Request $request)
    {
        $language = $request->input('lang', 'en');

        // Validate language
        $supportedLanguages = ['en', 'ar', 'fr', 'es'];
        if (!in_array($language, $supportedLanguages)) {
            $language = 'en';
        }

        // Set session
        Session::put('locale', $language);
        App::setLocale($language);

        // Save to database
        Setting::set('app_language', $language, 'string', 'general');

        return response()->json(['success' => true, 'language' => $language]);
    }

    public function save(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get all form inputs except _token and _method
            $inputs = $request->except(['_token', '_method', '_group']);
            $group = $request->input('_group', 'general');

            foreach ($inputs as $key => $value) {
                // Determine type
                $type = 'string';
                if (is_bool($value) || $value === 'on' || $value === 'off') {
                    $type = 'boolean';
                    $value = ($value === 'on' || $value === true) ? true : false;
                } elseif (is_numeric($value)) {
                    $type = 'integer';
                } elseif (is_array($value)) {
                    $type = 'json';
                }

                Setting::set($key, $value, $type, $group);
            }

            DB::commit();

            return back()->with('success', 'Settings saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error saving settings: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        return $this->save($request);
    }

    public function testConnection(Request $request)
    {
        try {
            // Test database connection
            DB::connection()->getPdo();

            return response()->json([
                'success' => true,
                'message' => __('admin.connection_successful')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateApiKey(Request $request)
    {
        $apiKey = bin2hex(random_bytes(32));

        // Save to database
        Setting::set('api_key', $apiKey, 'string', 'security');

        return response()->json([
            'success' => true,
            'api_key' => $apiKey
        ]);
    }
}