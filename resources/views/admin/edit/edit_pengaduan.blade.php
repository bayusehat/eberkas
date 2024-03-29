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
            <form action="{{ url('pengaduan/update/'.$transaksi->id_transaksi) }}" method="POST" id="formBna" enctype="multipart/form-data">
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
                                        <td><input class="form-control form-control-sm" name="nomor_jastel[]" placeholder="Nomor Jastel" value="{{ $nj->nomor_jastel }}" required></td>
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
                            @php
                                if($transaksi->jenis_identitas_transaksi == 'KTP'){
                                    $kosong = '';
                                    $ktp = 'selected';
                                    $sim = '';
                                }else if($transaksi->jenis_identitas_transaksi == 'SIM'){
                                    $kosong = '';
                                    $ktp = '';
                                    $sim = 'selected';
                                }else{
                                    $kosong = 'selected';
                                    $ktp = '';
                                    $sim = '';
                                }
                            @endphp
                            <label for="jenis_identitas_transaksi">Jenis Identitas<span class="text-danger">*</span> :</label>
                            <select name="jenis_identitas_transaksi" id="jenis_identitas_transaksi" class="form-control form-control-sm">
                                <option value="" {{$kosong}}>-- Pilih Jenis Identitas --</option>
                                <option value="KTP" {{$ktp}}>KTP</option>
                                <option value="SIM" {{$sim}}>SIM</option>
                            </select>
                            @error('jenis_identitas_transaksi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_identitas_transaksi">Nomor Identitas<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="no_identitas_transaksi" id="no_identitas_transaksi" value="{{ $transaksi->no_identitas_transaksi }}">
                            @error('no_identitas_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xl-6">
                        <div class="form-group">
                            <label for="status_penggunaan_transaksi">Status Penggunaan<span class="text-danger">*</span> :</label>
                            <select name="status_penggunaan_transaksi" id="status_penggunaan_transaksi" class="form-control form-control-sm">
                                <option value="">-- Pilih Status Penggunaan --</option>
                                <option @if($transaksi->status_penggunaan_transaksi == 'RUMAH TANGGA') {{'selected'}} @else {{''}} @endif>RUMAH TANGGA</option>
                                <option @if($transaksi->status_penggunaan_transaksi == 'BISNIS') {{'selected'}} @else {{''}} @endif>BISNIS</option>
                                <option @if($transaksi->status_penggunaan_transaksi == 'PEMERINTAH') {{'selected'}} @else {{''}} @endif>PEMERINTAH</option>
                                <option @if($transaksi->status_penggunaan_transaksi == 'SOSIAL') {{'selected'}} @else {{''}} @endif>SOSIAL</option>
                            </select>
                            @error('status_penggunaan_transaksi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="status_pemohon_transaksi">Status Pemohon<span class="text-danger">*</span> :</label>
                            <select name="status_pemohon_transaksi" id="status_pemohon_transaksi" class="form-control form-control-sm">
                                <option value="">-- Pilih Status Pemohon --</option>
                                <option @if($transaksi->status_pemohon_transaksi == 'PEMILIK') {{'selected'}} @else {{''}} @endif>PEMILIK</option>
                                <option @if($transaksi->status_pemohon_transaksi == 'PEMAKAI') {{'selected'}} @else {{''}} @endif>PEMAKAI</option>
                            </select>
                            @error('status_pemohon_transaksi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="isi_pengaduan_transaks">Isi Pengaduan<span class="text-danger">*</span> :</label>
                            <textarea name="isi_pengaduan_transaksi" id="isi_pengaduan_transaksi" class="form-control form-control-sm">{{ $transaksi->isi_pengaduan_transaksi }}</textarea>
                            @error('isi_pengaduan_transaksi') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="keadaan_sambungan_telepon_transaksi">Keadaan Sambungan Telepon<span class="text-danger">*</span> :</label><br>
                            <input type="radio" name="keadaan_sambungan_telepon_transaksi" id="keadaan_sambungan_telepon_transaksi" value="ADA PARALEL" @if($transaksi->keadaan_sambungan_telepon_transaksi == 'ADA PARALEL') {{'checked'}} @else {{''}} @endif> ADA PARALEL<br>
                            <input type="radio" name="keadaan_sambungan_telepon_transaksi" id="keadaan_sambungan_telepon_transaksi" value="ADA ALAT ANTI INTERLOKAL" @if($transaksi->keadaan_sambungan_telepon_transaksi == 'ADA ALAT ANTI INTERLOKAL') {{'checked'}} @else {{''}} @endif> ADA ALAT ANTI INTERLOKAL<br>
                            <input type="radio" name="keadaan_sambungan_telepon_transaksi" id="keadaan_sambungan_telepon_transaksi" value="ADA ALAT TAMBAHAN LAIN" @if($transaksi->keadaan_sambungan_telepon_transaksi == 'ADA ALAT TAMBAHAN LAIN') {{'checked'}} @else {{''}} @endif> ADA ALAT TAMBAHAN LAIN<br>
                            @error('keadaan_sambungan_telepon') <small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="cp_transaksi">Contact Person<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="cp_transaksi" id="cp_transaksi" value="{{ $transaksi->cp_transaksi }}">
                            @error('cp_transaksi') <small class="text-danger">{{ $message }}</small> @enderror
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
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <button type="submit" id="submit" class="btn btn-warning btn-block @if(!$transaksi->signature_pelanggan_transaksi) {{'disabled'}} @else {{''}} @endif"><i class="fas fa-edit"></i> Update Berkas</button>
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
                            '<td><input class="form-control form-control-sm" name="nomor_jastel[]" placeholder="Nomor Jastel" required></td>'+
                            '<td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-block deleteBtn"><i class="fas fa-trash"></i> Hapus</button></td>'+
                    '</tr>';
            $(row).insertBefore('#last');
        });

        $("#table_nomor_jastel").on("click", ".deleteBtn", function() {
            $(this).closest("tr").remove();
        }); 
    });
</script>