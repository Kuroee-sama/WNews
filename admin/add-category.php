<?php
   session_start();                         // Mulai sesi: diperlukan untuk cek login & pesan antar-halaman
   include('includes/config.php');          // Memuat konfigurasi DB ($con) dan setelan lain
   error_reporting(0);                      // Menyembunyikan error di output (sebaiknya log saja, bukan disembunyikan total)

   if(strlen($_SESSION['login'])==0)        // Jika belum login (nilai 'login' kosong)
     { 
   header('location:index.php');            // Arahkan ke halaman login
   }                                        // CATATAN: tambahkan exit; setelah header agar eksekusi berhenti
   else{                                    // Sudah login: lanjutkan render halaman
   
   if(isset($_POST['submit']))              // Jika form disubmit (ada POST 'submit')
   {
   $category=$_POST['category'];            // Ambil input nama kategori dari form
   $description=$_POST['description'];      // Ambil input deskripsi kategori dari form
   $status=1;                               // Set status aktif default (1)

   // INSERT ke database (saat ini masih interpolasi string langsung)
   $query=mysqli_query($con,"insert into tblcategory(CategoryName,Description,Is_Active) values('$category','$description','$status')");
   if($query)
   {
   $msg="Category created ";                // Simpan pesan sukses untuk ditampilkan
   }
   else{
   $error="Something went wrong . Please try again.";    // Simpan pesan error untuk ditampilkan
   } 
   } // end if submit
   
   ?>
<!-- Top Bar Start -->
<?php include('includes/topheader.php');?>     <!-- Header atas (CSS/JS + topbar) -->
<!-- Top Bar End -->

<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>   <!-- Sidebar kiri navigasi -->
<!-- Left Sidebar End -->

<div class="content-page">                     <!-- Area konten halaman (kanan) -->
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">         <!-- Kotak judul halaman -->
                        <h4 class="page-title">Add Category</h4>   <!-- Judul halaman -->
                        <ol class="breadcrumb p-0 m-0">  <!-- Breadcrumb navigasi -->
                            <li>
                                <a href="#">Admin</a>
                            </li>
                            <li>
                                <a href="#">Category </a>
                            </li>
                            <li class="active">
                                Add Category
                            </li>
                        </ol>
                        <div class="clearfix"></div>     <!-- Clear float -->
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b>Add Category </b></h4>
                        <hr />
                        <div class="row">
                            <div class="col-sm-6">
                                <!---Success Message--->
                                <?php if($msg){ ?>                           <!-- Jika ada pesan sukses -->
                                <div class="alert alert-success" role="alert">
                                    <strong>Well done!</strong> <?php echo htmlentities($msg);?>  <!-- Tampilkan aman -->
                                </div>
                                <?php } ?>

                                <!---Error Message--->
                                <?php if($error){ ?>                         <!-- Jika ada pesan error -->
                                <div class="alert alert-danger" role="alert">
                                    <strong>Oh snap!</strong> <?php echo htmlentities($error);?>  <!-- Tampilkan aman -->
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Form tambah kategori -->
                        <form class="row" name="category" method="post">     <!-- Form POST (tanpa action => kembali ke halaman ini) -->
                            <div class="form-group col-md-6">
                                <label class="control-label">Category</label>
                                <input type="text" class="form-control" value="" name="category" required>
                                <!-- Input nama kategori (wajib diisi) -->
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" control-label">Category Description</label>
                                <textarea class="form-control" rows="5" name="description" required></textarea>
                                <!-- Input deskripsi kategori (wajib diisi) -->
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                                    Submit
                                </button>  <!-- Tombol submit -->
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

    <?php include('includes/footer.php');?>     <!-- Footer + JS inisialisasi plugin -->

    <?php } ?>                                  <!-- Tutup blok else (sudah login) -->
