@extends('layouts.auth-app')

@section('content')
    <div class="dashboard-container">
        <!-- Main Card Container -->
        <div class="main-card">
            <!-- Card 1 - Welcome Card -->
            <div class="welcome-card">
                <div class="welcome-left">
                    <div class="profile-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="welcome-text">
                        <h2>Selamat Datang</h2>
                        <p>Halo, {{ $user->name }}</p>
                    </div>
                </div>
                <div class="welcome-right">
                    <button class="home-btn" onclick="window.location.href='{{ route('welcome') }}'">Home</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">Log Out</button>
                    </form>
                </div>
            </div>

            <!-- Card 2 - Election Status Card -->
            <div class="election-status-card">
                <div class="election-status-content">
                    @if($periodStatus === 'Non-aktif')
                        <div>
                            <h3 class="status-title">Tidak Ada Pemilihan</h3>
                            <p class="status-message">Saat ini tidak ada periode pemilihan yang aktif</p>
                        </div>
                    @else
                        <p class="period-dates">
                            <span class="start-date">{{ $periodData['start_date'] }}</span>
                            <span class="separator">-</span>
                            <span class="end-date">{{ $periodData['end_date'] }}</span>
                        </p>
                        
                        @if($periodStatus === 'Belum dimulai')
                            <h3 class="status-title">Belum Dimulai</h3>
                        @elseif($periodStatus === 'Telah Selesai')
                            <h3 class="status-title">Telah Selesai</h3>
                        @elseif($periodStatus === 'Sedang Berlangsung')
                            @if($userVoted)
                                <h3 class="status-title">Anda Sudah Memilih</h3>
                                <p class="status-message">Terima kasih telah berpartisipasi</p>
                            @else
                                <h3 class="status-title">Anda Belum Memilih</h3>
                            @endif
                        @endif
                        
                        <p class="election-name">{{ $periodData['name'] }}</p>
                    @endif
                    
                    <button id="view-election-btn" class="view-election-btn">
                        Lihat Pemilihan
                    </button>
                    
                    <!-- Hidden elements for JS -->
                    <div id="period-status" 
                         data-status="{{ $periodStatus }}" 
                         data-voted="{{ $userVoted ? 'true' : 'false' }}"
                         data-start-date="{{ $periodData['start_date'] ?? '' }}"
                         data-end-date="{{ $periodData['end_date'] ?? '' }}"
                         style="display: none;"></div>
                    <input type="hidden" id="election-route" value="{{ route('election.index') }}">
                </div>
            </div>

            <!-- Cards 3 & 4 - Quick Access Cards -->
            <div class="quick-access-cards">
                <!-- Card 3 - Election Access -->
                <div class="quick-access-card">
                    <div class="card-left">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="card-text">
                            <h3>Pemilihan</h3>
                            <p>Lihat daftar kandidat dan berikan suara Anda</p>
                        </div>
                    </div>
                    <a href="{{ route('election.index') }}" class="access-btn">Masuk</a>
                </div>

                <!-- Card 4 - Profile Access -->
                <div class="quick-access-card">
                    <div class="card-left">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <div class="card-text">
                            <h3>Profil</h3>
                            <p>Kelola informasi akun dan pengaturan Anda</p>
                        </div>
                    </div>
                    <a href="{{ route('settings.profile') }}" class="access-btn">Masuk Profil</a>
                </div>
            </div>
        </div>
    </div>

    <div id="election-modal" class="modal-overlay" style="display: none;">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-icon" id="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" id="modal-icon-path"/>
                    </svg>
                </div>
                <h3 class="modal-title" id="modal-title"></h3>
                <p class="modal-message" id="modal-message"></p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn" id="modal-close-btn">Tutup</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    @vite(['resources/scss/dashboard.scss'])
@endpush

@push('scripts')
    @vite(['resources/js/dashboard.js'])
@endpush