<div class="tab-pane fade" id="tab5">
    <div class="form-section animate__animated animate__fadeIn">
        <h5 class="section-title text-primary"><i class="fas fa-clipboard-check me-2"></i>G. Ringkasan Data Pendaftaran</h5>
        
        <div id="summaryArea" class="bg-light p-4 rounded-3 mb-4 border">
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Menyusun ringkasan data...</p>
            </div>
        </div>

        <div class="alert alert-warning d-flex align-items-center">
            <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
            <div>
                <strong>Perhatian:</strong> Periksa kembali data di atas. Dengan menekan tombol "Kirim Pendaftaran", Anda menyatakan bahwa data yang diisi adalah benar dan valid.
            </div>
        </div>

        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
            <button type="button" class="btn btn-prev px-5 shadow-sm" onclick="nextTab('tab4')">
                <i class="fas fa-chevron-left me-2"></i> Kembali
            </button>
            
            <button type="submit" class="btn btn-success-gradient px-5 shadow-sm btn-next" id="finalSubmit">
                KIRIM PENDAFTARAN <i class="fas fa-paper-plane ms-2"></i>
            </button>
        </div>
    </div>
</div>