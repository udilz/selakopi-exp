<script>
    $(document).ready(function() {
        //token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $('#table_status_orderan2').DataTable({
            responsive: true,
            lengthCase: true,
            autoWidth:true,
            paging:true,
            searching:true,
            ordering:true,
            info:true,
        });

        $('#table_status_orderan3').DataTable({
            responsive: true,
            lengthCase: true,
            autoWidth:true,
            paging:true,
            searching:true,
            ordering:true,
            info:true,
        });

        $('#table_status_orderan4').DataTable({
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
