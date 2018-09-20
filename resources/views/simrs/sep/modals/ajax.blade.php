<script type="text/javascript">
// Hak kelas Peserta
function getPeserta()
{
    var no_kartu = $('#no_kartu').val(); 
    var tgl_sep = moment().format("YYYY-MM-DD");
    $.ajax({
        type: 'get',
        url: '{{ route('bpjs.peserta') }}',
        data: {no_kartu:no_kartu, tgl_sep:tgl_sep},
        success: function(data) {
            d = JSON.parse(data);
            if (d.response !== null) {
                response = d.response.peserta;
                $('#kelas').val(response.hakKelas.keterangan);
                $('#aktif').val(response.statusPeserta.keterangan);
                // console.log(response);
            }
           
        }
    })
} 

$('#no_rujukan').keydown(function(e) {
    var rujukan = $('#no_rujukan').val();
    if (rujukan.length > 18) {
        if(e.keyCode !== 8) {
            e.preventDefault();
        }
    }
});

$('#namadpjp').keydown(function(e) {
    var rujukan = $('#namadpjp').val();
    if (rujukan.length > 18) {
        if(e.keyCode !== 8) {
            e.preventDefault();
        }
    }
});

$('#diagnosa').keydown(function(e) {
    var diagnosa = $('#diagnosa').val();
    if (diagnosa.length > 3) {
        if(e.keyCode !== 8) {
            e.preventDefault();
        }
    }
});

$('#poli').keydown(function(e) {
    var poli = $('#poli').val();
    if (poli.length > 3) {
        if(e.keyCode !== 8) {
            e.preventDefault();
        }
    }
});

function formatReg(no_reg) 
{
    return no_reg.substring(0,2); 
}

// Asal Rujukan
function asalRujukan()
{
    var ppk_rujukan = $('#ppk_rujukan').val();
    $.ajax({
        type: 'get',
        url: '{{ route('bpjs.ppkrujukan') }}',
        data : {ppk_rujukan: ppk_rujukan},
        success: function(data) {
            d = JSON.parse(data);
            response = d.response.faskses[0];
            // console.log(response);
            $('#jns_faskes').val(response.jenis_faskes);
            $('#nama_faskes').val(response.nama);
            if($('#jns_faskes').val() == 1) {
                $('#asal_rujukan').val('Faskes Tingkat 1');
            } else {
                $('#asal_rujukan').val('Faskes Tingkat 2');
            }
        }
    })
}

// Start Modal 
 function getStart()
{
   
    $('#frame_error').hide();
    $('#tgl_rujukan').val("");
    $('#ppk_rujukan').val("");
    $('#diagnosa').val("");
    $('#poli').val("");
    $('#kd_diagnosa').val("");
    $('#kd_poli').val("");
    $('#asal_rujukan').val("");
    $('#nama_faskes').val("");
    $('#catatan').val("");
    $('#penjamin').val('0');
    $('#c_penjamin').prop('checked', false);
    $('#form-skdp').hide();
    $('#form-penjamin1').hide();
    $('#form-penjamin2').hide();
    $('#form-katarak').hide();
    $('#no_surat').val("000000");
    $('#kd_dpjp').val("00000");
    $('#ket_kill').val("0");
    $('#kabupaten option').prop('selected', function() {
        return this.defaultSelected;
    });
    $('#kecamatan option').prop('selected', function() {
        return this.defaultSelected;
    });
    
}

function katarak()
{
    if($('#kd_poli').val() === 'MAT') {
        $('#form-katarak').show();
    } else {
        $('#form-katarak').hide();
    }
}

function getEditItem(data)
{
    $('#no_rujukan').focus();
    $('#no_rujukan').val(data.noRujukan);
    $('#jns_pelayanan').val(data.jnsPelayanan);
    $('#nama_pasien').val(data.nama_pasien);
    $('#no_ktp').val(data.nik);
    $('#tgl_lahir').val(data.tgl_lahir);
    $('#no_rm').val(data.no_rm);
    $('#no_reg').val(data.no_reg);
    $('#alamat').val(data.alamat);
    $('#no_telp').val(data.no_telp);
    $('#no_kartu').val(data.noKartu);
}

function resetSuccessSep() {
        $('#frame_sep_success').hide();
        $('#frame_sep_error').hide();
        $('success_sep').remove();
        $('error_sep').remove();
}

function resetAll(){
    $('#frame_error').hide();
    $('#error_rujukan').remove();
}

function getDiagnosa(kode, nama)
{
    $.ajax({
        type : 'get',
        url : '{{ route('bpjs.diagnosa') }}',
        data: {kode:kode, nama:nama},
        success: function(data) {
            $('#kd_diagnosa').html(data);
        }
    })
}

function getPoli(kode, nama)
{
    $.ajax({
        type : 'get',
        url : '{{ route('bpjs.poli') }}',
        data: {kode:kode, nama:nama},
        success: function(data) {
            $('#kd_poli').html(data);
        }
    })
}
// Penjamin KLL
function getProvinsi()
{
    $.ajax({
        type: 'get',
        url: '{{ route('bpjs.provinsi') }}',
        data: {},
        success: function(data) {
            $("#provinsi").html(data);
        }
    })
}

$('#provinsi').on('change',function() {
    var kd_prov = $(this).val(),
        CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type : 'get',
        url : '{{ route('bpjs.kabupaten') }}',
        data : {kd_prov:kd_prov},
        success: function(data) {
            $('#kabupaten').html(data);
        } 
    })
})

$('#kabupaten').on('change',function() {
    var kd_kab = $(this).val(),
        CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type : 'get',
        url : '{{ route('bpjs.kecamatan') }}',
        data : {kd_kab:kd_kab},
        success: function(data) {
            $('#kecamatan').html(data);
        } 
    })
})

// Checkboox
    $('#c_katarak').click(function() {
        if ($(this).is(':checked')) {
            $('#katarak').val(1);
        } else {
            $('#katarak').val(0);
        }
    })

    $('#c_cob').click(function() {
        if ($(this).is(':checked')) {
            $('#cob').val(1);
        } else {
            $('#cob').val(0);
        }
    })

    $('#c_eksekutif').click(function() {
        if ($(this).is(':checked')) {
            $('#eksekutif').val(1);
        } else {
            $('#eksekutif').val(0);
        }
    })

    $('#c_penjamin').click(function() {
        if ($(this).is(':checked')) {
            $('#penjamin').val(1);
            $('#lakalantas').val(1);
            $('#form-penjamin1').show(500);
            $('#form-penjamin2').show(500);
        } else {
            $('#penjamin').val(0);
            $('#lakalantas').val(0);
            $('#keterangan').val(0);
            $('#form-penjamin1').hide(500);
            $('#form-penjamin2').hide(500);
        }
    })  

// Format date
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    var bulan = [
        'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agus','Sep','Okt','Nov','Des'
    ];
    // if (month.length < 2) month = '0' + month;
    // if (day.length < 2) day = '0' + day;

    return [day, bulan[month], year].join('-');
}

</script>