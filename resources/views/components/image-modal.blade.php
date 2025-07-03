<div id="imageModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" aria-hidden="true" onclick="document.getElementById('imageModal').classList.add('hidden')"></div>

        <!-- Modal content -->
        <div class="inline-block align-bottom rounded-lg text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="Foto Kandidat" class="object-contain w-full h-full max-h-screen">
            
            <div class="flex justify-center mt-4">
                <button type="button" onclick="document.getElementById('imageModal').classList.add('hidden')" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>