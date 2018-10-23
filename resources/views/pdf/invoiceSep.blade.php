<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SURAT ELEGIBILITAS PESERTA</title>
    <style type="text/css">
        h4 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-left: -40px;
            /* margin-r2ght: -40px; */
            /* margin-top: -50px;
            margin-bottom: -50px; */
        }       
        /* table .table-ttd .ttd, .table-ttd {
            border: 1px solid;
        }    */
        .ttd-garis{
            border-bottom: 2px solid;
        }
        
        th {
            height: 15px;
            padding: 2px;
        }
        td {            
            font-family: "Times New Roman";
            font-size:12px;
            height: 8px;
            padding: 2px;
        }
     
        #sep-image {
            /* margin-top: 1px; */
            width: 10%;
            vertical-align: top;
        }
        .avatar-view {
            width: 250px;
            height: 35px;
        }
        #sep-title {
            margin-top: 1px;
            padding-left: 7em;
            width: 100%;
            font-size: 20px;
        }
        #sep-title-2 {
            /* margin-top: -50px; */
            padding-left: 7.6em;
            width: 100%;
            font-size: 20px;
        }
        #tgl-sep .tgl-sep, #tgl-sep .tgl-lahir, .no-rm, .tindakan, .ttd-pasien{
            width: 15%;
        }
        #tgl-sep .nilai-tgl-sep, .nilai-no-rm, .ttd-dokter, .g-2 .ttd-garis{
            width: 30%;
        }
        #tgl-sep .nilai-tgl-lahir, .kel-pas, .g-1{
            width: 20%;
        }
        #tgl-sep .jns-kel, #tgl-sep .nilai-jns-kel{
            width: 10%;
        }
        .no-rm, .nilai-no-rm, .alamat-p, .nilai-alamat-p, .tt-dua, .asal-fks, .nama-fks, .diagnosa, .nilai-diagnosa, .catatan, .n-catatan{
            vertical-align: top;
        }
        .blanked {
            width: 35%;
        }
        /* Set Page */
        /* @page {
            margin-top: 0.3em;
            margin-left: 0.6em;
        } */
    </style>
</head>
<body id="sep-content">
    <table class="table table-borderless table-header">
        <tr>
            <td id="sep-image" rowspan="2"><img class="img-responsive avatar-view"  src="{{ asset('img/logo-bpjs.png') }}"></td>
            <td id="sep-title">
                SURAT ELEGIBILITAS PESERTA 
            </td> 
        </tr> 
        <tr>
            <td id="sep-title-2">RSUD KRATON Pekalongan</td>
        </tr> 
        <tr style="width:50px">
            <td colspan="2"></td>                            
        </tr>                       
    </table>   
    <table class="table table-content">
        <tr>
            <td>No. SEP</td>
            <td>:</td>
            <td>{{ $data->noSep }}</td>
            <td>Nama Peserta</td>
            <td>:</td>
            <td>{{ $data->peserta->nama }}</td>
        </tr>
        <tr id="tgl-sep">
            <td class="tgl-sep">Tanggal SEP</td>
            <td>:</td>
            <td class="nilai-tgl-sep">{{ $data->tglSep }}</td>
            <td class="tgl-lahir">Tanggal Lahir</td>
            <td>:</td>
            <td class="nilai-tgl-lahir">{{ $data->peserta->tglLahir }}</td>
            <td class="jns-kel">Jns Kel</td>
            <td>:</td>
            <td class="nilai-jns-kel">{{ $data->peserta->kelamin }}</td>
        </tr>
        <tr>
            <td class="no-rm">No. RM</td>
            <td class="tt-dua">:</td>
            <td class="nilai-no-rm">{{ $data->peserta->noMr }}</td>
            <td rowspan="3" class="alamat-p">Alamat Pasien</td>
            <td rowspan="3" class="tt-dua">:</td>
            <td rowspan="3" colspan="10" class="nilai-alamat-p">{{ $data->alamat }}</td>
        </tr>
        <tr>
            <td>No. Registrasi</td>
            <td>:</td>
            <td>{{ $data->noReg }}</td>
        </tr>
        <tr>
            <td>No. Kartu</td>
            <td>:</td>
            <td>{{ $data->peserta->noKartu }}</td>
        </tr>
        <tr>
            <td>Poli Tujuan</td>
            <td>:</td>
            <td>{{ $data->poli }}</td>
            <td>Peserta</td>
            <td>:</td>
            <td colspan="4">{{ $data->peserta->jnsPeserta }}</td>
        </tr>
        <tr>
            <td class="asal-fks">Asal Faskes Tk. I</td>
            <td class="tt-dua">:</td>
            <td class="nama-fks">{{ $data->asalFaskes }}</td>
            <td>COB</td>
            <td>:</td>
            <td colspan="4">0</td>
        </tr>
        <tr>
            <td>Antrian</td>
            <td>:</td>
            <td>{{ $data->antrian }} {{ $data->namaKlinik }}</td>
            <td>Jenis Rawat</td>
            <td>:</td>
            <td colspan="4">{{ $data->jnsPelayanan }}</td>
        </tr>
        <tr>
            <td rowspan="2" class="diagnosa">Diagnosa Awal</td>
            <td rowspan="2" class="tt-dua">:</td>
            <td rowspan="2" class="nilai-diagnosa">{{ $data->diagnosa }} {{ $data->kdDiagnosa }}</td>
            <td>Kls Tanggungan</td>
            <td>:</td>
            <td colspan="4">Kelas {{ $data->kelasRawat }}</td>
        </tr>
        <tr rowspan="2">
        <td class="catatan">Catatan</td>
            <td class="tt-dua">:</td>
            <td class="n-catatan" colspan="4">{{ $data->catatan }}</td>
        </tr>
        <tr>
            <td>Diagnosa Utama</td>
            <td>:</td>
            <td></td>
            <td>Penjamin</td>
            <td>:</td>
            <td colspan="4"></td>
        </tr>        
    </table>
    <table class="table table-ttd">
        <tr>
            <td style="height:100px" colspan="4"></td>
        </tr>
        <tr>
            <td class="tindakan">Tindakan/ Operasi</td>
            <td>:</td>
            <td class="nilai-tindakan"></td>
        </tr>
        <tr class="ttd">
            <td sytle="vertical-align: top;"></td>
            <td style="width:27%"></td>
            <td style="width:27%"></td>
            <td style="width:15%" class="ttd-pasien">Pasien/ <br>Keluarga Pasien</td>
            <td style="width:1%"></td>
            <td style="width:1%" class="ttd-dokter">Dokter <br>DPJP</td>   
        </tr>
        <tr>
            <td style="height:50px" colspan="1"></td>
        </tr>
        <tr class="ttd-ttd">
            <td sytle="vertical-align: top;"></td>
            <td style="width:27%"></td>
            <td style="width:27%"></td>
            <td style="width:15%" class="ttd-garis"></td>
            <td class="g-gr"></td>
            <td style="width:1%" class="ttd-garis"></td>   
        </tr>
        <tr>
            <td style="height:5px" colspan="6"></td>
        </tr>
        <tr>
            <td colspan="5"> 
                <i>
                    *Saya Menyetujui BPJS Kesehatan menggunakan Informasi Medis Pasien jika diperlukan 
                     <br>*SEP bukan sebagai bukti penjamin peserta
                     <br><u><span>{{ !is_null($data->informasi) ? $data->informasi->prolanisPRB : '' }}</span></u>
                </i>
            </td>
            <td>Dicetak Oleh : {{ Auth::user()->nama_pegawai }}</td>
        </tr>
    </table>
</body>
</html>