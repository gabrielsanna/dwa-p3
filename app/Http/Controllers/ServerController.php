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
    	$dnsRecord = dns_get_record($hostname, DNS_A);
		$ipAddress = $dnsRecord[0]['ip'];

    	return view('servermanager.query')->with(['ip' => $ipAddress, 'hostname' => $hostname]);
    }
}
