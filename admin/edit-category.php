<?php
   session_start();                                // Memulai sesi PHP untuk menggunakan $_SESSION (misal cek login).
   include('includes/config.php');                 // Menyertakan file konfigurasi, termasuk koneksi database ($con).
   error_reporting(0);                             // Menonaktifkan penampilan error (tidak ditampilkan ke output).

   if(strlen($_SESSION['login'])==0)               // Mengecek apakah user belum login (panjang string 'login' == 0).
     { 
   header('location:index.php');                   // Jika belum login, alihkan ke halaman index.php (login).
   }
   else{                                           // Jika sudah login, lanjutkan proses halaman.
   if(isset($_POST['submit']))                     // Jika form disubmit (ada POST dengan name="submit").
   {
   $catid=intval($_GET['cid']);                    // Mengambil ID kategori dari parameter URL 'cid' dan memaksanya menjadi integer.
   $category=$_POST['category'];                   // Mengambil nilai nama kategori dari input form.
   $description=$_POST['description'];             // Mengambil nilai deskripsi kategori dari input form.

   // Menjalankan perintah UPDATE untuk mengubah nama & deskripsi pada id kategori terkait.
   $query=mysqli_query($con,"Update  tblcategory set CategoryName='$category',Description='$description' where id='$catid'");

   if($query)                                      // Jika query UPDATE berhasil dieksekusi.
   {
   $msg="Category Updated successfully ";          // Menyetel pesan sukses ke variabel $msg.
   }
   else{
   $error="Something went wrong . Please try again.";  // Jika gagal, menyetel pesan error ke variabel $error.
   } 
   }   
   ?>
<!-- Top Bar Start -->
<?php include('includes/topheader.php');?>         <!-- Menyertakan bagian topheader (head/topbar/CSS/JS awal). -->
<!-- Top Bar End -->
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>       <!-- Menyertakan sidebar kiri untuk navigasi. -->
<!-- Left Sidebar End -->
<div class="content-page">                          <!-- Kontainer area konten sisi kanan (layout utama). -->
    <!-- Start content -->
    <div class="content">                           <!-- Bagian konten utama. -->
        <div class="container">                     <!-- Kontainer Bootstrap untuk lebar responsif. -->

            <div class="row">                       <!-- Baris judul halaman + breadcrumb. -->
                <div class="col-xs-12">
                    <div class="page-title-box">    <!-- Kotak judul halaman. -->
                        <h4 class="page-title">Edit Category</h4>        <!-- Judul halaman. -->
                        <ol class="breadcrumb p-0 m-0">                  <!-- Breadcrumb tanpa padding & margin. -->
                            <li>
                                <a href="#">Admin</a>                    <!-- Level breadcrumb: Admin. -->
                            </li>
                            <li>
                                <a href="#">Category </a>                <!-- Level breadcrumb: Category. -->
                            </li>
                            <li class="active">
                                Edit Category                             <!-- Level breadcrumb aktif: Edit Category. -->
                            </li>
                        </ol>
                        <div class="clearfix"></div>                     <!-- Elemen pembersih float. -->
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">                           <!-- Baris untuk kotak form edit. -->
                <div class="col-sm-12">
                    <div class="card-box">              <!-- Kotak/card pembungkus form. -->
                        <h4 class="m-t-0 header-title"><b>Edit Category </b></h4> <!-- Judul card. -->
                        <hr />
                        <div class="row">
                            <div class="col-sm-6">
                                <!---Success Message--->
                                <?php if($msg){ ?>      <!-- Jika variabel $msg berisi pesan sukses. -->
                                <div class="alert alert-success" role="alert">
                                    <strong>Well done!</strong> <?php echo htmlentities($msg);?> <!-- Tampilkan pesan sukses (di-escape). -->
                                </div>
                                <?php } ?>
                                <!---Error Message--->
                                <?php if($error){ ?>    <!-- Jika variabel $error berisi pesan error. -->
                                <div class="alert alert-danger" role="alert">
                                    <strong>Oh snap!</strong> <?php echo htmlentities($error);?> <!-- Tampilkan pesan error (di-escape). -->
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php 
                              $catid=intval($_GET['cid']);   // Mengambil kembali ID kategori dari parameter URL 'cid' sebagai integer.
                              $query=mysqli_query($con,"Select id,CategoryName,Description,PostingDate,UpdationDate from  tblcategory where Is_Active=1 and id='$catid'");
                                                             // Menjalankan query SELECT untuk mengambil data kategori aktif dengan id tersebut.
                              $cnt=1;                        // Variabel penghitung (tidak digunakan dalam tampilan ini).
                              while($row=mysqli_fetch_array($query)) // Melakukan iterasi hasil query (biasanya satu baris).
                              {
                              ?>
                        <form class="row" name="category" method="post"> <!-- Form pengiriman perubahan kategori (POST). -->
                            <div class="form-group col-md-6">
                                <label class="control-label">Category</label> <!-- Label input nama kategori. -->
                                <input type="text" class="form-control" 
                                       value="<?php echo htmlentities($row['CategoryName']);?>" 
                                       name="category" required>              <!-- Input teks nama kategori (diisi dari DB), wajib. -->
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Category Description</label> <!-- Label input deskripsi. -->
                                <textarea class="form-control" rows="5" name="description" required>
                                    <?php echo htmlentities($row['Description']);?>
                                </textarea>                                   <!-- Textarea deskripsi (diisi dari DB), wajib. -->
                            </div>
                            <?php } ?>                                        <!-- Menutup loop while setelah menampilkan field. -->
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                                    Update                                     <!-- Tombol submit untuk menyimpan perubahan. -->
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
    <?php include('includes/footer.php');?>      <!-- Menyertakan footer (script JS penutup, plugin, dsb).-->
    <?php } ?>                                   <!-- Menutup blok else awal (jika user sudah login). -->
