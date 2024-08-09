<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class InternetStatusController extends Controller
{
    public function checkInternet()
    {
        $connected = $this->isConnected();
        $wasConnected = Cache::get('internet_connected', true);

        if ($connected && !$wasConnected) {
            // Internet connection has been restored
            Cache::put('internet_connected', true);
            $status = 'restored';
        } elseif (!$connected) {
            // Internet connection is lost
            Cache::put('internet_connected', false);
            $status = 'lost';
        } else {
            $status = 'unchanged';
        }

        return response()->json(['status' => $status]);
    }

    private function isConnected()
    {
        $endpoints = ["www.google.com", "www.example.com"];
        foreach ($endpoints as $endpoint) {
            $connected = @fsockopen($endpoint, 80);
            if ($connected) {
                fclose($connected);
                return true;
            }
        }
        return false;
    }

}
