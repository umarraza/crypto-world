$(document).ready( function () {

    $('#myTable').DataTable();

    var par = document.getElementById('par');
    var div = document.getElementById('div');
    var w = 100;
    div.style.width = w + '%';
    var s = 0;
    function movefunction() {
        par.style.left = s +'%';
        if (s <= 0 - w+1) {
            s = w-1;
        }else {
            s=s-1;
        }
    }
    window.onload = setInterval(movefunction,30);
} );