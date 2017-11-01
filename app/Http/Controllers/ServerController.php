<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
	# Properties
	private $queryURL;
	private $queryProtocol;
	private $queryData;
	private $httpHeader;

	public function query (Request $request) {
		# Validate the request data

		if ($request->input('searchUrl') == null) {
			$resultArray = [];
		}
		else {
			$this->validate($request, [
				'searchURL' => 'active_url',
			]);

			$hostname = $request->input('searchUrl');
		}

		if ($request->has('searchUrl')) {
			$this->queryURL = $request->input('searchUrl');
			$this->queryProtocol = $request->input('searchUrl');
			$this->queryData = $request->input('dataToPull');

			if ($this->queryData == "all" || $this->queryData == "webserver" || $this->queryData == "setscookie") {
				$this->pull_http_header($this->queryURL, $this->queryProtocol);
			}

			$resultArray = $this->get_array();
		}

		return view('servermanager.query')->with('resultArray', $resultArray);
	}

	###################################################################
	# Query methods, for querying information about our target URL
	###################################################################

	# Get an http header from the target URL
	private function pull_http_header(string $hostname, string $webProtocol) {
		# Request an HTTP header and store as an array
		$cmdOutput = shell_exec('curl -I '.$webProtocol.'://'.$hostname);
		$cmdOutput = explode(PHP_EOL, $cmdOutput);

		$this->httpHeader = $cmdOutput;
	}

	private function pull_ip_address() {
		# Query the IP address; we'll just grab the first A record
		$dnsRecord = dns_get_record($this->queryURL, DNS_A);
		$ipAddress = $dnsRecord[0]['ip'];

		return $ipAddress;
	}

	private function pull_webserver() {
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

	private function pull_sets_cookie() {
		if (empty($this->httpHeader) == true) {
			$this->httpHeader = $this->pull_http_header($this->queryURL, $this->queryProtocol);
		}

		$cookie = "No";

		foreach ($this->httpHeader as $value) {
			if (strpos($value, 'Set-Cookie:') !== false) {
				$cookie = "Yes";
			}
		}

		return $cookie;
	}

	private function get_array() {
		# Build a keyed array of data to output
		$resultArray = array(
			"URL" => "$this->queryURL"
		);

		if ($this->queryData == "all" || $this->queryData == "webserver") {
			$resultArray["Web server"] = $this->pull_webserver();
		}
		if ($this->queryData == "all" || $this->queryData == "ipaddress") {
			$resultArray["IP address"] = $this->pull_ip_address();
		}
		if ($this->queryData == "all" || $this->queryData == "setscookie") {
			$resultArray["Sets cookie"] = $this->pull_sets_cookie();
		}

		return $resultArray;
	}
}
