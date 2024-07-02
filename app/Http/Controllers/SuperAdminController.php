<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Carbon\Carbon;
use App\Models\Package;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminController extends Controller
{
    public function dashboard(){
        $data = array();

        // $permissions = array(
        //     'add.system.admin',
        //     'assign.roles',
        //     'delete.system.admin',
        //     'edit.system.admin',
        //     'add.client',
        //     'assign.agent',
        //     'edit.client',
        //     'extend.expiry.dates',
        //     'edit.user.package',
        //     'delete.client',
        //     'add.package',
        //     'edit.package',
        //     'delete.package',
        //     'view.revenue.reports'
        // );

        // foreach($permissions as $perm){
        //     Permission::create(['name' => $perm,'guard_name' => 'web']);
        // }
        

        $package = Package::get();

        $weeks=[];
        $months=[];
        $todays = [];
        $years = [];
        $package_names = [];

        $currentWeek = Carbon::now()->week;

        foreach($package as $pack){
            $package_names[] = $pack->name;

            $weeks[] = Subscription::where('package_id',$pack->id)->whereRaw('YEARWEEK(created_at) = YEARWEEK(CURRENT_DATE())')
            ->sum('amount_paid');
            $todays[] = Subscription::where('package_id',$pack->id)->whereDate('created_at',date('Y-m-d'))->sum('amount_paid');
            $months[] = Subscription::where('package_id',$pack->id)->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [date('Y-m')])->sum('amount_paid');
            $annual[] = Subscription::where('package_id',$pack->id)->whereRaw('DATE_FORMAT(created_at, "%Y") = ?', [date('Y')])->sum('amount_paid');

        }

        $wkdata = [];
        $wkdata['y'] = 'This Week';

        $tddata = [];
        $tddata['y'] = 'Today';

        $mndata = [];
        $mndata['y'] = 'This Month';

        $yrdata = [];
        $yrdata['y'] = 'This Year';
        $ykeys = [];

       foreach($weeks as $key=> $week){
            $wkdata []= $weeks[$key];
            $tddata[] = $todays[$key];
            $mndata[] = $months[$key];
            $yrdata[] = $annual[$key];
            $ykeys[] = $key;
       }

       $tddata = json_encode($tddata);
       $wkdata = json_encode($wkdata);
       $yrdata = json_encode($yrdata);
       $mndata = json_encode($mndata);
       $package_names = json_encode($package_names);
       $ykeys = json_encode($ykeys);
       
        

        return view('superadmin.dashboard', compact('package_names','tddata','yrdata','wkdata','mndata','ykeys'));
    }
}
