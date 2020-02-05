<style>
    
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
            @if (count($errors) > 0)
                @foreach ($errors as $err)
                    {{ $err }}
                @endforeach
            @endif
            <form action="{{ url('indihome/insert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xl-6">
                    <label for="I"><b>I. Detail Layanan</b></label>
                    <div class="form-group">
                        <label for="jenis_permohonan_indihome">Jenis Permohonan<span class="text-danger">*</span> :</label>
                        <select name="jenis_permohonan_indihome" id="jenis_permohonan_indihome" class="form-control form-control-sm" onchange="getPermohonan()">
                            <option value="">-- Pilih Jenis Permohonan --</option>
                            <option value="KONTRAK BARU">KONTRAK BARU</option>
                            <option value="UPGRADE LAYANAN/DOWNGRADE LAYANAN">UPGRADE LAYANAN/DOWNGRADE LAYANAN</option>
                        </select>
                        @error('jenis_permohonan_indihome') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="jenis_paket_indihome">Paket<span class="text-danger">*</span> :</label>
                        <br>
                        <input type="radio" name="jenis_paket_indihome" id="jenis_paket_indihome" value="3 PLAY"> 3 Play<br>
                        <input type="radio" name="jenis_paket_indihome" id="jenis_paket_indihome" value="2 PLAY"> 2 Play<br>
                        <input type="radio" name="jenis_paket_indihome" id="jenis_paket_indihome" value="1 PLAY"> 1 Play<br>
                        @error('jenis_paket_indihome') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_layanan">Paket Layanan Indihome<span class="text-danger">*</span> : </label>
                        <select name="id_layanan" id="id_layayan" class="form-control form-control-sm select2">
                            <option value="">-- Pilih Jenis Layanan --</option>
                            @foreach ($layanan as $l)
                                <option value="{{ $l->id_layanan }}">{{ $l->nama_layanan }}</option>
                            @endforeach
                        </select>
                        @error('id_layanan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_ont">Jenis ONT & STB<span class="text-danger">*</span> :</label>
                        <br>
                        @foreach ($jenis_ont as $o)
                            <input type="radio" name="id_ont" value="{{ $o->id_ont }}"> {{ $o->nama_ont }}<br>
                        @endforeach
                        @error('id_ont') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_paket_tambahan">Paket Tambahan :</label>
                        <br>
                        @foreach ($paket_tambahan as $pt)
                            <input type="checkbox" name="id_paket_tambahan[]" value="{{ $pt->id_paket_tambahan }}"> {{ $pt->nama_paket_tambahan }} <br>
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
                            <input type="text" class="form-control form-control-sm" name="telepon_indihome" id="telepon_indihome" value="{{ old('telepon_indihome') }}">
                        </div>
                        <div class="form-group">
                            <label for="no_internet_indihome">Nomor Internet / Indihome :</label>
                            <input type="text" class="form-control form-control-sm" name="no_internet_indihome" id="no_internet_indihome" value="{{ old('no_internet_indihome') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usulan_instalasi_indihome">Usulan Waktu Instalasi<span class="text-danger">*</span> :</label>
                        <input type="text" class="form-control form-control-sm datepicker" name="usulan_instalasi_indihome" id="usulan_instalasi_indihome" value="{{ old('usulan_instalasi_indihome') }}">
                        @error('usulan_instalasi_indihome') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <hr>
                    <!-- Detail Pelanggan -->
                    <label for=""><strong>II. Detail Pelanggan</strong></label>
                    <label for="">Yang bertanda tangan di bawah ini :</label>
                    <div class="form-group">
                        <label for="nama_tanda_indihome">Nama Pengunjung<span class="text-danger">*</span> : </label>
                        <input type="text" class="form-control form-control-sm" name="nama_tanda_indihome" id="nama_tanda_indihome" value="{{ old('nama_tanda_indihome') }}">
                        @error('nama_tanda_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Identitas Diri<span class="text-danger">*</span> : </strong></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Jenis Identitas Pengunjung<span class="text-danger">*</span> : </label>
                                    <select name="jenis_identitas_tanda_indihome" id="jenis_identitas_tanda_indihome" class="form-control form-control-sm">
                                        <option value="">-- Pilih Jenis Identitas --</option>
                                        <option>KTP</option>
                                        <option>SIM</option>
                                        <option>PASSPORT</option>
                                    </select>
                                    @error('jenis_identitas_tanda_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">No. Identitas Pengunjung<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control form-control-sm" name="no_identitas_tanda_indihome" id="no_identitas_tanda_indihome" placeholder="Nomor Identitas" value="{{ old('no_identitas_tanda_indihome') }}">
                                    @error('no_identitas_tanda_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                    <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Alamat Pengunjung<span class="text-danger">*</span> :</label> 
                                    <textarea name="alamat_tanda_indihome" id="alamat_tanda_indihome" class="form-control form-control-sm" placeholder="Alamat">{{ old('alamat_tanda_indihome') }}</textarea>
                                    @error('alamat_tanda_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Kode Pos Pengunjung<span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control form-control-sm" name="kodepos_tanda_indihome" id="kodepos_tanda_indihome" placeholder="Kodepos" value="{{ old('kodepos_tanda_indihome') }}">
                                    @error('kodepos_tanda_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Dalam Hal ini bertindak untuk dan atas nama<span class="text-danger">*</span> :</label>
                        <select name="atas_nama_indihome" id="atas_nama_indihome" class="form-control form-control-sm">
                            <option value="">-- Pilih Tindakan --</option>
                            <option>PRIBADI</option>
                            <option>PEMBERI KUASA</option>
                            <option>PERUSAHAAN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_pelanggan_indihome">Nama Pelanggan<span class="text-danger">*</span> :</label>
                        <input type="text" class="form-control form-control-sm" name="nama_pelanggan_indihome" id="nama_pelanggan_indihome" value="{{ old('nama_pelanggan_indihome') }}">
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
                                        <option>KTP</option>
                                        <option>SIM</option>
                                        <option>PASSPORT</option>
                                    </select>
                                    @error('jenis_identitas_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">No. Identitas Pelanggan<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control form-control-sm" name="no_identitas_pelanggan_indihome" id="no_identitas_pelanggan_indihome" placeholder="Nomor Identitas" value="{{ old('no_identitas_pelanggan_indihome') }}">
                                    @error('no_identitas_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                    <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Alamat Pelanggan<span class="text-danger">*</span> :</label> 
                                    <textarea name="alamat_pelanggan_indihome" id="alamat_pelanggan_indihome" class="form-control form-control-sm" placeholder="Alamat Pelanggan">{{ old('alamat_pelanggan_indihome') }}</textarea>
                                    @error('alamat_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Kode Pos Pelanggan<span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control form-control-sm" name="kodepos_pelanggan_indihome" id="kodepos_pelanggan_indihome" placeholder="Kodepos Pelanggan" value="{{ old('kodepos_pelanggan_indihome') }}">
                                    @error('kodepos_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                    <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal Lahir Pelanggan<span class="text-danger">*</span> :</label> 
                                    <input type="text" class="form-control form-control-sm datepicker" name="tanggal_lahir_pelanggan_indihome" id="tanggal_lahir_pelanggan_indihome" value="{{ old('tanggal_lahir_pelanggan_indihome') }}">
                                    @error('tanggal_lahir_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Jenis Kelamin Pelanggan<span class="text-danger">*</span> </label>
                                    <select name="jenis_kelamin_pelanggan_indihome" id="jenis_kelamin_pelanggan_indihome" class="form-control form-control-sm">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option>LAKI-LAKI</option>
                                        <option>PEREMPUAN</option>
                                    </select>
                                    @error('jenis_kelamin_pelanggan_indihome') <small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_npwp_pelanggan_indihome">No. NPWP :</label>
                        <input type="text" class="form-control form-control-sm" name="no_npwp_pelanggan_indihome" id="no_npwp_pelanggan_indihome" value="{{ old('no_npwp_pelanggan_indihome') }}">
                    </div>
                    <div class="form-group">
                        <label for="nama_ibu_kandung_pelanggan">Nama Ibu Kandung Pelanggan<span class="text-danger">*</span> : </label>
                        <input type="text" class="form-control form-contol-sm" name="nama_ibu_kandung_pelanggan" id="nama_ibu_kandung_pelanggan" value="{{ old('nama_ibu_kandung_pelanggan') }}">
                        @error('nama_ibu_kandung_pelanggan') <small class="text-danger">{{ $message }} </small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email_pelanggan">E-mail<span class="text-danger">*</span> :</label>
                        <input type="text" class="form-control form-control-sm" name="email_pelanggan" id="email_pelanggan" value="{{ old('email_pelanggan') }}">
                        @error('email_pelanggan') <small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Nomor Kontak :</strong></label>
                        <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="kontak_telepon_indihome">Rumah :</label>
                                    <input type="text" class="form-control form-control-sm" name="kontak_telepon_indihome" id="kontak_telepon_indihome" value="{{ old('kontak_telepon_indihome') }}">
                                    @error('kontak_telepon_indihome') <small class="text-danger">{{ $message }} </small>@enderror
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kontak_hp_indihome">HP<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control form-control-sm" name="kontak_hp_indihome" id="kontak_hp_indihome" value="{{ old('kontak_hp_indihome') }}">
                                    @error('kontak_hp_indihome') <small class="text-danger">{{ $message }} </small>@enderror
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_pemasangan_indihome">Status Pemasangan di Alamt tsb.<span class="text-danger">*</span> :</label>
                        <select name="status_pemasangan_indihome" id="status_pemasangan_indihome" class="form-control form-control-sm">
                            <option value="">-- Pilih Status --</option>
                            <option>PEMILIK</option>
                            <option>PENYEWA</option>
                            <option>LAIN-LAIN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="komunikasi_indihome">Komunikasi yang disukai :</label>
                        <select name="komunikasi_indihome" id="komunikasi_indihome" class="form-control form-control-sm">
                            <option>EMAIL</option>
                            <option>MAIL</option>
                            <option>TELEPON</option>
                            <option>HANDPHONE</option>
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
                            <option value="TUNAI">TUNAI</option>
                            <option value="TRANSFER">TRANSFER</option>
                            <option value="AUTO DEBET">AUTO DEBET</option>
                            <option value="KREDIT">KREDIT</option>
                        </select>
                        <div id="non-kredit">
                            <div class="form-group">
                                <label for="bank_pembayaran">Bank</label>
                                <input type="text" class="form-control form-control-sm" name="bank_pembayaran" id="bank_pembayaran" value="{{ old('bank_pembayaran') }}">
                            </div>
                            <div class="form-group">
                                <label for="no_rekening_pembayaran">No. Rekening</label>
                                <input type="text" class="form-control form-control-sm" name="no_rekening_pembayaran" id="no_rekening_pembayaran" value="{{ old('no_rekening_pembayaran') }}">
                            </div>
                            <div class="form-group">
                                <label for="atas_nama_pembayaran">Atas Nama</label>
                                <input type="text" class="form-control form-control-sm" name="atas_nama_pembayaran" id="atas_nama_pembayaran" value="{{ old('atas_nama_pembayaran') }}">
                            </div>
                        </div>
                        <div id="kredit">
                            <div class="form-group">
                                <label for="jenis_kartu_kredit_pembayaran">Jenis Kartu Kredit</label>
                                <select name="jenis_kartu_kredit_pembayaran" id="jenis_kartu_kredit_pembayaran" class="form-control form-control-sm">
                                    <option value="">TIDAK KREDIT</option>
                                    <option>VISA</option>
                                    <option>MASTER</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pemegang_kartu_kredit_pembayaran">Nama Pemengang KArtu</label>
                                <input type="text" class="form-control form-control-sm" name="pemegang_kartu_kredit_pembayaran" id="pemegang_kartu_kredit_pembayaran" value="{{ old('pemegang_kartu_kredit_pembayaran') }}">
                            </div>
                            <div class="form-group">
                                <label for="no_kartu_kredit_pembayaran">No. Kartu</label>
                                <input type="text" class="form-control form-control-sm" name="no_kartu_kredit_pembayaran" id="no_kartu_kredit_pembayaran" value="{{ old('no_kartu_kredit_pembayaran') }}">
                            </div>
                            <div class="form-group">
                                <label for="masa_berlaku_kartu_kredit_pembayaran">Masa Berlaku</label>
                                <input type="text" class="form-control form-control-sm datepicker" name="masa_berlaku_kartu_kredit_pembayaran" id="masa_berlaku_kartu_kredit_pembayaran" value="{{ old('masa_berlaku_kartu_kredit_pembayaran') }}">
                            </div>
                            <div class="form-group">
                                <label for="bank_penerbit_pembayaran">Bank Penerbit</label>
                                <input type="text" class="form-control form-control-sm" name="bank_penerbit_pembayaran" id="bank_penerbit_pembayaran" value="{{ old('bank_penerbit_pembayaran') }}">
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
                            <textarea name="alamat_penagihan_indihome" id="alamat_penagihan_indihome" class="form-control form-control-sm" placeholder="Alamat Tagihan">{{ old('alamat_penagihan_indihome') }}</textarea>
                            @error('alamat_penagihan_indihome') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="kodepos_penagihan_indihome">Kodepos<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control form-control-sm" name="kodepos_penagihan_indihome" id="kodepos_penagihan_indihome" value="{{ old('kodepos_penagihan_indihome') }}">
                            @error('kodepos_penagihan_indihome') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <table style="width: 100%" cellpadding="10">
                            <tr>
                                <td>
                                    1. Bersedia menerima informasi dari TELKOM Group atau Authorized Partner melalui berbagai media termasuk telepon, sms, email dan internet ads
                                </td>
                                <td><input type="checkbox" name="pl1" id="pl1" value="YA" required></td>
                            </tr>
                            <tr>
                                <td>
                                    2. Bersedia mencantumkan nomor IndiHome di Buku Pentunjuk Telepon Telkom dan Layanan "Directory Service" Telkom 108
                                </td>
                                <td><input type="checkbox" name="pl2" id="pl2" value="YA" required></td>
                            </tr>
                            <tr>
                                <td>
                                     3. Menyetujui bahwa dengan diberlakukannya dokumen kontrak berlangganan IndiHome ini,�maka kontrak berlangganan lama untuk produk Telepon dan atau�Internet dan atau Usee TV�dianggap tidak berlaku lagi (Khusus bagi Pelanggan Upgrade Layanan)
                                </td>
                                <td><input type="checkbox" name="pl3" id="pl3" value="YA" required></td>
                            </tr>
                            <tr>
                                <td>
                                    4. Bila Data Pelanggan pada kontrak berlangganan produk Telepon dan atau�Internet dan atau Usee TV�berbeda dengan Kontrak Berlangganan layanan IndiHome ini maka pelanggan yang menanda tangani kontrak berlangganan IndiHome bersedia bertanggung jawab atas segala resiko atas perubahan data Pelanggan tersebut (Khusus bagi Pelanggan Upgrade Layanan)
                                </td>
                                <td><input type="checkbox" name="pl4" id="pl4" value="YA" required></td>
                            </tr>
                            <tr>
                                <td>
                                    5. Pelanggan akan dikenakan biaya sewa bulanan ONT, STB dan Platform IPTV sesuai dengan jenis STB yang digunakan. Setiap penambahan STB ke 2 (dua) dan seterusnya, juga akan dikenakan biaya sewa bulanan sesuai jenis STB serta biaya instalasi/setting (sesuai kondisi instalasi yang berlaku) yang ditagihkan pada bulan berikutnya setelah pemasangan STB tersebut
                                </td>
                                <td><input type="checkbox" name="pl5" id="pl5" value="YA" required></td>
                            </tr>
                            <tr>
                                <td>
                                    6. Bila pelanggan berhenti berlangganan, Telkom akan mengambil perangkat CPE milik TELKOM yang terinstal di alamat Pelanggan untuk layanan IndiHome
                                </td>
                                <td><input type="checkbox" name="pl6" id="pl6" value="YA" required></td>
                            </tr>
                            <tr>
                                <td>
                                    7. Besaran tagihan IndiHome, paket tambahan dan sewa ONT - STB dapat berubah sewaktu-waktu
                                </td>
                                <td><input type="checkbox" name="pl7" id="pl7" value="YA" required></td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group">
                        <small class="text-danger">* Lampiran hanya diperbolehkan berukuran kurang dari 1 MB!</small><br>
                        <label for="lampiran_indihome">Lampiran<span class="text-danger">*</span> :</label>
                        <input type="file" class="form-control" name="lampiran_indihome[]" id="lampiran_indihome" multiple required>
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
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xl-6">
                    
                </div>
                <div class="col-md-6 col-sm-6 col-xl-6">
                    <button type="submit" id="submit" class="btn btn-success btn-block disabled"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        getPembayaran();
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