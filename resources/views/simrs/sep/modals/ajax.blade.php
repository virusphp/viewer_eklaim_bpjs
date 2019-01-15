<script type="text/javascript">

// Start Modal 
function getStart()
{
    // $('#asalRujukan').find("option[selected]").removeAttr('selected');
    $('#asalRujukan').prop('selectedIndex',0);
    $('#frame_error').hide();
    $('#klsRawat').attr('readonly', false);
    $('#klsRawat').attr('disabled', false);
    $('#ppk_rujukan').val("");
    $('#diagAwal').val("");
    $('#tujuan').val("");
    $('#kd_diagnosa').val("");
    $('#kd_poli').val("");
    $('#asal_rujukan').val("");
    $('#nama_faskes').val("").attr('readonly', false);
    $('#catatan').val("");
    $('#penjamin').val('0');
    $('#c_penjamin').prop('checked', false);
    $('#form-skdp').hide();
    $('#form-penjamin1').hide();
    $('#form-penjamin2').hide();
    $('#form-katarak').hide();
    $('#noSurat').val("000000");
    $('#noSuratLama').val("000000")
    $('#kd_dpjp').val("000000");
    $('#ket_kill').val("0");

    $('#data-asal-pasien').hide();
    $('#data-instansi').hide();
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
        $('#nama_pelayanan b').append('<span>Rawat Jalan</span>');
        // $('#hak_kelas').css('display', 'none').removeAttr('name');
        // $('#kelas').removeAttr('style').attr('name','klsRawat');
        $('#klsRawat').attr('disabled','true');
        $('#poli-tujuan b').append('<span>Poli Tujuan : '+data.nama_sub_unit+'</span>');
        // $('#status-prb b').append('<span>Poli Tujuan : '+data.nama_sub_unit+'</span>');
        $('#data-asal-pasien').show();
        $('#data-instansi').show();
        getAsalPasien(data.asalPasien);
        getNamaInstansi(data.kdInstansi)
    } else {
        $('#nama_pelayanan').val('Rawat Inap');
        getDokterDpjp();
        getHistory();
    }
    getKelas();
    // getPRujukanppkpkAsal();
    getPeserta();
}

function getKelas()
{
    var url = '{{ route('bpjs.kelas') }}',
        method = 'GET';
    $.ajax({
        url: url,
        method: method,
        data: {},
        success: function(res) {
            $('#klsRawat').removeAttr('style').attr('name','klsRawat');
            $('#klsRawat').html(res);
        }
    }) 
}

function getAsalPasien(data)
{
    var url = '{{ route('simrs.asalpasien') }}',
        method = 'GET';
    $.ajax({
        url: url,
        method: method,
        data: {},
        success: function(res) {
            $('#asalPasien').html(res);
            $('#asalPasien option[value='+data+']').attr('selected','selected').closest('#asal_pasien');
        }
    }) 
}

function getNamaInstansi(data)
{
    var url = '{{ route('simrs.namainstansi') }}',
        method = 'GET';
    $.ajax({
        url: url,
        method: method,
        data: {},
        success: function(res) {
            console.log(data);
            $('#namaInstansi').html(res);
            $('#namaInstansi option[value='+data+']').attr('selected','selected').closest('#nama_instansi');
            $("#namaInstansi").select2({
                placeholder: 'Select an option'
            });
        }
    }) 
}

//get data edit SEP
function getEditSep(data)
{
    $('#noRujukan').focus();
    $('#noRujukan').val(data.noRujukan).attr('readonly', true);
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

    dataSep(data.noSep);
    $('#tglSep').val(data.tglSep);
    
    if($('#jns_pelayanan').val() == 2) {
        $('#nama_pelayanan').val('Rawat Jalan');
        $('#klsRawat').attr('disabled','true');
        $('#poli-tujuan b').append('<span>Poli Tujuan : '+data.nama_sub_unit+'</span>');
        $('#data-asal-pasien').show();
        $('#data-instansi').show();
        getAsalPasien(data.asalPasien);
        getNamaInstansi(data.kdInstansi)
    } else {
        $('#nama_pelayanan').val('Rawat Inap'); 
    }     
    getKelas();
    getHistory();
    getDataSep();
    getDokterDpjp();
    getPeserta();
  
}

 // iki PR
function dataSep(noSEP)
{
    $.ajax({
        type: 'get',
        url: '{{ route('bpjs.sep') }}',
        data : {sep: noSEP},
        success: function(data) {
            d = JSON.parse(data).response
            $("#catatan").val(d.catatan)
        }
    })
}

// iki PR
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
                        $('#tglRujukan').val(response.tglKunjungan).attr('readonly', 'true');
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

function ceNoSurat()
{
    var noRujukan = $('#noRujukan').val(),
        url = '{{ route('nosurat.internal.one') }}',
        method = 'GET';

    $.ajax({
        url: url,
        method: method,
        data: { noRujukan: noRujukan },
        success: function(res) {
            if (res.length == 0) {
            //     console.log('benar');
            //     $('#txtkodeDPJP').removeAttr('style').attr('name', 'dokterDPJP');
            //     $('#kodeDPJP').css('display', 'none').removeAttr('name');
            //     $("#kodeDPJP").val([]).trigger("change")
            //     $("#kodeDPJP .selection").css('display','none');
                $("#kodeDPJP").select2({
                    placeholder: 'Select an option'
                });
            } else {
            //     console.log('salah');
            //     $('#txtkodeDPJP').css('display', 'none').removeAttr('name');
            //     $('#kodeDPJP').removeAttr('style').attr('name','dokterDPJP');
            //     $("#kodeDPJP .select2").removeAttr('style');
            //     $("#kodeDPJP span .select2-container").removeAttr('style');
                $("#kodeDPJP").select2({
                    placeholder: 'Select an option'
                });
            }
        }
    })
}

function getDataSep()
{
    var noSep = $('#noSep').val(),
        noReg = $('#no_reg').val(),
        url = '{{ route('sep.edit') }}',
        method = 'GET';
    if (noSep.length < 1) return;
    $.ajax({
        method: method,
        url: url,
        data: {
            noSep: noSep, noReg: noReg
        },
        success: function(response) {
            // console.log(response);
            if($('#jns_pelayanan').val() == 2) {
                getSkdp();
                $('#nama_pelayanan').val('Rawat Jalan');
            } else {
                $('#nama_pelayanan').val('Rawat Inap');
                // $('#tujuan').attr('readonly','true');
                getSkdp();
                $('#kd_poli').val("000");
                $('#noRujukan').val(response.No_Rujukan);
            }
            $('#noRujukan').val(response.No_Rujukan).attr('readonly', 'true');
            $('#tglRujukan').val(response.Tgl_Rujukan).attr('readonly', 'true');
            $('#ppk_rujukan').val(response.Kd_Faskes);
            $('#diagAwal').val(response.Nama_Diagnosa);
            $('#kd_diagnosa').val(response.Kd_Diagnosa).attr('readonly','true');
            $('#tujuan').val(response.Nama_Poli);
            $('#kd_poli').val(response.Kd_Poli).attr('readonly','true');
            $('#catatan').val(response.catatan);
            // $('#asalRujukan option[value='+response.Asal_Faskes+']').attr('selected','selected').closest('#asalRujukan').attr('disabled','true');
            $('#nama_faskes').val(response.Nama_Faskes).attr('readonly', 'true');
            $('#noSuratLama').val(response.no_surat_kontrol).attr('readonly', 'true');
            $('#noSurat').val(response.no_surat_kontrol);
            $('#noSuratLama').prop('type', 'text');
            $('#noSurat').prop('type', 'hidden');
           
            $('#kd_dpjp').val(response.kd_dpjp).attr('readonly', 'true');
            $('#kodeDPJP').val(response.kd_dpjp);
            $('#edit-modal-sep').append('<span>'+response.no_SJP+'</span>');
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
                var noReg = $('#no_reg').val().substr(0,2);
                // $('#kelas').val(response.hakKelas.keterangan);
                $('#aktif').val(response.statusPeserta.keterangan+' '+response.jenisPeserta.keterangan);
                $('#klsRawat option[value='+response.hakKelas.kode+']').attr('selected','selected').closest('#hak_kelas');
                if (response.informasi.prolanisPRB !== null) {
                    $('#status-prb b').append('<span>Informasi Peserta : '+response.informasi.prolanisPRB+'</span>');
                } 
                if ( $('#jns_pelayanan').val() == 2 && noReg == "03" ) {
                    // console.log(response.provUmum.nmProvider);
                    $('#nama_faskes').val(response.provUmum.nmProvider);
                    $('#ppk_rujukan').val(response.provUmum.kdProvider);
                    // $('#tgl_rujukan').attr('readonly', false);
                }
            }
        }
    })
} 

// History pengunjung
function getHistory()
{
    var no_kartu = $('#no_kartu').val(),
        url = '{{ route('bpjs.cekhistory') }}',
        method = 'GET',
        akhir = moment().format("YYYY-MM-DD");
    if (no_kartu.length < 1) return;
    $.ajax({
        method: method,
        url: url,
        data: {no_kartu:no_kartu, akhir:akhir},
        success: function(response) {
            // console.log(response.diagnosa);
            // ini SKO
            if ($('#jns_pelayanan').val() == 2 && response.jnsPelayanan == 1) {
                $('#asalRujukan option[value='+2+']').attr('selected','selected').closest('#asalRujukan').attr('disabled','true');
                $('#noRujukan').val(response.noSep).attr('readonly',true);
                $('#nama_faskes').val(response.ppkPelayanan).attr('readonly',true);
                $('#ppk_rujukan').val(response.noSep.substr(0,8)).attr('readonly',true);
                $('#tglRujukan').val(response.tglSep);
                $('#form-skdp').show();
                $('#noSurat').val("000000");
            // ini SPO
            } else if ($('#jns_pelayanan').val() == 1) {

                $("#asalRujukan option").each(function(){
                    if($(this).val()==2){ 
                        $(this).prop("selected", true).attr('selected',true).closest('#asalRujukan');
                    }
                });
                // $('#asalRujukan option[value='+2+']').attr('selected','selected').closest('#asalRujukan');
                // $('#noRujukan').val(response.noSep).attr('readonly',true);
                $('#nama_faskes').val("RSUD KRATON");
                $('#ppk_rujukan').val("1105R001");
                $('#tglRujukan').val(response.tglSep);
                $('#form-skdp').show();
                $('#noSurat').val("000000");
                $('#kd_poli').val("000");
                $('#tujuan').val("000").attr('readonly', true);
                ceNoSurat();
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
            // console.log(data.response.faskes[0]); 
            // response = d.response.faskes[0];
            $('#nama_faskes').val(data.response.faskes[0].nama).attr('readonly',true);
            $("#asalRujukan option").each(function(){
                if($(this).val()==data.response.faskes[0].jenis_faskes){ 
                    $(this).prop("selected", true).attr('selected',true).closest('#asalRujukan').attr('disabled','true');
                }
            });
        }
    })
}

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

function getSRI() {
    $("#asalRujukan").val([2]);
    $("#tujuan").val("");
    $("#kd_poli").val("000");
    $('#asalRujukan option[value='+2+']').attr('selected','selected').closest('#asalRujukan');
    $('#nama_faskes').val("RSUD KRATON");
    $('#ppk_rujukan').val("1105R001");
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

function getDokterDpjp()
{
    $.ajax({
        type: 'get',
        url: '{{ route('bpjs.dpjp') }}',
        data: {},
        success: function(data) {
            $("#kodeDPJP").html(data);
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

$('#noRujukan').keydown(function(e) {
    var rujukan = $('#noRujukan').val();
    if (rujukan.length > 18) {
        if(e.keyCode !== 8 && e.keyCode !== 9 && e.ctrlKeye !== true && e.keyCode !== 65) {
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

$('#txtkodeDPJP').keydown(function(e) {
    var rujukan = $('#txtkodeDPJP').val();
    if (rujukan.length > 18) {
        if(e.keyCode !== 8 && e.keyCode !== 9 && e.ctrlKeye !== true && e.keyCode !== 65) {
            e.preventDefault();
        }
    }
});

$('#txtkodeDPJP').keyup(function() {
    if(this.value.length > 1) return;
    if ($(this).val().length == 0) {
        $('#kd_dpjp').val("00000");
    }
});

$('#diagAwal').keydown(function(e) {
    var diagnosa = $('#diagAwal').val();
    if (diagnosa.length > 6) {
        if(e.keyCode !== 8 && e.keyCode !== 9 && e.ctrlKeye !== true && e.keyCode !== 65) {
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
        if(e.keyCode !== 8 && e.keyCode !== 9 && e.ctrlKeye !== true && e.keyCode !== 65) {
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