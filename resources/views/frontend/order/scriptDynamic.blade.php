<script>
    $(document).ready(function () {
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
