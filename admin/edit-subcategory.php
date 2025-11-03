    <?php
   session_start();     //Mengaktifkan sesi PHP agar data user (misal username admin yang sedang login) bisa disimpan dan diakses di semua halaman.
   include('includes/config.php');    //Mengimpor file konfigurasi config.php yang biasanya berisi koneksi ke database MySQL (contoh: $con = mysqli_connect(...)).
   error_reporting(0);      //Menonaktifkan tampilan pesan error di halaman agar tampilan tetap rapi.
   if(strlen($_SESSION['login'])==0) //Mengecek apakah variabel sesi login kosong → artinya belum login.
     { 
   header('location:index.php'); //Jika belum login, user langsung diarahkan ke halaman index.php (halaman login admin).
   }
   else{
    //Mengecek apakah form edit subkategori sudah disubmit (karena ada input bernama sucatdescription).
   if(isset($_POST['sucatdescription']))
   {
   $subcatid=intval($_GET['scid']); //Mengambil ID subkategori dari parameter URL (?scid=...) lalu diubah ke tipe integer agar aman dari injeksi.    
   $categoryid=$_POST['category']; //Mengambil ID kategori yang dipilih dari form.
   $subcatname=$_POST['subcategory']; //Mengambil nama subkategori dari form.
   $subcatdescription=$_POST['sucatdescription']; //Mengambil deskripsi subkategori dari form textarea.
   $query=mysqli_query($con,"update tblsubcategory set CategoryId='$categoryid',Subcategory='$subcatname',SubCatDescription='$subcatdescription' where SubCategoryId='$subcatid'"); //Menjalankan perintah SQL untuk memperbarui data subkategori di tabel tblsubcategory
   if($query)
   {
   $msg="Sub-Category created "; //Jika query berhasil → $msg akan berisi pesan sukses.
   }
   else{
   $error="Something went wrong . Please try again.";  //Jika gagal → $error berisi pesan error.  
   } 
   }
   
   
   ?>

        <?php include('includes/topheader.php');?> <!-- Agar halaman ini punya tampilan header dan menu samping admin panel. -->
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->
        <?php include('includes/leftsidebar.php');?>
        <!-- Left Sidebar End -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Add Sub-Category</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li>
                                        <a href="#">Admin</a>
                                    </li>
                                    <li>
                                        <a href="#">Category </a>
                                    </li>
                                    <li class="active">
                                        Add Sub-Category
                                    </li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <h4 class="m-t-0 header-title"><b>Add Sub-Category </b></h4> <!-- Judul halaman di panel admin-->
                                <hr />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!---Success Message--->
                                        <?php if($msg){ ?>
                                        <div class="alert alert-success" role="alert">
                                            <strong>Well done!</strong> <?php echo htmlentities($msg);?>
                                        </div>
                                        <?php } ?>
                                        <!---Error Message--->
                                        <?php if($error){ ?>
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error);?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php 
                              //fetching Category details
                              $subcatid=intval($_GET['scid']); //Mengambil ID subkategori dari parameter URL.
                              $query=mysqli_query($con,"Select tblcategory.CategoryName as catname,tblcategory.id as catid,tblsubcategory.Subcategory as subcatname,tblsubcategory.SubCatDescription as SubCatDescription,tblsubcategory.PostingDate as subcatpostingdate,tblsubcategory.UpdationDate as subcatupdationdate,tblsubcategory.SubCategoryId as subcatid from tblsubcategory join tblcategory on tblsubcategory.CategoryId=tblcategory.id where tblsubcategory.Is_Active=1 and  SubCategoryId='$subcatid'"); //Menjalankan query SQL untuk mengambil detail subkategori beserta nama kategorinya dengan join antara tabel tblsubcategory dan tblcategory berdasarkan ID subkategori yang diambil dari URL.
                              $cnt=1; 
                              while($row=mysqli_fetch_array($query)) 
                              {
                              
                              ?>
                                <form class="row" name="category" method="post"> <!-- Form untuk mengedit subkategori dengan method POST. -->
                                    <div class="form-group col-md-6"> 
                                        <label class="control-label">Category</label>
                                        <select class="form-control" name="category" required>
                                            <option value="<?php echo htmlentities($row['catid']);?>"><?php echo htmlentities($row['catname']);?></option>
                                            <?php
                                                // Feching active categories
                                                $ret=mysqli_query($con,"select id,CategoryName from  tblcategory where Is_Active=1"); //Menjalankan query SQL untuk mengambil semua kategori yang aktif dari tabel tblcategory.
                                                while($result=mysqli_fetch_array($ret)) //Looping untuk setiap kategori aktif yang diambil dari query.
                                                {    
                                                ?>
                                            <option value="<?php echo htmlentities($result['id']);?>"><?php echo htmlentities($result['CategoryName']);?></option> 
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6"> <!--Form group untuk input nama subkategori.-->
                                        <label class="control-label">Sub-Category</label> 
                                        <input type="text" class="form-control" value="<?php echo htmlentities($row['subcatname']);?>" name="subcategory" required> <!--Input teks untuk nama subkategori, diisi dengan nilai saat ini dari database.-->
                                    </div>
                                    <div class="form-group col-md-6"> <!--Form group untuk input deskripsi subkategori.-->
                                        <label class="control-label">Sub-Category Description</label>
                                        <textarea class="form-control" rows="5" name="sucatdescription" required><?php echo htmlentities($row['SubCatDescription']);?></textarea>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group col-md-12"> <!--Tombol submit untuk mengirim form.-->
                                        <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submitsubcat"> <!--form akan mengirim data POST ke halaman yang sama.Kemudian blok PHP di awal file akan memproses dan memperbarui database.-->
                                            Submit 
                                        </button>
                                    </div>
                                </form> 
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- container -->
            </div>
            <!-- content -->
            <?php include('includes/footer.php');?>
            <?php } ?>