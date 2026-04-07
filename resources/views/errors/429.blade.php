@extends('bale-disnaker::layouts.error')

@section('title', 'Terlalu Banyak Permintaan')

@section('content')
    <x-bale-disnaker::error-content code="429" title="Terlalu Banyak Permintaan"
        message="Terlalu banyak permintaan dalam waktu singkat. Silakan tunggu beberapa saat." />
@endsection