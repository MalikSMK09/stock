 <?php 

 include "configuration/config_connect.php";

 if($_POST['rowid']) {
        $id = $_POST['rowid'];
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap



        $sql = "SELECT * FROM payment WHERE nota = $id and tipe=2";
        $result = mysqli_query($conn,$sql);
        $baris =mysqli_fetch_assoc($result); ?>


        <form action="penjualan" method="post">



             <div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Nota:</label>
                  <div class="col-sm-9">
                    <input type="text" name="nota" class="form-control" value="<?php echo $id;?>" readonly>
                  </div>
                </div>
        </div>

             <div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Tanggal:</label>
                  <div class="col-sm-9">
                    <?php if ($baris['payday']!="" || $baris['payday']!= null){?>
                    <input type="text" class="form-control" value="<?php echo $baris['payday'];?>"  readonly="">
                    <?php } else {?> <input type="date" class="form-control" name="payday"  > <?php }?>
                  </div>
                </div>
        </div>

<div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Metode:</label>
                  <div class="col-sm-9">
                    <?php if ($baris['cara']!="" || $baris['cara']!= null){?>
                    <input type="text" class="form-control" value="<?php echo $baris['cara'];?>"  readonly="">
                    <?php } else {?> 

                     <select class="form-control select2" style="width: 100%;" name="cara">
                        
                        <option value="Cash">Cash</option>
                      <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $sql=mysqli_query($conn,"select * from options where tipe='pay' ");
        while ($row=mysqli_fetch_assoc($sql)){
          echo "<option value='".$row['nama']."' >".$row['nama']."</option>";
        }
      ?>

                    </select>
                    <?php }?>
                  </div>
                </div>
        </div>

<div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Bank:</label>
                  <div class="col-sm-9">
                      <?php if ($baris['bank']!="" || $baris['bank']!= null){?>
                    <input type="text" class="form-control" value="<?php echo $baris['bank'];?>"  readonly="">
                    <?php } else {?>  <select class="form-control select2" style="width: 100%;" name="bank">
                        
                        <option value="BCA">BCA</option>
                      <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $sql=mysqli_query($conn,"select * from options where tipe='bank' ");
        while ($row=mysqli_fetch_assoc($sql)){
          echo "<option value='".$row['nama']."' >".$row['nama']."</option>";
        }
      ?>

                    </select> <?php }?>
                  </div>
                </div>
        </div>
<div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">REF:</label>
                  <div class="col-sm-9">
                      <?php if ($baris['ref']!="" || $baris['ref']!= null){?>
                    <input type="text" class="form-control" value="<?php echo $baris['ref'];?>"  readonly="">
                    <?php } else {?>  
                    <textarea style="width:100%;" name="ref"></textarea>
                    <?php }?>
                  </div>
                </div>
        </div>

              </div>
              <div class="form-group">
                <?php if ($baris['cara']=="" || $baris['cara']== null){?>
                <button type="submit" class="btn pull-left btn-flat btn-primary" name="simpan">Simpan Pembayaran</button>
              <?php } ?>
               
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->





            






            <!-- /.box-body -->

          
        </form>
        
<?php   }  ?>

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