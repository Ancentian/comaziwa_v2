<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AgentPayment;
use App\Models\Subscription;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'address',
        'password',
    ];

    public static function calculatecommission($id){
        $amount = Agent::calculateIncome($id);
                    
        if($amount <= 1000){

            return (0.1*$amount);

        }else if($amount > 1000 && $amount <= 5000){

            return (0.15*$amount);

        }else{

            return (0.2*$amount);
        }
    }

    public static function calculateIncome($id){
        $amount = Subscription::leftjoin('users','subscriptions.tenant_id','users.id')
                    ->where('users.agent_id',$id)->sum('subscriptions.amount_paid');
        $amount = !empty($amount) ? $amount : 0;

        return ($amount);
    }

    public static function calculateBalance($id){
        $commission = Agent::calculatecommission($id);

        $paid = Agent::calculatePaid($id);

        return (($commission - $paid));

    }

    public static function calculatePaid($id) {
        $paid = AgentPayment::where('agent_id',$id)->sum('amount');
        $html = !empty($paid) ? ($paid) : (0);

        return $html;
    }
}
