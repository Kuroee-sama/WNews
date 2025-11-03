<?php 
   session_start();                        //Mengaktifkan sesi agar admin yang login bisa dikenali.
   include('includes/config.php');         //Memasukkan file konfigurasi database.
   error_reporting(0);                     //Menyembunyikan pesan error dari tampilan browser.
   if(strlen($_SESSION['login'])==0)       //Memeriksa apakah admin sudah login atau belum.
     { 
   header('location:index.php');           //Mengarahkan ke halaman login jika belum login.
   }
   else{                                   //Jika sudah login, lanjutkan ke halaman manajemen postingan.
   
   if($_GET['action']='restore')           //Memeriksa apakah ada aksi pemulihan postingan.
   {
   $postid=intval($_GET['pid']);           //Mengambil ID postingan yang akan dipulihkan dari parameter URL.
   $query=mysqli_query($con,"update tblposts set Is_Active=1 where id='$postid'"); //Menandai postingan sebagai aktif (dipulihkan) di database.
   if($query)
   {
   $msg="Post restored successfully ";     //Menyiapkan pesan sukses jika pemulihan berhasil.
   }
   else{ 
   $error="Something went wrong . Please try again.";   //Menyiapkan pesan error jika pemulihan gagal. 
   } 
   }
   if($_GET['presid'])                     //Memeriksa apakah ada aksi penghapusan permanen postingan.
   {
       $id=intval($_GET['presid']);        //Mengambil ID postingan yang akan dihapus secara permanen dari parameter URL.
       $query=mysqli_query($con,"delete from  tblposts  where id='$id'"); //Menghapus postingan secara permanen dari database.
       $delmsg="Post deleted forever";     //Menyiapkan pesan sukses jika penghapusan permanen berhasil.
   }
   ?>

<?php include('includes/topheader.php');?> <!-- Menyertakan bagian topheader (head/topbar/CSS/JS awal). -->
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>  <!-- Menyertakan sidebar kiri untuk navigasi. -->

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Trashed Posts </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="#">Admin</a> <
                                
                            </li>
                            <li>
                                <a href="#">Posts</a>
                            </li>
                            <li class="active">
                                Trashed Posts
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
             
            <!-- end row -->
            <div class="row">
                <div class="col-sm-6">
                    <?php if($delmsg){ ?> <!-- Menampilkan pesan sukses penghapusan permanen jika ada. -->
                    <div class="alert alert-danger" role="alert">
                        <strong>Oh snap!</strong> <?php echo htmlentities($delmsg);?> <!-- Tampilkan pesan sukses penghapusan permanen (di-escape). -->
                    </div>
                    <?php } ?> <!-- Menutup blok if untuk pesan sukses penghapusan permanen. -->
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="table-responsive">
                                <table class="table table-bordered  m-0" id="example">
                                    <thead>
                                        <tr>
                                             
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Subcategory</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                       $query=mysqli_query($con,"select tblposts.id as postid,tblposts.PostTitle as title,tblcategory.CategoryName as category,tblsubcategory.Subcategory as subcategory from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join tblsubcategory on tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=0"); //Mengambil postingan yang telah dihapus (Is_Active=0) dari database.
                                       $rowcount=mysqli_num_rows($query); //Menghitung jumlah postingan yang ditemukan.
                                       if($rowcount==0) //Jika tidak ada postingan yang ditemukan.
                                       {
                                       ?>
                                        <tr>
                                            <td colspan="4" align="center">
                                                <h3 style="color:red">No record found</h3>
                                            </td>
                                        <tr>
                                            <?php 
                                          } else {    //Jika ada postingan yang ditemukan, tampilkan dalam tabel.
                                          while($row=mysqli_fetch_array($query)) //Mengambil setiap baris hasil query sebagai array asosiatif.
                                          {
                                          ?>
                                        <tr>
                                             
                                            <td><b><?php echo htmlentities($row['title']);?></b></td>
                                            <td><?php echo htmlentities($row['category'])?></td> 
                                            <td><?php echo htmlentities($row['subcategory'])?></td>
                                            <td>
                                                <a href="trash-posts.php?pid=<?php echo htmlentities($row['postid']);?>&&action=restore" onclick="return confirm('Do you really want to restore ?')"> <i class="ion-arrow-return-right" title="Restore this Post"></i></a>
                                                &nbsp;
                                                <a href="trash-posts.php?presid=<?php echo htmlentities($row['postid']);?>&&action=perdel" onclick="return confirm('Do you really want to delete ?')"><i class="fa fa-trash-o" style="color: #f05050" title="Permanently delete this post"></i></a>
                                            </td>
                                        </tr>
                                        <?php } }?>
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
        <?php include('includes/footer.php');?> <!-- Menyertakan bagian footer halaman admin. -->
        <?php } ?> <!-- Menutup blok else dari pemeriksaan login admin. -->