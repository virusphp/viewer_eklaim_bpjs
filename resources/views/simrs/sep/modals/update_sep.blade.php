<script type="text/javascript">

$(document).on('click', "#edit-sep", function(e) {
    $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
    var date = moment().format("YYYY-MM-DD"),
        no_reg = $(this).val(),
        CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'),
        options = {
            'backdrop' : 'static'
        },
        method = 'GET',
        url = '{{ route('sep.ubah') }}';
    $('input#tgl_reg').val(formatDate(date));
    $('#cetak-sep').attr('id','update-sep').val('Update Sep').removeClass('btn-primary').addClass('btn-warning');
    getStart();
    $.ajax({
        method: method,
        url: url,
        data: {
            _token: CSRF_TOKEN,
            no_reg: no_reg
        },
        success: function(response) {
            getEditSep(response);
        }

    });
    $('#modal-sep').modal(options);
});

// Update Sep
$(document).on('click','#update-sep', function(e) {
    var form = $('#form-sep'),
            method = 'PUT',
            url = '{{ route('sep.update') }}';
    
    // Reset validationo error
    form.find('.invalid-feedback').remove();
    form.find('input').removeClass('is-invalid');
    form.find('#asalRujukan').prop('disabled', false);
    form.find('#klsRawat').prop('disabled', false);
    $.ajax({
        method: method,
        url: url,
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
            // console.log(response);
            if (response.response !== null) {
                $('#frame_sep_success').show().html("<span class='text-success' id='success_sep'></span>");
                $('#success_sep').html(response.metaData.message+" update No SEP :"+response.response).hide()
                    .fadeIn(1500, function() { $('#success_sep'); });
                setTimeout(resetSuccessSep,4000);
                ajaxLoad();
                $('#modal-sep').modal('hide');
            } else {
                $('#frame_error').show().html("<span class='text-danger' id='error_sep'></span>");
                $('#error_sep').html(response.metaData.message+" Silahkan lengkapi").hide()
                    .fadeIn(1500, function() { $('#error_sep'); });
                setTimeout(resetAll,4000);
            }
        },
        error: function(xhr) {
            var errors = xhr.responseJSON; 
            errorsHtml = '<ul>';
            $.each( errors.errors, function( key, value ) {
                $("#" + key)
                        .addClass('is-invalid')
                        .closest('.form-group')
                        .append('<span class="invalid-feedback"><strong>' +value[0]+ '</strong></span>');
            });
        }
    });
});
</script>