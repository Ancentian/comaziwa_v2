<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaySlips extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id','basic_salary','paye','net_pay','pay_period','allowances','benefits','statutory_deductions','nonstatutory_deductions','tenant_id','paid_on','paid_status'];
}
