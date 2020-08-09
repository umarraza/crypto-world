$(document).ready( function () {


    $('#close-sidebar').on('click', function() {
        $('#kt_aside').attr('style', 'width: 0px !important');
    });

    $('#open-sidebar').on('click', function() {
        $('#kt_aside').attr('style', 'width: 250px !important');
    });

    $('#myTable').DataTable();
} );