<div class="p-6">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Candidate Photo -->
        <div class="relative bg-gray-200 h-64">
            @if($candidate->photo_url)
                <img src="{{ asset($candidate->photo_url) }}" alt="Foto Kandidat" 
                    class="object-contain w-full h-full cursor-pointer" 
                    onclick="openImageModal('{{ asset($candidate->photo_url) }}')">
            @else
                <div class="flex items-center justify-center w-full h-full bg-gray-300">
                    <span class="text-gray-500">No Photo</span>
                </div>
            @endif
        </div>
        
        <!-- Candidate Info -->
        <div class="p-6">
            <div class="text-center">
                <span class="inline-block px-4 py-2 mb-4 text-2xl font-bold text-white bg-blue-600 rounded-full">
                    No. {{ str_pad($candidate->number, 2, '0', STR_PAD_LEFT) }}
                </span>
                <h3 class="text-2xl font-bold">{{ $candidate->chairman->name }}</h3>
                <p class="text-gray-600">Ketua</p>
                <h4 class="mt-2 text-xl font-bold">{{ $candidate->viceChairman->name }}</h4>
                <p class="text-gray-600">Wakil Ketua</p>
                
                <div class="mt-6 text-left">
                    <h4 class="text-lg font-semibold">Visi:</h4>
                    <p class="mt-2 text-gray-700">{{ $candidate->vision }}</p>
                    
                    <h4 class="mt-4 text-lg font-semibold">Misi:</h4>
                    <p class="mt-2 text-gray-700">{{ $candidate->mission }}</p>
                </div>
            </div>
            
            <div class="flex justify-center mt-8">
                <a href="{{ route('vote.confirm', $candidate) }}" 
                   class="px-6 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Pilih Kandidat Ini
                </a>
            </div>
        </div>
    </div>
</div>