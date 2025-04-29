<!-- Modal Hapus Produk -->
        <div class="modal fade" id="modalHapusProduk{{ $item->id_produk }}" tabindex="-1"
            aria-labelledby="modalHapusProdukLabel{{ $item->id_produk }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalHapusProdukLabel{{ $item->id_produk }}">
                            Hapus Produk?
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-6">Nama Produk</div>
                            <div class="col-6">: {{ $item->nama_produk }}</div>

                            <div class="col-6">Kode Produk</div>
                            <div class="col-6">: {{ $item->kode_produk }}</div>

                            <div class="col-6">Kategori</div>
                            <div class="col-6">: {{ $item->kategori->nama_kategori }}</div>

                            <div class="col-6">Stok</div>
                            <div class="col-6">: {{ $item->stok }}</div>

                            <div class="col-6">Stok Minimal</div>
                            <div class="col-6">: {{ $item->stok_minimal }}</div>

                            @if ($item->deskripsi)
                                <div class="col-6">Deskripsi</div>
                                <div class="col-6">: {{ $item->deskripsi }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Tutup</button>
                        <form action="{{ route('produkDestroy', $item->id_produk) }}" method="POST" class="d-inline">
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
