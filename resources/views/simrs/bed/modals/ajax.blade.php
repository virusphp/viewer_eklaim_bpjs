<script type="text/javascript">
    function getStart()
    {
        var form = $('#form-user');
            form[0].reset();
            $('#v-foto').attr('src', '');
            // console.log(image);
        
        var form = $('#form-user')
            // Reset validationo error
            form.find('.invalid-feedback').remove();
            form.find('input').removeClass('is-invalid');
            form.find('textarea').removeClass('is-invalid');
    }

    function resetSuccessUser() {
        $('#frame_user_success').hide();
        $('#frame_user_error').hide();
        $('success_user').remove();
        $('error_user').remove();
    }

    function deleteUser(){
        return confirm('Apa kamu yakin ingin menghapus data ini?!');
    }

    $(document).on('click','#tambah_user', function() {
        $(this).addClass('edit-item-trigger-clicked');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'),
            options = {
                'backdrop' : 'static'
            };

        $('#modal-user').modal(options);
    });

    $('.modal').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
        $('#v-foto').attr('src', '');
    });

</script>