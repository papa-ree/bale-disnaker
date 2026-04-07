@extends('bale-disnaker::layouts.error')

@section('title', 'Tidak Boleh Diakses')

@section('content')
    <x-bale-disnaker::error-content code="401" title="Akses Ditolak"
        message="Maaf, Anda tidak memiliki akses untuk mengakses halaman ini." />
@endsection