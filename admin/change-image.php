<?php 
   session_start();                                   // Mulai sesi untuk akses variabel $_SESSION (autentikasi, dsb)
   include('includes/config.php');                    // Sertakan konfigurasi, termasuk koneksi database ($con)
   error_reporting(0);                                // Nonaktifkan penampilan error (error tetap terjadi tapi tidak ditampilkan)
   if(strlen($_SESSION['login'])==0)                  // Cek apakah user belum login: panjang string session 'login' = 0
     { 
   header('location:index.php');                      // Jika belum login, arahkan ke index.php
   }                                                  // Tutup blok if pertama
   else{                                              // Jika sudah login, lanjutkan eksekusi halaman
   if(isset($_POST['update']))                        // Jika form dikirim dengan tombol bernama 'update'
   {
   
   $imgfile=$_FILES["postimage"]["name"];             // Ambil nama file gambar yang diunggah dari input 'postimage'
   // get the image extension
   $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile)); // Ambil 4 karakter terakhir sebagai "ekstensi"
   // allowed extensions
   $allowed_extensions = array(".jpg","jpeg",".png",".gif");          // Daftar ekstensi yang diizinkan
   // Validation for allowed extensions .in_array() function searches an array for a specific value.
   if(!in_array($extension,$allowed_extensions))      // Cek apakah ekstensi file tidak termasuk yang diizinkan
   {
   echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>"; // Tampilkan alert jika tidak valid
   }
   else
   {
   //rename the image file
   $imgnewfile=md5($imgfile).$extension;              // Buat nama file baru berdasarkan md5 dari nama lama + ekstensi
   // Code for move image into directory
   move_uploaded_file($_FILES["postimage"]["tmp_name"],"postimages/".$imgnewfile); // Pindahkan file yang diupload ke folder 'postimages'
   
   
   
   $postid=intval($_GET['pid']);                      // Ambil ID posting dari parameter GET 'pid', paksa menjadi integer
   $query=mysqli_query($con,"update tblposts set PostImage='$imgnewfile' where id='$postid'"); // Jalankan query update kolom PostImage
   if($query)                                         // Jika query berhasil
   {
   $msg="Post Feature Image updated ";                // Set pesan sukses ke variabel $msg
   }
   else{
   $error="Something went wrong . Please try again."; // Set pesan error ke variabel $error
   } 
   }
   }
   ?>
<!-- Top Bar Start -->
<?php include('includes/topheader.php');?>            <!-- Sertakan header atas (doctype/head/topbar/css/js awal) -->
<script>
// Fungsi untuk mengambil subkategori via AJAX saat kategori berubah
function getSubCat(val) {
    $.ajax({
        type: "POST",                                 // Metode HTTP: POST
        url: "get_subcategory.php",                   // Endpoint yang dipanggil untuk mengambil data subkategori
        data: 'catid=' + val,                         // Data yang dikirim: parameter catid berisi nilai kategori terpilih
        success: function(data) {                     // Callback ketika request sukses
            $("#subcategory").html(data);             // Isi elemen select dengan id 'subcategory' menggunakan HTML yang diterima
        }
    });
}
</script>
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>          <!-- Sertakan sidebar kiri navigasi -->
<!-- Left Sidebar End -->
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">                             <!-- Pembungkus area konten kanan -->
    <!-- Start content -->
    <div class="content">                              <!-- Area konten utama -->
        <div class="container">                        <!-- Kontainer Bootstrap -->

            <div class="row">                          <!-- Baris judul halaman -->
                <div class="col-xs-12">
                    <div class="page-title-box">       <!-- Kotak judul + breadcrumb -->
                        <h4 class="page-title">Update Image </h4> <!-- Judul halaman -->
                        <ol class="breadcrumb p-0 m-0">           <!-- Breadcrumb tanpa padding/margin -->
                            <li>
                                <a href="#">Admin</a>             <!-- Level breadcrumb: Admin -->
                            </li>
                            <li>
                                <a href="#"> Posts </a>           <!-- Level breadcrumb: Posts -->
                            </li>
                            <li>
                                <a href="#"> Edit Posts </a>      <!-- Level breadcrumb: Edit Posts -->
                            </li>
                            <li class="active">
                                Update Image                      <!-- Posisi breadcrumb saat ini -->
                            </li>
                        </ol>
                        <div class="clearfix"></div>              <!-- Clear float untuk merapikan layout -->
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">                           <!-- Baris untuk pesan sukses/error -->
                <div class="col-sm-6">
                    <!---Success Message--->
                    <?php if($msg){ ?>                  <!-- Jika variabel $msg terisi (ada pesan sukses) -->
                    <div class="alert alert-success" role="alert"> <!-- Tampilkan alert Bootstrap sukses -->
                        <strong>Well done!</strong> <?php echo htmlentities($msg);?> <!-- Teks pesan (di-escape) -->
                    </div>
                    <?php } ?>
                    <!---Error Message--->
                    <?php if($error){ ?>                <!-- Jika variabel $error terisi (ada pesan error) -->
                    <div class="alert alert-danger" role="alert">  <!-- Tampilkan alert Bootstrap error -->
                        <strong>Oh snap!</strong> <?php echo htmlentities($error);?> <!-- Teks pesan (di-escape) -->
                    </div>
                    <?php } ?>
                </div>
            </div>

            <form name="addpost" method="post" enctype="multipart/form-data"> <!-- Form unggah file gambar baru; multipart diperlukan -->
                <?php
            $postid=intval($_GET['pid']);                 // Ambil lagi ID posting dari parameter GET
            $query=mysqli_query($con,"select PostImage,PostTitle from tblposts where id='$postid' and Is_Active=1 ");
                                                         // Query untuk mengambil gambar & judul posting yang aktif
            while($row=mysqli_fetch_array($query))       // Iterasi hasil query (diharapkan satu baris)
            {
            ?>
                <div class="row">                         <!-- Baris konten formulir -->
                    <div class="col-md-10 col-md-offset-1"> <!-- Kolom lebar 10 dengan offset 1 (tengah) -->
                        <div class="p-6">                 <!-- Padding/spacing internal -->
                            <div class="">                <!-- Pembungkus konten -->
                                <form name="addpost" method="post"> <!-- (Form dalam form) Form HTML untuk menampilkan data judul (readonly) -->
                                    <div class="form-group m-b-20">  <!-- Grup form dengan margin bawah -->
                                        <label for="exampleInputEmail1">Post Title</label> <!-- Label input judul -->
                                        <input type="text" class="form-control" id="posttitle" 
                                               value="<?php echo htmlentities($row['PostTitle']);?>" 
                                               name="posttitle" readonly>  <!-- Input berisi judul posting, hanya baca -->
                                    </div>
                                    <div class="row">                <!-- Baris untuk menampilkan gambar saat ini -->
                                        <div class="col-sm-12">
                                            <div class="card-box">    <!-- Kotak kartu untuk konten -->
                                                <h4 class="m-b-30 m-t-0 header-title"><b>Current Post Image</b></h4> <!-- Judul bagian gambar saat ini -->
                                                <img src="postimages/<?php echo htmlentities($row['PostImage']);?>" width="300" />
                                                <!-- Tag img menampilkan gambar fitur yang ada, lebar 300px -->
                                                <br />                <!-- Break baris -->
                                            </div>
                                        </div>
                                    </div>

                                    <?php } ?>                       <!-- Tutup loop while yang menampilkan data posting -->
                                    <div class="row">                <!-- Baris untuk input gambar baru -->
                                        <div class="col-sm-12">
                                            <div class="card-box">    <!-- Kotak kartu untuk input gambar baru -->
                                                <h4 class="m-b-30 m-t-0 header-title"><b>New Feature Image</b></h4> <!-- Judul bagian unggah baru -->
                                                <input type="file" class="form-control" id="postimage" name="postimage" required>
                                                <!-- Input file untuk memilih gambar baru, wajib diisi -->
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-success waves-effect waves-light">Update </button>
                                    <!-- Tombol submit untuk memproses unggah & update gambar -->
                                </form>                   <!-- Tutup form bagian tengah -->
                            </div>
                        </div> <!-- end p-20 -->
                    </div> <!-- end col -->
                </div>     <!-- end row -->
        </div>             <!-- container -->
    </div>                 <!-- content -->
    <?php include('includes/footer.php');?>             <!-- Sertakan footer (script JS akhir, plugin, dsb) -->
    <?php } ?>                                          <!-- Tutup blok else awal (jika user sudah login) -->
