<!-- Modal Hapus -->
       <div class="modal fade" id="modalHapusStokKeluar{{ $item->id_stok_keluar }}" tabindex="-1"
           aria-labelledby="modalHapusStokKeluarLabel{{ $item->id_stok_keluar }}" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
               <div class="modal-content">
                   <div class="modal-header bg-danger text-white">
                       <h5 class="modal-title" id="modalHapusStokKeluarLabel{{ $item->id_stok_keluar }}">
                           Hapus Data Stok Keluar?
                       </h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true" class="text-white">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body text-left">
                       <div class="row">
                           <div class="col-6">Kode Produk</div>
                           <div class="col-6">: {{ $item->produk->kode_produk }}</div>
                           <div class="col-6">Produk</div>
                           <div class="col-6">: {{ $item->produk->nama_produk }}</div>
                           <div class="col-6">Jumlah Keluar</div>
                           <div class="col-6">: {{ $item->jumlah }}</div>
                           <div class="col-6">Tanggal Keluar</div>
                           <div class="col-6">: {{ $item->tanggal_keluar }}</div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                           <i class="fas fa-times"></i> Tutup
                       </button>
                       <form action="{{ route('stokkeluarDestroy', $item->id_stok_keluar) }}" method="POST"
                           class="d-inline">
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
