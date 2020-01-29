<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
body{
      font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;
	  font-size:7px;
}
</style>

@php
    use App\PaketTambahan;
    use App\PaketTambahanIndihome;

    $pLeft = PaketTambahan::skip(0)->take(3)->get();
    $pRight= PaketTambahan::skip(4)->take(3)->get();

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
@endphp

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Indihome</title>
</head>
<body>
<table width="100%" align="center"><tr><td>
<table width="100%">
<tr>
	<td><strong><font size="2px">KONTRAK BERLANGGANAN INDIHOME</font></strong></td>
	<td align="right"><img src="{{ asset('images/indi.jpg') }}" /></td>
</tr>
</table>



<table width="100%" style="border: 1px solid black;">
	<tr>
<td colspan="6"><strong>I. Detail Layanan</strong></td>
</tr>

<tr>
<td>
  <strong>Jenis Permohonan* :</strong> {{ $indihome->jenis_permohonan_indihome }}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>
  <strong>Paket Layanan IndiHome*:</strong> {{ $indihome->nama_layanan }} </td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr>
<td valign="top"><strong>Paket Tambahan : 
</strong><br />

    @foreach ($pLeft as $pl)
        @php
            $check = PaketTambahanIndihome::where(['id_indihome' => $indihome->id_indihome, 'id_paket_tambahan' => $pl->id_paket_tambahan])->first()
        @endphp
            <input type="checkbox" name="pt1" value="{{ $pl->id_paket_tambahan }}" @if($check) {{'checked'}} @else {{''}} @endif/>
        {{$pl->nama_paket_tambahan}}<br />
    @endforeach
    
   
    
    Lain-lain : {{ $indihome->paket_lain_indihome }}
</td>
<td valign="top">
<br />
    @foreach ($pRight as $pr)
        @php
            $check2 = PaketTambahanIndihome::where(['id_indihome' => $indihome->id_indihome, 'id_paket_tambahan' => $pr->id_paket_tambahan])->first()
        @endphp
            <input type="checkbox" name="pt1" value="{{ $pr->id_paket_tambahan }}" @if($check2) {{'checked'}} @else {{''}} @endif/>
        {{$pr->nama_paket_tambahan}}<br />
    @endforeach
</td>
<td>&nbsp;</td>
<td valign="top"><strong>Jenis ONT & STB* :</strong><br />
    @foreach ($jenis_ont as $o)
        <input type="checkbox" name="jenis_ont1" value="{{ $o->id_ont}}" @if($indihome->id_ont == $o->id_ont) {{'checked'}} @else {{''}} @endif/>
         {{$o->nama_ont}}<br />
    @endforeach

<td> </td>
<td>&nbsp;</td>
</tr>

<tr>
  <td colspan="6">
    <strong>Nomor Layanan (khusus bagi Pelanggan yang Upgrade Layanan) :</strong></td>
</tr>

<tr>
<td>
1. Nomor Telepon Rumah*
: {{ $indihome->telepon_indihome }}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td valign="top">&nbsp;</td>
<td valign="top">&nbsp;</td>
<td valign="top">&nbsp;</td>
</tr>

<tr>
<td>
2. Nomor Internet / IndiHome
: {{ $indihome->no_internet_internet }}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td valign="top">&nbsp;</td>
<td valign="top">&nbsp;</td>
<td valign="top">&nbsp;</td>
</tr>

<tr>
<td height="24" colspan="6">
  <strong>Usulan Waktu Instalasi (sebagai referensi) : </strong></td>
</tr>

<tr>
<td>
1. Hari / Tanggal
: {{ hari_ini(date('D',strtotime($indihome->usulan_instalasi_indihome))).' / '.date('d',strtotime($indihome->usulan_instalasi_indihome)).' '.bulan_ini(date('m',strtotime($indihome->usulan_instalasi_indihome))).' '.date('Y',strtotime($indihome->usulan_instalasi_indihome)) }}</td>
<td valign="top">&nbsp;</td>
<td valign="top">&nbsp;</td>
<td valign="top">&nbsp;</td>
</tr>
</table>
<br />
<table style="border: 1px solid black;" width="100%">
<tr>
<td colspan="6"><strong>II. Detail Pelanggan</strong></td>
</tr>

<tr>
<td colspan="3" width="50"><strong>Yang bertanda tangan di bawah ini:</strong></td><td colspan="3" width="50"><strong>Dalam hal ini bertindak untuk dan atas nama* :</strong> {{ $indihome->nama_tanda_indihome }}</td>
</tr>

<tr>
<td>
  1. Nama* : {{ $indihome->nama_tanda_indihome }}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>4. Nama Pelanggan* : {{ $indihome->nama_pelanggan_indihome }}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr>
<td>
  2. Identitas Diri* : {{ $indihome->jenis_identitas_tanda_indihome }} &nbsp;&nbsp;&nbsp;No : {{ $indihome->no_identitas_tanda_indihome }}</td>
<td>&nbsp;</td>
<td valign="top">&nbsp;</td>
<td>5. Identitas Diri* : {{ $indihome->jenis_identitas_pelanggan_indihome }} &nbsp; No :{{ $indihome->no_identitas_pelanggan_indihome }}</td><td>&nbsp;</td><td>&nbsp;</td>
</tr>

<tr>
<td valign="top">
  3. Alamat* : {{ $indihome->alamat_tanda_indihome }} &nbsp;&nbsp; Kode Pos :{{ $indihome->kodepos_tanda_indihome }}</td>
<td valign="top">&nbsp;</td>
<td valign="top">&nbsp;</td>
<td>6. Alamat Pemasangan* : {{ $indihome->alamat_pelanggan_indihome }} &nbsp;&nbsp;Kode Pos : {{ $indihome->alamat_pelanggan_indihome }}</td><td>&nbsp;</td><td>&nbsp;</td>
</tr>

<tr>
<td valign="top">&nbsp;</td>
<td valign="top">

</td>
<td valign="top">&nbsp;</td>
<td>7. Nomor NPWP : {{ $indihome->no_npwp_pelanggan_indihome }}</td><td>&nbsp;</td><td>&nbsp;</td>
</tr>

<tr>
  <td colspan="6">&nbsp;&nbsp;<table width="100%" style="border: 1px solid black;">
  <tr>
  <td>
    Nama Ibu Kandung* : {{ $indihome->nama_ibu_kandung_pelanggan_indihome }}</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  </tr>
    
  <tr>
  <td>
    Email* : {{ $indihome->email_pelanggan }}</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  </tr>
    
  <tr>
  <td>
    Nomor Kontak*: &nbsp;Rumah : {{ $indihome->kontak_telepon_indihome }} &nbsp;&nbsp;<strong>&nbsp;</strong>Hp : {{ $indihome->kontak_hp_indihome}} </td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  </tr>
  </table>&nbsp;&nbsp;</td>
</tr>

<tr>
<td>
  8. Status Pemasangan di alamat tsb.* : {{ $indihome->status_pemasangan_indihome }}</td>
<td>&nbsp;</td>
<td valign="top">&nbsp;</td>
<td>9. Komunikasi yang disukai : {{ $indihome->komunikasi_indihome }}</td><td>&nbsp;</td><td>&nbsp;</td>
</tr>
</table>
<br />
<table width="100%" style="border: 1px solid black;">
<tr>
<td colspan="2" width="50%"><strong>III. JENIS PEMBAYARAN NON KARTU KREDIT</strong></td>
<td colspan="2"><strong>IV. JENIS PEMBAYARAN KARTU KREDIT</strong></td>

</tr>

<tr>
<td width="25%">
1 Jenis Pembayaran
: {{ $indihome->jenis_pembayaran_indihome }}</td>
<td>&nbsp;</td>
<td valign="top" width="35%">1 Jenis Kartu Kredit
: {{ $indihome->jenis_kartu_kredit_pembayaran }}</td>
<td width="25%">5 Bank Penerbit
: {{ $indihome->bank_penerbit_pembayaran }}</td>
</tr>

<tr>
<td>
2 Bank
: {{ $indihome->bank_pembayaran }}</td>
<td>&nbsp;</td>
<td>2 Nama Pemegang Kartu
: {{ $indihome->pemegang_kartu_kredit_pembayaran }}</td>
<td>&nbsp;</td>
</tr>

<tr>
<td>
3 No. Rekening
: {{ $indihome->no_rekening_pembayaran }}</td>
<td>&nbsp;</td>
<td>3 Nomor Kartu
: {{ $indihome->no_kartu_kredit_pembayaran }}</td>
<td>&nbsp;</td>
</tr>

<tr>
<td>
4 Atas Nama : {{ $indihome->atas_nama_pembayaran }}</td>
<td>&nbsp;</td>
<td>4 Masa Berlaku
: {{ date('d F Y',strtotime($indihome->masa_berlaku_kartu_kredit_pembayaran)) }}</td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="4"><table width="100%" style="border: 1px solid black;">
<tr>
  <td width="50%"><strong>Pernyataan Dan Jaminan</strong><br />Kami yang bertanda tangan di bawah ini, dengan ini menyatakan :<br />1. Adalah pemegang Kartu Kredit yang sah dan berwenang<br />2. Seluruh data yang kami berikan adalah benar dan lengkap</td>
  <td valign="top" width="50%"><br />3. Setuju untuk dilakukan pendebitan rekening Kartu Kredit kami untuk keperluan pembayaran biaya pasang baru, biaya berlangganan, dan/atau biaya tambahan lain yang mungkin timbul selama berlangganan layanan IndiHome. </td>
</tr>
</table></td>
</tr>
</table>
<br />
<table width="100%" style="border: 1px solid black;">
<tr>
<td colspan="3"><strong>V. ALAMAT  TAGIHAN</strong></td>
</tr>

<tr>
<td valign="top">
Alamat Penagihan*: {{ $indihome->alamat_penagihan_indihome }} &nbsp;&nbsp;&nbsp;Kode Pos*: {{ $indihome->kodepos_penagihan_indihome }}</td>
<td>&nbsp;</td>
<td valign="top">&nbsp;
</td>
</tr>
</table>
<br />
<table width="100%"style="border: 1px solid black;">
<tr>
  <td colspan="3"><strong>VI. INFORMASI TAMBAHAN (WAJIB DIBACA & DIBERI TANDA [√] )</strong></td></tr>
<tr>
@php
    $p = explode(';',$indihome->persetujuan_indihome);
@endphp
<td colspan="2" valign="top" width="95%">1. Bersedia menerima informasi dari TELKOM Group atau Authorized Partner melalui berbagai media termasuk telepon, sms, email dan internet ads  </td>
<td valign="top" width="5%">&nbsp;<input name="pl1" type="checkbox" value="1" @if($p[0] == 'YA') {{'checked'}} @else {{''}} @endif/></td>
</tr>

<tr>
<td colspan="2" valign="top">2. Bersedia mencantumkan nomor IndiHome di Buku Pentunjuk Telepon Telkom dan Layanan "Directory Service" Telkom 108</td>
<td valign="top">&nbsp;<input name="pl2" type="checkbox" value="1" @if($p[1] == 'YA') {{'checked'}} @else {{''}} @endif/></td>
</tr>

<tr>
<td colspan="2" valign="top">3. Menyetujui bahwa dengan diberlakukannya dokumen kontrak berlangganan IndiHome ini, maka kontrak berlangganan lama untuk produk Telepon dan atau Internet dan atau Usee TV dianggap tidak berlaku lagi (Khusus bagi Pelanggan Upgrade Layanan) </td>
<td valign="top">&nbsp;<input name="pl3" type="checkbox" value="1" @if($p[2] == 'YA') {{'checked'}} @else {{''}} @endif/></td>
</tr>

<tr>
<td colspan="2" valign="top">4. Bila Data Pelanggan pada  kontrak berlangganan produk Telepon dan atau Internet dan atau Usee TV  berbeda dengan Kontrak Berlangganan layanan IndiHome ini maka pelanggan yang menanda tangani kontrak berlangganan IndiHome bersedia bertanggung jawab atas segala resiko atas perubahan data Pelanggan tersebut (Khusus bagi Pelanggan Upgrade Layanan) </td>
<td valign="top">&nbsp;<input name="pl4" type="checkbox" value="1" @if($p[3] == 'YA') {{'checked'}} @else {{''}} @endif/></td>
</tr>

<tr>
<td colspan="2" valign="top">5. Pelanggan akan dikenakan biaya sewa bulanan ONT, STB dan Platform IPTV sesuai dengan jenis STB yang digunakan. Setiap penambahan STB ke 2 (dua) dan seterusnya, juga akan dikenakan biaya sewa bulanan sesuai jenis STB serta biaya instalasi/setting (sesuai kondisi instalasi yang berlaku) yang ditagihkan pada bulan berikutnya setelah pemasangan STB tersebut </td>
<td valign="top">&nbsp;<input name="pl5" type="checkbox" value="1"@if($p[4] == 'YA') {{'checked'}} @else {{''}} @endif/></td>
</tr>

<tr>
<td colspan="2" valign="top">6. Bila pelanggan berhenti berlangganan, Telkom akan mengambil perangkat CPE milik TELKOM yang terinstal di alamat Pelanggan untuk layanan IndiHome</td>
<td valign="top">&nbsp;<input name="pl6" type="checkbox" value="1" @if($p[5] == 'YA') {{'checked'}} @else {{''}} @endif/></td>
</tr>

<tr>
<td colspan="2" valign="top">7. Besaran tagihan IndiHome, paket tambahan dan sewa ONT - STB dapat berubah sewaktu-waktu</td>
<td valign="top">&nbsp;<input name="pl7" type="checkbox" value="1" @if($p[6] == 'YA') {{'checked'}} @else {{''}} @endif/></td>
</tr>
</table>

<table width="100%">
	<tr>
		<td width="10%">&nbsp;</td>
		<td width="80%">&nbsp;</td>
		<td width="10%" align="center">{{ $indihome->kota_indihome }}, {{ date('d',strtotime($indihome->create_indihome)) .' '.bulan_ini(date('m',strtotime($indihome->create_indihome))).' '.date('Y',strtotime($indihome->create_indihome)) }}&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td width="10%" align="center">
            Petugas Telkom
		</td>
		<td width="80%">&nbsp;</td>
		<td width="10%" align="center">
            Pelanggan
		</td>
	</tr>
	<tr>
		<td width="10%" align="center">
			<img src="{{ asset('signature/'.$indihome->signature_login) }}" align="center"; width="100" />
		</td>
		<td width="80%">&nbsp;</td>
		<td width="10%" align="center">
		    <img src="{{ asset('signature/'.$indihome->signature_pelanggan_indihome) }}" align="center"; width="100" />
		</td>
	</tr>
	<tr>
		<td width="10%" align="center">
			{{ strtoupper($indihome->nama) }}
		</td>
		<td width="80%">&nbsp;</td>
		<td width="10%" align="center">
			{{ strtoupper($indihome->nama_pelanggan_indihome) }}
		</td>
	</tr>
</table>


</td></tr></table>
</body>
</html>
