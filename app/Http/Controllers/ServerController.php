<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
    //

    public function index ($hostname) {
    	return "You are looking for " . $hostname;
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function get_ip_address ($hostname) {
    	$dnsRecord = dns_get_record($hostname, DNS_A);
		$ipAddress = $dnsRecord[0]['ip'];

    	return view('servermanager.query')->with(['ip' => $ipAddress, 'hostname' => $hostname]);
    }

    public function query ($hostname = null) {
    	if ($hostname == null) {
    		$resultArray = ['test' => 'test2'];
    		return view('servermanager.query')->with('resultArray', $resultArray);
    	}
    	else {
	    	$dnsRecord = dns_get_record($hostname, DNS_A);
			$ipAddress = $dnsRecord[0]['ip'];

	    	return view('servermanager.query')->with(['ip' => $ipAddress, 'hostname' => $hostname]);
	    }
    }


    ###################################################################
	# Query methods, for querying information about our target URL
	###################################################################

    # Get an http header from the target URL
    public function pull_http_header(string $hostname, string $webProtocol) {
    	# Request an HTTP header and store as an array
		$cmdOutput = shell_exec('curl -I '.$webProtocol.'://'.$address);
		$cmdOutput = explode(PHP_EOL, $cmdOutput);

		$this->httpHeader = $cmdOutput;
    }

    public function pull_ip_address($hostname) {
    	# Query the IP address; we'll just grab the first A record
		$dnsRecord = dns_get_record($this->queryURL, DNS_A);
		$ipAddress = $dnsRecord[0]['ip'];

		return $ipAddress;
    }

    public function pull_webserver($hostname) {
    	if (empty($this->httpHeader) == true) {
    		$this->httpHeader = $this->pull_http_header($this->queryURL, $this->queryProtocol);
    	}

    	foreach ($this->httpHeader as $value) {
    		if (strpos($value, 'Server: ') !== false) {
				$server = str_replace('Server: ', '', $value); 
			}
    	}

    	if (isset($server) == false) {
    		$server = "Unknown";
    	}

    	return $server;
    }

    public function pull_sets_cookie($hostname) {
    	if (empty($this->httpHeader) == true) {
    		$this->httpHeader = $this->pull_http_header($this->address, $this->queryProtocol);
    	}

    	$cookie = "No";

    	foreach ($this->httpHeader as $value) {
    		if (strpos($value, 'Set-Cookie:') !== false) {
				$cookie = "Yes";
			}
    	}

    	return $cookie;
    }
}
