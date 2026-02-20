<section class="election-section">
    @if(isset($activePeriod) && $activePeriod)
        <div class="election-header">
            <div class="election-period">
                {{ $activePeriod->start_date->format('H:i | d M Y') }} - 
                {{ $activePeriod->end_date->format('H:i | d M Y') }}
            </div>
        </div>
        
        <div class="candidates-grid">
            @foreach($candidates as $candidate)
            <div class="candidate-card">
                <div class="candidate-photo">
                    @if($candidate->photo_url)
                        <img src="{{ Storage::disk('s3')->url($candidate->photo_url) }}" alt="Foto Kandidat">
                    @else
                        <span class="text-gray-500">Tidak Ada Foto</span>
                    @endif
                </div>
                <div class="candidate-info">
                    <div class="candidate-number">
                        {{ str_pad($candidate->number, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="candidate-position">Ketua</div>
                    <div class="candidate-name">{{ $candidate->chairman->name }}</div>
                    <div class="candidate-position">Wakil Ketua</div>
                    <div class="candidate-name">{{ $candidate->viceChairman->name }}</div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="no-election">
            <h3>Tidak Ada Pemilihan</h3>
            <p>Saat ini tidak ada periode pemilihan yang aktif</p>
        </div>
    @endif
</section>