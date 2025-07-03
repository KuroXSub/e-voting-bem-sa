<div class="p-6">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 text-center">
            <h3 class="text-xl font-bold text-gray-800">Konfirmasi Pilihan</h3>
            <p class="mt-2 text-gray-600">Apakah Anda yakin untuk memilih kandidat ini?</p>
            
            <!-- Candidate Info -->
            <div class="mt-6">
                @if($candidate->photo_url)
                    <img src="{{ asset($candidate->photo_url) }}" alt="Foto Kandidat" 
                        class="w-32 h-32 mx-auto rounded-full object-cover">
                @else
                    <div class="w-32 h-32 mx-auto bg-gray-300 rounded-full flex items-center justify-center">
                        <span class="text-gray-500">No Photo</span>
                    </div>
                @endif
                
                <div class="mt-4">
                    <p class="text-lg font-semibold">No. {{ str_pad($candidate->number, 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-gray-700">{{ $candidate->chairman->name }}</p>
                    <p class="text-gray-600 text-sm">Ketua</p>
                    <p class="mt-1 text-gray-700">{{ $candidate->viceChairman->name }}</p>
                    <p class="text-gray-600 text-sm">Wakil Ketua</p>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-center mt-8 space-x-4">
                <form action="{{ route('vote.submit', $candidate) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Konfirmasi Pilihan
                    </button>
                </form>
                <button onclick="document.getElementById('modalContainer').classList.add('hidden')" class="px-6 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Kembali
                </button>
            </div>
        </div>
    </div>
</div>