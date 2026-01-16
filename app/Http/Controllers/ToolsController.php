<?php

namespace App\Http\Controllers;

use App\Models\Computation;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function calculator(string $type): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $allowed = ['mortgage', 'apecpagibig', 'apecinhouse','hauslandinhouse'];

        abort_unless(in_array($type, $allowed), 404);

        return view("dashboard.tools.calculators.$type");
    }

    public function computations(Request $request)
    {
        $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'model_unit' => ['required', 'exists:model_units,id'],
        ],[
            'project_id.required' => 'Project is required.',
            'model_unit.required' => 'Model Unit is required.',
        ]);

        $computations = Computation::where('project_id', $request->get('project_id'))
            ->where('model_unit_id', $request->get('model_unit'))->get();
        return view('dashboard.tools.computations.index',compact('computations'));
    }
}
