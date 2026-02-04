@extends('bale-disnaker::layouts.error')

@section('title', 'Session Expired')

@section('content')
    <x-bale-disnaker::error-content code="419" title="Sesi Berakhir"
        message="Maaf, sesi Anda telah berakhir. Silakan muat ulang halaman dan coba lagi." />
@endsection