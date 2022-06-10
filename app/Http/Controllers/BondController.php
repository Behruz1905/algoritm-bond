<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bond;
use App\Models\Order;
use App\Helpers\Adjust;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class BondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bond  $bond
     * @return \Illuminate\Http\Response
     */
    public function show(Bond $bond)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bond  $bond
     * @return \Illuminate\Http\Response
     */
    public function edit(Bond $bond)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bond  $bond
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bond $bond)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bond  $bond
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bond $bond)
    {
        //
    }

    public function payouts(Bond $bond)
    {
        

        $FaizlərinHesablanmaPeriodu = $bond->period_calc_interest;

        $periodunMüddətiniAyİlə = NULL;
        $periodunMüddətiniGünİlə = NULL;

        switch ($FaizlərinHesablanmaPeriodu) {
            case 360:
                $periodunMüddətiniGünİlə = 12 / $bond->frequency_of_payment * 30;
            break;
            case 364:
                $periodunMüddətiniGünİlə = 364 / $bond->frequency_of_payment;
            break;
            case 365:
                $periodunMüddətiniAyİlə = 12 / $bond->frequency_of_payment;
            break;
        }

        if(! $periodunMüddətiniAyİlə){
           $date =  Carbon::parse($bond->emission_date)->subDay($periodunMüddətiniGünİlə);
        }
       
        $date = Adjust::timeToConvertWorkDays($date);



        return response()->json([

            'dates' => [
                ["date" => $date],
             
            ]
    
        ]);
    }


    public function order(Bond $bond, Request $request)
    {


        $validated  = $request->validate([
            'date' => 'required',
            'count' => 'required|numeric',
        ]);
        //dd($validated);
        $check = Adjust::checkIntervalBond($bond, $validated);
        $validated['bond_id'] = $bond->id;

        $order = Order::create($validated);

        return response()->json([

                  "code" => 200,
                  "message" => "Order created. Order ID ".$order->id 
    
        ]);
    }
}
