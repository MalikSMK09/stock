<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
pagination();
?>

<?php
if (!login_check()) {
?>
<meta http-equiv="refresh" content="0; url=logout" />
<?php
exit(0);
}
?>
        <div class="wrapper">
<?php
theader();
menu();
?>
            <div class="content-wrapper">
                <section class="content-header">
</section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
            <div class="col-lg-12">
                        <!-- ./col -->

<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "add_jual_new"; // halaman
$dataapa = "Kasir"; // data
$tabeldatabase = "transaksi_masuk_new"; // tabel database
$chmod = $chmenu2; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman


 function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(RIGHT(nota, 5)) as max_id FROM bayar ORDER BY nota";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = (int) substr($id_max, 1, 5);
  $sort_num++;
  $new_code = sprintf("%05s", $sort_num);
  return $new_code;
 }
 
?>


<!-- SETTING STOP -->

 <!-- Memanggil CSS autccomplete -->
 <link rel="stylesheet" href="libs/autocomplete/autocomplete.css">
     
<body OnLoad="document.barcodeform.barcode.focus();">
<!-- BOX INSERT BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>


       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>
<script>
function setFocusToTextBox(){
    document.getElementById("barcode").focus();
}
</script>

  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
      <div class="box">
      
  <div class="box-header with-border">
 <form class="form-horizontal" method="get" name="barcodeform" id="formmain" class="form-user">

            <div class="row">
         <div class="col-sm-3 col-sm-4 col-lg-3 col-xs-12">
            <input type="text" class="form-control" placeholder="Kode Barcode" name="barcode" id="barcode">
             <input type="hidden" class="form-control" name="kode" id="kode" >
         </div>

           <div class="col-sm-6 col-sm-6 col-lg-6 col-xs-12">
            <input type="text" class="form-control"  placeholder="Nama Barang" id="barang" name="barang">
         </div>

          <div class="col-sm-2 col-sm-2 col-lg-3 col-xs-12">
            <input type="text" class="form-control"  placeholder="jumlah stok" name="stok" id="stok" readonly>
             <input type="hidden" class="form-control" name="nota" id="nota" value="<?php echo autoNumber();?>">
         </div>
     </div>



  </div>


        <div class="box-body">


 
  <div class="row">
        <div class="col-xs-12">
            <button type="button" name="addcart1" id="addcart1" class="btn btn-success btn-block">ENTER | Masukan Keranjang</button>
        </div>
</div>

        </div>
</form>


                                <!-- /.box-body -->
                            </div>
 



 <div id="tampil">

    </div>
  


<script>
var input = document.getElementById("barang");
input.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("addcart1").click();
  }
});

var barcode = document.getElementById("barcode");

barcode.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("scanbarcode").click();
  }
});

</script>





  <div class="row">

        <div class="col-xs-12 col-md-6 col-lg-6">
    <a href="retur.php" class="btn btn-block btn-danger">Kembali</a>
            </div>

             <div class="col-xs-12 col-md-6 col-lg-6">
    <a href="bayar_new.php" class="btn btn-block btn-primary">F9 | Lanjut Bayar</a>
            </div>
     
     </div>





                        </div>

<?php
} else {
?>
   <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa;?> ini .</b>
    </div>
    <?php
}
?>
                        <!-- ./col -->
                    </div>





<script>
document.onkeydown = function(e){
 var isi;
 switch(e.keyCode){
  case 113:
  document.getElementById("barcode").value = "";
    document.getElementById("kode").value = "";
    document.getElementById("barang").value = "";
    document.getElementById("stok").value = "";
  
  break;
  case 115:
   document.getElementById("barcode").focus(); 
  break;
    case 119:
   document.getElementById("barang").focus(); 
  break;
  
  case 120:

   window.location = "bayar_new.php";
  break;
 } 

}
</script>


                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <!-- /.Left col -->
                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php  footer(); ?>
            <div class="control-sidebar-bg"></div>
        </div>
          <!-- ./wrapper -->


 <!-- Memanggil jQuery.js -->
        <script src="libs/autocomplete/jquery-3.2.1.min.js"></script>

        <!-- Memanggil Autocomplete.js -->
        <script src="libs/autocomplete/jquery.autocomplete.min.js"></script>
       


  <script type="text/javascript">

          var $j = jQuery.noConflict();
            $j(document).ready(function() {

                // Selector input yang akan menampilkan autocomplete.
                $j( "#barang" ).autocomplete({
                    serviceUrl: "add_jual_auto.php",   // Kode php untuk prosesing data.
                    dataType: "JSON",           // Tipe data JSON.
                    onSelect: function (suggestion) {
                        $( "#barang" ).val("" + suggestion.nama);
                         $( "#barcode" ).val("" + suggestion.barcode);
                         $( "#stok" ).val("" + suggestion.stok);
                           $( "#kode" ).val("" + suggestion.kode);
                            $("#barang").focus();//this here
                    }
                });
            })
        </script>

 <script src="libs/autocomplete/jquery-1.12.4.js"></script>

 <script type="text/javascript">

 var $g = jQuery.noConflict();

        $g(document).ready(function(){

        function reloadCart(){
            var data = $g('#formmain').serialize();
            $g('#tampil').load("add_jual_auto_cart.php", data);
        }

        reloadCart();
          
            $("#addcart1").click(function(){
                var data = $('#formmain').serialize();
                $.ajax({
                    type  : 'POST',
                    url : "add_jual_insert.php",
                    data: data,

                    cache : false,
                    success : function(data){
                        reloadCart();
                   
                      $("#formmain")[0].reset();

                      var json = $.parseJSON(data);
                        if(json.status == "gagal"){
                            alert(json.message);
                        }

                    }
                });
            });


              $("#scanbarcode").click(function(){
                var data = $('#formmain').serialize();
                $.ajax({
                    type  : 'POST',
                    url : "add_jual_insert_barcode.php",
                    data: data,

                    cache : false,
                    success : function(data){
                        reloadCart();
                      
                      $("#formmain")[0].reset();
                       $("#barcode").focus();//this here

                        var json = $.parseJSON(data);
                        if(json.status == "gagal"){
                            alert(json.message);
                        }

                    }
                });
            });


        });
    </script>










<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="dist/plugins/jQuery/jquery-ui.min.js"></script>

        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
        <script src="dist/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="dist/plugins/morris/morris.min.js"></script>
        <script src="dist/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="dist/plugins/knob/jquery.knob.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="dist/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="dist/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="dist/plugins/fastclick/fastclick.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="dist/js/demo.js"></script>
    <script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="dist/plugins/fastclick/fastclick.js"></script>
    <script src="dist/plugins/select2/select2.full.min.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="dist/plugins/iCheck/icheck.min.js"></script>


<!--AUTO Complete-->

<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'YYYY/MM/DD h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Akhir 7 Hari': [moment().subtract(6, 'days'), moment()],
            'Akhir 30 Hari': [moment().subtract(29, 'days'), moment()],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

   $('.datepicker').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });

   //Date picker 2
   $('#datepicker2').datepicker('update', new Date());

    $('#datepicker2').datepicker({
      autoclose: true
    });

   $('.datepicker2').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
</body>
</html>
