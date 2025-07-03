<div class="p-6">
    <h3 class="text-xl font-bold mb-4 text-center">Daftar Kandidat</h3>
    @if($candidates->isEmpty())
        <p class="text-gray-600 text-center">Belum ada kandidat untuk pemilihan ini.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($candidates as $candidate)
                <div class="border rounded-lg p-4 cursor-pointer hover:bg-gray-50"
                     onclick="openCandidateDetailModal('{{ route('election.candidate.detail', $candidate) }}')">
                    <div class="aspect-w-4 aspect-h-3 mb-3">
                        @if($candidate->photo_url)
                            <img src="{{ asset($candidate->photo_url) }}" alt="Foto Kandidat" 
                                 class="object-contain w-full h-full"
                                 onclick="event.stopPropagation(); openImageModal('{{ asset($candidate->photo_url) }}')">
                        @else
                            <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                <span class="text-gray-500">No Photo</span>
                            </div>
                        @endif
                    </div>
                    <div class="text-center">
                        <span class="inline-block px-2 py-1 text-sm font-bold text-white bg-blue-600 rounded-full">
                            {{ str_pad($candidate->number, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <h4 class="font-semibold mt-2">{{ $candidate->chairman->name }}</h4>
                        <p class="text-sm text-gray-600">Ketua</p>
                        <h5 class="font-medium mt-1">{{ $candidate->viceChairman->name }}</h5>
                        <p class="text-sm text-gray-600">Wakil Ketua</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="mt-6 text-center">
        <button onclick="closeModal()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Tutup
        </button>
    </div>
</div>