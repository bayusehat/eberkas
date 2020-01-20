<section>
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $title }}
            </h1>
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
                    <div class="col-md-8 col-sm-12 col-xl-8">
                        <div class="form-group">
                            <label for="tanggal">Pilih Tanggal :</label> 
                            <input type="text" class="form-control datepicker" name="tanggal" id="tanggal" placeholder="Pilih Tanggal berkas" required>
                            @error('tanggal') <small class="text-danger"> {{ $message }} </small> @enderror
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
                            <h3 class="text-center">Hasil Pencarian Berkas</h3>
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No. Jastel</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Berkas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="resultBerkas">
                                    <tr>
                                        <td class="text-center" colspan="6">
                                            <h6 class="text-danger"><i>Cari berkas</i></h6>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
    function cariBerkas(){
        var tanggal = $('#tanggal').val();

        if(tanggal){
            $.ajax({
                url : '{{ url("berkas/search") }}',
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
                },
                method : 'POST',
                data : {
                    'tanggal' : tanggal
                },
                beforeSend:function(){
                    $('#resultBerkas').loading();
                },
                complete:function(){
                    $('#resultBerkas').loading('stop');
                },
                success:function(res){
                    $('#resultBerkas').html(res).fadeIn();
                }
            })
        }else{
            alert('Tanggal harus diisi!');
        }
    }
</script>