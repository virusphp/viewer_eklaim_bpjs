<script type="text/javascript">

// Start Modal 
function getStart()
{
    $('#frame_error').hide();
    $('#tgl_rujukan').val("");
    $('#ppk_rujukan').val("");
    $('#diagAwal').val("");
    $('#tujuan').val("");
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
    $('#noSurat').val("000000");
    $('#kd_dpjp').val("000000");
    $('#ket_kill').val("0");
    $('#kabupaten option').prop('selected', function() {
        return this.defaultSelected;
    });
    $('#kecamatan option').prop('selected', function() {
        return this.defaultSelected;
    });

   
    //     if (sep.length !== null) {
    //         $('#edit-item').attr('disabled', 'disabled');
    //     }

    var form = $('#form-sep');
    // Reset validationo error
    form.find('.invalid-feedback').remove();
    form.find('input').removeClass('is-invalid');
    form.find('textarea').removeClass('is-invalid');
    
}

// get data SIMRS
function getEditItem(data)
{
    $('#noRujukan').focus();
    $('#noRujukan').val(data.noRujukan).removeAttr('readonly');
    $('#jns_pelayanan').val(data.jnsPelayanan);
    $('#nama_pasien').val(data.nama_pasien);
    $('#no_ktp').val(data.nik);
    $('#tgl_lahir').val(data.tgl_lahir);
    $('#no_rm').val(data.no_rm);
    $('#no_reg').val(data.no_reg);
    $('#alamat').val(data.alamat);
    $('#noTelp').val(data.no_telp);
    $('#no_kartu').val(data.noKartu);
    $('#noSep').val(data.noSep);
    $('#tglSep').val(data.tglSep);
    if($('#jns_pelayanan').val() == 2) {
        $('#nama_pelayanan').val('Rawat Jalan');
    } else {
        $('#nama_pelayanan').val('Rawat Inap');
    }
    getPeserta();
}

//get data edit SEP
function getEditSep(data)
{
    $('#noRujukan').val(data.noRujukan).attr('readonly','true');
    $('#jns_pelayanan').val(data.jnsPelayanan);
    $('#nama_pasien').val(data.nama_pasien);
    $('#no_ktp').val(data.nik);
    $('#tgl_lahir').val(data.tgl_lahir);
    $('#no_rm').val(data.no_rm);
    $('#no_reg').val(data.no_reg);
    $('#alamat').val(data.alamat);
    $('#noTelp').val(data.no_telp);
    $('#no_kartu').val(data.noKartu);
    $('#noSep').val(data.noSep);
    $('#tglSep').val(data.tglSep);
    if($('#jns_pelayanan').val() == 2) {
        $('#nama_pelayanan').val('Rawat Jalan');
    } else {
        $('#nama_pelayanan').val('Rawat Inap');
    }
    getPeserta();
    getDataSep();
    getRujukan();
}

function getRujukan()
{
    var rujukan = $('#noRujukan').val();
    if (rujukan.length < 17) return;
    $.ajax({
            type: 'get',
            url : '{{ route('bpjs.rujukan') }}',
            data : {rujukan: rujukan},
            success: function(data){
                d = JSON.parse(data);
                // console.log(d);
                if (d.response === null) {
                    $('#frame_error').show().html("<span class='text-danger' id='error_rujukan'></span>");
                    $('#error_rujukan').html('No Rujukan tidak ada').hide()
                        .fadeIn(1500, function() { $('#error_rujukan'); });
                        setTimeout(resetAll,3000);
                } else {
                    response = d.response.rujukan;
                    if ($('#no_kartu').val() === response.peserta.noKartu) {
                        $('#tgl_rujukan').val(response.tglKunjungan);
                        $('#ppk_rujukan').val(response.provPerujuk.kode);
                        $('#diagAwal').val(response.diagnosa.nama);
                        $('#kd_diagnosa').val(response.diagnosa.kode).attr('readonly','true');
                        $('#tujuan').val(response.poliRujukan.nama);
                        $('#kd_poli').val(response.poliRujukan.kode).attr('readonly','true');
                        $('#intern_rujukan').val(response.noKunjungan).attr('readonly','true');
                        $('#noRujukan').val(response.noKunjungan);
                        asalRujukan();
                        katarak();
                        getSkdp();

                    } else {
                        $('#frame_error').show().html("<span class='text-danger' id='error_rujukan'></span>");
                        $('#error_rujukan').html('No Rujukan tidak cocok').hide()
                            .fadeIn(1500, function() { $('#error_rujukan'); });
                            setTimeout(resetAll,3000);
                    }
                }
            
            }, 
            error: function() {
                $('#frame_error').show(100);
                $('#error_rujukan').html('Brigding lamban, sedang gangguan server bpjs');
            }
        
        });
}

function getDataSep()
{
    var noSep = $('#noSep').val(),
        url = '{{ route('bpjs.sep') }}',
        method = 'GET';
    if (noSep.length < 1) return;
    $.ajax({
        method: method,
        url: url,
        data: {
            noSep: noSep
        },
        success: function(response) {
            // console.log(response);
            d = JSON.parse(response);
            if (d.response !== null) {
                response = d.response;
                $('#catatan').val(response.catatan);
                $('#edit-modal-sep').append('<span>'+response.noSep+'</span>');
            }
        }
    })
}

// Hak kelas Peserta
function getPeserta()
{
    var no_kartu = $('#no_kartu').val(),
        tgl_sep = moment().format("YYYY-MM-DD");
    if (no_kartu.length < 1) return;
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

// Asal Rujukan // iki PR
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
                $('#asalRujukan').val('Faskes Tingkat 1');
            } else {
                $('#asalRujukan').val('Faskes Tingkat 2');
            }
        }
    })
}

function selectSkdp()
{

}

$('#noRujukan').keydown(function(e) {
    var rujukan = $('#noRujukan').val();
    if (rujukan.length > 18) {
        if(e.keyCode !== 8 && e.keyCode !== 9) {
            e.preventDefault();
        }
    }
});

$('#noSurat').focusout(function() {
    var noSurat = "000000";
    if ($(this).val().length == 0) {
        $('#noSurat').val(noSurat);
    } else if ($(this).val().length >= 1) {
        $('#noSurat').val(autonumber($(this).val()));
    }
})


$('#kodeDPJP').keydown(function(e) {
    var rujukan = $('#kodeDPJP').val();
    if (rujukan.length > 18) {
        if(e.keyCode !== 8 && e.keyCode !== 9) {
            e.preventDefault();
        }
    }
});

$('#kodeDPJP').keyup(function() {
    if(this.value.length > 1) return;
    if ($(this).val().length == 0) {
        $('#kd_dpjp').val("");
    }
});

$('#diagAwal').keydown(function(e) {
    var diagnosa = $('#diagAwal').val();
    if (diagnosa.length > 3) {
        if(e.keyCode !== 8 && e.keyCode !== 9) {
            e.preventDefault();
        }
    }
});

$('#diagAwal').keyup(function() {
    if(this.value.length > 1) return;
    if ($(this).val().length == 0) {
        $('#kd_diagnosa').val("");
    }
});

$('#tujuan').keydown(function(e) {
    var poli = $('#tujuan').val();
    if (poli.length > 3) {
        if(e.keyCode !== 8 && e.keyCode !== 9) {
            e.preventDefault();
        }
    }
});

$('#tujuan').keyup(function() {
    if(this.value.length > 1) return;
    if ($(this).val().length == 0) {
        $('#kd_poli').val("");
    }
});
// Group Penjamin KLL
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
    });
});

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

function autonumber(nilai)
{
  nilai = nilai.toString();
  var spas = "", 
      start = 0, 
      max = 6 - nilai.length;
  for(; start < max; start++)
    spas += "0";
  return spas + nilai;
}

function formatReg(no_reg) 
{
    return no_reg.substring(0,2); 
}

function katarak()
{
    if($('#kd_poli').val() === 'MAT') {
        $('#form-katarak').show();
    } else {
        $('#form-katarak').hide();
    }
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

function getSkdp()
{
    var internal = $('#intern_rujukan').val();
    if (internal !== 0) {
        $.ajax({
            url : '{{ route('rujukan.internal') }}',
            type: 'get',
            data: {internal: internal},
            success: function(data) {
                if (data.length > 0) {
                    $('#form-skdp').show();
                    $('#noSurat').val("000000");
                }
            }
        })
    }

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