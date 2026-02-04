@extends('bale-disnaker::layouts.error')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
    <x-bale-disnaker::error-content code="404" title="Halaman Tidak Ditemukan"
        message="Maaf, halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan." />
@endsection