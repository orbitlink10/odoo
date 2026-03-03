<?php

namespace App\Modules\POS\Controllers;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        $pages = collect([
            ['name' => 'POS Policies', 'updated' => now()->subDays(3), 'status' => 'published'],
            ['name' => 'Return & Refund', 'updated' => now()->subDays(8), 'status' => 'published'],
            ['name' => 'Cashier Guide', 'updated' => now()->subDay(), 'status' => 'draft'],
        ]);

        return view('modules.pos.pages.index', compact('pages'));
    }
}
