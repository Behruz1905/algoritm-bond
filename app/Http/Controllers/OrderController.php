<?php

namespace App\Http\Controllers;

use App\Helpers\Adjust;
use App\Models\Bond;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function interest(Order $order,Request $request)
    {
        $bond = Bond::findOrFail($order->id);
        $diff = Adjust::diffTwoDateWithDays($bond->last_turnover_date, $order->date);
        $amounts = Adjust::amounts($bond, $order->count,$diff);

        return response()->json([

            'payouts' => [
                ["date" => $order->date, "amount" => $amounts],
            ]
        ]);

    }
}
