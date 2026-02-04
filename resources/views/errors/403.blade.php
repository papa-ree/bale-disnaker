@extends('bale-disnaker::layouts.error')

@section('title', 'Forbidden')

@section('content')
    <x-bale-disnaker::error-content code="403" title="Akses Dilarang"
        message="Maaf, Anda tidak memiliki izin untuk mengakses halaman ini." />
@endsection