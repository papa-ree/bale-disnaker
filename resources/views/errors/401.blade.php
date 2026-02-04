@extends('bale-disnaker::layouts.error')

@section('title', 'Unauthorized')

@section('content')
    <x-bale-disnaker::error-content code="401" title="Unauthorized"
        message="Maaf, Anda tidak memiliki akses untuk mengakses halaman ini." />
@endsection