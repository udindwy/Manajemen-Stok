<!-- Modal Hapus Kategori -->
<div class="modal fade" id="modalHapusKategori{{ $item->id_kategori }}" tabindex="-1"
    aria-labelledby="modalHapusKategoriLabel{{ $item->id_kategori }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalHapusKategoriLabel{{ $item->id_kategori }}">
                    Hapus Kategori?
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <div class="row">
                    <div class="col-6">Nama Kategori</div>
                    <div class="col-6">: {{ $item->nama_kategori }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup</button>
                <form action="{{ route('kategoriDestroy', $item->id_kategori) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
