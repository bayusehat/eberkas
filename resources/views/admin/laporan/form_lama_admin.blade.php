<section>
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $title }}
            </h1>
            <a href="{{ url('laporan/lama/admin') }}" class="btn btn-primary float-right"><i class="fas fa-sync"></i> Refresh Page</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses!</strong> {{ Session::get('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
    
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> {{ Session::get('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
                <div class="row mt-5">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <div class="table-responsive">
                            <h3 class="text-center">{{ $title }}</h3>
                            <table class="table table-hover table-bordered table-striped display" style="width:100%" id="tableData">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Jatel</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script>
    $(document).ready(function(){
       loadForm()
    });

    function loadForm(){
        $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '{{ url("laporan/lama/admin/load") }}'
            },
            columns: [
                { name: 'id_transaksi', searchable: false, className: 'text-center' },
                { name: 'nomor_jastel' },
                { name: 'nama_jenis_transaksi'},
                { name: 'nama_transaksi'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            lengthMenu: [10],
            order: [[0, 'asc']],
        });
    }
</script>