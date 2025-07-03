<div class="p-6">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-8 text-center">
            <div class="flex justify-center">
                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="mt-4 text-2xl font-bold text-gray-800">TERIMA KASIH TELAH MEMILIH</h3>
            <p class="mt-2 text-gray-600">Suara Anda telah tercatat</p>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('dashboard') }}";
        }, 3000);
    </script>
</div>