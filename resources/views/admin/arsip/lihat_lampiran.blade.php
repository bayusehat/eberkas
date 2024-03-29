<section>
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $title }}
            </h1>
            <a href="{{ url('lampiran') }}" class="btn btn-danger float-right"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                        <a href="{{ url('lampiran/create/'.request()->segment(3).'/'.request()->segment(4)) }}" class="btn btn-success float-right"><i class="fas fa-plus"></i> Tambah Lampiran</a>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <div class="table-responsive">
                            <h3 class="text-center">Data Lampiran</h3>
                            <table class="table table-hover table-bordered table-striped display" id="">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Thumbnail</th>
                                        <th>Keterangan</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($lampiran)
                                        @foreach ($lampiran as $i => $l)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td class="text-center"><img src="{{ asset('lampiranfile/'.$l->lampiran) }}" alt="{{ $l->keterangan_lampiran }}" style="width:100px"></td>
                                                <td>{{ $l->keterangan_lampiran }}</td>
                                                <td class="text-center">
                                                    <a href="{{ url('lampiran/download/'.$l->id_lampiran) }}" class="btn btn-primary btn-sm"><i class="fas fa-download"></i> Download File</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script>
    $(document).ready(function(){
        $('table.display').DataTable();
    });
</script>