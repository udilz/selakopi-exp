<script>
    $(document).ready(function () {
        //token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        //reload page otamatis
        setTimeout(function(){
            window.location.reload(1);
        }, 10000);

        $('#table_status_orderan').DataTable({
            responsive: true,
            lengthCase: true,
            autoWidth:true,
            paging:true,
            searching:true,
            ordering:true,
            info:true,
        });

    });
</script>
