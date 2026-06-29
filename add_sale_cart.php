

<?php
session_start();
 include "configuration/config_connect.php";
  include "configuration/config_chmod.php";
$halaman = "jual"; // halaman
$dataapa = "Penjualan"; // data
$tabeldatabase = "invoicejual"; // tabel database
$chmod = $chmenu6; // Hak akses Men

 function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(no) as max_id FROM sale ORDER BY no";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = $id_max;
  $sort_num++;
  $new_code = sprintf("%06s", $sort_num);
  return $new_code;
 }
 


function angka($angka){
  $hasil_ribuan = number_format($angka,0,',','.');
  return $hasil_ribuan;
}

?>


              <div class="row">
                <div class="col-md-12">
                  <div class="box box-info">
                    <div class="box-header with-border">
             <b>Daftar Transaksi</b>
           </div>

           <?php
           error_reporting(E_ALL ^ E_DEPRECATED);

           $nota = isset($_POST['nota']) ? mysqli_real_escape_string($conn, $_POST['nota']) : (isset($_GET['nota']) ? mysqli_real_escape_string($conn, $_GET['nota']) : autoNumber());

           $sql    = "select * from invoicejual where nota ='$nota' order by no desc";
           $result = mysqli_query($conn, $sql);
           $rpp    = 15;
           $reload = "$halaman"."?pagination=true";
           $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);



           if ($page <= 0)
           $page = 1;
           $tcount  = mysqli_num_rows($result);
           $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
           $count   = 0;
           $i       = ($page - 1) * $rpp;
           $no_urut = ($page - 1) * $rpp;
           ?>
           <div class="box-body table-responsive">
              <table class="data table table-hover table-bordered">
                  <thead>
                      <tr>
                          <th>No</th>
                         
                          <th>Nama Barang</th>
                          <th style="text-align:center">Jumlah</th>
                          <th style="text-align:center">Harga</th>
                          <th style="text-align:center">Total Pembayaran</th>
           <?php  if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                          <th>Opsi</th>
           <?php }else{} ?>
                      </tr>
                  </thead>
                    <?php
           error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
           while(($count<$rpp) && ($i<$tcount)) {
           mysqli_data_seek($result,$i);
           $fill = mysqli_fetch_array($result);
           ?>
           <tbody>
           <tr>
           <td style="width:10px"><?php echo ++$no_urut;?></td>
          
           <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
           <td style="width:12%"><input type="text" class="form-control input-sm update" data-id="<?php echo $fill['no'];?>" value="<?php echo $fill['jumlah'];?>" data-id='<?php echo $fill['no'];?>'></td>
           
           <td style="width:15%;text-align:center"><?php  echo mysqli_real_escape_string($conn, angka($fill['harga'])); ?></td>


           <td style="width:12%;text-align:center"><?php  echo mysqli_real_escape_string($conn, angka($fill['jumlah']*$fill['harga'])); ?></td>
           <td style="width:7%">

            <a href="" class="btn btn-xs bg-blue" data-toggle="modal" data-target="#edit<?php echo $fill['no'];?>"><?php echo $fill['diskon_persen'];?> <i class="fa fa-percent"> </i></a>


           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
           <button type="button" class="btn btn-danger btn-xs delete" data-id='<?php echo $fill['no'];?>'><i class="fa fa-trash"></i></button>
           <?php } else {}?>
           </td></tr>



           <!-- Modal -->
<div id="edit<?php echo $fill['no'];?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Harga Jual Sebelum Diskon: <?php echo angka($fill['harga_asli']);?></h4>
      </div>
       <form method="get" action="add_jual_new.php" id="formdisk">
      <div class="modal-body">
      



                                                 <script>
                                               function persendisal<?php echo $fill['no'];?>() {
                                                     var total =  document.getElementById('normal<?php echo $fill['no'];?>').value
                                                     var persen = document.getElementById('perdis<?php echo $fill['no'];?>').value;
                                                  
                                                     var hasil = parseFloat(total) * (parseFloat(persen)/100);
                                                     var result= parseFloat(total) - parseFloat(hasil);
                                                     var result= result.toFixed(0)

                                                     if (!isNaN(result)) {
                                                        document.getElementById('diskon<?php echo $fill['no'];?>').value = result;
                                                     }
                                                   if (!$(persen).val(0)){
                                                     document.getElementById('diskon<?php echo $fill['no'];?>').value = "0";
                                                   }
                                               }
                                               </script>



                                                 <script>
                                               function nomdisal<?php echo $fill['no'];?>() {
                                                     var total =  document.getElementById('normal<?php echo $fill['no'];?>').value
                                                     var nom = document.getElementById('diskon<?php echo $fill['no'];?>').value;
                                                  
                                                     var calc = parseFloat(nom) / parseFloat(total);
                                                     var result = parseFloat(calc) * 100;
                                                     var result = result.toFixed(0);
                                                     if (!isNaN(result)) {
                                                        document.getElementById('perdis<?php echo $fill['no'];?>').value = result;
                                                     }
                                                   if (!$(nom).val(0)){
                                                     document.getElementById('perdis<?php echo $fill['no'];?>').value = "0";
                                                   }
                                               }
                                               </script>


 <div class="row">

                <div class="col-xs-4">
                  <label>Diskon (%)</label>
                   <div class="input-group">
                  <input type="hidden" class="form-control" placeholder="Diskon %" name="normal" id="normal<?php echo $fill['no'];?>" value="<?php echo $fill['harga_asli'];?>">
                  <input type="number" class="form-control perdis<?php echo $fill['no'];?>" placeholder="Diskon %" name="perdis<?php echo $fill['no'];?>" id="perdis<?php echo $fill['no'];?>" value="<?php echo $fill['diskon_persen'];?>"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "2" onkeyup="persendisal<?php echo $fill['no'];?>();">
                   <span class="input-group-addon">%</span>
                </div>
                </div>
                <div class="col-xs-8">
                    <label>Harga Setelah Diskon</label>
                  <input type="text" class="form-control diskon<?php echo $fill['no'];?>" placeholder="Harga Setelah Diskon" name="diskon<?php echo $fill['no'];?>" id="diskon<?php echo $fill['no'];?>" value="<?php echo $fill['diskon_harga'];?>" onkeyup="nomdisal<?php echo $fill['no'];?>();">
                  <input type="hidden" class='form-control no<?php echo $fill['no'];?>' name="no<?php echo $fill['no'];?>" id="no<?php echo $fill['no'];?>" value="<?php echo $fill['no'];?>">
                </div>
              </div>




      </div>

      <div class="modal-footer">
      
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
         <button type="button" name="aturdis<?php echo $fill['no'];?>" id="aturdis<?php echo $fill['no'];?>" class="btn bg-blue">Terapkan</button>

      </div>
    </div>
 </form>
  </div>
</div>





<script type="text/javascript">

 $j(document).ready(function(){

  $("#aturdis<?php echo $fill['no'];?>").click(function(){
          
     var no =document.getElementsByClassName('no<?php echo $fill['no'];?>')[0].value
      var diskon =document.getElementsByClassName('diskon<?php echo $fill['no'];?>')[0].value
       var perdis =document.getElementsByClassName('perdis<?php echo $fill['no'];?>')[0].value

  $.ajax({
                    type  : 'POST',
                     async: false,
                    url : "add_sale_diskon.php",
                     data: { no: no, diskon: diskon, perdis: perdis},

                    cache : false,
                    success : function(data){
                        $('#tampil').load("add_sale_cart.php");
                      
                       $('#edit<?php echo $fill['no'];?>').modal('hide');
                    $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();
                 
                    }
                });
  

         });

});
</script>






           <?php
           $i++;
           $count++;
           }

           ?>
           </tbody></table>
           <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>


           </div>

           </div>


         </div>
                  </div>




 <script type="text/javascript">

// update 
function cekharga(id,qty){
   var el = this;
 
  // AJAX Request
      $.ajax({
        url: 'add_sale_update.php',
        type: 'POST',
        data: { id:id,qty:qty },
         cache  : false,
                    success : function(data){
                        $('#tampil').load("add_sale_cart.php");
                       
                        var json = $.parseJSON(data);
                        if(json.status == "gagal"){
                            alert(json.message);
                        }

                    }
      });
   
}



 $j(document).ready(function(){

     $j('.update').keyup(function(){
          
   var id = $(this).data('id');
   var qty = $(this).val();

   var timeout = null;
    clearTimeout(timeout);

     timeout = setTimeout(function ()
        {

        cekharga(id,qty);
 }, 500);

         });

});
</script>







 <script type="text/javascript">
$j(document).ready(function(){

 // Delete 
 $j('.delete').click(function(){
   var el = this;
  
   // Delete id
   var deleteid = $(this).data('id');
 
  
      // AJAX Request
      $.ajax({
        url: 'add_sale_remove.php',
        type: 'POST',
        data: { id:deleteid },
         cache  : false,
                    success : function(data){
                        $('#tampil').load("add_sale_cart.php");
                        }
      });
 

 });

});
</script>