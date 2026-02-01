<?php

namespace App\Services;

use App\Models\Sales;

class SalesService
{
    public function createSales(array $salesData)
    {
        $sales = Sales::create($salesData);
        return $sales ?
            response()->json(['success' => true, 'message' => 'Sales created successfully!',
                'sales' => $sales->id, 'project_id' => $sales->modelUnit->project->id], 201, []) :
            response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
    }
}
