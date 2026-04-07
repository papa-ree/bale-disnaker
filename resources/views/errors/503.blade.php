@extends('bale-disnaker::layouts.error')

@section('title', 'Layanan Tidak Tersedia')

@section('content')
    <x-bale-disnaker::error-content code="503" title="Layanan Tidak Tersedia"
        message="Maaf, layanan kami sedang dalam pemeliharaan. Silakan coba beberapa saat lagi." />
@endsection