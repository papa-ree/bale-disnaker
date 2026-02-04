@extends('bale-disnaker::layouts.error')

@section('title', 'Server Error')

@section('content')
    <x-bale-disnaker::error-content code="500" title="Kesalahan Server"
        message="Maaf, terjadi kesalahan pada server kami. Kami sedang berusaha memperbaikinya." />
@endsection