@extends('servermanager.master')

@push('head')
	<link href="/css/book/show.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
	<form method='GET'>
		<div class="form-group">
			<label>Enter a web URL (required):</label>
			<input type='text' class="form-control" name='searchUrl' placeholder="www.example.com">
		</div>

		<div class="form-group">
			<label for='querySelect'>What information would you like to query?</label>
			<select class="form-control" name="dataToPull" id="querySelect">
				<option value="all">All Information</option>
				<option value="webserver">Type of Web Server</option>
				<option value="ipaddress">IP Address</option>
				<option value="setscookie">Does this page set a cookie?</option>
			</select>
		</div>

		<fieldset class="form-group">
			<label class="form-check-label">What protocol should be used?</label>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="protocol" value="http" checked> HTTP
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="protocol" value="https"> HTTPS
				</label>
			</div>
		</fieldset>

		<input type='submit' class='btn btn-primary btn-small' value='Search'>
	</form>

	<table class="table">
	@foreach($resultArray as $resultKey => $resultValue)
		<tr>
			<td>{{ $resultKey }}</td>
			<td>{{ $resultValue }}</td>
		</tr>
	@endforeach
	</table>

@endsection
