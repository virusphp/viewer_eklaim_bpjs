<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SURAT RUJUKAN INTERNAL</title>
    <style type="text/css">
        /* h4 {
            text-align: center;
        } */
        /* table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }        */
      
        .ttd-garis{
            border-bottom: 2px solid;
        }
        
        /* .table-content {
            border-spacing: 0;
        } */
        
        @page {
            margin-top: 10px;
            martin-right: 5px;
            margin-left: 5px;
            margin-bottom: 10px;
        }

        @font-face {
            font-family: 'DOTMATRI';
            src: {{ asset('font-dotmatrix/DOTMATRI.ttf') }};
            src: local('DOTMATRI'), url('./DOTMATRI.woff') format('woff'), url('./DOTMATRI.ttf') format('truetype');
        }

        @media print {
            body {
                font-size: 11pt;
                font-family: "Arial";
            }
        }

        /* @media screen {
            body {
                font-size: 11pt;
                font-family: "Arial";
            }
        }
        
        body {
            background : #ffffff;
            color: #000000;
            margin: 10px 5px 5px 10px;
            font-family: "Arial";
            font-size:11px;
            padding: 1px;
        }
         */
        /* table tr td {
            font-size: 11pt;
            font-family:'Arial';
            padding: 1px;
        } */

        /* i , i strong {
            font-size: 10px;
            vertical-align: top;
        } */
     
        #sep-image {
            width: 250px;
            vertical-align: top;
            /* margin-bottom: 5px; */

        }

        .avatar-view {
            width: 170px;
            height: 25px;
        }

        .terimakasih {
            font-size: 12.5px;
        }

        #sep-title {
            padding-left: 10px;
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
       /* #tgl-sep .tgl-sep, #tgl-sep .tgl-lahir, .no-rm, .tindakan, .ttd-pasien{
            width: 15%;
        }
        #tgl-sep .nilai-tgl-sep, .nilai-no-rm, .ttd-dokter, .g-2 .ttd-garis, #v-noSep, {
            width: 35%;
        }
        #tgl-sep .nilai-tgl-lahir, .kel-pas, .g-1{
            width: 20%;
        } */
        /* #tgl-sep .jns-kel, #tgl-sep .nilai-jns-kel {
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
            font-size: 11px; */
        }
    </style>
</head>
<body id="sep-content" onload="printSep()">
    <table class="table table-borderless table-header">
        <tr>
            <td id="sep-image" rowspan="2">
                <img class="img-responsive avatar-view" src="{{ asset('img/logo-bpjs.png') }}">
            </td>
            <td id="sep-title" colspan="2">
                <p id="sep-title">SURAT RUJUKAN INTERNAl </p> 
            </td> 
        </tr> 
        <tr>
            <td id="sep-title">
                <p id="sep-title">{{ $surat->no_rujukan }}</p> 
            </td>
        </tr> 
    </table>   
    <table class="table table-content">
        <tr>
            <td>Kepada YTH</td>
            <td>:</td>
            <td colspan="4" id="v-noSep">
                RSUD KRATON Pekalongan - poli 
            </td>
        </tr>
        <tr>
            <td colspan="6" class="tgl-sep">Memohono Pemeriksaan dan Penanganan Lebih lanjut : </td>
        </tr>
        <tr>
            <td>No. Kartu</td>
            <td>:</td>
            <td width="38%">wperwer</td>
            <td>No Rujukan</td>
            <td>:</td>
            <td width="28%">ksjfksdjf</td>
        <tr>
            <td>Nama Peserta</td>
            <td>:</td>
            <td>ksjdfksjdfkj</td>
            <td>Tgl. Rujukan</td>
            <td>:</td>
            <td>kjwerkjwekrj</td>
        </tr>
        <tr>
            <td>Tgl. Lahir</td>
            <td>:</td>
            <td>wkjrkwjer</td>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>xsdfsdf</td>
        </tr>
        <tr>
            <td>Diagnosa</td>
            <td>:</td>
            <td colspan="4">xsdfsdfsdf</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td colspan="4"></td>
        </tr>
    </table>
    <table class="table table-ttd">
        <tr>
           <td style="height:10px" colspan="6"></td>
        </tr>
        <tr>
            <td colspan="2" class="terimaksih">
                <p class="terimakasih">
                    Demikian atas bantuannya, diucapkan banyak terimakasih.
                </p>
            </td>
        </tr>
        <tr class="ttd">
            <td sytle="vertical-align: top;"></td>
            <td style="width:20%"></td>
            <td style="width:20%"></td>
            <td style="width:15%" class="ttd-pasien"></td>
            <td style="width:1%"></td>
            <td style="width:15%" class="ttd-dokter">Mengetahui,</td>   
        </tr>
        <tr>
            <td style="height:30px" colspan="6"></td>
        </tr>
        <tr class="ttd-ttd">
            <td sytle="vertical-align: top;"></td>
            <td style="width:20%"></td>
            <td style="width:20%"></td>
            <td style="width:15%"></td>
            <td class="g-gr"></td>
            <td style="width:15%" class="ttd-garis"></td>   
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