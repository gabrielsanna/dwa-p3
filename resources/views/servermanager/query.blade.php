@extends('servermanager.master')


@push('head')
    <link href="/css/book/show.css" type='text/css' rel='stylesheet'>
@endpush


@section('content')
    @if($ip)
        <p>IP address: {{ $ip }}</p>
    @else
        <p>No hostname given</p>
    @endif
@endsection
