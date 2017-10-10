<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
    //

    public function index ($hostname) {
    	return "You are looking for " . $hostname;
    }

    public function get_ip_address ($hostname) {
    	return "The IP address for " . $hostname . " is 1.1.1.1";
    }
}
