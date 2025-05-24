<!-- resources/views/components/loading-modal.blade.php -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body text-center p-5">
                <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5 class="mt-3 text-white" id="loadingText">Memproses...</h5>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi global untuk mengontrol loading
    window.showLoading = function(message = 'Memproses...') {
        document.getElementById('loadingText').textContent = message;
        new bootstrap.Modal(document.getElementById('loadingModal')).show();
    };

    window.hideLoading = function() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
        if (modal) modal.hide();
    };

    // Tangkap semua link dan form
    document.addEventListener('DOMContentLoaded', function() {
        // Tangkap semua link internal
        document.querySelectorAll('a[href^="/"], a[href^="http://"], a[href^="https://"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.target === '_blank' || this.href.includes('#') || e.ctrlKey || e.metaKey) return;
                e.preventDefault();
                showLoading('Memuat halaman...');
                setTimeout(() => window.location.href = this.href, 100);
            });
        });

        // Tangkap semua form submission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => showLoading('Mengirim data...'));
        });
    });

    // Tangkap event sebelum unload
    window.addEventListener('beforeunload', () => showLoading('Memuat...'));
</script>
