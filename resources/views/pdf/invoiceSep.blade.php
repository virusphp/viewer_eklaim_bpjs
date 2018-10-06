<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CETAK SEP</title>
    <style type="text/css">
        h4 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-left: -50px;
            margin-right: -50px;
            margin-top: -50px;
            margin-bottom: -50px;
        }       
        th {
            height: 15px;
            padding: 8px;
        }
        td {            
            font-family: "Courier, monospace";
            font-size:13px;
            height: 8px;
            padding: 2px;
        }

        .double_underline  {
            border-bottom: 1px black solid;
        }
        #sep-image {
            margin-top: 1px;
            width: 10%;
            vertical-align: top;
        }
        .avatar-view {
            width: 180px;
            height: 25px;
        }
        #sep-title {
            margin-top: 1px;
            padding-left: 2.8em;
            width: 100%;
            font-size: 15px;
        }
        #sep-title-2 {
            margin-top: -50px;
            padding-left: 4em;
            width: 90%;
            font-size: 15px;
        }
        #tgl-sep .tgl-sep, #tgl-sep .tgl-lahir, .no-rm, .tindakan{
            width: 15%;
        }
        #tgl-sep .nilai-tgl-sep, .nilai-no-rm, .dpjp, .g-2 {
            width: 30%;
        }
        #tgl-sep .nilai-tgl-lahir, .kel-pas, .g-1{
            width: 20%;
        }
        #tgl-sep .jns-kel, #tgl-sep .nilai-jns-kel{
            width: 10%;
        }
        .no-rm, .nilai-no-rm, .alamat-p, .nilai-alamat-p, .tt-dua, .asal-fks, .nama-fks, .diagnosa, .nilai-diagnosa{
            vertical-align: top;
        }
        .blanked {
            width: 35%;
        }
    </style>
</head>
<body>
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
        <tr style="width:30px">
            <td colspan="2"></td>                            
        </tr>                       
    </table>   
    <table class="table table-content">
        <tr>
            <td>No. SEP</td>
            <td>:</td>
            <td>12458477</td>
            <td>Nama Peserta</td>
            <td>:</td>
            <td>Sugandi</td>
        </tr>
        <tr id="tgl-sep">
            <td class="tgl-sep">Tanggal SEP</td>
            <td>:</td>
            <td class="nilai-tgl-sep">6 Oktober 2018</td>
            <td class="tgl-lahir">Tanggal Lahir</td>
            <td>:</td>
            <td class="nilai-tgl-lahir">9 September 1999</td>
            <td class="jns-kel">Jns Kel</td>
            <td>:</td>
            <td class="nilai-jns-kel">L</td>
        </tr>
        <tr>
            <td class="no-rm">No. RM</td>
            <td class="tt-dua">:</td>
            <td class="nilai-no-rm">123456</td>
            <td rowspan="3" class="alamat-p">Alamat Pasien</td>
            <td rowspan="3" class="tt-dua">:</td>
            <td rowspan="3" colspan="4" class="nilai-alamat-p">Krapyak Lor Nomor 33 RT 2 RW 99 Kec.Bojong Kab.Pekalongan Provinsi Jawa Tengah</td>
        </tr>
        <tr>
            <td>No. Registrasi</td>
            <td>:</td>
            <td>01254685788</td>
        </tr>
        <tr>
            <td>No. Kartu</td>
            <td>:</td>
            <td>337524415458</td>
        </tr>
        <tr>
            <td>Poli Tujuan</td>
            <td>:</td>
            <td>Hati</td>
            <td>Peserta</td>
            <td>:</td>
            <td colspan="4">PBI (APBN)</td>
        </tr>
        <tr>
            <td class="asal-fks">Asal Faskes Tk. I</td>
            <td class="tt-dua">:</td>
            <td class="nama-fks">Krapyak Kidul</td>
            <td>COB</td>
            <td>:</td>
            <td colspan="4">0</td>
        </tr>
        <tr>
            <td>Antrian</td>
            <td>:</td>
            <td>1</td>
            <td>Jenis Rawat</td>
            <td>:</td>
            <td colspan="4">Rawat Hati</td>
        </tr>
        <tr>
            <td rowspan="2" class="diagnosa">Diagnosa Awal</td>
            <td rowspan="2" class="tt-dua">:</td>
            <td rowspan="2" class="nilai-diagnosa">LOV Cinta yang mekar seperti bunga matahari</td>
            <td>Kls Tanggungan</td>
            <td>:</td>
            <td colspan="4">VVIP</td>
        </tr>
        <tr>
            <td>Catatan</td>
            <td>:</td>
            <td colspan="4">Jatuh cinta berkali kali</td>
        </tr>
        <tr>
            <td>Diagnosa Utama</td>
            <td>:</td>
            <td>LOVE Seperti Cinta Mekar</td>
            <td>Penjamin</td>
            <td>:</td>
            <td colspan="4">BPJS</td>
        </tr>        
    </table>
</body>
</html>