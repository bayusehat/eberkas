<style>
    #no_layanan{
        display: none;
    }
</style>
<section>
    <div class="card">
        <div class="card-header">
            <h3>
                {{ $title }}
            </h3>
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
            <form action="{{ url('cicilan/insert') }}" method="POST" id="formBna" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <input type="hidden" name="id_jenis_transaksi" value="{{ request()->segment(2) }}">
                    <div class="col-md-6 col-sm-12 col-xl-6">
                        <div class="form-group">
                            <label for="produk_transaksi">Produk Transaksi<span class="text-danger">*</span> :</label>
                            <select name="produk_transaksi" id="produk_transaksi" class="form-control form-control-sm">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $p)
                                    <option value="{{ $p->nama_produk }}">{{ $p->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_jastel">Nomor Jastel<span class="text-danger">*</span> :</label> 
                            <button type="button" class="btn btn-success btn-sm float-right" id="addRow"><i class="fas fa-plus"></i> Tambah Nomo Jastel</button>
                            <table style="width:100%" id="table_nomor_jastel" cellpadding="5">
                                <tr>
                                    <td><input class="form-control form-control-sm" name="nomor_jastel[]" placeholder="Nomor Jastel" required></td>
                                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-block deleteBtn"><i class="fas fa-trash"></i> Hapus</button></td>
                                </tr>
                                <tr id="last">
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="nama_transaksi">Nama<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="nama_transaksi" id="nama_transaksi" value="{{ old('nama_transaksi') }}">
                            @error('nama_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_identitas_transaksi">Alamat Identitas<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="alamat_identitas_transaksi" id="alamat_identitas_transaksi" value="{{ old('alamat_identitas_transaksi') }}">
                            @error('alamat_identitas_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_instalasi_transaksi">Alamat Instalasi<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="alamat_instalasi_transaksi" id="alamat_instalasi_transaksi" value="{{ old('alamat_instalasi_transaksi') }}">
                            @error('alamat_instalasi_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_identitas_transaksi">Jenis Identitas<span class="text-danger">*</span> :</label>
                            <select name="jenis_identitas_transaksi" id="jenis_identitas_transaksi" class="form-control form-control-sm">
                                <option value="">-- Pilih Jenis Identitas --</option>
                                <option value="KTP">KTP</option>
                                <option value="SIM">SIM</option>
                            </select>
                            @error('jenis_identitas_transaksi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_identitas_transaksi">Nomor Identitas<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="no_identitas_transaksi" id="no_identitas_transaksi" value="{{ old('no_identitas_transaksi') }}">
                            @error('no_identitas_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp_transaksi">Nomor HP<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="no_hp_transaksi" id="no_hp_transaksi" value="{{ old('no_hp_transaksi') }}">
                            @error('no_hp_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="cp_transaksi">Nomor Telepon<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="cp_transaksi" id="cp_transaksi" value="{{ old('cp_transaksi') }}">
                            @error('cp_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="tunggakan">Tunggakan :</label> 
                            <button type="button" class="btn btn-success btn-sm float-right" id="addRowTunggakan"><i class="fas fa-plus"></i> Tambah Tunggakan</button>
                            <table style="width:100%" id="table_tunggakan" cellpadding="5">
                                <tr>
                                    <td><input class="form-control form-control-sm" name="tunggakan[]" placeholder="Tunggakan 1" required></td>
                                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-block deleteBtn"><i class="fas fa-trash"></i> Hapus</button></td>
                                </tr>
                                <tr id="lastTunggakan">
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Bulan Tagihan :</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Mulai<span class="text-danger">*</span> :</label>
                                            <input type="text" class="form-control form-control-sm datemonth" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                                            @error('tanggal_mulai') <small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="tanggal_sampai">Sampai<span class="text-danger">*</span> :</label>
                                            <input type="text" class="form-control form-control-sm datemonth" name="tanggal_sampai" id="tanggal_sampai" value="{{ old('tanggal_sampai') }}">
                                            @error('tanggal_sampai') <small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Periode Pengangsuran :</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="tanggal_periode_mulai">Mulai<span class="text-danger">*</span> :</label>
                                            <input type="text" class="form-control form-control-sm datemonth" name="tanggal_periode_mulai" id="tanggal_periode_mulai" value="{{ old('tanggal_periode_mulai') }}">
                                            @error('tanggal_periode_mulai') <small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="tanggal_periode_sampai">Sampai<span class="text-danger">*</span> :</label>
                                            <input type="text" class="form-control form-control-sm datemonth" name="tanggal_periode_sampai" id="tanggal_periode_sampai" value="{{ old('tanggal_periode_sampai') }}">
                                            @error('tanggal_periode_sampai') <small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="denda_cicilan_transaksi">Denda<span class="text-danger">*</span> :</label> 
                                <input type="text" class="form-control form-control-sm" name="denda_cicilan_transaksi" id="denda_cicilan_transaksi" value="{{ old('denda_cicilan_transaksi') }}">
                                @error('denda_cicilan_transaksi') <small class="text-danger">{{ $message }}</small> @enderror                               
                            </div>
                            <div class="form-group">
                                <label for="jumlah_total_cicilan_transaksi">Jumlah Total<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-contorl-sm" name="jumlah_total_cicilan_transaksi" id="jumlah_total_cicilan_transaksi" value="{{ old('jumlah_total_cicilan_transaksi') }}">
                                @error('jumlah_total_cicilan_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="angsuran_transaksi">Diangsur dalam (kali)<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="angsuran_transaksi" id="angsuran_transaksi" value="{{ old('angsuran_transaksi') }}">
                                @error('angsuran_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="sambungan_digunakan_transaksi">Sambungan yang hanya dapat digunakan<span class="text-danger">*</span> :</label><br>
                                <input type="radio" name="sambungan_digunakan_transaksi" value="TERIMA SAJA"> Terima Saja <br>
                                <input type="radio" name="sambungan_digunakan_transaksi" value="DIBUKA LOKAL"> Dibuka Lokal <br>
                                <input type="radio" name="sambungan_digunakan_transaksi" value="DIISOLIR TOTAL"> Diisolir Total <br>
                                @error('sambungan_digunakan_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="tagihan_beban_transaksi">Tagihan yang dibebankan<span class="text-danger">*</span> :</label><br>
                                <input type="radio" name="tagihan_beban_transaksi" value="BISA TERIMA SAJA"> Terima Saja <br>
                                <input type="radio" name="tagihan_beban_transaksi" value="DIISOLIR TOTAL"> Diisolir Total <br>
                                @error('tagihan_beban_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="no_isolir_lain_transaksi">No. Lain yang diisolir<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="no_isolir_lain_transaksi" id="no_isolir_lain_transaksi" value="{{ old('no_isolir_transaksi') }}">
                            </div>
                            <div class="form-group">
                                <small class="text-danger">* Lampiran hanya diperbolehkan berukuran kurang dari 1 MB!</small><br>
                                <label for="lampiran">Lampiran<span class="text-danger">*</span> :</label>
                                <input type="file" class="form-control" name="lampiran[]" id="lampiran" multiple required>
                                @error('lampiran') <small>{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-block" id="signature"><i class="fas fa-sign"></i> Tanda Tangan Pelanggan</a>
                                <input type="hidden" name="id_signature" id="id_signature" value="{{ old('id_signature') }}">
                                @error('id_signature') <small class="text-danger">{{ $message }}</small>@enderror
                                <br>
                                <div id="signature-pad" class="jay-signature-pad">
                                    <div class="jay-signature-pad--body">
                                        <canvas id="jay-signature-pad" height="100px"></canvas>
                                    </div>
                                    <div class="signature-pad--footer txt-center">
                                        <small class="description">Tanda Tangan Diatas</small>
                                        <div class="signature-pad--actions txt-center">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="button" class="button clear" data-action="clear">Clear</button>
                                                    <button type="button" class="button" data-action="change-color">Change color</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <button type="submit" id="submit" class="btn btn-success btn-block disabled"><i class="fas fa-save"></i> Simpan Berkas</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('#addRow').click(function(){
            var row = '<tr>'+
                            '<td><input class="form-control form-control-sm" name="nomor_jastel[]" placeholder="Nomor Jastel"></td>'+
                            '<td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-block deleteBtn"><i class="fas fa-trash"></i> Hapus</button></td>'+
                    '</tr>';
            $(row).insertBefore('#last');
        });
        var t = 2;
        $('#addRowTunggakan').click(function(){
            var row = '<tr>'+
                            '<td><input class="form-control form-control-sm" name="tunggakan[]" placeholder="Tunggakan '+t+'"></td>'+
                            '<td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-block deleteBtn"><i class="fas fa-trash"></i> Hapus</button></td>'+
                    '</tr>';
            $(row).insertBefore('#lastTunggakan');
            t++;
        });

        $("#table_nomor_jastel").on("click", ".deleteBtn", function() {
            $(this).closest("tr").remove();
        }); 
    });
</script>