document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi komponen JavaScript jika diperlukan
    console.log('Welcome page loaded');
    
    // Contoh: Animasi scroll untuk section
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fadeIn');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.hero, .features, .election-section').forEach(section => {
        observer.observe(section);
    });
});