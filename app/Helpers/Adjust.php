<?php

namespace App\Helpers;

use Carbon\Carbon;
use Exception;

class Adjust 
{
    public static function timeToConvertWorkDays($date){
        if(!$date)  return null;
        $date = Carbon::parse($date);
        
        if($date->dayOfWeek > 5 || $date->dayOfWeek == 0){
            $date = $date->startOfWeek();
            $date = $date->addWeeks(1); // $date->addWeek();
        }

    
        return $date->format('Y-m-d') ?? null;
    }



    public static function checkIntervalBond($bond, $fields)
    {

       // dd($fields);

          if(Carbon::parse($bond->emission_date) > Carbon::parse($fields['date'])){
             throw new Exception("Alış tarixi Emissitya taricindən az ola bilməz");
          }

          if(Carbon::parse($bond->last_turnover_date) < Carbon::parse($fields['date'])){
            throw new Exception("Alış tarix Son tədavül tarixi-dən cox ola bilməz");
         }

         return true;
    }

    public static function diffTwoDateWithDays($bond_date, $order_date)
    {
        $bond_date = Carbon::parse($bond_date);
        $order_date = Carbon::parse($order_date);
    
        return $bond_date->diffInDays($order_date);
    }


    public static function amounts($bond,$count, $diffDays)  //yigilmis faizler
    {
    
        return round(($bond->nominal_price/100 * $bond->coupon_interest)/ $bond->period_calc_interest * $diffDays * $count,4);
        
    }   
}
