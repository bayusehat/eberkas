<section>
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $title }}
            </h1>
            {{-- <a href="{{ url('lampiran') }}" class="btn btn-danger float-right"><i class="fas fa-arrow-left"></i> Kembali</a> --}}
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
                {{-- <div class="row">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <a href="{{ url('lampiran/create/'.request()->segment(3).'/'.request()->segment(4)) }}" class="btn btn-success float-right"><i class="fas fa-plus"></i> Tambah Lampiran</a>
                    </div>
                </div> --}}
                <div class="row mt-5">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <div class="table-responsive">
                            <h3 class="text-center">Data Lampiran</h3>
                            <table class="table table-hover table-bordered table-striped display" id="tblOld">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Nomer Indihome</th>
                                        <th>Witel</th>
                                        <th>Plasa</th>
                                        <th>Tanggal Input</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script>
    $(function(){
        loadData();
    });

    function loadData(){
        $('#tblOld').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '{{ url("indihome/old/load") }}'
            },
            columns: [
                { name: 'id_indihome', searchable: false, className: 'text-center' },
                { name: 'nama' },
                { name: 'nomer_indihome'},
                { name: 'witel_plasa'},
                { name: 'loker' },
                { name: 'tgl_input'},
                { name: 'file', searchable: true, className: 'text-center'}
            ],
            lengthMenu: [10],
            order: [[0, 'desc']],
        });
    }
</script>