@extends('layouts.main')

@push('styles')
    <style>
        .img-confusion-matrix {
            width: 20%;
            height: auto;
        }
    </style>
@endpush

@section('content')
    <div class="flex justify-start my-7 text-gray-200 flex-col gap-3">
        <h1 class="text-4xl font-bold text-center">Klasifikasi Ras Kambing</h1>
        <p class="text-sm text-center">Dengan bantuan deep learning dan arsitektur CNN resnet50, kami telah membuat model
            Klasifikasi Ras
            Kambing ini di mana kami dapat dengan mudah mengklasifikasikan berbagai ras kambing.</a></p>
        <hr>
        <livewire:predict-page />
    </div>
@endsection
