<section>
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $title }}
            </h1>
            <a href="{{ url('laporan/lama') }}" class="btn btn-primary float-right"><i class="fas fa-sync"></i> Refresh Page</a>
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
            <form method="POST" id="formSearchBerkas">
                @csrf
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xl-4">
                        <div class="form-group">
                            <label for="tanggal">Bulprod :</label> 
                            <input type="text" class="form-control form-control-sm datemonth" name="bulprod" id="bulprod" placeholder="Masukan keyword" value="{{ old('bulprod') }}" required>
                            @error('bulprod') <small class="text-danger"> {{ $message }} </small> @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xl-4">
                        <div class="form-group">
                            <label for=""></label>
                            <button type="button" onclick="cariBerkas()" class="btn btn-success btn-block"><i class="fas fa-search"></i> Cari Berkas</button>
                        </div>
                    </div>
                </div>
            </form>
                <div class="row mt-5">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <div class="table-responsive">
                            <h3 class="text-center">{{ $title }}</h3>
                            <table class="table table-hover table-bordered table-striped display" style="width:100%" id="tableData">
                                <thead>
                                    <tr>
                                        <th>Witel</th>
                                        <th>Jumlah Berkas</th>
                                        <th>Berkas Lengkap</th>
                                        <th>Berkas Kurang</th>
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
        $('#tableData').DataTable();
    });

    function cariBerkas(){
        var bulprod = $('#bulprod').val();

        if(bulprod){
            $('#tableData').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('laporan/indihome/search') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data : {
                    'bulprod' : bulprod
                }
            },
            columns: [
                { name: 'witel', searchable: false, orderable: true, className: 'text-center' },
                { name: 'jumlah_berkas', className:'text-center'},
                { name: 'berkas_lengkap', className:'text-center'},
                { name: 'berkas_kurang', className:'text-center'},
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
        }else{
            alert('Tanggal harus diisi!');
        }
    }
</script>