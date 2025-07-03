// resources/js/dashboard.js
function handleElectionButton() {
    const periodStatus = document.getElementById('period-status').dataset.status;
    const userVoted = document.getElementById('period-status').dataset.voted === 'true';
    const startDate = document.getElementById('period-status').dataset.startDate;
    const endDate = document.getElementById('period-status').dataset.endDate;

    if (periodStatus === 'Non-aktif') {
        showElectionStatusModal(
            'Tidak Ada Pemilihan', 
            'Saat ini tidak ada periode pemilihan yang aktif.'
        );
    } else if (periodStatus === 'Belum dimulai') {
        showElectionStatusModal(
            'Pemilihan Belum Dimulai', 
            `Periode pemilihan akan dimulai pada ${startDate}.`
        );
    } else if (periodStatus === 'Telah Selesai') {
        showElectionStatusModal(
            'Pemilihan Telah Selesai', 
            `Periode pemilihan telah berakhir pada ${endDate}.`
        );
    } else if (periodStatus === 'Sedang Berlangsung' && userVoted) {
        showElectionStatusModal(
            'Anda Sudah Memilih', 
            'Terima kasih telah berpartisipasi dalam pemilihan ini.'
        );
    } else if (periodStatus === 'Sedang Berlangsung' && !userVoted) {
        window.location.href = document.getElementById('election-route').value;
    }
}

function showElectionStatusModal(title, message) {
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-message').textContent = message;
    document.getElementById('modal-icon-path').setAttribute('d', getModalIconPath(title));
    document.getElementById('election-modal').style.display = 'flex';
}

document.getElementById('modal-close-btn').addEventListener('click', function() {
    document.getElementById('election-modal').style.display = 'none';
});

function getModalIconColor(title) {
    if (title.includes('Tidak Ada')) return 'bg-gray-100 text-gray-500';
    if (title.includes('Belum')) return 'bg-blue-100 text-blue-500';
    if (title.includes('Selesai')) return 'bg-green-100 text-green-500';
    return 'bg-yellow-100 text-yellow-500';
}

function getModalIconPath(title) {
    if (title.includes('Sudah')) return 'M5 13l4 4L19 7';
    return 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
}

function closeModal(button) {
    const modal = document.querySelector('.modal-overlay');
    if (modal) {
        modal.remove();
    }
}

// Initialize event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const electionBtn = document.getElementById('view-election-btn');
    if (electionBtn) {
        electionBtn.addEventListener('click', handleElectionButton);
    }
});