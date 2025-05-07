@extends('layout.panel.app', ['title' => 'Data Lansia'])
@section('content')
    <x-base.card>
        <x-base.map />
    </x-base.card>

    <livewire:lansia-table />
@endsection
@section('scripts')
    @vite(['resources/js/target-marker.js'])
@endsection
