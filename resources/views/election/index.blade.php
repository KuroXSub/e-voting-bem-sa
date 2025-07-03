@extends('layouts.auth-app')

@section('title', 'Halaman Pemilihan')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Halaman Pemilihan
    </h2>
@endsection

@section('content')
    <div class="election-container">
        <div class="election-main-card">
            @if ($userVoted)
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                    <p class="font-bold text-center text-2xl">Anda Telah Memilih!</p>
                    <p class="text-center mt-2">Terima kasih atas partisipasi Anda dalam pemilihan periode ini.</p>
                </div>
            @elseif (!$activePeriod)
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                    <p class="font-bold text-center text-2xl">Tidak Ada Pemilihan Sedang Berlangsung</p>
                    <p class="text-center mt-2">{{ $statusInfo }}</p>
                </div>
            @else
                <div class="election-header">
                    <h2>Pilih Kandidat Anda</h2>
                </div>

                @if($candidates->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-xl text-gray-600">Belum Ada Kandidat untuk Periode Ini.</p>
                        <p class="text-md text-gray-500 mt-2">Silakan hubungi administrator.</p>
                    </div>
                @else
                    <div class="candidates-grid">
                        @foreach($candidates->sortBy('number') as $candidate)
                            <div class="candidate-card">
                                <div class="candidate-photo">
                                    @if($candidate->photo_path)
                                        <img src="{{ $candidate->photo_path }}" alt="Foto Kandidat">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-500">
                                            Tidak Ada Foto
                                        </div>
                                    @endif
                                </div>
                                <div class="candidate-info">
                                    <span class="candidate-number">
                                        {{ str_pad($candidate->number, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <h3 class="candidate-name">{{ $candidate->chairman->name }}</h3>
                                    <p class="candidate-position">Ketua</p>
                                    <h4 class="candidate-name">{{ $candidate->viceChairman->name }}</h4>
                                    <p class="candidate-position">Wakil Ketua</p>
                                    <p class="candidate-vision">{{ $candidate->vision }}</p>
                                    <div class="candidate-actions">
                                        <button class="detail-btn" 
                                                data-detail-url="{{ route('election.candidate.detail', $candidate) }}">
                                            Lihat Detail
                                        </button>
                                        <button class="vote-btn" 
                                                data-vote-url="{{ route('election.vote.confirm', $candidate) }}">
                                            Pilih Kandidat
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

            <a href="{{ route('dashboard') }}" class="dashboard-btn">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
    
    <!-- Modal Templates -->
    <template id="confirm-modal-template">
        <div class="modal-container">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Konfirmasi Pilihan</h3>
                    <button class="close-btn close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Konten akan diisi secara dinamis -->
                </div>
            </div>
        </div>
    </template>

    <!-- Modal Templates -->
    <template id="image-modal-template">
        <div class="image-modal-content">
            <img src="" alt="Foto Kandidat">
            <button class="close-btn close-modal">&times;</button>
        </div>
    </template>

    <!-- Di bagian akhir dari index.blade.php -->
    <template id="thank-you-modal-template">
        <div class="modal-container">
            <div class="modal-body">
                <div class="thank-you-icon">
                    <img src="{{ asset('images/tick.png') }}" alt="Success" width="80">
                </div>
                <p class="thank-you-message">Terima kasih atas partisipasi Anda!</p>
                <button class="close-btn close-modal">Tutup</button>
            </div>
        </div>
    </template>
@endsection

@push('styles')
    @vite(['resources/scss/election.scss'])
@endpush

@push('scripts')
    @vite(['resources/js/election.js'])
@endpush