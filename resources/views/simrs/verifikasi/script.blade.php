<script>
$(function () {
            var checkAll = $('input.all');
            var checkboxes = $('input.check-modules');

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });

            checkAll.on('ifChecked ifUnchecked', function (event) {
                if (event.type == 'ifChecked') {
                    checkboxes.iCheck('check');
                } else {
                    checkboxes.iCheck('uncheck');
                }
            });

            checkboxes.on('ifChanged', function (event) {
                if (checkboxes.filter(':checked').length == checkboxes.length) {
                    checkAll.prop('checked', 'checked');
                } else {
                    checkAll.prop('checked', '');
            }
            
            checkAll.iCheck('update');
        });

        checkboxes.on('ifChecked ifUnchecked', function (event) {
            var checkAccess = $(this).parents('tr').find('.check-access');
            if (event.type == 'ifChecked') {
                checkAccess.iCheck('check');
            } else {
                checkAccess.iCheck('uncheck')
            }
        })

        $('.check-access').on('ifChanged', function () {
            var checkAccess = $(this).parents('tr').find('.check-access');
            var checkModule = $(this).parents('tr').find('.check-modules');

            if (checkAccess.filter(':checked').length == checkAccess.length) {
                checkModule.prop('checked', 'checked');
            } else {
                checkModule.prop('checked', '');
            }
            
            checkModule.iCheck('update');

            if (checkboxes.filter(':checked').length == checkboxes.length) {
                checkAll.prop('checked', 'checked');
            } else {
                checkAll.prop('checked', '');
            }
            
            checkAll.iCheck('update');
        })
    });
</script>