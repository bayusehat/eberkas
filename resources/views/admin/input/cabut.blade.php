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
            <form action="{{ url('cabut/insert') }}" method="POST" id="formBna">
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
                            <label for="tanggal_lahir_transaksi">Tanggal Lahir<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm datepicker" name="tanggal_lahir_transaksi" id="tanggal_lahir_transaksi" value="{{ old('tanggal_lahir_transaksi') }}">
                            @error('tanggal_lahir_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp_transaksi">Nomor HP<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="no_hp_transaksi" id="no_hp_transaksi" value="{{ old('no_hp_transaksi') }}">
                            @error('no_hp_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="email_transaksi">E-mail :</label>
                            <input type="text" class="form-control form-control-sm" name="email_transaksi" id="email_transaksi" value="{{ old('email_transaksi') }}">
                            @error('email_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xl-6">
                        <div class="form-group">
                            <label for=""><strong>Penerima Kuasa</strong></label>
                            <div class="form-group">
                                <label for="nama_penerima_kuasa_transaksi">Nama Penerima<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="nama_penerima_kuasa_transaksi" id="nama_penerima_kuasa_transaksi" value="{{ old('nama_penerima_kuasa_transaksi') }}">
                                @error('nama_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat_penerima_kuasa_transaksi">Alamat Penerima Kuasa<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="alamat_penerima_kuasa_transaksi" id="alamat_penerima_kuasa_transaksi" value="{{ old('alamat_penerima_kuasa_transaksi') }}">
                                @error('alamat_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis_identitas_penerima_kuasa_transaksi">Jenis Identitas Penerima Kuasa<span class="text-danger">*</span> :</label>
                                <select name="jenis_identitas_penerima_kuasa_transaksi" id="jenis_identitas_penerima_kuasa_transaksi" class="form-control form-control-sm">
                                    <option value="">-- Pilih Jenis Identitas --</option>
                                    <option value="KTP">KTP</option>
                                    <option value="SIM">SIM</option>
                                </select>
                                @error('jenis_identitas_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="no_identitas_penerima_kuasa_transaksi">Nomor Identitas Penerima Kuasa<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="no_identitas_penerima_kuasa_transaksi" id="no_identitas_penerima_kuasa_transaksi" value="{{ old('no_identitas_penerima_kuasa_transaksi') }}">
                                @error('no_identitas_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="alasan_penerima_kuasa_transaksi">Alasan<span class="text-danger">*</span> :</label>
                                <select name="alasan_penerima_kuasa_transaksi" id="alasan_penerima_kuasa_transaksi" class="form-control form-control-sm">
                                    <option value="">-- Pilih Alasan --</option>
                                    <option>PINDAH ALAMAT</option>
                                    <option>PINDAH KE OPERATOR LAIN</option>
                                    <option>PINDAH KE PRA BAYAR</option>
                                    <option>SERING TERJADI GANGGUAN</option>
                                    <option>TAGIHAN TINGGI</option>
                                    <option>SUDAH ADA INDIHOME</option>
                                </select>
                                @error('alasan_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="deposit_penerima_kuasa_transaksi">Deposit<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="deposit_penerima_kuasa_transaksi" id="deposit_penerima_kuasa_transaksi" value="{{ old('deposit_penerima_kuasa_transaksi') }}">
                                @error('deposit_penerima_kuasa_transaksi') <small>{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="cp_transaksi">Contact Person<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control form-control-sm" name="cp_transaksi" id="cp_transaksi" value="{{ old('cp_transaksi') }}">
                                @error('cp_transaksi') <small>{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="nama_atasan_transaksi">Nama Atasan :</label>
                                <input type="text" class="form-control form-control-sm" name="nama_atasan_transaksi" id="nama_atasan_transaksi" value="{{ old('nama_atasan_transaksi') }}">
                                @error('nama_atasan_transaksi') <small>{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="jabatan_atasan_transaksi">Jabatan Atasan :</label>
                                <input type="text" class="form-control form-control-sm" name="jabatan_atasan_transaksi" id="jabatan_atasan_transaksi" value="{{ old('jabatan_atasan_transaksi') }}">
                                @error('jabatan_atasan_transaksi') <small>{{ $message }}</small>@enderror
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
                            <div class="form-group">
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-block" id="signature-atasan"><i class="fas fa-sign"></i> Tanda Tangan Atasan</a>
                                <input type="hidden" name="id_signature_atasan" id="id_signature_atasan" value="{{ old('id_signature_atasan') }}">
                                @error('id_signature_atasan') <small class="text-danger">{{ $message }}</small>@enderror
                                <br>
                                <div id="signature-pad-atasan" class="jay-signature-pad">
                                    <div class="jay-signature-pad--body">
                                        <canvas id="jay-signature-pad-atasan" height="100px"></canvas>
                                    </div>
                                    <div class="signature-pad--footer txt-center">
                                        <small class="description">Tanda Tangan Diatas</small>
                                        <div class="signature-pad--actions txt-center">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="button" class="button clear" data-action="clear2">Clear</button>
                                                    <button type="button" class="button" data-action="change-color2">Change color</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="button save" data-action="save-png2">Save as PNG</button>
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

        $("#table_nomor_jastel").on("click", ".deleteBtn", function() {
            $(this).closest("tr").remove();
        }); 
    });
</script>