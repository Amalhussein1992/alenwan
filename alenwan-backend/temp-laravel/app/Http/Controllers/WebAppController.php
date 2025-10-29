<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class WebAppController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Display a specific page by slug
     */
    public function showPage($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('page', compact('page'));
    }
}
