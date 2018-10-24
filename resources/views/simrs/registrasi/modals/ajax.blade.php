<script type="text/javascript">
    function getStart()
    {
        var form = $('#form-pasien');
            form[0].reset();
        $('#poli').attr('readonly', true);
        $('#tarif').attr('readonly', true);
        $('#kdDokter').attr('readonly', true);
        $('#jnsPasien').attr('readonly', true);
        var form = $('#form-pasien')
            // Reset validationo error
            form.find('.invalid-feedback').remove();
            form.find('input').removeClass('is-invalid');
    }

    $('.modal').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
        $('#no_rm').attr('readonly', false);
    });
</script>