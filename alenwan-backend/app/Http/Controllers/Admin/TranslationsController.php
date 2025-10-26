<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TranslationsController extends Controller
{
    public function index()
    {
        return view('admin.translations.index');
    }

    public function save(Request $request)
    {
        try {
            $translations = $request->all();

            foreach ($translations as $language => $sections) {
                foreach ($sections as $section => $items) {
                    $filePath = resource_path("lang/{$language}/{$section}.php");

                    // Create directory if it doesn't exist
                    $directory = dirname($filePath);
                    if (!File::exists($directory)) {
                        File::makeDirectory($directory, 0755, true);
                    }

                    // Load existing translations if file exists
                    $existingTranslations = [];
                    if (File::exists($filePath)) {
                        $existingTranslations = include $filePath;
                    }

                    // Merge with new translations
                    $mergedTranslations = array_merge($existingTranslations, $items);

                    // Format the array for export
                    $content = "<?php\n\nreturn [\n";
                    foreach ($mergedTranslations as $key => $value) {
                        $escapedValue = addslashes($value);
                        $content .= "    '{$key}' => '{$escapedValue}',\n";
                    }
                    $content .= "];\n";

                    // Write to file
                    File::put($filePath, $content);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Translations saved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function export($language)
    {
        $langPath = resource_path("lang/{$language}");

        if (!File::exists($langPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Language not found'
            ], 404);
        }

        $translations = [];
        $files = File::files($langPath);

        foreach ($files as $file) {
            $section = pathinfo($file, PATHINFO_FILENAME);
            $translations[$section] = include $file;
        }

        return response()->json([
            'success' => true,
            'language' => $language,
            'translations' => $translations
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:en,ar,fr,es',
            'file' => 'required|file|mimes:json'
        ]);

        try {
            $content = File::get($request->file('file')->getRealPath());
            $translations = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON format');
            }

            $language = $request->input('language');

            foreach ($translations as $section => $items) {
                $filePath = resource_path("lang/{$language}/{$section}.php");

                $directory = dirname($filePath);
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }

                $content = "<?php\n\nreturn [\n";
                foreach ($items as $key => $value) {
                    $escapedValue = addslashes($value);
                    $content .= "    '{$key}' => '{$escapedValue}',\n";
                }
                $content .= "];\n";

                File::put($filePath, $content);
            }

            return redirect()->route('admin.translations.index')
                ->with('success', 'Translations imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.translations.index')
                ->with('error', 'Error importing translations: ' . $e->getMessage());
        }
    }
}
