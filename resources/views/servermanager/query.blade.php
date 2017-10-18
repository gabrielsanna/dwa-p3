@extends('servermanager.master')

@push('head')
    <link href="/css/book/show.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
	@if($ip)
        <p>Hostname: {{ $hostname }}<br>
    @else
        <p>No hostname given</p>
    @endif

    @if($ip)
        IP address: {{ $ip }}</p>
    @endif
@endsection
