<?php

namespace App\Modules\POS\Controllers;

use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    public function index()
    {
        $branches = collect([
            ['name' => 'Main Branch', 'location' => 'CBD', 'status' => 'active'],
            ['name' => 'Westlands Branch', 'location' => 'Westlands', 'status' => 'active'],
            ['name' => 'Mombasa Branch', 'location' => 'Mombasa', 'status' => 'setup'],
        ]);

        return view('modules.pos.branches.index', compact('branches'));
    }
}
