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
            <form action="{{ url('alih/insert') }}" method="POST" id="formBna">
                @csrf
                <div class="row">
                    <input type="hidden" name="id_jenis_transaksi" value="{{ request()->segment(2) }}">
                    <div class="col-md-6 col-sm-12 col-xl-6">
                        <div class="form-group">
                            <label for="produk_transaksi">Produk Transaksi :</label>
                            <select name="produk_transaksi" id="produk_transaksi" class="form-control form-control-sm">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $p)
                                    <option value="{{ $p->nama_produk }}">{{ $p->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_jastel">Nomor Jastel :</label> 
                            <button type="button" class="btn btn-success btn-sm float-right" id="addRow"><i class="fas fa-plus"></i> Tambah Nomo Jastel</button>
                            <table style="width:100%" id="table_nomor_jastel" cellpadding="5">
                                <tr>
                                    <td><input class="form-control form-control-sm" name="nomor_jastel[]" placeholder="Nomor Jastel"></td>
                                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-block deleteBtn"><i class="fas fa-trash"></i> Hapus</button></td>
                                </tr>
                                <tr id="last">
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="nama_transaksi">Nama :</label>
                            <input type="text" class="form-control form-control-sm" name="nama_transaksi" id="nama_transaksi" value="{{ old('nama_transaksi') }}">
                            @error('nama_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_identitas_transaksi">Alamat Identitas :</label>
                            <input type="text" class="form-control form-control-sm" name="alamat_identitas_transaksi" id="alamat_identitas_transaksi" value="{{ old('alamat_identitas_transaksi') }}">
                            @error('alamat_identitas_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_instalasi_transaksi">Alamat Instalasi :</label>
                            <input type="text" class="form-control form-control-sm" name="alamat_instalasi_transaksi" id="alamat_instalasi_transaksi" value="{{ old('alamat_instalasi_transaksi') }}">
                            @error('alamat_instalasi_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_identitas_transaksi">Jenis Identitas :</label>
                            <select name="jenis_identitas_transaksi" id="jenis_identitas_transaksi" class="form-control form-control-sm">
                                <option value="">-- Pilih Jenis Identitas --</option>
                                <option value="KTP">KTP</option>
                                <option value="SIM">SIM</option>
                            </select>
                            @error('jenis_identitas_transaksi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_identitas_transaksi">Nomor Identitas :</label>
                            <input type="text" class="form-control form-control-sm" name="no_identitas_transaksi" id="no_identitas_transaksi" value="{{ old('no_identitas_transaksi') }}">
                            @error('no_identitas_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir_transaksi">Tanggal Lahir :</label>
                            <input type="text" class="form-control form-control-sm datepicker" name="tanggal_lahir_transaksi" id="tanggal_lahir_transaksi" value="{{ old('tanggal_lahir_transaksi') }}">
                            @error('tanggal_lahir_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp_transaksi">Nomor HP :</label>
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
                                <label for="nama_penerima_kuasa_transaksi">Nama Penerima :</label>
                                <input type="text" class="form-control form-control-sm" name="nama_penerima_kuasa_transaksi" id="nama_penerima_kuasa_transaksi" value="{{ old('nama_penerima_kuasa_transaksi') }}">
                                @error('nama_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat_penerima_kuasa_transaksi">Alamat Penerima Kuasa :</label>
                                <input type="text" class="form-control form-control-sm" name="alamat_penerima_kuasa_transaksi" id="alamat_penerima_kuasa_transaksi" value="{{ old('alamat_penerima_kuasa_transaksi') }}">
                                @error('alamat_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis_identitas_penerima_kuasa_transaksi">Jenis Identitas Penerima Kuasa :</label>
                                <select name="jenis_identitas_penerima_kuasa_transaksi" id="jenis_identitas_penerima_kuasa_transaksi" class="form-control form-control-sm">
                                    <option value="">-- Pilih Jenis Identitas --</option>
                                    <option value="KTP">KTP</option>
                                    <option value="SIM">SIM</option>
                                </select>
                                @error('jenis_identitas_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="no_identitas_penerima_kuasa_transaksi">Nomor Identitas Penerima Kuasa :</label>
                                <input type="text" class="form-control form-control-sm" name="no_identitas_penerima_kuasa_transaksi" id="no_identitas_penerima_kuasa_transaksi" value="{{ old('no_identitas_penerima_kuasa_transaksi') }}">
                                @error('no_identitas_penerima_kuasa_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="paket_lama_transaksi">Paket Lama :</label>
                                <select name="paket_lama_transaksi" id="paket_lama_transaksi" class="form-control form-control-sm">
                                    <option value="">-- Pilih Paket Lama --</option>
                                    @foreach ($paketlama as $pl)
                                        <option value="{{ $pl->id_layanan }}">{{ $pl->nama_layanan }}</option>
                                    @endforeach
                                </select>
                                @error('paket_lama_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label for="paket_baru_transaksi">Paket Baru :</label>
                                <select name="paket_baru_transaksi" id="paket_baru_transaksi" class="form-control form-control-sm">
                                    <option value="">-- Pilih Paket Baru --</option>
                                    @foreach ($paketbaru as $pb)
                                        <option value="{{ $pb->id_layanan }}">{{ $pb->nama_layanan }}</option>
                                    @endforeach
                                </select>
                                @error('paket_baru_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div id="hunting">
                                <div class="form-group">
                                    <label for="induk_hunting_fitur_transaksi">Induk Hunting :</label>
                                    <input type="text" class="form-control form-control-sm" name="induk_hunting_fitur_transaksi" id="induk_hunting_fitur_transaksi">
                                    @error('induk_hunting_fitur_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="anak_hunting_fitur_transaksi">Anak Hunting :</label>
                                    <input type="text" class="form-control form-control-sm" name="anak_hunting_fitur_transaksi" id="anak_hunting_fitur_transaksi">
                                    @error('anak_hunting_fitur_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cp_transaksi">Contact Person :</label>
                                <input type="text" class="form-control form-control-sm" name="cp_transaksi" id="cp_transaksi" value="{{ old('cp_transaksi') }}">
                                @error('cp_transaksi') <small>{{ $message }}</small>@enderror
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
                        <button type="submit" class="btn btn-success btn-block"><i class="fas fa-save"></i> Simpan Berkas</button>
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
        $('#hunting').hide();
    });

    function getHunting(id){
        if(id == 9){
            $('#hunting').show();
        }
    }
</script>