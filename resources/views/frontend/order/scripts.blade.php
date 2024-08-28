<script>
    function scrollToHome() {
        var menuSection = document.getElementById(
            'home-section'); // Assuming the menu section has an ID of 'menu-section'
        menuSection.scrollIntoView({
            behavior: 'smooth'
        }); // Scroll smoothly to the menu section
    }

    function scrollToMenu() {
        var menuSection = document.getElementById(
            'menu-section'); // Assuming the menu section has an ID of 'menu-section'
        menuSection.scrollIntoView({
            behavior: 'smooth'
        }); // Scroll smoothly to the menu section
    }

    function scrollToContact() {
        var menuSection = document.getElementById(
            'contact-section'); // Assuming the menu section has an ID of 'menu-section'
        menuSection.scrollIntoView({
            behavior: 'smooth'
        }); // Scroll smoothly to the menu section
    }

    $(document).ready(function() {
        //token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        // // reload page otamatis
        // setTimeout(function(){
        //     window.location.reload(1);
        // }, 10000);

        // $('#tableMenuMakanan').DataTable({
        //     responsive: true,
        //     lengthCase: true,
        //     autoWidth:true,
        //     paging:true,
        //     searching:true,
        //     ordering:true,
        //     info:true,
        // });

        //store keranjang;
        $(document).on('submit', '#orderMakanan', function(e) {
            e.preventDefault();
            let dataForm = this;
            $.ajax({
                type: $('#orderMakanan').attr('method'),
                url: $('#orderMakanan').attr('action'),
                data: new FormData(dataForm),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#orderMakanan').find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {

                        $.each(response.error, function(prefix, val) {
                            $('#orderMakanan').find('span.' + prefix + '_error')
                                .text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            width: 300,
                            title: '<strong>' + response.message + ' !</strong>',
                            icon: 'success',
                            html: '@if (isset($tables)) <a href="{{ route('pelanggan.status_orderan', $tables->no_meja) }}">Lihat Status Orderan<i class="fa fa-home"></i></a>  @endif',
                            // showCloseButton: true,
                            showCancelButton: true,
                            confirmButtonText: '@if (isset($tables)) <a style="color:#fff;" href="{{ route('pelanggan.status_orderan', $tables->no_meja) }}">Ok</a> @endif',
                            focusConfirm: false,
                        });
                        $('#orderMakanan')[0].reset();
                    }
                }
            });
        });

        $('#table_status_orderan').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: true,
            responsive: true,
        });
    });
</script>
