{{-- resources/views/election/modals/candidate-detail.blade.php --}}
<div class="space-y-4">
    <div class="flex justify-center">
        <div class="candidate-photo">
            @if($candidate->photo_url)
                <img src="{{ Storage::disk('s3')->url($candidate->photo_url) }}" 
                    alt="Foto Kandidat">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-500">
                    Tidak Ada Foto
                </div>
            @endif
        </div>
    
    <div class="text-center">
        <span class="candidate-number">
            {{ str_pad($candidate->number, 2, '0', STR_PAD_LEFT) }}
        </span>
        <h3 class="candidate-name">{{ $candidate->chairman->name }}</h3>
        <p class="candidate-position">Ketua</p>
        <h4 class="candidate-name">{{ $candidate->viceChairman->name }}</h4>
        <p class="candidate-position">Wakil Ketua</p>
    </div>
    
    <div class="candidate-vision-mission">
        <h4>Visi:</h4>
        <p>{{ $candidate->vision }}</p>
        
        <h4 class="mt-4">Misi:</h4>
        <p>{{ $candidate->mission }}</p>
    </div>
    
    <div class="modal-footer">
        <button class="back-btn close-modal">
            Kembali
        </button>
    </div>
</div>