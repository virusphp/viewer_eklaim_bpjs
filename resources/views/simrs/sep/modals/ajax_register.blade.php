<script type="text/javascript">
    function r_getStart()
    {
        var form = $('#r_form-pasien');
            form[0].reset();
        $('#r_frame_error').hide();
        $('#r_frame_success').hide();
        $('#r_poli').attr('readonly', true);
        $('#r_tarif').attr('readonly', true);
        $('#r_kdDokter').attr('readonly', true);
        $('#r_jnsPasien').attr('readonly', true);
        var form = $('#form-pasien')
            // Reset validationo error
            form.find('.invalid-feedback').remove();
            form.find('input').removeClass('is-invalid');
    }

    // $('.modal').on('hidden.bs.modal', function(){
    //     $(this).find('form')[0].reset();
        
        
    // });

    $('#r_nama_poli').keyup(function() {
        if(this.value.length > 1) return;
        if ($(this).val().length == 0) {
            $('#r_poli').val("");
            $('#r_tarif').val("");
            $('#r_kd_tarif').val("");
            $('#r_rek_p').val("");
            $("#r_kdDokter").val([]).trigger("change")
        }
    });

    function r_resetAll(){
        $('#r_frame_error').hide();
        $('#r_error_reg').remove();
    }

    function r_resetSuccessReg() {
        $('#r_frame_success').hide();
        $('#r_success_reg').remove();
    }
</script>