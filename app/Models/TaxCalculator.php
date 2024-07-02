<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxCalculator extends Model
{
    use HasFactory;

    public static function calculateTax($amount){

        $total_tax = 0;
        $remaining_salary = $amount;

        // Tax band 1: $0 tax for first $750
        if ($remaining_salary > 402) {
            $band1_amount = min($remaining_salary, 402);
            $total_tax += 0; // No tax in this band
            $remaining_salary -= $band1_amount;
        }

        
        // Tax band 2: 2% tax on amounts between $751 and $2500
        if ($remaining_salary > 0 && $remaining_salary > 402) {
            $band2_amount = min($remaining_salary, 512 - 402 );
            $tax_rate_band2 = 0.05;
            $total_tax += $band2_amount * $tax_rate_band2;
            $remaining_salary -= $band2_amount;
        }

        // Tax band 3: 10% tax on amounts between $2501 and $4500
        if ($remaining_salary > 0 && $remaining_salary > 512) {
            $band3_amount = min($remaining_salary, 642 - 512 );
            $tax_rate_band3 = 0.1;
            $total_tax += $band3_amount * $tax_rate_band3;
            $remaining_salary -= $band3_amount;
        }

        // Tax band 4: 18% tax on amounts between $4501 and $8000
        if ($remaining_salary > 0 && $remaining_salary > 642) {
            $band4_amount = min($remaining_salary, 3642 - 642);
            $tax_rate_band4 = 0.175;
            $total_tax += $band4_amount * $tax_rate_band4;
            $remaining_salary -= $band4_amount;
        }     
        

        // Tax band 5: 25% tax on amounts between $8001 and $10000
        if ($remaining_salary > 0 && $remaining_salary > 3642) {
            $band5_amount = min($remaining_salary, 20037 - 3642);
            $tax_rate_band5 = 0.25;
            $total_tax += $band5_amount * $tax_rate_band5;
            $remaining_salary -= $band5_amount;
        }

         // Tax band 6: 30% tax on amounts between $8001 and $10000
         if ($remaining_salary > 0 && $remaining_salary > 20037) {
            $band6_amount = min($remaining_salary, 50000 - 20037);
            $tax_rate_band6 = 0.30;
            $total_tax += $band6_amount * $tax_rate_band6;
            $remaining_salary -= $band6_amount;
        }


        // Tax band 6: 10% tax on amounts above $10000
        if ($remaining_salary > 0) {
            $tax_rate_band7 = 0.35;
            $total_tax += $remaining_salary * $tax_rate_band7;
        }

        // Round the total tax to 2 decimal places
        $total_tax = round($total_tax, 2);

        return $total_tax;
    }
}
