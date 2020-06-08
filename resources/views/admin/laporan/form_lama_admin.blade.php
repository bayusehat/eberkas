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
            <form method="POST" id="formSearchBerkas" action="{{ url('laporan/lama/admin/search') }}">
                @csrf
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xl-3">
                        <div class="form-group">
                            <label for="witel">Witel :</label>
                            <select name="witel" id="witel" onchange="getPlasaSearch()" class="form-control form-control-sm select2">
                                <option value="">Semua Witel</option>
                                @foreach ($witel as $w)
                                    <option value="{{ $w->witel_plasa }}">{{ $w->witel_plasa }}</option>
                                @endforeach
                            </select>
                            <label for="tanggal">Loker :</label> 
                            <select name="loker" id="loker" class="form-control form-control-sm select2">
                                <option value="">Semua Loker</option>
                                @foreach ($loker as $l)
                                    <option value="{{ $l->nama_plasa }}">{{ $l->nama_plasa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xl-3">
                        <div class="form-group">
                            <label for="tanggal">Jenis Transaksi :</label> 
                            <select name="jenis" id="jenis" class="form-control form-control-sm">
                                <option value="">Semua Transaksi</option>
                                @foreach ($jenis as $j)
                                    <option value="{{ $j->id_jenis_transaksi }}">{{ $j->nama_jenis_transaksi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xl-3">
                        <div class="form-group">
                            <label for="tanggal">Tanggal Dari :</label> 
                            <input type="text" class="form-control form-control-sm datepicker" name="dari" id="dari">
                            <label for="tanggal">Tanggal Sampai :</label> 
                            <input type="text" class="form-control form-control-sm datepicker" name="sampai" id="sampai">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xl-3">
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
                            <h4 class="text-center">{{ $search }}</h4>
                            <hr>
                            <table class="table table-hover table-bordered table-striped display" style="width:100%" id="tableData">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Action</th>
                                        <th>Tgl. Transaksi</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Nomor Jastel</th>
                                        <th>Loker</th>
                                        <th>Witel</th>
                                        <th>Nama Pelanggan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($data as $i => $d)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td class="text-center">
                                                <a href="{{ url('detail/'.$d->id_jenis_transaksi.'/'.$d->id_transaksi) }}" class="btn btn-primary btn-sm btn-block" target="_blank"><i class="fas fa-eye"></i> Detail</a>
                                                <a href="{{ url('edit/'.$d->id_jenis_transaksi.'/'.$d->id_transaksi) }}" class="btn btn-warning btn-sm btn-block" target="_blank"><i class="fas fa-edit"></i> Edit</a>
                                            </td>
                                            <td>{{ date('d/m/Y H:i',strtotime($d->create_transaksi)) }}</td>                                            
                                            <td>{{ $d->nama_jenis_transaksi }}</td>
                                            <td>{{ $d->nomor_jastel }}</td>
                                            <td>{{ $d->loker }}</td>
                                            <td>{{ $d->witel }}</td>
                                            <td>{{ $d->nama_transaksi }}</th>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@php
    dd($data);
@endphp
<script>
    $(document).ready(function(){
    var title = '{{ $search }}';
    $('title').html(title);
    $("#tableData").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible',
                }
            },
            'colvis'
        ]
      });
      getPlasaSearch();
    });
</script>