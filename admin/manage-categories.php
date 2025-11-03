<?php
   session_start();                          //Mengaktifkan sesi PHP agar bisa mengenali admin yang sedang login.
   include('includes/config.php');           //Mengimpor file konfigurasi yang berisi koneksi database.
   error_reporting(0);                       //Menonaktifkan tampilan pesan error di halaman agar tampilan tetap rapi.
   if(strlen($_SESSION['login'])==0)         //Mengecek apakah admin sudah login.
     { 
   header('location:index.php');             //Jika belum login, arahkan ke halaman index.php (halaman login).
   }
   else{                                     //Jika sudah login, lanjutkan ke bagian berikutnya.
    
    // Code for deleting category
   if($_GET['action']=='del' && $_GET['rid'])  //Mengecek apakah ada parameter URL untuk menghapus kategori.
   {
    $id=intval($_GET['rid']);  //Mengambil ID kategori dari parameter URL (?rid=...) lalu diubah ke tipe integer agar aman dari injeksi.
    $query=mysqli_query($con,"update tblcategory set Is_Active='0' where id='$id'"); //Menjalankan query untuk menandai kategori sebagai tidak aktif (soft delete).
    $msg="Category deleted "; //Menyimpan pesan sukses ke variabel $msg.
   }
   // Code for restore
   if($_GET['resid']) //Mengecek apakah ada parameter URL untuk mengembalikan kategori yang dihapus.
   {
    $id=intval($_GET['resid']); //Mengambil ID kategori dari parameter URL (?resid=...) lalu diubah ke tipe integer agar aman dari injeksi.
    $query=mysqli_query($con,"update tblcategory set Is_Active='1' where id='$id'"); //Menjalankan query untuk menandai kategori sebagai aktif kembali.
    $msg="Category restored successfully"; //Menyimpan pesan sukses ke variabel $msg.
   }
   
   // Code for Forever deletionparmdel
   if($_GET['action']=='parmdel' && $_GET['rid'])  //Mengecek apakah ada parameter URL untuk menghapus kategori secara permanen.
   {
    $id=intval($_GET['rid']); //Mengambil ID kategori dari parameter URL (?rid=...) lalu diubah ke tipe integer agar aman dari injeksi.
    $query=mysqli_query($con,"delete from  tblcategory  where id='$id'"); //Menjalankan query untuk menghapus kategori secara permanen dari database.
    $delmsg="Category deleted forever";    //Menyimpan pesan sukses ke variabel $delmsg.
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
                                <h4 class="page-title">Manage Categories</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li>
                                        <a href="#">Admin</a>
                                    </li>
                                    <li>
                                        <a href="#">Category </a>
                                    </li>
                                    <li class="active">
                                        Manage Categories
                                    </li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <!--Pesan notifikasi-->
                    <div class="row">
                        <div class="col-sm-6">
                            <?php if($msg){ ?> <!--Jika ada pesan sukses ($msg)-->
                            <div class="alert alert-success" role="alert"> 
                                <strong>Well done!</strong> <?php echo htmlentities($msg);?> <!--htmlentities() digunakan agar output aman dari HTML injection-->
                            </div>
                            <?php } ?>
                            <?php if($delmsg){ ?> ,<!--Jika ada pesan kesalahan ($delmsg)-->
                            <div class="alert alert-danger" role="alert"> 
                                <strong>Oh snap!</strong> <?php echo htmlentities($delmsg);?>
                            </div>
                            <?php } ?>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="demo-box m-t-20">
                                    <div class="m-b-30">
                                        <a href="add-category.php">
                                            <button id="addToTable" class="btn btn-custom waves-effect waves-light btn-md">Add <i class="mdi mdi-plus-circle-outline"></i></button> <!--Tombol untuk menambahkan kategori baru yang mengarahkan ke halaman add-category.php-->
                                        </a>
                                    </div>
                                    <div class="table-responsive"> <!--Membuat tabel yang responsif-->
                                        <table class="table m-0 table-bordered" id="example"> <!--Tabel untuk menampilkan daftar kategori-->
                                            <thead>
                                                <tr>
                                                    <th>#</th> <!--Kolom untuk nomor urut-->
                                                    <th> Category</th>
                                                    <th>Description</th>
                                                    <th>Posting Date</th>
                                                    <th>Last updation Date</th>
                                                    <th>Action</th> <!--Kolom untuk aksi seperti edit dan delete-->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                       $query=mysqli_query($con,"Select id,CategoryName,Description,PostingDate,UpdationDate from  tblcategory where Is_Active=1"); //Query untuk mengambil data kategori yang aktif dari database
                                       $cnt=1; //Inisialisasi variabel penghitung untuk nomor urut
                                       while($row=mysqli_fetch_array($query)) //Looping untuk menampilkan setiap baris data kategori
                                       {
                                       ?>
                                                <tr>
                                                   <!--Menampilkan data kategori dalam tabel-->
                                                    <th scope="row"><?php echo htmlentities($cnt);?></th>
                                                    <td><?php echo htmlentities($row['CategoryName']);?></td>
                                                    <td><?php echo htmlentities($row['Description']);?></td>
                                                    <td><?php echo htmlentities($row['PostingDate']);?></td>
                                                    <td><?php echo htmlentities($row['UpdationDate']);?></td>
                                                    <td><a class="btn btn-primary btn-sm" href="edit-category.php?cid=<?php echo htmlentities($row['id']);?>"><i class="fa fa-pencil"></i></a> <!--Tombol untuk mengedit kategori yang mengarahkan ke halaman edit-category.php dengan ID kategori sebagai parameter-->
                                                        &nbsp;<a class="btn btn-danger btn-sm" href="manage-categories.php?rid=<?php echo htmlentities($row['id']);?>&&action=del"> <i class="fa fa-trash-o"></i></a> <!--Tombol untuk menghapus kategori yang mengarahkan ke halaman manage-categories.php dengan ID kategori dan aksi delete sebagai parameter-->
                                                    </td> 
                                                </tr> 
                                                <?php
                                       $cnt++; //Increment variabel penghitung untuk nomor urut
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
                                        <h4><i class="fa fa-trash-o"></i> Deleted Categories</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table m-0 table-bordered table-bordered-danger" id="example1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th> Category</th>
                                                    <th>Description</th>
                                                    <th>Posting Date</th>
                                                    <th>Last updation Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                       $query=mysqli_query($con,"Select id,CategoryName,Description,PostingDate,UpdationDate from  tblcategory where Is_Active=0"); //Query untuk mengambil data kategori yang dihapus (Is_Active=0)
                                       $cnt=1; //Inisialisasi variabel penghitung untuk nomor urut
                                       while($row=mysqli_fetch_array($query)) //Looping untuk menampilkan setiap baris data kategori yang dihapus
                                       {
                                       ?>
                                                <tr>
                                                <!--Menampilkan data kategori yang dihapus dalam tabel-->
                                                    <th scope="row"><?php echo htmlentities($cnt);?></th>
                                                    <td><?php echo htmlentities($row['CategoryName']);?></td>
                                                    <td><?php echo htmlentities($row['Description']);?></td>
                                                    <td><?php echo htmlentities($row['PostingDate']);?></td>
                                                    <td><?php echo htmlentities($row['UpdationDate']);?></td>
                                                    <td><a href="manage-categories.php?resid=<?php echo htmlentities($row['id']);?>"><i class="ion-arrow-return-right" title="Restore this category"></i></a> <!--Tombol untuk mengembalikan kategori yang dihapus-->
                                                        &nbsp;<a href="manage-categories.php?rid=<?php echo htmlentities($row['id']);?>&&action=parmdel" title="Delete forever"> <i class="fa fa-trash-o" style="color: #f05050"></i> </a> <!--Tombol untuk menghapus kategori secara permanen-->
                                                    </td>
                                                </tr>
                                                <?php
                                       $cnt++; //Increment variabel penghitung untuk nomor urut
                                        } ?>
                                            </tbody>
                                        </table>
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