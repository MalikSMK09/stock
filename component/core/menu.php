<?php
include "configuration/config_connect.php";
include "configuration/config_chmod.php";
$nouser= $_SESSION['nouser'];
$user= "SELECT * FROM user WHERE no='$nouser' ";
$query = mysqli_query($conn, $user);
$row  = mysqli_fetch_assoc($query);
$nama = $row['nama'];
$jabatan = $row['jabatan'];
$avatar = $row['avatar'];
$q=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM backset"));
?>


 <aside class="main-sidebar">

                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php  echo $avatar; ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php  echo $nama; ?></p>
                            <a href="#"><i class="fa fa-circle text-online"></i> Online</a>
                            
                        </div>
                    </div>
<br>
                             <ul class="sidebar-menu">
                       <!-- <li class="header">MENU UTAMA</li> -->
                        <li class="treeview">
                            <a href="index"> <i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>

                        </li>



<?php

if($chmenu4 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-th-list"></i> <span>Barang</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="barang"><i class="fa fa-circle-o"></i>Data Barang</a>
                                </li>

                        <?php        if($chmenu4 >= 2 || $_SESSION['jabatan'] == 'admin'){ ?>
                                      <li>
                                    <a href="add_barang"><i class="fa fa-circle-o"></i>Tambah Barang</a>
                                                  </li>
                                                <?php } ?>
                                       <li>
                                    <a href="cetak_barcode"><i class="fa fa-circle-o"></i>Barcode</a>
                                                  </li>
                                        <li>
                                    <a href="kategori"><i class="fa fa-circle-o"></i>Kategori</a>
                                                  </li>
                                        <li>
                                    <a href="merek"><i class="fa fa-circle-o"></i>Brand</a>
                                                  </li>    

                            </ul>
                        </li>



<?php }else{}

if($chmenu5 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-plus"></i> <span>Pembelian</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
          <?php if($chmenu5 >= 2 || $_SESSION['jabatan'] == 'admin'){ ?>
                                      <li>
                                    <a href="add_buy"><i class="fa fa-circle-o"></i>Buat Pembelian</a>
                                                  </li>
                                    <?php } ?>
                                       <li>
                                    <a href="pembelian"><i class="fa fa-circle-o"></i>Data Transaksi</a>
                                                  </li>
                                                  <li>
                                    <a href="hutang_beli"><i class="fa fa-circle-o"></i>Hutang</a>
                                                  </li>
                                                    <li>
                                    <a href="supplier"><i class="fa fa-circle-o"></i>Supplier</a>
                                                  </li>
                                                   <li>
                                    <a href="pembelian_rekap"><i class="fa fa-circle-o"></i>Rekap Pembelian</a>
                                                  </li>

                                                   </ul>
                        </li>

    <?php }else{}

if($chmenu6 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-minus"></i> <span>Sales Invoice</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">

                <?php if($chmenu6 >= 2 || $_SESSION['jabatan'] == 'admin'){ ?>
                               
                                      <li>
                                    <a href="add_sale"><i class="fa fa-circle-o"></i>Buat Invoice</a>
                                                  </li>
                                                <?php } ?>

                                       <li>
                                    <a href="penjualan"><i class="fa fa-circle-o"></i>Data Invoice</a>
                                                  </li>
                                       
                                             

                                     <?php           if($chmenu6 >= 5 || $_SESSION['jabatan'] == 'admin'){ ?>
                                                   <li>
                                    <a href="rekening"><i class="fa fa-circle-o"></i>Rekening</a>
                                                  </li><?php } ?>
                                      

                            </ul>
                        </li>




<?php }else{}
if($chmenu2 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-folder-close"></i> <span>Kasir</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                   <?php if($chmenu2 >= 2 || $_SESSION['jabatan'] == 'admin'){ ?>
                                <li>
                                    <a href="add_jual"><i class="fa fa-circle-o"></i>Transaksi Baru</a>
                                </li>

                                  <?php } ?>
                               
                                        <li>
                                    <a href="retur"><i class="fa fa-circle-o"></i>Data Transaksi</a>
                                                  </li>
                            </ul>
                        </li>



    <?php }else{}



    
if($chmenu3 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-tag"></i> <span>Pelanggan</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="pelanggan"><i class="fa fa-circle-o"></i>Data Pelanggan</a>
                                </li>
                                  <li>
                                    <a href="quotation"><i class="fa fa-circle-o"></i>Penawaran</a>
                                 </li>

                                 <li>
                                    <a href="pelanggan_income"><i class="fa fa-circle-o"></i>Pendapatan</a>
                                 </li>
                            </ul>
                        </li>


  <?php }else{}


if($chmenu7 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class=" glyphicon glyphicon-flash"></i> <span>Pengeluaran Operasional</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">

  <?php              if($chmenu7 >= 2 || $_SESSION['jabatan'] == 'admin'){ ?>
                                  <li>
                                    <a href="add_operasional"><i class="fa fa-circle-o"></i>Tambah Trx</a>
                                                  </li>
                                                <?php } ?>
                                <li>
                                    <a href="operasional"><i class="fa fa-circle-o"></i>Data Operasional</a>
                                </li>
                                                <li>
                                    <a href="tipe_operasional"><i class="fa fa-circle-o"></i>Tipe Pengeluaran</a>
                                                  </li>

                            </ul>
                        </li>


<?php }else{}
              if($chmenu8 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

    <li class="treeview">
          <a href="#"> <i class="glyphicon glyphicon-inbox"></i> <span>Stok</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
            <ul class="treeview-menu">
                <li>
                    <a href="stok_barang"><i class="fa fa-circle-o"></i>Data Stok</a>
                  </li>
                  <li>
                      <a href="stok_masuk"><i class="fa fa-circle-o"></i>Stok Masuk</a>
                    </li>
                     <li>
                      <a href="stok_keluar"><i class="fa fa-circle-o"></i>Stok Keluar</a>
                    </li>
                     <li>
                      <a href="stok_surat"><i class="fa fa-circle-o"></i>Surat Jalan</a>
                    </li>
                <li>
                      <a href="mutasi"><i class="fa fa-circle-o"></i>Mutasi Stok</a>
                    </li>

                    <li>
                      <a href="stok_retur"><i class="fa fa-circle-o"></i>Stok Barang Retur</a>
                    </li>
                   
                      <li>
                        <a href="stok_menipis"><i class="fa fa-circle-o"></i>Stok Menipis</a>
                      </li>

                       <li>
                        <a href="stok_sesuaikan_laporan"><i class="fa fa-circle-o"></i>Penyesuaian Stok</a>
                      </li>
                      <?php              if($chmenu8 >= 2 || $_SESSION['jabatan'] == 'admin'){ ?>
                       <li>
                        <a href="stok_valuasi"><i class="fa fa-circle-o"></i>Valuasi</a>
                      </li><?php } ?>


                </ul>
              </li>


<?php }else{}
  if($chmenu9 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                          <li class="treeview">
                              <a href="#"> <i class="glyphicon glyphicon-stats"></i> <span>Laporan</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                 <ul class="treeview-menu">
                                  <li>
                                      <a href="report_beli"><i class="fa fa-circle-o"></i>Pembelian</a>
                                  </li>
                                   <li>
                                      <a href="report_beli_hutang"><i class="fa fa-circle-o"></i>Hutang Pembelian</a>
                                  </li>
                                  <li>
                                      <a href="report_jual"><i class="fa fa-circle-o"></i>Kasir</a>
                                  </li>
                                   <li>
                                      <a href="report_inv"><i class="fa fa-circle-o"></i>Sales Invoice</a>
                                  </li>
                                  <li>
                                      <a href="report_inv_piutang"><i class="fa fa-circle-o"></i>Piutang Penjualan</a>
                                  </li>

                                  <li>
                                      <a href="report_operasi"><i class="fa fa-circle-o"></i>Operasional</a>
                                  </li>
                                 
                                   <li>
                                      <a href="report_labarugi"><i class="fa fa-circle-o"></i>Laba Rugi</a>
                                  </li>

                              </ul>
                          </li>

<?php }else{}



  


if($chmenu1 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>


              <li class="treeview">
                            <a href=""> <i class="glyphicon glyphicon-user"></i> <span>Manajemen User</span> <span class="pull-right-container"> </span> </a>
                               <ul class="treeview-menu">
                                <li>
                                    <a href="admin"><i class="fa fa-circle-o"></i>Daftar User</a>
                                </li>
                <li>
                <a href="add_jabatan"><i class="fa fa-circle-o"></i>Jabatan User</a>
                               </li>
                               
                              <li>
                <a href="pengumuman"><i class="fa fa-circle-o"></i>Pengumuman</a>
                                                  </li>

                            </ul>
                        </li>
<?php }else{}


if($chmenu10 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>


              <li class="treeview">
                            <a href=""> <i class="glyphicon glyphicon-cog"></i> <span>Pengaturan</span> <span class="pull-right-container"> </span> </a>
                               <ul class="treeview-menu">
                                <li>
                                    <a href="set_general"><i class="fa fa-circle-o"></i>General Setting</a>
                                </li>
                                   <li>
                                <a href="payment_options"><i class="fa fa-circle-o"></i>Metode Bayar</a>
                                                       
                                                                   </li>
                                 <li>
                <a href="set_faktur"><i class="fa fa-circle-o"></i>Layout Faktur</a>
                               </li>
                <li>
                <a href="set_themes"><i class="fa fa-circle-o"></i>Tampilan</a>
                               </li>

                                                       
                                                                   
                
                                                   <li>
                <a href="backup"><i class="fa fa-circle-o"></i>Backup & restore</a>
                                                  </li>
              
                                                                    <li>
                                <a href="set_pin"><i class="fa fa-circle-o"></i>PIN aplikasi</a>
                                                       
                                                                   </li>
            <?php if($q['l153n53']=='1'){?>
                                                  <li>
                <a href="license"><i class="fa fa-circle-o"></i>LISENSI</a>
                                                  </li>
                  <?php } ?>
                                                   <li>
                <a href="license_about"><i class="fa fa-circle-o"></i>Tentang</a>
                                                  </li>
                            </ul>
                        </li>
<?php }else{} 

 ?>


                    </ul>

                </section>
                <!-- /.sidebar -->
            </aside>
