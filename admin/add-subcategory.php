> <?php                                 // (TYPO) Terdapat karakter '>' di depan tag PHP. Hapus agar tidak memunculkan output tak sengaja.
   session_start();                     // Mulai sesi: dipakai untuk autentikasi & flash message
   include('includes/config.php');      // Koneksi DB ($con) dan konfigurasi lain
   error_reporting(0);                  // Menyembunyikan error (disarankan log saja, bukan disembunyikan total)

   if(strlen($_SESSION['login'])==0)    // Jika belum login (session 'login' kosong)
     { 
   header('location:index.php');        // Redirect ke halaman login
   }                                    // (Tambahkan exit; setelah header agar eksekusi berhenti)
   else{
   if(isset($_POST['submitsubcat']))    // Jika form disubmit (tombol name="submitsubcat")
   {
   $categoryid=$_POST['category'];      // Ambil ID kategori dari form (seharusnya integer)
   $subcatname=$_POST['subcategory'];   // Ambil nama subkategori dari form (string)
   $subcatdescription=$_POST['sucatdescription']; // Ambil deskripsi subkategori (nama field: 'sucatdescription')
   $status=1;                           // Status aktif default

   // INSERT ke DB (saat ini masih interpolasi langsung → raw SQL)
   $query=mysqli_query($con,"insert into tblsubcategory(CategoryId,Subcategory,SubCatDescription,Is_Active) values('$categoryid','$subcatname','$subcatdescription','$status')");
   if($query)
   {
   $msg="Sub-Category created ";        // Pesan sukses
   }
   else{
   $error="Something went wrong . Please try again."; // Pesan gagal
   } 
   }
   
   ?>
<?php include('includes/topheader.php');?>   <!-- Memuat head/topbar + CSS/JS awal -->
<!-- Top Bar End -->
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?> <!-- Memuat sidebar kiri -->
<!-- Left Sidebar End -->

<div class="content-page">                   <!-- Area konten kanan -->
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Add Sub-Category</h4>     <!-- Judul halaman -->
                        <ol class="breadcrumb p-0 m-0">                  <!-- Breadcrumb -->
                            <li><a href="#">Admin</a></li>
                            <li><a href="#">Category </a></li>
                            <li class="active">Add Sub-Category</li>
                        </ol>
                        <div class="clearfix"></div>                     <!-- Clear float -->
                    </div>
                </div>
            </div>

            <!-- end row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b>Add Sub-Category </b></h4>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <!---Success Message--->
                                <?php if($msg){ ?>                        <!-- Jika ada pesan sukses -->
                                <div class="alert alert-success" role="alert">
                                    <strong>Well done!</strong> <?php echo htmlentities($msg);?>  <!-- Tampilkan aman -->
                                </div>
                                <?php } ?>
                                <!---Error Message--->
                                <?php if($error){ ?>                      <!-- Jika ada pesan error -->
                                <div class="alert alert-danger" role="alert">
                                    <strong>Oh snap!</strong> <?php echo htmlentities($error);?>  <!-- Tampilkan aman -->
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Form tambah subkategori -->
                        <form class="row" name="category" method="post">  <!-- POST ke halaman ini -->
                            <div class="form-group col-md-6">
                                <label class="control-label">Category</label>
                                <select class="form-control" name="category" required>  <!-- Pilih kategori induk -->
                                    <option value="">Select Category </option>
                                    <?php
                                      // Ambil kategori aktif
                                      $ret=mysqli_query($con,"select id,CategoryName from  tblcategory where Is_Active=1");
                                      while($result=mysqli_fetch_array($ret))
                                      {    
                                    ?>
                                    <option value="<?php echo htmlentities($result['id']);?>">
                                      <?php echo htmlentities($result['CategoryName']);?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Sub-Category</label>
                                <input type="text" class="form-control" value="" name="subcategory" required> <!-- Nama subkategori -->
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Sub-Category Description</label>
                                <textarea class="form-control" rows="5" name="sucatdescription" required></textarea> <!-- Deskripsi -->
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submitsubcat">
                                    Submit
                                </button>                                   <!-- Submit form -->
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
    <?php include('includes/footer.php');?>        <!-- Footer + script inisialisasi plugin -->
    <?php } ?>                                     <!-- Tutup blok else (sudah login) -->
