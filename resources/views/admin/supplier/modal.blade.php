<!-- Modal Hapus Supplier -->
<div class="modal fade" id="modalHapusSupplier{{ $item->id_supplier }}" tabindex="-1"
    aria-labelledby="modalHapusSupplierLabel{{ $item->id_supplier }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalHapusSupplierLabel{{ $item->id_supplier }}">
                    Hapus Supplier?
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <div class="row mb-2">
                    <div class="col-6">Nama Supplier</div>
                    <div class="col-6">: {{ $item->nama_supplier }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Kontak</div>
                    <div class="col-6">: {{ $item->kontak }}</div>
                </div>
                <div class="row">
                    <div class="col-6">Lead Time</div>
                    <div class="col-6">: {{ $item->lead_time }} hari</div>
                </div>
            </div>
            <div class="modal-footer">
                <form action="{{ route('supplier.destroy', $item->id_supplier) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>