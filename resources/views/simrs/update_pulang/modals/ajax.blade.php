<script type="text/javascript">

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

// Format date
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    var bulan = [
        'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agus','Sep','Okt','Nov','Des'
    ];
    // if (day.length < 2) day = '0' + day;

    return [day, bulan[month], year].join('-');
}

</script>