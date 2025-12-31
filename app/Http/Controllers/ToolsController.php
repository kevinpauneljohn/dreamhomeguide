<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function calculator(string $type): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $allowed = ['mortgage', 'apecpagibig', 'apecinhouse'];

        abort_unless(in_array($type, $allowed), 404);

        return view("dashboard.tools.calculators.$type");
    }
}
