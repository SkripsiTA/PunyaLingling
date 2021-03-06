<div class="modal fade" id="formNomorSurat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Nomor Surat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
            
            <div class="modal-body">
                
                
                <div class="pl-lg-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-username">Kode Surat</label>
                                <input type="text" id="kode_nomor_surat" class="form-control" placeholder="Kode Surat" name="kode_nomor_surat">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                            <label class="form-control-label" for="input-email">Keterangan</label>
                            <input type="text" id="keterangan" class="form-control" placeholder="Keterangan" name="keterangan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="btn_save" value="add">Simpan</button>
                <input type="hidden" id="master_surat_id" name="master_surat_id" value="0">
            </div>
        </form>
        </div>
    </div>
</div>
<?php /**PATH D:\Teknologi Informasi\Tugas Akhir\PROJECT\SirajaProject\resources\views/admin/masterdata/surat/add-nomor-surat.blade.php ENDPATH**/ ?>