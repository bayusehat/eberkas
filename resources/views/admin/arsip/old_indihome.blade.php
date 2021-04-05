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
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xl-3">
                        <div class="form-group">
                            <label for="">Range Tanggal</label>
                            <input type="text" class="datepicker form-control" name="dari_tgl" id="dari_tgl" placeholder="Dari Tanggal">
                            s./d.
                            <input type="text" class="datepicker form-control" name="sampai_tgl" id="sampai_tgl" placeholder="Sampai Tanggal">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xl-3">
                        <div class="form-group">
                            <label for="">Witel</label>
                            <select name="witel" id="witel" class="form-control">
                                <option value="all">ALL</option>
                                @foreach ($witel as $w)
                                    <option value="{{ $w->witel_plasa }}">{{ $w->witel_plasa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xl-3">
                        <div class="form-group">
                            <label for="">Loker</label>
                            <select name="loker" id="loker" class="form-control">
                                <option value="all">ALL</option>
                                @foreach ($plasa as $p)
                                    <option value="{{ $p->nama_plasa }}">{{ $p->nama_plasa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xl-3">
                        <div class="form-group">
                            <br>
                            <button type="button" class="btn btn-success btn-block" onclick="loadData()"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                </div>
            </form>
                
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
                                        <th>Jumlah File</th>
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
            searching: false,
            ajax: {
                url: '{{ url("indihome/old/load") }}',
                data : {
                    'witel'     : $("#witel").val(),
                    'loker'     : $("#loker").val(),
                    'dari_tgl'  : $("#dari_tgl").val(),
                    'sampai_tgl': $("#sampai_tgl").val()
                }
            },
            columns: [
                { name: 'id_indihome', searchable: false, className: 'text-center' },
                { name: 'nama' },
                { name: 'nomer_indihome'},
                { name: 'witel_plasa'},
                { name: 'loker' },
                { name: 'tgl_input'},
                { name: 'jumlah', searchable: true, className: 'text-center'},
                { name: 'file'}
            ],
            lengthMenu: [10],
            order: [[6, 'desc']],
        });
    }
</script>