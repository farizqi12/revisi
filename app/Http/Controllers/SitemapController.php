<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function generate()
    {
        $sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $sitemap .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        // Add the login page
        $sitemap .= "  <url>\n";
        $sitemap .= "    <loc>" . URL::to('/') . "</loc>\n";
        $sitemap .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
        $sitemap .= "    <changefreq>daily</changefreq>\n";
        $sitemap .= "    <priority>1.0</priority>\n";
        $sitemap .= "  </url>\n";

        $sitemap .= "</urlset>";

        return response($sitemap)->header('Content-Type', 'text/xml');
    }
}
