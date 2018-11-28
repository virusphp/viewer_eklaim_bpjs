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
            margin-bottom: 2px;
        }       
      
        .ttd-garis{
            border-bottom: 2px solid;
        }
        
        .table-content {
            border-spacing: 0;
            /* width: 100%; */
        }
        
        th {
            height: 15px;
            padding: 1px;
        }
        
        @font-face {
            font-family: 'DOTMATRI';
            src: {{ asset('font-dotmatrix/DOTMATRI.ttf') }};
            src: local('DOTMATRI'), url('./DOTMATRI.woff') format('woff'), url('./DOTMATRI.ttf') format('truetype');
        }

        body {
            margin: 15px;
            font-family: "Consolas";
            font-size:13px;
            padding: 1px;
        }

        td {            
            font-family: "Consolas";
            font-size:13px;
            /* font-weight: 500; */
            padding: 1px;
        }

        i , i strong {
            font-size: 10px;
            vertical-align: top;
        }
     
        #sep-image {
            width: 5%;
            vertical-align: top;
            /* margin-bottom: 5px; */

        }

        .avatar-view {
            width: 170px;
            height: 25px;
            /* margin-top: 5px; */
        }

        #sep-title {
            margin-top: 1px;
            padding-left: 5em;
            /* width: 100%; */
            font-size: 19px;
            /* margin-bottom: 5px; */
        }
        #sep-title-2 {
            padding-left: 6.6em;
            /* width: 100%; */
            font-size: 17px;
            /* margin-bottom: 5px; */
        }
       #tgl-sep .tgl-sep, #tgl-sep .tgl-lahir, .no-rm, .tindakan, .ttd-pasien{
            width: 15%;
        }
        #tgl-sep .nilai-tgl-sep, .nilai-no-rm, .ttd-dokter, .g-2 .ttd-garis, #v-noSep, {
            width: 35%;
        }
        #tgl-sep .nilai-tgl-lahir, .kel-pas, .g-1{
            width: 20%;
        }
        #tgl-sep .jns-kel, #tgl-sep .nilai-jns-kel {
            width: 10%;
        }

        .asal-fks {
            width: 18%;
        }
        
        .nilai-poli {
            width: 33%;
        }

        .no-rm, .nilai-no-rm, .alamat-p, .nilai-alamat-p, .tt-dua, .asal-fks, .nama-fks, .diagnosa, .nilai-diagnosa, .catatan, .n-catatan{
            vertical-align: top;
        }

        .blanked {
            width: 35%;
        }

        .kanan {
            font-size: 11px;
            /* clear: right; */
            /* float: right; */
        }
        /* Set fotn */
        /* @page {
            margin-top: 0.3em;
            margin-left: 0.6em;
        } */
    </style>
</head>
<body id="sep-content" onload="printSep()">
    <table class="table table-borderless table-header" >
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
            <td id="v-noSep">{{ $dataSep->noSep }}</td>
            <td>Nama Peserta</td>
            <td>:</td>
            <td colspan="4" id="v-nmPeserta">{{ $dataSep->peserta->nama }}</td>
        </tr>
        <tr id="tgl-sep">
            <td class="tgl-sep">Tanggal SEP</td>
            <td>:</td>
            <td class="nilai-tgl-sep">{{ $dataSep->tglSep }}</td>
            <td class="tgl-lahir">Tanggal Lahir</td>
            <td>:</td>
            <td class="nilai-tgl-lahir">{{ $dataSep->peserta->tglLahir }}</td>
            <td class="jns-kel">Jns Kel</td>
            <td>:</td>
            <td class="nilai-jns-kel">{{ $dataSep->peserta->kelamin }}</td>
        </tr>
        <tr>
            <td class="no-rm">No. RM</td>
            <td class="tt-dua">:</td>
            <td class="nilai-no-rm">{{ $dataSep->peserta->noMr }}</td>
            <td rowspan="3" class="alamat-p">Alamat Pasien</td>
            <td rowspan="3" class="tt-dua">:</td>
            <td rowspan="3" colspan="10" class="nilai-alamat-p">{{ $dataSep->alamat }}</td>
        </tr>
        <tr>
            <td>No. Registrasi</td>
            <td>:</td>
            <td>{{ $dataSep->noReg }}</td>
        </tr>
        <tr>
            <td>No. Kartu</td>
            <td>:</td>
            <td>{{ $dataSep->peserta->noKartu }}</td>
        </tr>
        <tr>
            <td>Poli Tujuan</td>
            <td>:</td>
            <td class="nilai-poli">{{ $dataSep->poli }}</td>
            <td>Peserta</td>
            <td>:</td>
            <td colspan="4">{{ $dataSep->peserta->jnsPeserta }}</td>
        </tr>
        <tr>
            <td class="asal-fks">Asal Faskes Tk. I</td>
            <td class="tt-dua">:</td>
            <td class="nama-fks">{{ $dataSep->asalFaskes }}</td>
            <td>COB</td>
            <td>:</td>
            <td colspan="4">0</td>
        </tr>
        <tr>
            <td>Antrian</td>
            <td>:</td>
            <td>{{ $dataSep->antrian }} {{ $dataSep->namaKlinik }}</td>
            <td>Jenis Rawat</td>
            <td>:</td>
            <td colspan="4">{{ $dataSep->jnsPelayanan }}</td>
        </tr>
        <tr>
            <td rowspan="2" class="diagnosa">Diagnosa Awal</td>
            <td rowspan="2" class="tt-dua">:</td>
            <td rowspan="2" class="nilai-diagnosa">{{ $dataSep->diagnosa }} {{ $dataSep->kdDiagnosa }}</td>
            <td>Kls Tanggungan</td>
            <td>:</td>
            <td colspan="4">Kelas {{ $dataSep->kelasRawat }}</td>
        </tr>
        <tr rowspan="2">
        <td class="catatan">Catatan</td>
            <td class="tt-dua">:</td>
            <td class="n-catatan" colspan="4">{{ $dataSep->catatan }}</td>
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
            <td style="height:110px" colspan="6"></td>
        </tr>
        <tr>
            <td class="tindakan">Tindakan/ Operasi</td>
            <td>:</td>
            <td colspan="4" class="nilai-tindakan"></td>
        </tr>
        <tr class="ttd">
            <td sytle="vertical-align: top;"></td>
            <td style="width:20%"></td>
            <td style="width:20%"></td>
            <td style="width:15%" class="ttd-pasien">Pasien/ <br>Keluarga Pasien</td>
            <td style="width:1%"></td>
            <td style="width:15%" class="ttd-dokter">Dokter <br>DPJP</td>   
        </tr>
        <tr>
            <td style="height:30px" colspan="6"></td>
        </tr>
        <tr class="ttd-ttd">
            <td sytle="vertical-align: top;"></td>
            <td style="width:20%"></td>
            <td style="width:20%"></td>
            <td style="width:15%" class="ttd-garis"></td>
            <td class="g-gr"></td>
            <td style="width:15%" class="ttd-garis"></td>   
        </tr>
        <tr>
            <td colspan="5"> 
                <i>
                    *Saya Menyetujui BPJS Kesehatan menggunakan Informasi Medis Pasien jika diperlukan 
                     <br>*SEP bukan sebagai bukti penjamin peserta
                     <br><strong>{{ !is_null($informasi->prolanisPRB) ? '*Peserta '.$informasi->prolanisPRB : '' }}</strong>
                </i>
            </td>
            <td class="kanan" colspan="1">Dicetak Oleh : {{ Auth::user()->nama_pegawai }}</td>
        </tr>
    </table>
</body>
</html>
<script>
    function printSep(){           
        window.print();
        window.close();        
    }   
</script>