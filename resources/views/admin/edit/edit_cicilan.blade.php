<style>
    #no_layanan{
        display: none;
    }
</style>
@php
    use App\Tunggakan;
@endphp
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
            <form action="{{ url('cicilan/update/'.$transaksi->id_transaksi) }}" method="POST" id="formBna">
                @csrf
                <div class="row">
                    <input type="hidden" name="id_jenis_transaksi" value="{{ request()->segment(2) }}">
                    <div class="col-md-6 col-sm-12 col-xl-6">
                        <div class="form-group">
                            <label for="produk_transaksi">Produk Transaksi :</label>
                            <select name="produk_transaksi" id="produk_transaksi" class="form-control form-control-sm">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $p)
                                    <option value="{{ $p->nama_produk }}" @if($transaksi->produk_transaksi == $p->nama_produk) {{'selected'}} @else {{''}} @endif>{{ $p->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_jastel">Nomor Jastel :</label> 
                            <button type="button" class="btn btn-success btn-sm float-right" id="addRow"><i class="fas fa-plus"></i> Tambah Nomo Jastel</button>
                            <table style="width:100%" id="table_nomor_jastel" cellpadding="5">
                                @foreach ($nojastel as $nj)
                                    <tr>
                                        <td><input class="form-control form-control-sm" name="nomor_jastel[]" placeholder="Nomor Jastel" value="{{ $nj->nomor_jastel }}"></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-block deleteBtn"><i class="fas fa-trash"></i> Hapus</button></td>
                                    </tr>
                                @endforeach
                                <tr id="last">
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="nama_transaksi">Nama :</label>
                            <input type="text" class="form-control form-control-sm" name="nama_transaksi" id="nama_transaksi" value="{{ $transaksi->nama_transaksi }}">
                            @error('nama_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_identitas_transaksi">Alamat Identitas :</label>
                            <input type="text" class="form-control form-control-sm" name="alamat_identitas_transaksi" id="alamat_identitas_transaksi" value="{{ $transaksi->alamat_identitas_transaksi }}">
                            @error('alamat_identitas_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_instalasi_transaksi">Alamat Instalasi :</label>
                            <input type="text" class="form-control form-control-sm" name="alamat_instalasi_transaksi" id="alamat_instalasi_transaksi" value="{{ $transaksi->alamat_instalasi_transaksi }}">
                            @error('alamat_instalasi_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_identitas_transaksi">Jenis Identitas :</label>
                            <select name="jenis_identitas_transaksi" id="jenis_identitas_transaksi" class="form-control form-control-sm">
                                <option value="">-- Pilih Jenis Identitas --</option>
                                <option value="KTP" @if($transaksi->jenis_identitas_transaksi == 'KTP') {{'selected'}} @else {{''}} @endif>KTP</option>
                                <option value="SIM" @if($transaksi->jenis_identitas_transaksi == 'SIM') {{'selected'}} @else {{''}} @endif>SIM</option>
                            </select>
                            @error('jenis_identitas_transaksi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_identitas_transaksi">Nomor Identitas :</label>
                            <input type="text" class="form-control form-control-sm" name="no_identitas_transaksi" id="no_identitas_transaksi" value="{{ $transaksi->no_identitas_transaksi }}">
                            @error('no_identitas_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp_transaksi">Nomor HP</label>
                            <input type="text" class="form-control form-control-sm" name="no_hp_transaksi" id="no_hp_transaksi" value="{{ $transaksi->no_hp_transaksi }}">
                            @error('no_hp_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="cp_transaksi">Nomor Telepon</label>
                            <input type="text" class="form-control form-control-sm" name="cp_transaksi" id="cp_transaksi" value="{{ $transaksi->cp_transaksi }}">
                            @error('cp_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="tunggakan">Tunggakan :</label> 
                            <button type="button" class="btn btn-success btn-sm float-right" id="addRowTunggakan"><i class="fas fa-plus"></i> Tambah Tunggakan</button>
                            <table style="width:100%" id="table_tunggakan" cellpadding="5">
                                @foreach ($tunggakan as $t)
                                     <tr>
                                        <td><input class="form-control form-control-sm" name="tunggakan[]" value="{{ $t->tunggakan }}"></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-block deleteBtn"><i class="fas fa-trash"></i> Hapus</button></td>
                                    </tr>
                                @endforeach
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
                                            <label for="tanggal_mulai">Mulai :</label>
                                            <input type="text" class="form-control form-control-sm datemonth" name="tanggal_mulai" id="tanggal_mulai" value="{{ $transaksi->tahun_mulai.'-0'.$transaksi->bulan_mulai }}">
                                            @error('tanggal_mulai') <small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="tanggal_sampai">Sampai :</label>
                                            <input type="text" class="form-control form-control-sm datemonth" name="tanggal_sampai" id="tanggal_sampai" value="{{ $transaksi->tahun_sampai.'-0'.$transaksi->bulan_sampai }}">
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
                                            <label for="tanggal_periode_mulai">Mulai :</label>
                                            <input type="text" class="form-control form-control-sm datemonth" name="tanggal_periode_mulai" id="tanggal_periode_mulai" value="{{ $transaksi->tahun_periode_mulai.'-0'.$transaksi->bulan_periode_mulai }}">
                                            @error('tanggal_periode_mulai') <small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="tanggal_periode_sampai">Sampai :</label>
                                            <input type="text" class="form-control form-control-sm datemonth" name="tanggal_periode_sampai" id="tanggal_periode_sampai" value="{{ $transaksi->tahun_periode_sampai.'-0'.$transaksi->bulan_periode_sampai }}">
                                            @error('tanggal_periode_sampai') <small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="denda_cicilan_transaksi">Denda :</label> 
                                <input type="text" class="form-control form-control-sm" name="denda_cicilan_transaksi" id="denda_cicilan_transaksi" value="{{ $transaksi->denda_cicilan_transaksi }}">
                                @error('denda_cicilan_transaksi') <small class="text-danger">{{ $message }}</small> @enderror                               
                            </div>
                            <div class="form-group">
                                <label for="jumlah_total_cicilan_transaksi">Jumlah Total :</label>
                                <input type="text" class="form-control form-contorl-sm" name="jumlah_total_cicilan_transaksi" id="jumlah_total_cicilan_transaksi" value="{{ $transaksi->jumlah_total_cicilan_transaksi }}">
                                @error('jumlah_total_cicilan_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="angsuran_transaksi">Diangsur dalam (kali) :</label>
                                <input type="text" class="form-control form-control-sm" name="angsuran_transaksi" id="angsuran_transaksi" value="{{ $transaksi->angsuran_transaksi }}">
                                @error('angsuran_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="sambungan_digunakan_transaksi">Sambungan yang hanya dapat digunakan :</label><br>
                                <input type="radio" name="sambungan_digunakan_transaksi" value="TERIMA SAJA" @if($transaksi->sambungan_digunakan_transaksi == 'TERIMA SAJA') {{'checked'}} @else {{''}} @endif> Terima Saja <br>
                                <input type="radio" name="sambungan_digunakan_transaksi" value="DIBUKA LOKAL" @if($transaksi->sambungan_digunakan_transaksi == 'DIBUKA LOKAL') {{'checked'}} @else {{''}} @endif> Dibuka Lokal <br>
                                <input type="radio" name="sambungan_digunakan_transaksi" value="DIISOLIR TOTAL" @if($transaksi->sambungan_digunakan_transaksi == 'DIISOLIR TOTAL') {{'checked'}} @else {{''}} @endif> Diisolir Total <br>
                                @error('sambungan_digunakan_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="tagihan_beban_transaksi">Tagihan yang dibebankan :</label><br>
                                <input type="radio" name="tagihan_beban_transaksi" value="BISA TERIMA SAJA" @if($transaksi->tagihan_beban_transaksi == 'BISA TERIMA SAJA') {{'checked'}} @else {{''}} @endif> Terima Saja <br>
                                <input type="radio" name="tagihan_beban_transaksi" value="DIISOLIR TOTAL" @if($transaksi->tagihan_beban_transaksi == 'DIISOLIR TOTAL') {{'checked'}} @else {{''}} @endif> Diisolir Total <br>
                                @error('tagihan_beban_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="no_isolir_lain_transaksi">No. Lain yang diisolir :</label>
                                <input type="text" class="form-control form-control-sm" name="no_isolir_lain_transaksi" id="no_isolir_lain_transaksi" value="{{ $transaksi->no_isolir_lain_transaksi }}">
                            </div>
                            <div class="form-group">
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-block" id="signature"><i class="fas fa-sign"></i> Tanda Tangan Pelanggan</a>
                                <input type="hidden" name="id_signature" id="id_signature" value="{{ $transaksi->signature_pelanggan_transaksi }}">
                                @if ($transaksi->signature_pelanggan_transaksi)
                                    {!! '<i class="text-success"> Sudah ada tanda tangan</i>' !!}
                                @else
                                    {!! '<i class="text-danger"> Belum ada tanda tangan</i>' !!} 
                                @endif
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
                        <button type="submit" id="submit" class="btn btn-warning btn-block @if(!$transaksi->signature_pelanggan_transaksi) {{'disabled'}} @else  {{''}} @endif"><i class="fas fa-edit"></i> Update Berkas</button>
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