<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $item->id_pengguna }}" tabindex="-1"
    aria-labelledby="exampleModalLabel{{ $item->id_pengguna }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabel{{ $item->id_pengguna }}">Hapus {{ $title }} ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <div class="row">
                    <div class="col-6">Nama</div>
                    <div class="col-6">: {{ $item->nama }}</div>
                    <div class="col-6">Email</div>
                    <div class="col-6">: <span class="badge badge-primary">{{ $item->email }}</span></div>
                    <div class="col-6">Role</div>
                    <div class="col-6">:
                        @if ($item->peran == 'admin')
                            <span class="badge badge-info">{{ $item->peran }}</span>
                        @else
                            <span class="badge badge-primary">{{ $item->peran }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup</button>
                <form action="{{ route('userDestroy', $item->id_pengguna) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
