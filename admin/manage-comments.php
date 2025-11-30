<?php
   session_start(); //Mengaktifkan sesi agar admin yang login bisa dikenali.
   include('includes/config.php'); //Memasukkan file konfigurasi database.
   error_reporting(0); //Menyembunyikan pesan error dari tampilan browser.
   if(strlen($_SESSION['login'])==0) //Memeriksa apakah admin sudah login atau belum.
     { 
   header('location:index.php'); //Mengarahkan ke halaman login jika belum login.
   }
   else{ //Jika sudah login, lanjutkan ke halaman manajemen komentar.
   // Code for disapprove
    if( $_GET['disid'])  //Memeriksa apakah ada aksi penolakan komentar.
   {
    $id=intval($_GET['disid']); //Mengambil ID komentar yang akan di-disapprove dari parameter URL.
    $query=mysqli_query($con,"update tblcomments set status='0' where id='$id'"); //Mengubah status komentar menjadi 0 (tidak disetujui) di database.
    $msg="Comment unapprove "; //Menyiapkan pesan sukses jika komentar berhasil di-disapprove.
   }
   // Code for restore
   if($_GET['appid']) //Memeriksa apakah ada aksi persetujuan komentar.
   {
    $id=intval($_GET['appid']); //Mengambil ID komentar yang akan disetujui dari parameter URL.
    $query=mysqli_query($con,"update tblcomments set status='1' where id='$id'"); //Mengubah status komentar menjadi 1 (disetujui) di database.
    $msg="Comment approved"; //Menyiapkan pesan sukses jika komentar berhasil disetujui.
   }
   
   // Code for deletion
   if($_GET['action']=='del' && $_GET['rid']) //Memeriksa apakah ada aksi penghapusan komentar.
   {
    $id=intval($_GET['rid']); //Mengambil ID komentar yang akan dihapus dari parameter URL.
    $query=mysqli_query($con,"delete from  tblcomments  where id='$id'"); //Menghapus komentar dari database.
    $delmsg="Comment deleted forever"; //Menyiapkan pesan sukses jika komentar berhasil dihapus.
   }
   
   ?>
       
        <!-- Top Bar Start -->
        <?php include('includes/topheader.php');?>
        <!-- ========== Left Sidebar Start ========== -->
        <?php include('includes/leftsidebar.php');?>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Manage Approved Comments</h4> <!-- Judul halaman manajemen komentar yang disetujui. -->
                                <ol class="breadcrumb p-0 m-0"> 
                                    <li>
                                        <a href="#">Admin</a> <!-- Breadcrumb navigasi untuk admin. -->
                                    </li>
                                    <li>
                                        <a href="#">Comments </a> <!-- Breadcrumb navigasi untuk komentar. -->
                                    </li>
                                    <li class="active"> <!-- Breadcrumb navigasi untuk halaman saat ini. -->
                                         Manage
                                        Approved Comments
                                    </li>
                                </ol>
                                <div class="clearfix"></div> <!-- Membersihkan float pada elemen sebelumnya. -->
                            </div>
                        </div>
                    </div>
                  
                    <!-- end row -->
                    <div class="row">
                        <div class="col-sm-6">
                            <?php if($msg){ ?> <!-- Memeriksa apakah ada pesan sukses yang disiapkan. -->
                            <div class="alert alert-success" role="alert"> <!-- Menampilkan pesan sukses dalam kotak peringatan hijau. -->
                                <strong>Well done!</strong> <?php echo htmlentities($msg);?> <!-- Menampilkan pesan sukses yang telah disiapkan. -->
                            </div>
                            <?php } ?>
                            <?php if($delmsg){ ?> <!-- Memeriksa apakah ada pesan penghapusan yang disiapkan. -->
                            <div class="alert alert-danger" role="alert"> <!-- Menampilkan pesan penghapusan dalam kotak peringatan merah. -->
                                <strong>Oh snap!</strong> <?php echo htmlentities($delmsg);?> <!-- Menampilkan pesan penghapusan yang telah disiapkan. -->
                            </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="demo-box m-t-20">
                                    <div class="table-responsive">
                                        <table class="table m-0 table-bordered" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th> Name</th>
                                                    <th>Email Id</th>
                                                    <th>Comment</th>
                                                    <th>Status</th>
                                                    <th>Post / News</th>
                                                    <th>Posting Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                           $query=mysqli_query($con,"Select tblcomments.id,  tblcomments.name,tblcomments.email,tblcomments.postingDate,tblcomments.comment,tblposts.id as postid,tblposts.PostTitle from  tblcomments join tblposts on tblposts.id=tblcomments.postId where tblcomments.status=1"); //Mengambil data komentar yang disetujui dari database.
                           $cnt=1; //Inisialisasi penghitung untuk nomor urut komentar.
                           while($row=mysqli_fetch_array($query)) //Mengambil setiap baris hasil query sebagai array asosiatif. 
                           {
                           ?>
                                                 <!--Tampilan data komentar dalam tabel. -->
                                                <tr>
                                                    <th scope="row"><?php echo htmlentities($cnt);?></th>
                                                    <td><?php echo htmlentities($row['name']);?></td>
                                                    <td><?php echo htmlentities($row['email']);?></td>
                                                    <td><?php echo htmlentities($row['comment']);?></td>
                                                    <td><span class="badge badge-secondary"><?php $st=$row['status'];
                              if($st=='0'): //Memeriksa status komentar.
                              echo "Wating for approval"; //Jika status 0, tampilkan "Wating for approval".
                              else: //Jika status 1, tampilkan "Approved".
                              echo "Approved"; //Jika status 1, tampilkan "Approved".
                              endif; //Akhir dari pemeriksaan status.
                              ?></span></td>
                                                <!-- Menampilkan judul postingan yang dikomentari dengan tautan ke halaman edit postingan. -->
                                                    <td><a href="edit-post.php?pid=<?php echo htmlentities($row['postid']);?>"><?php echo htmlentities($row['PostTitle']);?></a> </td> <!--Tautan ke halaman edit postingan. -->
                                                    <td><?php echo htmlentities($row['postingDate']);?></td> <!-- Menampilkan tanggal komentar diposting. -->
                                                    <td width="100px">
                                                        <?php if($st==0):?> <!-- Memeriksa status komentar. -->
                                                        <a href="manage-comments.php?disid=<?php echo htmlentities($row['id']);?>" title="Disapprove this comment" class="btn btn-primary btn-sm"><i class="ion-arrow-return-right"></i></a> <!--Tombol untuk menolak komentar jika statusnya 0. -->
                                                        <?php else :?> <!-- Jika status komentar adalah 1 (disetujui). -->
                                                        <a class="btn btn-info btn-sm" href="manage-comments.php?appid=<?php echo htmlentities($row['id']);?>" title="Approve this comment"><i class="ion-arrow-return-right"></i></a> <!--Tombol untuk menyetujui komentar jika statusnya 1. -->
                                                        <?php endif;?> 
                                                        &nbsp;<a href="manage-comments.php?rid=<?php echo htmlentities($row['id']);?>&&action=del" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i></a> <!-- Tombol untuk menghapus komentar. -->
                                                    </td>
                                                </tr>
                                                <?php
                           $cnt++; //Menambah penghitung nomor urut komentar.
                            } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="demo-box m-t-20">
                                    <div class="m-b-30">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- container -->
                </div>
                <!-- content -->
                <?php include('includes/footer.php');?>
                <?php } ?>