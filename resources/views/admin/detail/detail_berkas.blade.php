@php
    function hari_ini($hari){
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return $hari_ini;
}

function bulan_ini($bulan){
 
 switch($bulan){
     case '01':
         $bulan_ini = "Januari";
     break;

     case '02':			
         $bulan_ini = "Februari";
     break;

     case '03':
         $bulan_ini = "Maret";
     break;

     case '04':
         $bulan_ini = "April";
     break;

     case '05':
         $bulan_ini = "Mei";
     break;

     case '06':
         $bulan_ini = "Juni";
     break;

     case '07':
         $bulan_ini = "Juli";
     break;

     case '08':
         $bulan_ini = "Agustus";
     break;

     case '09':
         $bulan_ini = "September";
     break;

     case '10':
         $bulan_ini = "Oktober";
     break;

     case '11':
         $bulan_ini = "November";
     break;

     case '12':
         $bulan_ini = "Desember";
     break;
     
     default:
         $bulan_ini = "Tidak di ketahui";		
     break;
 }

 return $bulan_ini;
}

use App\FiturIndihome;
use App\Layanan;
use App\NomorJastel;
use App\Login;
@endphp
<table width="849" border="0" cellspacing="0" cellpadding=0>
    <tr>
        <td width="162"><img src="{{ asset('images/logo.png') }}" alt=""></td>
        <td width="461">&nbsp;</td>
        <td>
            {{-- <div align="right"><img src="{{ asset('images/logo_flexi.jpg') }}" height="70"/></div> --}}
        </td>
    </tr>
</table>
<div>
    @if ($transaksi->id_jenis_transaksi == 1)
        <p><strong>PERMOHONAN DAN PERSETUJUAN BALIK NAMA {{ $transaksi->produk_transaksi }}</strong></p>
        <p>Pelanggan dengan data-data tersebut dibawah ini bertindak untuk dan atas nama Diri Sendiri / Kuasa,<br>
        Kepada PT. Telekomunikasi Indonesia, Tbk. dengan dan spesifikasi berikut :</p>

        <table width="427" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="163">Nama Pelanggan </td>
                <td width="10">:</td>
                <td width="254">{{ $transaksi->nama_transaksi }}</td>
            </tr>
            <tr>
                <td>Alamat Pelanggan : </td>
                <td>:</td>
                <td>{{ $transaksi->alamat_identitas_transaksi }}</td>
            </tr>
            <tr>
                <td>Alamat Instalasi&nbsp;</td>
                <td>:</td>
                <td>{{ $transaksi->alamat_instalasi_transaksi }}</td>
            </tr>
            <tr>
                <td>Jenis Identitas - Nomor Identitas :</td>
                <td>:</td>
                <td>{{ $transaksi->jenis_identitas_transaksi .'-'. $transaksi->no_identitas_transaksi }}</td>
            </tr>
        </table>

        <p><b><u>Spesifikasi Fasilitas Jasa Telekomunikasi</u></b></p>

        <table width="639" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td width="33"><div align="center">No.</div></td>
              <td width="139"><div align="center">Nomor Telepon </div></td>
              <td width="94"><div align="center">Jenis Instalasi </div></td>
              <td width="96"><div align="center">Segmen</div></td>
              <td width="110"><div align="center">Jenis Layanan </div></td>
              <td width="84"><div align="center">Biaya</div></td>
              <td width="67"><div align="center">ket.</div></td>
            </tr>
            <tr>
              <td>1</td>
              <td>{{ $nojastel[0]->nomor_jastel }}</td>
              <td>{{ $transaksi->nama_jenis_transaksi }}</td>
              <td>{{ $transaksi->segment_transaksi }}</td>
              <td>{{ $transaksi->jenis_layanan_transaksi }}</td>
              <td>{{ number_format($transaksi->biaya_transaksi) }}</td>
              <td>{{ $transaksi->keterangan_transaksi }}</td>
            </tr>
          </table>
        @endif

        @if ($transaksi->id_jenis_transaksi == 2)
        <p><strong>PERMOHONAN DAN PERSETUJUAN BALIK NAMA {{ $transaksi->produk_transaksi }}</strong></p>
        <p>Pelanggan dengan data-data tersebut dibawah ini bertindak untuk dan atas nama Diri Sendiri / Kuasa,<br>
        Kepada PT. Telekomunikasi Indonesia, Tbk. dengan dan spesifikasi berikut :</p>

        <table width="427" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="163">Nama Pelanggan </td>
                <td width="10">:</td>
                <td width="254">{{ $transaksi->nama_transaksi }}</td>
            </tr>
            <tr>
                <td>Alamat Pelanggan : </td>
                <td>:</td>
                <td>{{ $transaksi->alamat_identitas_transaksi }}</td>
            </tr>
            <tr>
                <td>Alamat Instalasi&nbsp;</td>
                <td>:</td>
                <td>{{ $transaksi->alamat_instalasi_transaksi }}</td>
            </tr>
            <tr>
                <td>Nomor Lama</td>
                <td>:</td>
                <td>{{ $transaksi->no_lama_transaksi }}</td>
            </tr>
            <tr>
                <td>Jenis Identitas - Nomor Identitas :</td>
                <td>:</td>
                <td>{{ $transaksi->jenis_identitas_transaksi .'-'. $transaksi->no_identitas_transaksi }}</td>
            </tr>
        </table>

        <p><b><u>Spesifikasi Fasilitas Jasa Telekomunikasi</u></b></p>

        <table width="639" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td width="33"><div align="center">No.</div></td>
              <td width="139"><div align="center">Nomor Telepon </div></td>
              <td width="94"><div align="center">Jenis Instalasi </div></td>
              <td width="96"><div align="center">Segmen</div></td>
              <td width="110"><div align="center">Jenis Layanan </div></td>
              <td width="84"><div align="center">Biaya</div></td>
              <td width="67"><div align="center">ket.</div></td>
            </tr>
            <tr>
              <td>1</td>
              <td>{{ $nojastel[0]->nomor_jastel }}</td>
              <td>{{ $transaksi->nama_jenis_transaksi }}</td>
              <td>{{ $transaksi->segment_transaksi }}</td>
              <td>{{ $transaksi->jenis_layanan_transaksi }}</td>
              <td>{{ number_format($transaksi->biaya_transaksi) }}</td>
              <td>{{ $transaksi->keterangan_transaksi }}</td>
            </tr>
          </table>
        @endif

        @if ($transaksi->id_jenis_transaksi == 3)
        @php
            $nomorJastel = NomorJastel::where('id_transaksi',$transaksi->id_transaksi)->get();
        @endphp
        <p><strong><U>SURAT PERNYATAAN</U></strong><BR />
            Berhenti Berlangganan {{ $transaksi->produk_transaksi }}</p>
                  <p>Yang bertanda tangan di bawah ini: </p>
                  <table width="527" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="167">Nama </td>
                      <td width="13">:</td>
                      <td width="347">{{ $transaksi->nama_penerima_kuasa_transaksi }}</td>
                    </tr>
                    <tr>
                      <td>Alamat </td>
                      <td>:</td>
                      <td>{{ $transaksi->alamat_penerima_kuasa_transaksi }}</td>
                    </tr>
                    <tr>
                      <td>Jenis Identitas-No</td>
                      <td>:</td>
                      <td>{{ $transaksi->jenis_identitas_penerima_kuasa_transaksi .'/'.$transaksi->no_identitas_penerima_kuasa_transaksi }}</td>
                    </tr>
            </table>
                  <p>Dalam hal ini bertindak untuk atas nama diri sendiri, pemberi kuasa Perseorangan / Perusahaan / Badan Usaha atau Lembaga: </p>
                  <table width="536" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="161">Nama Pelanggan</td>
                      <td width="12">:</td>
                      <td width="363">{{ $transaksi->nama_transaksi }}</td>
                    </tr>
                    <tr>
                      <td>Alamat Pelanggan</td>
                      <td>:</td>
                      <td>{{ $transaksi->alamat_identitas_transaksi }}</td>
                    </tr>
                    <tr>
                      <td>Jenis Identitas-No.</td>
                      <td>:</td>
                      <td>{{ $transaksi->jenis_identitas_transaksi.'/'.$transaksi->no_identitas_transaksi }}</td>
                    </tr>
            </table>
                  <p>Menyatakan berhenti berlangganan {{ $transaksi->produk_transaksi }} Nomor: <b>
                      @foreach ($nomorJastel as $nj)
                          {{ $nj->nomor_jastel.',' }}
                      @endforeach
                    </b>, karena:</p>
            
                      <p>
                        <input type="checkbox" name="checkbox" value="checkbox" @if ($transaksi->alasan_penerima_kuasa_transaksi == 'PINDAH ALAMAT') {{'checked'}} @else {{''}}@endif> 
                        Pindah Alamat <br />
                        <input type="checkbox" name="checkbox" value="checkbox" @if ($transaksi->alasan_penerima_kuasa_transaksi == 'PINDAH KE OPERATOR LAIN') {{'checked'}} @else {{''}}@endif > 
                        Pindah Operator Lain <br />
                        <input type="checkbox" name="checkbox" value="checkbox" @if ($transaksi->alasan_penerima_kuasa_transaksi == 'PINDAH KE PRA BAYAR') {{'checked'}} @else {{''}}@endif > 
                        Pindah Ke Prabayar <br />
                        <input type="checkbox" name="checkbox" value="checkbox" @if ($transaksi->alasan_penerima_kuasa_transaksi == 'SERING TERJADI GANGGUAN') {{'checked'}} @else {{''}}@endif > 
                        Sering terjadi Gangguan<br />
                        <input type="checkbox" name="checkbox" value="checkbox" @if ($transaksi->alasan_penerima_kuasa_transaksi == 'TAGIHAN TINGGI') {{'checked'}} @else {{''}}@endif > 
                        Tagihan Tinggi / Membengkak <br />
                        <input type="checkbox" name="checkbox" value="checkbox" @if ($transaksi->alasan_penerima_kuasa_transaksi == 'SUDAH ADA INDIHOME') {{'checked'}} @else {{''}}@endif  > 
                        Sudah Ada Indihome</p>
                      <p>Terhitung Mulai Hari:  {{ hari_ini(date('D',strtotime($transaksi->create_transaksi))) }}, {{ date('d',strtotime($transaksi->create_transaksi)) }} bulan {{ bulan_ini(date('m',strtotime($transaksi->create_transaksi))) }} tahun {{ date('Y',strtotime($transaksi->create_transaksi)) }}.<br />
                        Untuk Keperluan Berhenti Berlangganan maka saya akan membayar uang deposit sebesar Rp. {{ number_format((int) $transaksi->deposit_penerima_kuasa_transaksi) }}</p>
                      <p>Contact Person: {{ $transaksi->cp_transaksi }}</p>
                      <p>Demikian Surat pernyataan ini di buat untuk dipergunakan seperlunya. </p>
                    <table width="650" border="0" cellspacing="0" cellpadding="0">
                      <tr valign="top">
                        <td width="250" align="center">{{ $transaksi->kota }}, {{ date('d',strtotime($transaksi->create_transaksi)) }} {{ bulan_ini(date('m',strtotime($transaksi->create_transaksi))) }} {{ date('Y',strtotime($transaksi->create_transaksi)) }}</td>
                        <td width="200">&nbsp;</td>
                        <td width="200" align="center"></td>
                      </tr>
                      <tr valign="top">
                        <td width="250" align="center">Pelanggan<br />
                          <img src="{{ asset('signature/'.$transaksi->signature_pelanggan_transaksi) }}" width="130" /> <br />
                          {{ strtoupper($transaksi->nama_transaksi) }}
                        </td>
                        <td width="200">&nbsp;</td>
                        <td width="200" align="center">Petugas Telkom<br />
                          <img src="{{ asset('signature/'.$transaksi->signature_login) }}" width="130" /> <br />
                          {{ strtoupper($transaksi->nama) }}
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="253">&nbsp;</td>
                        <td width="205" align="center">Mengetahui,<br />
                          @php
                            if($transaksi->witel == 'SINGARAJA'){
                              $atasan = Login::join('eberkas_role','eberkas_role.id_role','=','eberkas_login.id_role')
                                            ->where('loker','PLASA GIANYAR')->where('eberkas_login.id_role',3)->first();
                              if($atasan){
                                $atasan = $atasan;
                              }else{
                                $atasan = Login::join('eberkas_role','eberkas_role.id_role','=','eberkas_login.id_role')
                                            ->where('loker','PLASA GIANYAR')->where('eberkas_login.id_role',4)->first();
                              }
                            }else{
                              $atasan = Login::join('eberkas_role','eberkas_role.id_role','=','eberkas_login.id_role')
                                            ->where('loker',$transaksi->loker)->where('eberkas_login.id_role',3)->first();
                              if($atasan){
                                $atasan = $atasan;
                              }else{
                                $atasan = Login::join('eberkas_role','eberkas_role.id_role','=','eberkas_login.id_role')
                                            ->where('loker',$transaksi->loker)->where('eberkas_login.id_role',4)->first();
                              }
                            }
                          @endphp
                          {{$atasan->nama_role}}
                          <br>
                          <img src="{{ asset('signature/'.$atasan->signature_login) }}"width="100" /><br /> 
                          {{ strtoupper($atasan->nama) }}
                          </td>
                        <td width="161"><br /></td>
                      </tr>
                  </table>
            </div>
        @endif

        @if($transaksi->id_jenis_transaksi == 4)
          <p><strong>PERMOHONAN DAN PERSETUJUAN PINDAH ALAMAT</strong></p>
          <p>Pelanggan dengan data-data tersebut di bawah ini bertindak untuk dan atas nama Diri Sendiri / Kuasa,<br />Dengan ini mengajukan permohonan berlangganan sambungan telekomunikasi "TELKOM Phone" <br />Kepada PT. Telekomunikasi Indonesia,Tbk. dengan dan spesifikasi berikut:  </p>
          <p><b><u>Data Pelanggan/Kuasa:</u></b> </p>
          <table width="529" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176">Nama Pelanggan</td>
                <td width="14">:</td>
                <td width="339">{{ $transaksi->nama_transaksi }}</td>
              </tr>
              <tr>
                <td>Alamat Pelanggan</td>
                <td>:</td>
                <td>{{ $transaksi->alamat_identitas_transaksi  }}</td>
              </tr>
              <tr>
                <td>Alamat Instalasi&nbsp;Lama</td>
                <td>:</td>
                <td>{{ $transaksi->alamat_instalasi_transaksi }}</td>
              </tr>
              <tr>
                <td>Alamat Instalasi&nbsp;Baru</td>
                <td>:</td>
                <td>{{ $transaksi->alamat_instalasi_baru }}</td> 
              </tr>
              <tr>
                <td>Jenis Identitas-No.</td>
                <td>:</td>
                <td>{{ $transaksi->jenis_identitas_transaksi.'/'.$transaksi->no_identitas_transaksi }}</td>
              </tr>
            </table>
          <p><b><u>Spesifikasi Fasilitas Jasa telekomunikasi</u></b> </p>
          <table width="639" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td width="33"><div align="center">No.</div></td>
                <td width="139"><div align="center">Nomor Jastel </div></td>
                <td width="94"><div align="center">Jenis Instalasi </div></td>
                <td width="96"><div align="center">segmen</div></td>
                <td width="110"><div align="center">Jenis Layanan </div></td>
                <td width="84"><div align="center">Biaya</div></td>
                <td width="67"><div align="center">ket.</div></td>
              </tr>
              <tr>
                <td>1</td>
                <td>
                @foreach ($nojastel as $nj) 
                  {{ $nj->nomor_jastel }}  
                @endforeach
                </td>
                <td>{{ $transaksi->id_jenis_transaksi }}</td>
                <td>{{ $transaksi->segment_transaksi }}</td>
                <td>{{ $transaksi->jenis_layanan_transaksi }}</td>
                <td>{{ number_format($transaksi->biaya_transaksi) }}</td>
                <td>{{ $transaksi->keterangan_transaksi }}</td>
              </tr>
            </table>
        @endif

        @if ($transaksi->id_jenis_transaksi == 6) 
        <p><strong><U>FORM PERMINTAAN {{ $transaksi->layanan_fitur_transaksi }} FASILITAS ISTIMEWA (FITUR)</U></strong><BR />
        </p>
        <p>Dengan Hormat,<br />
            Untuk Nomor Telepon: <strong>
            @foreach ($nojastel as $nj)
                {{ $nj->nomor_jastel}}
            @endforeach</strong><br />
              Mohon @if ($transaksi->layanan_fitur_transaksi == 'PEMASANGAN')
                  {{ 'dipasang'}}
              @else
                  {{ 'dicabut'}}
              @endif Fasilitas Istimewa Berupa:</p>
        <table width="421" border="0" cellspacing="0" cellpadding="0">
         @foreach ($fitur as $f)
             @php
                 $tgk = FiturIndihome::where(['id_transaksi' => $transaksi->id_transaksi,'id_fitur' => $f->id_fitur])->first();
             @endphp
             <tr>
               <td><input type="checkbox" value="{{ $f->id_fitur }}" @if($tgk) {{'checked'}} @else {{''}} @endif> {{ $f->nama_fitur }}</td>
             </tr>
             @php
                $hunt = FiturIndihome::where(['id_transaksi' =>  $transaksi->id_transaksi,'id_fitur' => 9])->first();
             @endphp
             @if ($hunt)
              <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Induk Hunting </td>
                <td colspan="2">: {{ $transaksi->induk_hunting_transaksi }}</td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Anak Hunting </td>
                <td colspan="2">: {{ $transaksi->anak_hunting_transaksi }}</td>
              </tr>
             @else
                {{''}}
             @endif
         @endforeach
        </table>
        <p>Dengan ketentuan bahwa biaya pasang, percakapan, dan biaya lainnya yang berhubungan dengan <br />
        pemasangan / pencabutan fasilitas tersebut menjadi tanggung jawab saya: </p>
        <table width="425" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="172">Nama &nbsp;&nbsp;</td>
            <td width="11">:</td>
            <td width="242">{{ $transaksi->nama_penerima_kuasa_transaksi }}</td>
          </tr>
          <tr>
            <td>Alamat &nbsp;</td>
            <td>:</td>
            <td>{{ $transaksi->alamat_penerima_kuasa_transaksi }}</td>
          </tr>
          <tr>
            <td>Jenis Identitas-No.</td>
            <td>:</td>
            <td>{{ $transaksi->jenis_identitas_penerima_kuasa_transaksi.'/'.$transaksi->no_identitas_penerima_kuasa_transaksi }}</td>
          </tr>
        </table>
        <p>Dalam hal ini bertindak untuk atas nama diri sendiri, pemberi kuasa Perseorangan / Perusahaan / Badan Usaha atau Lembaga: </p>
        <table width="421" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="164">Nama Pelanggan</td>
            <td width="14">:</td>
            <td width="243">{{ $transaksi->nama_transaksi }}</td>
          </tr>
          <tr>
            <td>Alamat Pelanggan</td>
            <td>:</td>
            <td>{{ $transaksi->alamat_identitas_transaksi }}</td>
          </tr>
          <tr>
            <td>Jenis Identitas-No.</td>
            <td>:</td>
            <td>{{ $transaksi->jenis_identitas_transaksi.'/'.$transaksi->no_identitas_transaksi }}</td>
          </tr>
        </table>
        <p>Saya menyatakan memahami dan tunduk kepada ketentuan berlangganan fasilitas istimewa (Fitur) yang berlaku. </p>
          <p>Contact Person: {{ $transaksi->cp_transaksi }}</p>
            <p>Demikian Surat pernyataan ini di buat untuk dipergunakan seperlunya. </p>
              <table width="650" border="0" cellspacing="0" cellpadding="0">
                  <tr valign="top">
                    <td width="250" align="center">{{ $transaksi->kota }}, {{ hari_ini(date('D',strtotime($transaksi->create_transaksi))) .' '.bulan_ini(date('m',strtotime($transaksi->create_transaksi))).' '.date('Y',strtotime($transaksi->create_transaksi)) }}</td>
                    <td width="200">&nbsp;</td>
                    <td width="200" align="center">Menyetujui,</td>
                  </tr>
                  <tr valign="top">
                    <td width="250" align="center">Pelanggan<br />
                      <img src="{{ asset('signature/'.$transaksi->signature_pelanggan_transaksi) }}" width="130" /> <br />
                      {{ strtoupper($transaksi->nama_penerima_kuasa_transaksi) }}
                    </td>
                    <td width="200">&nbsp;</td>
                    <td width="200" align="center">Petugas Telkom<br />
                      <img src="{{ asset('signature/'.$transaksi->signature_login) }}" width="130" /> <br />
                       {{ strtoupper($transaksi->nama) }}
                    </td>
                  </tr>
                </table>
              </div>
        @endif

        @if($transaksi->id_jenis_transaksi == 8)
        <p><strong><U>SURAT PENGADUAN </U></strong><BR />
        </p>
        <p>Yang bertanda tangan di bawah ini: </p>
        <table width="566" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="189">Nama &nbsp;</td>
              <td width="15">:</td>
              <td width="362">{{ $transaksi->nama_transaksi }}</td>
            </tr>
            <tr>
              <td>Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td>:</td>
              <td>{{ $transaksi->alamat_identitas_transaksi }}</td>
            </tr>
            <tr>
              <td>No. Telepon &nbsp;&nbsp;&nbsp;</td>
              <td>:</td>
              <td>{{ $nojastel[0]->nomor_jastel }}</td>
            </tr>
            <tr>
              <td>Status Penggunaan</td>
              <td>:</td>
              <td><input type="checkbox" name="checkbox222" value="checkbox" @if($transaksi->status_penggunaan_transaksi == 'RUMAH TANGGA') {{'checked'}} @else {{''}} @endif />
              Rumah Tangga
              <input type="checkbox" name="checkbox232" value="checkbox" @if($transaksi->status_penggunaan_transaksi == 'BISNIS') {{'checked'}} @else {{''}} @endif />
              Bisnis
              <input type="checkbox" name="checkbox242" value="checkbox" @if($transaksi->status_penggunaan_transaksi == 'PEMERINTAH') {{'checked'}} @else {{''}} @endif />
              Pemerintah
              <input type="checkbox" name="checkbox252" value="checkbox" @if($transaksi->status_penggunaan_transaksi == 'SOSIAL') {{'checked'}} @else {{''}} @endif />Sosial </td>
              </tr>
            <tr>
              <td>Status Pemohon </td>
              <td>:</td>
              <td>
                <input type="checkbox" name="checkbox262" value="checkbox" @if($transaksi->status_pemohon_transaksi == 'PEMILIK') {{'checked'}} @else {{''}} @endif/>Pemilik
                <input type="checkbox" name="checkbox272" value="checkbox" @if($transaksi->status_pemohon_transaksi == 'PEMAKAI') {{'checked'}} @else {{''}} @endif/>Pemakai 
              </td>
            </tr>
          </table>
        <p>Mengajukan keberatan atas tagihan PT. TELKOM untuk bulan:<br />Dengan Alasan pengaduan:</p>
        <p><strong>&quot;{{ $transaksi->isi_pengaduan_transaksi }}&quot;</strong></p>
        <p>Keadaan Sambungan Telepon Kami saat ini: </p>
        <p>
            <input type="checkbox" name="checkbox283" value="checkbox" @if($transaksi->keadaan_sambungan_telepon_transaksi == 'ADA PARALEL') {{'checked'}} @else {{''}} @endif />
            Ada Pararel <br />
            <input type="checkbox" name="checkbox283" value="checkbox" <?php  if($transaksi->keadaan_sambungan_telepon_transaksi == 'ADA ALAT ANTI INTERLOKAL') { ?> checked="checked" <?php ; } ?> />
            Ada Alat Anti Interlokal <br />
            <input type="checkbox" name="checkbox283" value="checkbox" <?php  if($transaksi->keadaan_sambungan_telepon_transaksi == 'ADA ALAT TAMBAHAN LAIN') { ?> checked="checked" <?php ; } ?> />
            Ada Alat Tambahan Lain</p>
            <p>Selama Pengaduan masih dalam proses, kami bersedia membayar tagihan bulan berikutnya.</p>
            <p>Contact Person: {{ $transaksi->cp_transaksi }}</p>
            <p>Demikian pengaduan kami. </p>
            <table width="650" border="0" cellspacing="0" cellpadding="0">
              <tr valign="top">
                <td width="250" align="center">{{ $transaksi->kota }}, {{ hari_ini(date('D',strtotime($transaksi->create_transaksi))) .' '.bulan_ini(date('m',strtotime($transaksi->create_transaksi))).' '.date('Y',strtotime($transaksi->create_transaksi)) }}</td>
                <td width="200">&nbsp;</td>
                <td width="200" align="center"></td>
              </tr>
              <tr valign="top">
                <td width="250" align="center">Pelanggan<br />
                  <img src="{{ asset('signature/'.$transaksi->signature_pelanggan_transaksi) }}" width="130" /> <br />
                  <?php echo strtoupper($transaksi->nama_transaksi); ?>
                </td>
                <td width="200">&nbsp;</td>
                <td width="200" align="center">Petugas Telkom<br />
                  <img src="{{ asset('signature/'.$transaksi->signature_login) }}" width="130" /> <br />
                  <?php echo strtoupper($transaksi->nama); ?>
                </td>
              </tr>
            </table>
          </div>
        @endif

        @if ($transaksi->id_jenis_transaksi == 9)
        <p><strong><U>Side Letter Penggantian Paket Telkom Speedy </U></strong><BR />
        </p>
        <p>Yang bertanda tangan di bawah ini: </p>
        <table width="425" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="172">Nama &nbsp;&nbsp;</td>
              <td width="11">:</td>
              <td width="242">{{ $transaksi->nama_penerima_kuasa_transaksi }}</td>
            </tr>
            <tr>
              <td>Alamat &nbsp;</td>
              <td>:</td>
              <td>{{ $transaksi->alamat_penerima_kuasa_transaksi }}</td>
            </tr>
            <tr>
              <td>Jenis Identitas-No.</td>
              <td>:</td>
              <td>{{ $transaksi->jenis_identitas_penerima_kuasa_transaksi.'/'.$transaksi->no_identitas_penerima_kuasa_transaksi }}</td>
            </tr>
          </table>
        <p>Dalam hal ini bertindak untuk atas nama diri sendiri, pemberi kuasa Perseorangan / Perusahaan / Badan Usaha atau Lembaga: </p>
        <table width="421" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="164">Nama Pelanggan</td>
              <td width="14">:</td>
              <td width="243">{{ $transaksi->nama_transaksi }}</td>
            </tr>
            <tr>
              <td>Alamat Pelanggan</td>
              <td>:</td>
              <td>{{ $transaksi->alamat_identitas_transaksi }}</td>
            </tr>
            <tr>
              <td>Jenis Identitas-No.</td>
              <td>:</td>
              <td>{{ $transaksi->jenis_identitas_transaksi.'/'.$transaksi->no_identitas_transaksi }}</td>
            </tr>
           <tr>
              <td>Nomor Speedy</td>
              <td>:</td>
              <td>
                @foreach ($nojastel as $nj)
                    {{ $nj->nomor_jastel}}
                @endforeach
              </td>
            </tr>
          </table>
          @php
              $lama = Layanan::where(['id_layanan' => $transaksi->paket_lama_transaksi])->first();
              $baru = Layanan::where(['id_layanan' => $transaksi->paket_baru_transaksi])->first();
          @endphp
        <p>Bersedia mengganti paket Telkom Speedy :</p>
            <p>Dari Paket: <b>{{ $lama->nama_layanan }}</b><br />
              Menjadi paket: <b>{{ $baru->nama_layanan }}</b></p>
            <p>Terhitung Mulai Hari: {{hari_ini(date('D',strtotime($transaksi->create_transaksi)))}}, tanggal {{date('d',strtotime($transaksi->create_transaksi))}} bulan {{bulan_ini(date('m',strtotime($transaksi->create_transaksi)))}} tahun {{date('Y',strtotime($transaksi->create_transaksi))}}.</p>
            <p>Contact Person: {{ $transaksi->cp_transaksi }}</p>
            <p>Demikian Surat pernyataan ini di buat untuk dipergunakan seperlunya. </p>
            <table width="650" border="0" cellspacing="0" cellpadding="0">
              <tr valign="top">
                <td width="250" align="center">{{ $transaksi->kota }}, {{date('d',strtotime($transaksi->create_transaksi))}} {{bulan_ini(date('m',strtotime($transaksi->create_transaksi)))}} {{date('Y',strtotime($transaksi->create_transaksi))}}</td>
                <td width="200">&nbsp;</td>
                <td width="200" align="center">Menyetujui,</td>
              </tr>
              <tr valign="top">
                <td width="250" align="center">Pelanggan<br />
                  <img src="{{ asset('signature/'.$transaksi->signature_pelanggan_transaksi) }}" width="130" /> <br />
                  {{ strtoupper($transaksi->nama_penerima_kuasa_transaksi) }}
                </td>
                <td width="200">&nbsp;</td>
                <td width="200" align="center">Petugas Telkom<br />
                  <img src="{{ asset('signature/'.$transaksi->signature_login) }}" width="130" /> <br />
                  {{ strtoupper($transaksi->nama)}}
                </td>
            </tr>
          </table>
        </div>
        @endif

        @if ($transaksi->id_jenis_transaksi == 10)
        <p><strong>FORM CLAIM TAGIHAN {{ $transaksi->produk_transaksi }}</strong></p>
        <p>Yang bertanda tangan di bawah ini: ,<br />
        <b><u>Data Pelanggan:</u></b> </p>
        <table width="387" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="177">Nomor Jastel </td>
          <td width="15">:</td>
          <td width="195">
            @foreach ($nojastel as $nj)
                {{ $nj->nomor_jastel }}
            @endforeach
          </td>
        </tr>
		<tr>
          <td width="177">Nama Pelanggan</td>
          <td width="15">:</td>
          <td width="195">{{ $transaksi->nama_transaksi }}</td>
        </tr>
        <tr>
          <td>Alamat Pelanggan</td>
          <td>:</td>
          <td>{{ $transaksi->alamat_identitas_transaksi }}</td>
        </tr>
        <tr>
          <td>Alamat Instalasi&nbsp;</td>
          <td>:</td>
          <td>{{ $transaksi->alamat_instalasi_transaksi }}</td>
        </tr>

        <tr>
          <td>Jenis Identitas-No.</td>
          <td>:</td>
          <td>{{ $transaksi->jenis_identitas_transaksi.'/'.$transaksi->no_identitas_transaksi }}</td>
        </tr>
      </table>
	 
	    <p><b><u>Penerima Kuasa :</u></b> </p>

	    <table width="387" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="177">Nama Penerima Kuasa </td>
            <td width="15">:</td>
            <td width="195">{{ $transaksi->nama_penerima_kuasa_transaksi }}</td>
          </tr>
          <tr>
            <td>Alamat Penerima Kuasa </td>
            <td>:</td>
            <td>{{ $transaksi->alamat_penerima_kuasa_transaksi }}</td>
          </tr>
          <tr>
            <td>Jenis Identitas-No.</td>
            <td>:</td>
            <td>{{ $transaksi->jenis_identitas_penerima_kuasa_transaksi.'/'.$transaksi->no_identitas_penerima_kuasa_transaksi }}</td>
          </tr>
        </table>
	    <p><strong>Mengajukan Keberatan atas tagihan PT.Telkom sebesar Rp. <?php echo number_format($transaksi->jumlah_claim_transaksi,0); ?></strong></p>
	    <p>Dengan Alasan Pengaduan :
	    
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="3%">a.</td>
            <td width="26%">Tagihan Diluar Dugaan Karena </td>
            <td width="1%">:</td>
            <td width="70%">{{ $transaksi->alasan_claim_transaksi }}</td>
          </tr>
          <tr>
            <td>b.</td>
            <td>Bulan Tagihan Yang Di Klaimkan </td>
            <td>:</td>
            <td>{{ $transaksi->bulan_mulai.'-'.$transaksi->tahun_mulai.' s/d '.$transaksi->bulan_sampai.'-'.$transaksi->tahun_sampai }}</td>
          </tr>
          <tr>
            <td>c.</td>
            <td>Identifikasi Awal atas Claim yg di tagihkan </td>
            <td>:</td>
            <td>{{ $transaksi->identifikasi_claim_transaksi}}</td>
          </tr>
        </table>
	    <p>Demikian Pengajuan Kami, kami setuju bahwa pengajuan ini harus disertai dengan pembuktian yang harus di proses lebih lanjut. </p>
	    <p>{{ $transaksi->kota }}, {{ date('d',strtotime($transaksi->create_transaksi)) .' '.bulan_ini(date('m',strtotime($transaksi->create_transaksi))).' '.date('Y',strtotime($transaksi->create_transaksi)) }}</p>
	    <table width="630" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
          <td width="200" align="center">Mengetahui,</td>
          <td width="200">&nbsp;</td>
          <td width="230" align="center">{{ $transaksi->kota }}, {{ date('d',strtotime($transaksi->create_transaksi)) .' '.bulan_ini(date('m',strtotime($transaksi->create_transaksi))).' '.date('Y',strtotime($transaksi->create_transaksi)) }}</td>
        </tr>
        <tr valign="top">
          <td width="200" align="center">Petugas Telkom,<br />
            <img src="{{ asset('signture/'.$transaksi->signature_login) }}" width="130" /> <br />
            {{ strtoupper($transaksi->nama)}}
          </td>
          <td width="200">&nbsp;</td>
          <td width="230" align="center">Pelanggan,<br />
            <img src="{{ asset('signature/'.$transaksi->signature_pelangga_transaksi) }}" width="130" /> <br />
            {{ strtoupper($transaksi->nama_transaksi) }}
        </tr>
        </table>
        <p>
        </div>
        @endif

        @if ($transaksi->id_jenis_transaksi == 11)
        <p><b><u>KESANGGUPAN MENGANGSUR</u></b></p>
        <ol style="padding-left: 15px;">
          <li>Yang bertanda tangan di bawah ini:</li>
        <table width="529" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="176">Nama</td>
              <td width="14">:</td>
              <td width="339">{{ $transaksi->nama_transaksi }}</td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>:</td>
              <td>{{ $transaksi->alamat_identitas_transaksi }}</td>
            </tr>
            <tr>
              <td>Nomor Telepon</td>
              <td>:</td>
              <td>{{ $transaksi->cp_transaksi }}</td>
            </tr>
            <tr>
              <td colspan="3"><strong>Kontak Person Pelanggan</strong></td>
            </tr>
            <tr>
              <td>HP</td>
              <td>:</td>
              <td>{{ $transaksi->no_hp_transaksi }}</td>
            </tr>
            <tr>
              <td>Telepon</td>
              <td>:</td>
              <td>{{ $transaksi->cp_transaksi }}</td>
            </tr>
          </table>
        <p>Dengan ini menyatakan bahwa saya mempunyai tunggakan rekening {{ $transaksi->produk_transaksi }} mulai bulan {{ bulan_ini('0'.$transaksi->bulan_periode_mulai).' '.$transaksi->tahun_periode_mulai }}<br />s/d bulan {{ bulan_ini('0'.$transaksi->bulan_periode_sampai).' '.$transaksi->tahun_periode_sampai }} sebesar Rp <?php echo number_format($transaksi->jumlah_total_cicilan_transaksi,0,",","."); ?>,- dengan rincian sebagai berikut:</p>
          <table width="700" border="1" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>Bln. Thn</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
              @php
                $jumlahTgk = count($tunggakan);
                $blnMulai = $transaksi->bulan_mulai;
                $thnMulai = $transaksi->tahun_mulai;
                $blnSampai = $transaksi->bulan_sampai;
                $thnSampai = $transaksi->tahun_sampai;
                $total = 0;
              @endphp
              @foreach ($tunggakan as $i => $t)
                  @php
                    if($blnMulai > 12 && $thnMulai >= $thnMulai){
                        $blnMulai = 1;
                        $thnMulai++;
                    }
                    $total += $t->tunggakan;
                  @endphp
                  <tr>
                    <td clas>{{ bulan_ini('0'.$blnMulai++) .' '.$thnMulai }}</td>
                    <td>{{ 'Rp. '.$t->tunggakan }}</td>
                  </tr>
              @endforeach
                  <tr>
                    <td style="text-align: right"><b>Denda : </b></td>
                    <td>{{ 'Rp. '.$transaksi->denda_cicilan_transaksi }}</td>
                  </tr>
                  <tr>
                    <td style="text-align: right"><b>Total : </b></td>
                    <td>{{ 'Rp. '.$total }}</td>
                  </tr>
            </tbody>
        </table>
        <p>Saya bersedia dan sanggup melunasi kewajiban pembayaran tunggakan rekening telepon tersebut secara <br>
        angsuran sebanyak {{ $transaksi->angsuran_transaksi }} () kali terhitung mulai bulan {{ bulan_ini('0'.$transaksi->bulan_periode_mulai) }} {{ $transaksi->tahun_periode_mulai}} s/d bulan {{ bulan_ini('0'.$transaksi->bulan_periode_sampai) }} {{ $transaksi->tahun_periode_sampai }}<br>
        bersama dengan tagihan bulan berjalan paling lambat tanggal dan  bulan berikutnya.
        <li>Selama dalam proses angsuran saya akan patuh terhadap ketentuan yang berlaku di <b>PT. Telkom Indonesia</b> <br>
        khususnya tentang:</li>
        <ol type="a" style="padding-left: 15px;">
          <li>Status sambungan Telkom hanya dapat digunakan untuk <b>{{ $transaksi->sambungan_digunakan_transaksi }}<br></b>.</li>
          <li>Apabila selama dalam status <b>{{ $transaksi->tagihan_beban_transaksi }}</b> timbul pulsa, </br>
          maka pemakaian tersebut tetap menjadi tanggung jawab pelanggan.</li>
          <li>Apabila angsuran setiap bulannya tidak dilunasi sesuai dengan kesepakatan, maka status sambungan</br>
            telepon akan dikenakan <b>SANKSI ISOLIR TOTAL</b>, dan selanjutnya apabila kewajiban tidak dilunasi</br>
            di atas 3 (tiga) bulan, maka sambungan telepon <b>DICABUT</b> secara sepihak oleh PT. Telkom Indonesia</br>
            dan sisa piutang tetap menjadi tanggung jawab pelanggan.</li>
          <li>Pembukaan kembali status sambungan telepon dilakukan setelah selesainya masa angsuran.</li>
          <li>Saya tidak keberatan untuk diisolir nomor telepon lainnya (bila ada) bila melalaikan kewajiban</br>
          untuk mengangsur yaitu nomor telepon <?php if(empty($transaksi->no_isolir_lain_transaksi)) { echo "..............."; } else { echo $transaksi->no_isolir_lain_transaksi; } ?></li>
        </ol>
        <p>Demikian Surat pernyataan ini saya buat dengan itikat baik untuk diketahui bagi yang berkepentingan.</p>
          <table width="630" border="0" cellspacing="0" cellpadding="0">
            <tr valign="top">
              <td width="200" align="center">Mengetahui,</td>
              <td width="200">&nbsp;</td>
              <td width="230" align="center">{{ $transaksi->kota.', '.date('d',strtotime($transaksi->create_transaksi)).' '.bulan_ini(date('m',strtotime($transaksi->create_transaksi))).' '.date('Y',strtotime($transaksi->create_transaksi)) }}</td>
            </tr>
            <tr valign="top">
              <td width="200" align="center">Petugas Telkom,<br />
                <img src="{{ asset('signature/'.$transaksi->signature_login) }}" width="130" /> <br />
                {{ strtoupper($transaksi->nama) }}
              </td>
              <td width="200">&nbsp;</td>
              <td width="230" align="center">Pelanggan,<br />
                <img src="{{ asset('signature/'.$transaksi->signature_pelanggan_transaksi) }}" width="130" /> <br />
                {{ strtoupper($transaksi->nama_transaksi) }}</td>
            </tr>
          </table>
        </ol>
        </div>
        @endif

        @if ($transaksi->id_jenis_transaksi != 3 && $transaksi->id_jenis_transaksi != 6 && $transaksi->id_jenis_transaksi != 8 && $transaksi->id_jenis_transaksi != 9 && $transaksi->id_jenis_transaksi != 10 && $transaksi->id_jenis_transaksi != 11)
        <p><b><u>PERSETUJUAN PERMOHONAN </u></b></p>
	      <p>Pada Hari ini {{ hari_ini(date('D',strtotime($transaksi->create_transaksi)))}}, tanggal {{ date('d',strtotime($transaksi->create_transaksi))}} bulan {{ bulan_ini(date('m',strtotime($transaksi->create_transaksi))) }} tahun {{ date('Y',strtotime($transaksi->create_transaksi))}}, pihak TELKOM 
	      telah menyetujui permohonan PELANGGAN dimaksud<br />
	      dan dengan ini TELKOM dan PELANGGAN sepakat untuk saling mengikatkan diri dalam kontrak berlangganan<br />
	      sambungan telekomunikasi "<strong>{{ $transaksi->produk_transaksi }}</strong>".</p>
	      <p>&nbsp;Data dan Informasi di atas adalah benar dan ketentuan berlangganan dalam kontrak berlangganan<br />
	      sambungan telekomunikasi tersebut telah di pahami dan berlaku bagi kedua belah pihak sejak di tandatangani <br />
	      oleh PELANGGAN dan PETUGAS TELKOM  yang berwenang.</p>       
	    <table width="630" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
          <td width="200" align="center"><p>{{ $transaksi->kota.', '.date('d',strtotime($transaksi->create_transaksi)).' '.bulan_ini(date('m',strtotime($transaksi->create_transaksi))).' '.date('Y',strtotime($transaksi->create_transaksi)) }}</p></td>
          <td width="200">&nbsp;</td>
          <td width="230" align="center">{{ $transaksi->kota.', '.date('d',strtotime($transaksi->create_transaksi)).' '.bulan_ini(date('m',strtotime($transaksi->create_transaksi))).' '.date('Y',strtotime($transaksi->create_transaksi)) }}</td>
        </tr>
        <tr valign="top">
          <td width="200" align="center">Petugas Telkom,<br />
            <img src="{{ asset('signature/'.$transaksi->signature_login ) }}" width="130" /> <br />
            {{ strtoupper($transaksi->nama)}} </td>
          <td width="200">&nbsp;</td>
          <td width="230" align="center">Pelanggan,<br />
            <img src="{{ asset('signature/'.$transaksi->signature_pelanggan_transaksi ) }}" width="130" /> <br />
            {{ $transaksi->nama_transaksi }}</td>
        </tr>
      </table>
      @endif
</div>
</div>