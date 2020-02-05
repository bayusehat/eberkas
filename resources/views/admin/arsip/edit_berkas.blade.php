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
                    <div class="col-md-4 col-sm-12 col-xl-4">
                        <div class="form-group">
                            <label for="tanggal">Pilih Tanggal :</label> 
                            <input type="text" class="form-control datepicker" name="tanggal" id="tanggal" placeholder="Pilih Tanggal berkas" required>
                            @error('tanggal') <small class="text-danger"> {{ $message }} </small> @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xl-4">
                        <div class="form-group">
                            <label for="tanggal">Nomor Jastel / Nomor HP</label> 
                            <input type="text" class="form-control" name="nomor_search" id="nomor_search" placeholder="Masukan Nomor Jastel / Nomor HP" required>
                            @error('nomor_search') <small class="text-danger"> {{ $message }} </small> @enderror
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
                            <table class="table table-hover table-bordered table-striped" style="width:100%" id="tableData">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Nama</th>
                                        <th>No. HP</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Berkas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td class="text-center" colspan="6">
                                            <h6 class="text-danger"><i>Cari berkas</i></h6>
                                        </td>
                                    </tr> --}}
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
        $('#tableData').DataTable();
    })
    function cariBerkas(){
        var tanggal = $('#tanggal').val();
        var nomor_search = $('#nomor_search').val();

        if(tanggal){
            $('#tableData').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('berkas/search') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data : {
                    'tanggal' : tanggal,
                    'nomor_search' : nomor_search
                }
            },
            columns: [
                { name: 'id_transaksi', searchable: false, orderable: true, className: 'text-center' },
                { name: 'jenis_transaksi' },
                { name: 'nama_transaksi'},
                { name: 'no_hp_transaksi'},
                { name: 'alamat_pelanggan_transaksi'},
                { name: 'create_transaksi'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
            // $.ajax({
            //     url : '{{ url("berkas/search") }}',
            //     headers : {
            //         'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            //     },
            //     method : 'POST',
            //     data : {
            //         'tanggal' : tanggal
            //     },
            //     beforeSend:function(){
            //         $('#resultBerkas').loading();
            //     },
            //     complete:function(){
            //         $('#resultBerkas').loading('stop');
            //     },
            //     success:function(res){
            //         $('#resultBerkas').html(res).fadeIn();
            //     }
            // })
        }else{
            alert('Tanggal harus diisi!');
        }
    }
</script>