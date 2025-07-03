{{-- resources/views/components/modal-status.blade.php --}}
<div class="modal-overlay" id="status-modal">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-icon {{ $iconColor }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}" />
                </svg>
            </div>
            <h3 class="modal-title">{{ $title }}</h3>
            <p class="modal-message">{{ $message }}</p>
        </div>
        <div class="modal-footer">
            <button class="modal-btn" id="close-status-modal">Tutup</button>
        </div>
    </div>
</div>