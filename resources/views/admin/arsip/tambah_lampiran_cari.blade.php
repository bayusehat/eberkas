<section>
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $title }}
            </h1>
            <a href="{{ url('lampiran') }}" class="btn btn-primary float-right"><i class="fas fa-sync"></i> Refresh Page</a>
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
            <form method="POST" action="{{ url('lampiran/search') }}" id="formSearchBerkas">
                @csrf
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xl-8">
                        <div class="form-group">
                            <label for="tanggal">Masukan Nomor Jastel / Nomor HP :</label> 
                            <input type="text" class="form-control" name="searchVal" id="searchVal" placeholder="Masukan keyword" required>
                            @error('tanggal') <small class="text-danger"> {{ $message }} </small> @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xl-4">
                        <div class="form-group">
                            <label for=""></label>
                            <button type="submit" class="btn btn-success btn-block"><i class="fas fa-search"></i> Cari Berkas</button>
                        </div>
                    </div>
                </div>
            </form>
                <div class="row mt-5">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <div class="table-responsive">
                            <h3 class="text-center">Hasil Transaksi Indihome</h3>
                            <table class="table table-hover table-bordered table-striped display" id="">
                                <thead>
                                    <tr>
                                        <th>No. Jastel</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Berkas</th>
                                        <th>HP</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($resultIndihome) > 0)
                                        @foreach ($resultIndihome as $ri)
                                            <tr>
                                                <td>{{ $ri->no_internet_indihome }}</td>
                                                <td>{{ $ri->jenis_permohonan_indihome }}</td>
                                                <td>{{ $ri->nama_pelanggan_indihome }}</td>
                                                <td>{{ $ri->alamat_pelanggan_indihome }}</td>
                                                <td>{{ date('d F H:i',strtotime($ri->create_indihome)) }}</td>
                                                <td>{{ $ri->kontak_hp_indihome }}</td>
                                                <td class="text-center">
                                                    <a href="{{ url('lampiran/create/7/'.$ri->id_indihome) }}" class="btn btn-primary btn-sm btn-block"><i class="fas fa-plus"></i> Tambah Lampiran</a>
                                                    <a href="{{ url('lampiran/view/7/'.$ri->id_indihome) }}" class="btn btn-warning btn-sm btn-block"><i class="fas fa-eye"></i> Lihat Lampiran</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <div class="table-responsive">
                            <h3 class="text-center">Hasil Transaksi Form Existing</h3>
                            <table class="table table-hover table-bordered table-striped display" id="">
                                <thead>
                                    <tr>
                                        <th>No. Jastel</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Nama</th>
                                        <th>Alamat Instalasi</th>
                                        <th>Tanggal Berkas</th>
                                        <th>HP</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($resultTransaksi) > 0)
                                         @foreach ($resultTransaksi as $rt)
                                            <tr>
                                                <td>{{ $rt->nomor_jastel }}</td>
                                                <td>{{ $rt->nama_jenis_transaksi }}</td>
                                                <td>{{ $rt->nama_transaksi }}</td>
                                                <td>{{ $rt->alamat_instalasi_transaksi }}</td>
                                                <td>{{ date('d F H:i',strtotime($rt->create_transaksi)) }}</td>
                                                <td>{{ $rt->no_hp_transaksi }}</td>
                                                <td class="text-center">
                                                    <a href="{{ url('lampiran/create/'.$rt->id_jenis_transaksi.'/'.$rt->id_transaksi) }}" class="btn btn-primary btn-sm btn-block"><i class="fas fa-plus"></i> Tambah Lampiran</a>
                                                    <a href="{{ url('lampiran/view/'.$rt->id_jenis_transaksi.'/'.$rt->id_transaksi) }}" class="btn btn-warning btn-sm btn-block"><i class="fas fa-eye"></i> Lihat Lampiran</a>
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