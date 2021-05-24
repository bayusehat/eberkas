<@php
    use App\PaketTambahanIndihome;
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
            @if (count($errors) > 0)
                @foreach ($errors as $err)
                    {{ $err }}
                @endforeach
            @endif
            <form action="{{ url('indihome/update/'.$indihome->id_indihome) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xl-6">
                    <label for="I"><b>I. Detail Layanan</b></label>
                    <div class="form-group">
                        <label for="jenis_permohonan_indihome">Jenis Permohonan<span class="text-danger">*</span> :</label>
                        <select name="jenis_permohonan_indihome" id="jenis_permohonan_indihome" class="form-control form-control-sm" onchange="getPermohonan()">
                            <option value="">-- Pilih Jenis Permohonan --</option>
                            <option value="KONTRAK BARU" @if($indihome->jenis_permohonan_indihome == 'KONTRAK BARU') {{'selected'}} @else {{''}}@endif>KONTRAK BARU</option>
                            <option value="UPGRADE LAYANAN/DOWNGRADE LAYANAN" @if($indihome->jenis_permohonan_indihome == 'UPGRADE LAYANAN/DOWNGRADE LAYANAN') {{'selected'}} @else {{''}}@endif>UPGRADE LAYANAN/DOWNGRADE LAYANAN</option>
                        </select>
                        @error('jenis_permohonan_indihome') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="jenis_paket_indihome">Jenis Paket<span class="text-danger">*</span> :</label>
                        <br>
                        <input type="radio" name="jenis_paket_indihome" id="jenis_paket_indihome" value="3 PLAY" @if($indihome->jenis_paket_indihome == "3 PLAY") {{'checked'}} @else {{''}} @endif> 3 Play<br>
                        <input type="radio" name="jenis_paket_indihome" id="jenis_paket_indihome" value="2 PLAY" @if($indihome->jenis_paket_indihome == "2 PLAY") {{'checked'}} @else {{''}} @endif> 2 Play<br>
                        <input type="radio" name="jenis_paket_indihome" id="jenis_paket_indihome" value="1 PLAY" @if($indihome->jenis_paket_indihome == "1 PLAY") {{'checked'}} @else {{''}} @endif> 1 Play<br>
                        @error('jenis_paket_indihome') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_layanan">Paket Layanan Indihome<span class="text-danger">*</span> : </label>
                        <select name="id_layanan" id="id_layayan" class="form-control form-control-sm select2">
                            <option value="">-- Pilih Jenis Layanan --</option>
                            @foreach ($layanan as $l)
                                <option value="{{ $l->id_layanan }}" @if($indihome->id_layanan == $l->id_layanan) {{'selected'}} @else {{''}} @endif>{{ $l->nama_layanan }}</option>
                            @endforeach
                        </select>
                        @error('id_layanan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_ont">Jenis ONT & STB<span class="text-danger">*</span> :</label>
                        <br>
                        @foreach ($jenis_ont as $o)
                            <input type="radio" name="id_ont" value="{{ $o->id_ont }}" @if($indihome->id_ont == $o->id_ont) {{'checked'}} @else {{''}} @endif> {{ $o->nama_ont }}<br>
                        @endforeach
                        @error('id_ont') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_paket_tambahan">Paket Tambahan :</label>
                        <br>
                        @foreach ($paket_tambahan as $pt)
                            @php
                                $pti = PaketTambahanIndihome::where(['id_indihome' => $indihome->id_indihome,'id_paket_tambahan' => $pt->id_paket_tambahan])->first();
                            @endphp
                            <input type="checkbox" name="id_paket_tambahan[]" value="{{ $pt->id_paket_tambahan }}" @if($pti) {{'checked'}} @else {{''}} @endif> {{ $pt->nama_paket_tambahan }} <br>
                        @endforeach
                        @error('id_paket_tambahan') <small class="text-danger">{{ $message }}</small> @enderror
                        <br>
                        <label for="paket_lain_indihome">Lain-lain : </label>
                        <input type="text" class="form-control form-control-sm" name="paket_lain_indihome" id="paket_lain_indihome" value="{{ old('paket_lain_indihome') }}">
                    </div>
                    <div id="">
                        <label for=""><strong>Nomor Layanan</strong></label>
                        <div class="form-group">
                            <label for="telepon_indihome">Nomor Telepon Rumah :</label>
                            <input type="text" class="form-control form-control-sm" name="telepon_indihome" id="telepon_indihome" value="{{ $indihome->telepon_indihome }}">
                        </div>
                        <div class="form-group">
                            <label for="no_internet_indihome">Nomor Internet / Indihome :</label>
                            <input type="text" class="form-control form-control-sm" name="no_internet_indihome" id="no_internet_indihome" value="{{ $indihome->no_internet_indihome }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usulan_instalasi_indihome">Usulan Waktu Instalasi<span class="text-danger">*</span> :</label>
                        <input type="text" class="form-control form-control-sm datepicker" name="usulan_instalasi_indihome" id="usulan_instalasi_indihome" value="{{ $indihome->usulan_instalasi_indihome }}">
                        @error('usulan_instalasi_indihome') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <hr>
                    <!-- Detail Pelanggan -->
                    <label for=""><strong>II. Detail Pelanggan</strong></label>
                    <label for="">Yang bertanda tangan di bawah ini :</label>
                    <div class="form-group">
                        <label for="nama_tanda_indihome">Nama Pengunjung<span class="text-danger">*</span> : </label>
                        <input type="text" class="form-control form-control-sm" name="nama_tanda_indihome" id="nama_tanda_indihome" value="{{ $indihome->nama_tanda_indihome }}">
                        @error('nama_tanda_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Identitas Diri Pengunjung<span class="text-danger">*</span> : </strong></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Jenis<span class="text-danger">*</span> : </label>
                                    <select name="jenis_identitas_tanda_indihome" id="jenis_identitas_tanda_indihome" class="form-control form-control-sm">
                                        <option value="">-- Pilih Jenis Identitas --</option>
                                        <option @if($indihome->jenis_identitas_tanda_indihome == 'KTP') {{'selected'}} @else {{''}} @endif>KTP</option>
                                        <option @if($indihome->jenis_identitas_tanda_indihome == 'SIM') {{'selected'}} @else {{''}} @endif>SIM</option>
                                        <option @if($indihome->jenis_identitas_tanda_indihome == 'PASSPORT') {{'selected'}} @else {{''}} @endif>PASSPORT</option>
                                    </select>
                                    @error('jenis_identitas_tanda_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">No. Identitas Pengunjung<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control form-control-sm" name="no_identitas_tanda_indihome" id="no_identitas_tanda_indihome" placeholder="Nomor Identitas" value="{{ $indihome->no_identitas_tanda_indihome }}">
                                    @error('no_identitas_tanda_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                    <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Alamat Pengunjung<span class="text-danger">*</span> :</label> 
                                    <textarea name="alamat_tanda_indihome" id="alamat_tanda_indihome" class="form-control form-control-sm" placeholder="Alamat">{{ $indihome->alamat_tanda_indihome }}</textarea>
                                    @error('alamat_tanda_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Kode Pos Pengunjung<span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control form-control-sm" name="kodepos_tanda_indihome" id="kodepos_tanda_indihome" placeholder="Kodepos" value="{{ $indihome->kodepos_tanda_indihome }}">
                                    @error('kodepos_tanda_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Dalam Hal ini bertindak untuk dan atas nama<span class="text-danger">*</span> :</label>
                        <select name="atas_nama_indihome" id="atas_nama_indihome" class="form-control form-control-sm">
                            <option value="">-- Pilih Tindakan --</option>
                            <option @if($indihome->atas_nama_indihome == 'PRIBADI') {{'selected'}} @else {{''}} @endif>PRIBADI</option>
                            <option @if($indihome->atas_nama_indihome == 'PEMEBERI KUASA') {{'selected'}} @else {{''}} @endif>PEMBERI KUASA</option>
                            <option @if($indihome->atas_nama_indihome == 'PERUSAHAAN') {{'selected'}} @else {{''}} @endif>PERUSAHAAN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_pelanggan_indihome">Nama Pelanggan<span class="text-danger">*</span> :</label>
                        <input type="text" class="form-control form-control-sm" name="nama_pelanggan_indihome" id="nama_pelanggan_indihome" value="{{ $indihome->nama_pelanggan_indihome }}">
                        @error('nama_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <!-- Pelanngan -->
                    <div class="form-group">
                        <label for=""><strong>Identitas Diri Pelanggan<span class="text-danger">*</span> :</strong></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Jenis<span class="text-danger">*</span> : </label>
                                    <select name="jenis_identitas_pelanggan_indihome" id="jenis_identitas_pelanggan_indihome" class="form-control form-control-sm">
                                        <option value="">-- Pilih Jenis Identitas --</option>
                                        <option @if($indihome->jenis_identitas_pelanggan_indihome == 'KTP') {{'selected'}} @else {{''}} @endif>KTP</option>
                                        <option @if($indihome->jenis_identitas_pelanggan_indihome == 'SIM') {{'selected'}} @else {{''}} @endif>SIM</option>
                                        <option @if($indihome->jenis_identitas_pelanggan_indihome == 'PASSPORT') {{'selected'}} @else {{''}} @endif>PASSPORT</option>
                                    </select>
                                    @error('jenis_identitas_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">No. Identitas Pelanggan<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control form-control-sm" name="no_identitas_pelanggan_indihome" id="no_identitas_pelanggan_indihome" placeholder="Nomor Identitas" value="{{ $indihome->no_identitas_pelanggan_indihome }}">
                                    @error('no_identitas_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                    <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Alamat Pelanggan<span class="text-danger">*</span> :</label> 
                                    <textarea name="alamat_pelanggan_indihome" id="alamat_pelanggan_indihome" class="form-control form-control-sm" placeholder="Alamat Pelanggan">{{ $indihome->alamat_pelanggan_indihome }}</textarea>
                                    @error('alamat_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Kode Pos Pelanggan<span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control form-control-sm" name="kodepos_pelanggan_indihome" id="kodepos_pelanggan_indihome" placeholder="Kodepos Pelanggan" value="{{ $indihome->kodepos_pelanggan_indihome }}">
                                    @error('kodepos_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                    <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal Lahir Pelanggan<span class="text-danger">*</span> :</label> 
                                    <input type="text" class="form-control form-control-sm datepicker" name="tanggal_lahir_pelanggan_indihome" id="tanggal_lahir_pelanggan_indihome" value="{{ $indihome->tanggal_lahir_pelanggan_indihome }}">
                                    @error('tanggal_lahir_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                @php
                                    if($indihome->jenis_kelamin_pelanggan_indihome == 'LAKI-LAKI'){
                                        $selected = 'selected';
                                        $selectedP= '';
                                    }else{
                                        $selected = '';
                                        $selectedP= 'selected';
                                    }
                                @endphp
                                <div class="form-group">
                                    <label for="">Jenis Kelamin Pelanggan<span class="text-danger">*</span> </label>
                                    <select name="jenis_kelamin_pelanggan_indihome" id="jenis_kelamin_pelanggan_indihome" class="form-control form-control-sm">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="LAKI-LAKI" {{ $selected }}>LAKI-LAKI</option>
                                        <option value="PEREMPUAN" {{ $selectedP }}>PEREMPUAN</option>
                                    </select>
                                    @error('jenis_kelamin_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_npwp_pelanggan_indihome">No. NPWP :</label>
                        <input type="text" class="form-control form-control-sm" name="no_npwp_pelanggan_indihome" id="no_npwp_pelanggan_indihome" value="{{ $indihome->no_npwp_pelanggan_indihome }}">
                    </div>
                    <div class="form-group">
                        <label for="nama_ibu_kandung_pelanggan">Nama Ibu Kandung Pelanggan<span class="text-danger">*</span> : </label>
                        <input type="text" class="form-control form-contol-sm" name="nama_ibu_kandung_pelanggan" id="nama_ibu_kandung_pelanggan" value="{{ $indihome->nama_ibu_kandung_pelanggan }}">
                        @error('nama_ibu_kandung_pelanggan') <small class="text-danger">{{ $message }} </small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email_pelanggan">E-mail<span class="text-danger">*</span> :</label>
                        <input type="text" class="form-control form-control-sm" name="email_pelanggan" id="email_pelanggan" value="{{ $indihome->email_pelanggan }}">
                        @error('email_pelanggan') <small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Nomor Kontak :</strong></label>
                        <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="kontak_telepon_indihome">Rumah :</label>
                                    <input type="text" class="form-control form-control-sm" name="kontak_telepon_indihome" id="kontak_telepon_indihome" value="{{ $indihome->kontak_telepon_indihome }}">
                                    @error('kontak_telepon_indihome') <small class="text-danger">{{ $message }} </small>@enderror
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kontak_hp_indihome">HP<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control form-control-sm" name="kontak_hp_indihome" id="kontak_hp_indihome" value="{{ $indihome->kontak_hp_indihome }}">
                                    @error('kontak_hp_indihome') <small class="text-danger">{{ $message }} </small>@enderror
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_pemasangan_indihome">Status Pemasangan di Alamt tsb.<span class="text-danger">*</span> :</label>
                        <select name="status_pemasangan_indihome" id="status_pemasangan_indihome" class="form-control form-control-sm">
                            <option value="">-- Pilih Status --</option>
                            <option @if($indihome->status_pemasangan_indihome == 'PEMILIK') {{"selected"}} @else {{''}} @endif>PEMILIK</option>
                            <option @if($indihome->status_pemasangan_indihome == 'PENYEWA') {{"selected"}} @else {{''}} @endif>PENYEWA</option>
                            <option @if($indihome->status_pemasangan_indihome == 'LAIN-LAIN') {{"selected"}} @else {{''}} @endif>LAIN-LAIN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="komunikasi_indihome">Komunikasi yang disukai :</label>
                        <select name="komunikasi_indihome" id="komunikasi_indihome" class="form-control form-control-sm">
                            <option @if($indihome->komunikasi_indihome == 'EMAIL') {{'selected'}} @else {{''}} @endif>EMAIL</option>
                            <option @if($indihome->komunikasi_indihome == 'MAIL') {{'selected'}} @else {{''}} @endif>MAIL</option>
                            <option @if($indihome->komunikasi_indihome == 'TELEPON') {{'selected'}} @else {{''}} @endif>TELEPON</option>
                            <option @if($indihome->komunikasi_indihome == 'HANDPHONE') {{'selected'}} @else {{''}} @endif>HANDPHONE</option>
                        </select>
                    </div>
                    <!-- End Pelanggan -->
                    <!-- End Detail Pelanggan --> 
                </div>
                <div class="col-md-6 col-sm-6 col-xl-6">
                    <!-- Jenis Pembayaran -->
                    <div class="form-group">
                        <label for=""><strong>III. Jenis Pembayaran </strong></label><br>
                        <label for="jenis_pembayaran_indihome">Jenis Pembayaran<span class="text-danger">*</span> :</label>
                        <select name="jenis_pembayaran_indihome" id="jenis_pembayaran_indihome" class="form-control form-control-sm" onchange="getPembayaran()">
                            <option value="TUNAI" @if($indihome->jenis_pembayaran_indihome == 'TUNAI') {{'selected'}} @else {{''}} @endif>TUNAI</option>
                            <option value="TRANSFER" @if($indihome->jenis_pembayaran_indihome == 'TRANSFER') {{'selected'}} @else {{''}} @endif>TRANSFER</option>
                            <option value="AUTO DEBET" @if($indihome->jenis_pembayaran_indihome == 'AUTO DEBET') {{'selected'}} @else {{''}} @endif>AUTO DEBET</option>
                            <option value="KREDIT" @if($indihome->jenis_pembayaran_indihome == 'KREDIT') {{'selected'}} @else {{''}} @endif>KREDIT</option>
                        </select>
                        <div id="non-kredit">
                            <div class="form-group">
                                <label for="bank_pembayaran">Bank</label>
                                <input type="text" class="form-control form-control-sm" name="bank_pembayaran" id="bank_pembayaran" value="{{ $indihome->bank_pembayaran }}">
                            </div>
                            <div class="form-group">
                                <label for="no_rekening_pembayaran">No. Rekening</label>
                                <input type="text" class="form-control form-control-sm" name="no_rekening_pembayaran" id="no_rekening_pembayaran" value="{{ $indihome->no_rekening_pembayaran }}">
                            </div>
                            <div class="form-group">
                                <label for="atas_nama_pembayaran">Atas Nama</label>
                                <input type="text" class="form-control form-control-sm" name="atas_nama_pembayaran" id="atas_nama_pembayaran" value="{{ $indihome->atas_nama_pembayaran }}">
                            </div>
                        </div>
                        <div id="kredit">
                            <div class="form-group">
                                <label for="jenis_kartu_kredit_pembayaran">Jenis Kartu Kredit</label>
                                <select name="jenis_kartu_kredit_pembayaran" id="jenis_kartu_kredit_pembayaran" class="form-control form-control-sm">
                                    <option value="">TIDAK KREDIT</option>
                                    <option @if($indihome->jenis_kartu_kredit_pembayaran == 'VISA') {{'selected'}} @else {{''}} @endif>VISA</option>
                                    <option @if($indihome->jenis_kartu_kredit_pembayaran == 'MASTER') {{'selected'}} @else {{''}} @endif>MASTER</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pemegang_kartu_kredit_pembayaran">Nama Pemengang KArtu</label>
                                <input type="text" class="form-control form-control-sm" name="pemegang_kartu_kredit_pembayaran" id="pemegang_kartu_kredit_pembayaran" value="{{ $indihome->pemegang_kartu_kredit_pembayaran }}">
                            </div>
                            <div class="form-group">
                                <label for="no_kartu_kredit_pembayaran">No. Kartu</label>
                                <input type="text" class="form-control form-control-sm" name="no_kartu_kredit_pembayaran" id="no_kartu_kredit_pembayaran" value="{{ $indihome->no_kartu_kredit_pembayaran }}">
                            </div>
                            <div class="form-group">
                                <label for="masa_berlaku_kartu_kredit_pembayaran">Masa Berlaku</label>
                                <input type="text" class="form-control form-control-sm datepicker" name="masa_berlaku_kartu_kredit_pembayaran" id="masa_berlaku_kartu_kredit_pembayaran" value="{{ $indihome->masa_berlaku_kartu_kredit_pembayaran }}">
                            </div>
                            <div class="form-group">
                                <label for="bank_penerbit_pembayaran">Bank Penerbit</label>
                                <input type="text" class="form-control form-control-sm" name="bank_penerbit_pembayaran" id="bank_penerbit_pembayaran" value="{{ $indihome->bank_penerbit_pembayaran }}">
                            </div>
                        </div>
                    </div>
                    <!-- End Jenis Pembayaran -->
                    <hr>
                    <div class="form-group">
                        <label for=""><strong>IV. Pernyataan Dan Jaminan</strong></label><br>
                        <p>
                            Kami yang bertanda tangan di bawah ini, dengan ini menyatakan :
                            <ol start="1">
                                <li>Adalah pemegang Kartu Kredit yang sah dan berwenang</li>
                                <li>Seluruh data yang kami berikan adalah benar dan lengkap</li>
                                <li>Setuju untuk dilakukan pendebitan rekening Kartu Kredit kami untuk keperluan pembayaran biaya pasang baru, biaya berlangganan, dan/atau biaya tambahan lain yang mungkin timbul selama berlangganan layanan IndiHome.</li>
                            </ol>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>V. Alamat Tagihan</strong></label><br>
                        <div class="form-group">
                            <label for="alamat_penagihan_indihome">Alamat<span class="text-danger">*</span> :</label>
                            <textarea name="alamat_penagihan_indihome" id="alamat_penagihan_indihome" class="form-control form-control-sm" placeholder="Alamat Tagihan">{{ $indihome->alamat_penagihan_indihome }}</textarea>
                            @error('alamat_penagihan_indihome') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="kodepos_penagihan_indihome">Kodepos<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="kodepos_penagihan_indihome" id="kodepos_penagihan_indihome" value="{{ $indihome->kodepos_penagihan_indihome }}">
                            @error('kodepos_penagihan_indihome') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        @php
                            $p = explode(';',$indihome->persetujuan_indihome);
                        @endphp
                        <table style="width: 100%" cellpadding="10">
                            <tr>
                                <td>
                                    1. Bersedia menerima informasi dari TELKOM Group atau Authorized Partner melalui berbagai media termasuk telepon, sms, email dan internet ads
                                </td>
                                <td><input type="checkbox" name="pl1" id="pl1" value="YA" @if($p[0] == 'YA') {{'checked'}} @else {{ '' }} @endif required></td>
                            </tr>
                            <tr>
                                <td>
                                    2. Bersedia mencantumkan nomor IndiHome di Buku Pentunjuk Telepon Telkom dan Layanan "Directory Service" Telkom 108
                                </td>
                                <td><input type="checkbox" name="pl2" id="pl2" value="YA" @if($p[1] == 'YA') {{'checked'}} @else {{''}} @endif required></td>
                            </tr>
                            <tr>
                                <td>
                                     3. Menyetujui bahwa dengan diberlakukannya dokumen kontrak berlangganan IndiHome ini,�maka kontrak berlangganan lama untuk produk Telepon dan atau�Internet dan atau Usee TV�dianggap tidak berlaku lagi (Khusus bagi Pelanggan Upgrade Layanan)
                                </td>
                                <td><input type="checkbox" name="pl3" id="pl3" value="YA" @if($p[2] == 'YA') {{'checked'}} @else {{''}} @endif required></td>
                            </tr>
                            <tr>
                                <td>
                                    4. Bila Data Pelanggan pada kontrak berlangganan produk Telepon dan atau�Internet dan atau Usee TV�berbeda dengan Kontrak Berlangganan layanan IndiHome ini maka pelanggan yang menanda tangani kontrak berlangganan IndiHome bersedia bertanggung jawab atas segala resiko atas perubahan data Pelanggan tersebut (Khusus bagi Pelanggan Upgrade Layanan)
                                </td>
                                <td><input type="checkbox" name="pl4" id="pl4" value="YA" @if($p[3] == 'YA') {{'checked'}} @else {{''}} @endif required></td>
                            </tr>
                            <tr>
                                <td>
                                    5. Pelanggan akan dikenakan biaya sewa bulanan ONT, STB dan Platform IPTV sesuai dengan jenis STB yang digunakan. Setiap penambahan STB ke 2 (dua) dan seterusnya, juga akan dikenakan biaya sewa bulanan sesuai jenis STB serta biaya instalasi/setting (sesuai kondisi instalasi yang berlaku) yang ditagihkan pada bulan berikutnya setelah pemasangan STB tersebut
                                </td>
                                <td><input type="checkbox" name="pl5" id="pl5" value="YA" @if($p[4] == 'YA') {{'checked'}} @else {{''}} @endif required></td>
                            </tr>
                            <tr>
                                <td>
                                    6. Bila pelanggan berhenti berlangganan, Telkom akan mengambil perangkat CPE milik TELKOM yang terinstal di alamat Pelanggan untuk layanan IndiHome
                                </td>
                                <td><input type="checkbox" name="pl6" id="pl6" value="YA" @if($p[5] == 'YA') {{'checked'}} @else {{''}} @endif required></td>
                            </tr>
                            <tr>
                                <td>
                                    7. Besaran tagihan IndiHome, paket tambahan dan sewa ONT - STB dapat berubah sewaktu-waktu
                                </td>
                                <td><input type="checkbox" name="pl7" id="pl7" value="YA" @if($p[6] == 'YA') {{'checked'}} @else {{''}} @endif required></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xl-6">
                    <h4>LAMPIRAN</h4>
                    {{-- <p class="text-danger">*lampiran untuk contoh ttd pelanggan</p> --}}
                    @foreach ($lampiran as $l)
                        <img src="{{ asset('lampiranfile/'.$l->lampiran) }}" alt="{{ $l->keterangan_lampiran}}" style="width: 500px"/><br>
                    @endforeach
                    <br>
                    @if (count($lampiran) <= 0)
                        <a href="{{ url('lampiran/create/7/'.$indihome->id_indihome) }}" class="btn btn-success btn-block" target="_blank"><i class="fa fa-file"></i> Tambah Lampiran</a>
                    @endif
                    
                </div>
                <div class="col-md-6 col-sm-12 col=xl-6">
                    <div class="form-group">
                        <label for="lampiran_indihome" class="text-danger"><i>Lampiran Tambahkan melalui menu Lampiran (Arsip->Lampiran)</i></label>
                        <label for="lampiran_indihome" class="text-danger"><i>Jika belum terdapat tanda tangan pelanggan, mohon untuk dilengkapi dengan klik button Tanda Tangan Pelanggan</i></label>
                    </div>
                    <div class="form-group">
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-block" id="signature"><i class="fas fa-sign"></i> Tanda Tangan Pelanggan</a>
                        <input type="hidden" name="id_signature" id="id_signature" value="{{ $indihome->signature_pelanggan_indihome }}">
                        @if ($indihome->signature_pelanggan_indihome)
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
                <div class="col-md-6 col-sm-6 col-xl-6">
                </div>
                <div class="col-md-6 col-sm-6 col-xl-6">
                    <button type="submit" id="submit" class="btn btn-warning btn-block @if(!$indihome->signature_pelanggan_indihome) {{'disabled'}} @else {{''}} @endif"><i class="fas fa-edit"></i> Update</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        getPembayaran();
        var p = "{{ $indihome->jenis_pembayaran_indihome}}";
        if(p == "TUNAI"){
            $('#non-kredit').hide();
            $('#kredit').hide();
        }else if(p == "TRANSFER" || p == "AUTO DEBET"){
            $('#non-kredit').show();
            $('#kredit').hide();
        }else{
            $('#non-kredit').hide();
            $('#kredit').show();
        }

        console.log(p);
    });

    // function getPermohonan(){
    //     var permohonan = $('#jenis_permohonan_indihome').val();
    //     if(permohonan == 'UPGRADE LAYANAN'){
    //         $('#no_layanan').show();
    //     }else{
    //         $('#no_layanan').hide();
    //     }
    // }

    function getPembayaran(){
        var pembayaran = $('#jenis_pembayaran_indihome').val();
        if(pembayaran == 'TUNAI'){
            $('#non-kredit').hide();
            $('#kredit').hide();
        }else if(pembayaran == 'TRANSFER' || pembayaran == 'AUTO DEBET'){
            $('#non-kredit').show();
            $('#kredit').hide();
        }else{
            $('#non-kredit').hide();
            $('#kredit').show();
        }
    }
</script>