{{-- resources/views/election/modals/confirm-vote.blade.php --}}
<div class="space-y-4">
    <div class="text-center">
        <h3 class="modal-title">Konfirmasi Pilihan Anda</h3>
        <p class="text-gray-600">Anda akan memilih pasangan calon:</p>
    </div>
    
    <div class="p-4 bg-gray-100 rounded-lg">
        <div class="text-center">
            <span class="candidate-number">
                {{ str_pad($candidate->number, 2, '0', STR_PAD_LEFT) }}
            </span>
            <h3 class="candidate-name">{{ $candidate->chairman->name }}</h3>
            <p class="candidate-position">Ketua</p>
            <h4 class="candidate-name">{{ $candidate->viceChairman->name }}</h4>
            <p class="candidate-position">Wakil Ketua</p>
        </div>
    </div>
    
    <div class="text-center text-sm text-gray-600">
        <p>Pilihan Anda tidak dapat diubah setelah dikonfirmasi</p>
    </div>
    
    <div class="modal-footer">
        <button class="vote-btn confirm-vote" 
                data-vote-url="{{ route('election.vote.submit', $candidate) }}">
            Konfirmasi Pilihan
        </button>
        <button class="back-btn close-modal">
            Batal
        </button>
    </div>
</div>