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
            <form action="{{ url('claim/update/'.$transaksi->id_transaksi) }}" method="POST" id="formBna" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <input type="hidden" name="id_jenis_transaksi" value="{{ request()->segment(2) }}">
                    <div class="col-md-6 col-sm-12 col-xl-6">
                        <div class="form-group">
                            <label for="produk_transaksi">Produk Transaksi<span class="text-danger">*</span> :</label>
                            <select name="produk_transaksi" id="produk_transaksi" class="form-control form-control-sm">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $p)
                                    <option value="{{ $p->nama_produk }}" @if($transaksi->produk_transaksi == $p->nama_produk) {{'selected'}} @else {{''}} @endif>{{ $p->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_jastel">Nomor Jastel<span class="text-danger">*</span> :</label> 
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
                            <label for="nama_transaksi">Nama<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="nama_transaksi" id="nama_transaksi" value="{{ $transaksi->nama_transaksi }}">
                            @error('nama_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_identitas_transaksi">Alamat Identitas<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="alamat_identitas_transaksi" id="alamat_identitas_transaksi" value="{{ $transaksi->alamat_identitas_transaksi }}">
                            @error('alamat_identitas_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_instalasi_transaksi">Alamat Instalasi<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="alamat_instalasi_transaksi" id="alamat_instalasi_transaksi" value="{{ $transaksi->alamat_instalasi_transaksi }}">
                            @error('alamat_instalasi_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_identitas_transaksi">Jenis Identitas<span class="text-danger">*</span> :</label>
                            <select name="jenis_identitas_transaksi" id="jenis_identitas_transaksi" class="form-control form-control-sm">
                                <option value="">-- Pilih Jenis Identitas --</option>
                                <option value="KTP" @if($transaksi->jenis_identitas_transaksi == 'KTP') {{'selected'}} @else {{''}} @endif>KTP</option>
                                <option value="SIM" @if($transaksi->jenis_identitas_transaksi == 'SIM') {{'selected'}} @else {{''}} @endif>SIM</option>
                            </select>
                            @error('jenis_identitas_transaksi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_identitas_transaksi">Nomor Identitas<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="no_identitas_transaksi" id="no_identitas_transaksi" value="{{ $transaksi->no_identitas_transaksi }}">
                            @error('no_identitas_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir_transaksi">Tanggal Lahir<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm datepicker" name="tanggal_lahir_transaksi" id="tanggal_lahir_transaksi" value="{{ $transaksi->tanggal_lahir_transaksi }}">
                            @error('tanggal_lahir_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp_transaksi">Nomor HP<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="no_hp_transaksi" id="no_hp_transaksi" value="{{ $transaksi->no_hp_transaksi }}">
                            @error('no_hp_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="email_transaksi">E-mail :</label>
                            <input type="text" class="form-control form-control-sm" name="email_transaksi" id="email_transaksi" value="{{ $transaksi->email_transaksi }}">
                            @error('email_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xl-6">
                        <div class="form-group">
                            <label for=""><strong>Penerima Kuasa</strong></label>
                            <div class="form-group">
                                <label for="nama_penerima_kuasa_transaksi">Nama Penerima<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="nama_penerima_kuasa_transaksi" id="nama_penerima_kuasa_transaksi" value="{{ $transaksi->nama_penerima_kuasa_transaksi }}">
                                @error('nama_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat_penerima_kuasa_transaksi">Alamat Penerima Kuasa<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="alamat_penerima_kuasa_transaksi" id="alamat_penerima_kuasa_transaksi" value="{{ $transaksi->alamat_penerima_kuasa_transaksi }}">
                                @error('alamat_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis_identitas_penerima_kuasa_transaksi">Jenis Identitas Penerima Kuasa<span class="text-danger">*</span> :</label>
                                <select name="jenis_identitas_penerima_kuasa_transaksi" id="jenis_identitas_penerima_kuasa_transaksi" class="form-control form-control-sm">
                                    <option value="">-- Pilih Jenis Identitas --</option>
                                    <option value="KTP" @if($transaksi->jenis_identitas_penerima_kuasa_transaksi == 'KTP') {{'selected'}} @else {{''}} @endif>KTP</option>
                                    <option value="SIM" @if($transaksi->jenis_identitas_penerima_kuasa_transaksi == 'SIM') {{'selected'}} @else {{''}} @endif>SIM</option>
                                </select>
                                @error('jenis_identitas_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="no_identitas_penerima_kuasa_transaksi">Nomor Identitas Penerima Kuasa<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="no_identitas_penerima_kuasa_transaksi" id="no_identitas_penerima_kuasa_transaksi" value="{{ $transaksi->no_identitas_penerima_kuasa_transaksi }}">
                                @error('no_identitas_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis_claim_transaksi">Jenis Claim<span class="text-danger">*</span> :</label>
                                <br>
                                <input type="radio" name="jenis_claim_transaksi" value="TUNAI" @if($transaksi->jenis_claim_transaksi == 'TUNAI') {{'checked'}} @else {{''}} @endif> Tunai <br>
                                <input type="radio" name="jenis_claim_transaksi" value="NON TUNAI" @if($transaksi->jenis_claim_transaksi == 'NON TUNAI') {{'checked'}} @else {{''}} @endif> Non Tunai <br>
                                <input type="radio" name="jenis_claim_transaksi" value="TIKETING" @if($transaksi->jenis_claim_transaksi == 'TIKETING') {{'checked'}} @else {{''}} @endif> Tiketing (Potongan Bulan Depan)
                                @error('jenis_claim_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="jumlah_claim_transaksi">Jumlah Claim<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="jumlah_claim_transaksi" id="jumlah_claim_transaksi" value="{{ $transaksi->jumlah_claim_transaksi }}">
                                @error('jumlah_claim_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="alasan_claim_transaksi">Alasan Claim<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="alasan_claim_transaksi" id="alasan_claim_transaksi" value="{{ $transaksi->alasan_claim_transaksi }}">
                                @error('alasan_claim_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="">Bulan Tagihan<span class="text-danger">*</span> :</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Mulai<span class="text-danger">*</span> :</label>
                                            <input type="text" class="form-control form-control-sm datemonth" name="tanggal_mulai" id="tanggal_mulai" value="{{ $transaksi->tahun_mulai.'-'.$transaksi->bulan_mulai }}">
                                            @error('tanggal_mulai') <small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="tanggal_sampai">Sampai<span class="text-danger">*</span> :</label>
                                            <input type="text" class="form-control form-control-sm datemonth" name="tanggal_sampai" id="tanggal_sampai" value="{{ $transaksi->tahun_sampai.'-'.$transaksi->bulan_sampai }}">
                                            @error('tanggal_sampai') <small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="identifikasi_claim_transaksi">Identifikasi Awal atas Claim<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="identifikasi_claim_transaksi" id="identifikasi_claim_transaksi" value="{{ $transaksi->identifikasi_claim_transaksi }}">
                                @error('identifikasi_claim_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-block" id="signature"><i class="fas fa-sign"></i> Tanda Tangan Pelanggan</a>
                                <input type="hidden" name="id_signature" id="id_signature" value="{{ $transaksi->signature_pelangga_transaksi }}">
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
                        <button type="submit" id="submit" class="btn btn-warning btn-block  
                        @if ($transaksi->signature_pelanggan_transaksi)
                            {{ '' }}
                        @else
                            {{ 'disabled' }}
                        @endif"><i class="fas fa-edit"></i> Update Berkas</button>
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

        $("#table_nomor_jastel").on("click", ".deleteBtn", function() {
            $(this).closest("tr").remove();
        }); 
    });
</script>