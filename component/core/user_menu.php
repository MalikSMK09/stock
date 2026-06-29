<?php
include "configuration/config_connect.php";
include "configuration/config_chmod.php";
$iduser= $_SESSION['id'];
$user= "SELECT * FROM tutor WHERE id='$iduser' ";
$query = mysqli_query($conn, $user);
$row  = mysqli_fetch_assoc($query);
$nama = $row['name'];
$kode = $row['kodetutor'];
$ava = $row['avatar'];
$jabatan= $_SESSION['jabatan'];



$userp= "SELECT * FROM supplier WHERE kode='$kode' ";
$queryp = mysqli_query($conn, $userp);
$rowa  = mysqli_fetch_assoc($queryp);
$foto = $rowa['avatar'];

if ($foto !='' || $foto != null){
    $avatar=$foto;
} else {
    $avatar=$ava;
}
?>
 <aside class="main-sidebar">

                <section class="sidebar ">
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
                            <a href="dashboard"> <i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>

                        </li>


<?php 

$sql="select * from ngajar where kodetutor='$kode'";
        $result=mysqli_query($conn,$sql);

        if (mysqli_num_rows($result)>0){


?>


                       <li class="treeview">
                            <a href="profil_user"> <i class="fa fa-dashboard"></i> <span>Profil Saya</span> </a>

                        </li>


<?php  } else {} ?>
                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-folder-close"></i> <span>Absensi Mengajar</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="absensi"><i class="fa fa-circle-o"></i>Data Absensi</a>
                                </li>
<li>
                                    <a href="add_absensi"><i class="fa fa-circle-o"></i>Tambah Absensi</a>
                                                  </li>

                                                  <li>
                                    <a href="user_klaim"><i class="fa fa-circle-o"></i>Data Klaim</a>
                                                  </li>
                                                   <li>
                                    <a href="add_userklaim"><i class="fa fa-circle-o"></i>Tambah Klaim</a>
                                                  </li>
                            </ul>
                        </li>




                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-folder-close"></i> <span>Pembayaran</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="user_pembayaran"><i class="fa fa-circle-o"></i>Data Pembayaran</a>
                                </li>
<li>
                                    <a href="rekening"><i class="fa fa-circle-o"></i>Info bank</a>
                                                  </li>
                            </ul>
                        </li>





  <li class="treeview">
                            <a href="change_thepass"> <i class="fa fa-dashboard"></i> <span>Ganti Password</span> </a>

                        </li>




              



                    </ul>

                </section>
                <!-- /.sidebar -->
            </aside>
