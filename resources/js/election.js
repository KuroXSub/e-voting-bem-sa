document.addEventListener('DOMContentLoaded', function() {
    setupEventListeners();
});

function setupEventListeners() {
    // Image modal
    document.querySelectorAll('.candidate-photo img').forEach(img => {
        img.addEventListener('click', function() {
            showImageModal(this.src);
        });
    });

    // Detail buttons
    document.querySelectorAll('.detail-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.dataset.detailUrl;
            fetchModal(url, 'Detail Kandidat');
        });
    });

    // Vote buttons on candidate cards
    document.querySelectorAll('.vote-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.dataset.voteUrl;
            fetchConfirmModal(url);
        });
    });

    // Event delegation for modals
    document.addEventListener('click', function(e) {
        // Close modals
        if (e.target.classList.contains('close-modal')) {
            closeModal();
        }
        
        // Final confirmation
        if (e.target.classList.contains('confirm-vote')) {
            const url = e.target.dataset.voteUrl;
            submitVote(url);
        }
    });
}

function showImageModal(imageUrl) {
    const modal = document.createElement('div');
    modal.className = 'image-modal';
    modal.innerHTML = document.getElementById('image-modal-template').innerHTML;
    
    const img = modal.querySelector('img');
    img.src = imageUrl;
    
    document.body.appendChild(modal);
    
    // Close when clicking outside image
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
}

function fetchConfirmModal(url) {
    fetch(url, {
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Gagal memuat modal konfirmasi');
        }
        return response.json();
    })
    .then(data => {
        if (data.html) {
            showModal('Konfirmasi Pilihan', data.html);
        } else {
            throw new Error('Konten modal tidak valid');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Terjadi kesalahan saat memuat konfirmasi');
    });
}

function fetchModal(url, title) {
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        showModal(title, data.html);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function showModal(title, content) {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    
    // Gunakan template yang sudah didefinisikan
    modal.innerHTML = `
        <div class="modal-container">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">${title}</h3>
                </div>
                <div class="modal-body">
                    ${content}
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal || e.target.classList.contains('close-modal')) {
            closeModal();
        }
    });
}

function closeModal() {
    const modal = document.querySelector('.modal-overlay, .image-modal');
    if (modal) {
        modal.remove();
    }
}

function submitVote(url) {
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { 
                throw new Error(err.error || 'Terjadi kesalahan'); 
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            closeModal();
            showThankYouModal();
            setTimeout(() => {
                window.location.href = data.redirect_url || '/dashboard';
            }, 2000);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Terjadi kesalahan saat menyimpan pilihan');
    });
}

function showThankYouModal() {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay thank-you-modal';
    modal.innerHTML = document.getElementById('thank-you-modal-template').innerHTML;
    document.body.appendChild(modal);
}