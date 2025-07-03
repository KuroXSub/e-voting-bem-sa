@extends('layouts.app')

@section('title', 'About Us')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tentang Kami
    </h2>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h1 class="text-3xl font-bold mb-4">Halaman Tentang Aplikasi Ini</h1>
            <p class="text-lg">Aplikasi ini dibuat dengan Laravel untuk memenuhi kebutuhan pengelolaan data. Kami berkomitmen untuk menyediakan antarmuka yang intuitif dan fungsionalitas yang kuat.</p>
            <p class="mt-4">
                Kembali ke <a href="{{ route('welcome') }}" class="text-blue-500 hover:underline">Home</a>.
            </p>
        </div>
    </div>
@endsection