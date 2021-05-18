<section>
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $title }}
            </h1>
            <a href="{{ url('indihome/new') }}" class="btn btn-danger float-right"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <a href="{{ url('indihome/new/pdf/'.request()->segment(4)) }}" class="btn btn-success float-right" target="_blank"><i class="fas fa-file"></i> Create PDF</a>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <div class="table-responsive">
                            <h3 class="text-center">Data File</h3>
                            <table class="table table-hover table-bordered table-striped display" id="tblOld">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama File</th>
                                        <th>Tipe File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $f => $fl)
                                        <tr>
                                            <td>{{ ++$f }}</td>
                                            <td>{{ $fl->lampiran }}</td>
                                            <td>{{ $fl->keterangan_lampiran }}</td>
                                            <td>
                                                <a href="{{ url("indihome/new/download/$fl->id_lampiran") }}" class="btn btn-success"> Download</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>