<?php 
   session_start();                     //Mengaktifkan sesi agar admin yang login bisa dikenali.
   include('includes/config.php');      //Memasukkan file konfigurasi database.
   error_reporting(0);                  //Menyembunyikan pesan error dari tampilan browser.
   if(strlen($_SESSION['login'])==0)    //Memeriksa apakah admin sudah login atau belum.
     { 
   header('location:index.php');        //Mengarahkan ke halaman login jika belum login.
   }
   else{                                 //Jika sudah login, lanjutkan ke halaman manajemen postingan.
   
   if($_GET['action']='del')            //Memeriksa apakah ada aksi penghapusan postingan.
   {
   $postid=intval($_GET['pid']);         //Mengambil ID postingan yang akan dihapus dari parameter URL.
   $query=mysqli_query($con,"update tblposts set Is_Active=0 where id='$postid'"); //Menandai postingan sebagai tidak aktif (dihapus) di database.
   if($query) 
   {
   $msg="Post deleted ";                 //Menyiapkan pesan sukses jika penghapusan berhasil.
   }
   else{ 
   $error="Something went wrong . Please try again.";   //Menyiapkan pesan error jika penghapusan gagal.
   } 
   }
   ?>
        <!-- Top Bar Start -->
        <?php include('includes/topheader.php');?>
        <!-- ========== Left Sidebar Start ========== -->
        <?php include('includes/leftsidebar.php');?>
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
                                <h4 class="page-title">Manage Posts </h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li>
                                        <a href="#">Admin</a>
                                    </li>
                                    <li>
                                        <a href="#">Posts</a>
                                    </li>
                                    <li class="active">
                                        Manage Post
                                    </li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="example">
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
                           $query=mysqli_query($con,"select tblposts.id as postid,tblposts.PostTitle as title,tblcategory.CategoryName as category,tblsubcategory.Subcategory as subcategory from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join tblsubcategory on tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=1 "); //Mengambil data postingan yang aktif dari database.
                           $rowcount=mysqli_num_rows($query); //Menghitung jumlah baris hasil query.
                           if($rowcount==0) //Memeriksa apakah ada postingan yang ditemukan.
                           {
                           ?>
                           
                                            <tr>
                                                <td colspan="4" align="center">
                                                    <h3 style="color:red">No record found</h3>
                                                </td>
                                            <tr>
                                                <?php 
                              } else { //Jika ada postingan, tampilkan data postingan dalam tabel.
                              while($row=mysqli_fetch_array($query)) //Mengambil setiap baris hasil query sebagai array asosiatif.
                              {
                              ?>
                                
                                            <tr>
                                                <td><?php echo htmlentities($row['title']);?></td>
                                                <td><?php echo htmlentities($row['category'])?></td>
                                                <td><?php echo htmlentities($row['subcategory'])?></td>
                                                <td><a class="btn btn-primary btn-sm" href="edit-post.php?pid=<?php echo htmlentities($row['postid']);?>"><i class="fa fa-pencil"></i></a> <!--Tombol untuk mengedit postingan. -->
                                                    &nbsp;<a class="btn btn-danger btn-sm" href="manage-posts.php?pid=<?php echo htmlentities($row['postid']);?>&&action=del" onclick="return confirm('Do you reaaly want to delete ?')"> <i class="fa fa-trash-o"></i></a> <!-- Tombol untuk mengedit dan menghapus postingan. -->
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
            <?php include('includes/footer.php');?>
            <?php } ?>