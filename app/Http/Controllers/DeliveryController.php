<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function store(Request $request, Farmer $farmer){
        // Input Validation
        $request->validate([
            'weight_kg' => 'required|numeric|min:1',
            'delivery_date' => 'required|date',
            'bad_fruit_percentage' => 'required|numeric|min:0|max:100',
        ]);

        // Monthly Accumulation
        $month = date('m', strtotime($request->delivery_date));
        $year = date('y', strtotime($request->delivery_date));

        // Taking sum of weight that stored by farmer at that month & year
        $currentMonthTotal = $farmer->deliveries()
            ->whereMonth('delivery_date', $month)
            ->whereYear('delivery_date', $year)
            ->sum('weight_kg');

        // Normalize per unit (from ton to kg)
        $limitKg = $farmer->yield_capacity_limit * 1000;

        $newWeight = $request->weight_kg;

        $isOverCapacity = ($currentMonthTotal + $newWeight) > $limitKg;

        DB::transaction(function () use ($request, $farmer, $isOverCapacity) {
            Delivery::create([
                'farmer_id' => $farmer->id,
                'delivery_date' => $request->delivery_date,
                'weight_kg' => $request->weight_kg,
                'bad_fruit_percentage' => $request->bad_fruit_percentage,
                'is_over_capacity' => $isOverCapacity,
                'needs_audit' => $isOverCapacity ? true : false,
            ]);
        });

        $message = $isOverCapacity
            ? 'Transaski disimpan. (Flagged as Over Capacity)' : 'Transaski disimpan.';
        
        return redirect()->route('farmers.show', $farmer)
            ->with('status', $message); // 'status' ini bisa kita pangggil di View

    }
}
