<?php 
session_start();                         // Mulai sesi PHP untuk memakai $_SESSION (auth, flash message, dll.)
include('includes/config.php');          // Memuat konfigurasi DB ($con) dan setelan lain yang diperlukan.
error_reporting(0);                      // Matikan penampilan error (baik untuk produksi, tapi menyulitkan debug). 
                                         // Catatan: sebaiknya log error (error_log) daripada mematikan total.

if(strlen($_SESSION['login'])==0)        // Cek apakah user belum login: jika $_SESSION['login'] kosong...
  { 
header('location:index.php');            // ...redirect ke halaman login/index
}                                        // (disarankan tambah exit; setelah header agar eksekusi berhenti)
else{                                    // Jika sudah login, lanjutkan render halaman

if(isset($_POST['update']))              // Jika tombol submit bernama "update" diklik (request POST)
{
$pagetype='aboutus';                     // PageName yang akan di-update (hard-coded "aboutus")
$pagetitle=$_POST['pagetitle'];          // Ambil judul halaman dari form
$pagedetails=$_POST['pagedescription'];  // Ambil konten/about dari form (HTML dari Summernote)

$query=mysqli_query($con,"update tblpages set PageTitle='$pagetitle',Description='$pagedetails' where PageName='$pagetype' "); 
                                         // Jalankan UPDATE langsung dengan interpolasi string.
                                         // CATATAN: rentan SQL Injection. Gunakan prepared statement.

if($query)                               // Jika kueri berhasil dieksekusi
{
$msg="About us  page successfully updated "; // Simpan pesan sukses untuk ditampilkan
}
else{
$error="Something went wrong . Please try again.";    // Jika gagal, simpan pesan error
} 

} // end if POST update
?>

<?php include('includes/topheader.php');?>     <!-- Header atas (CSS/JS awal + topbar) -->
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>   <!-- Sidebar kiri navigasi -->
<!-- Left Sidebar End -->

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">                      <!-- Kontainer area konten kanan -->
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">          <!-- Kotak judul halaman -->
                        <h4 class="page-title">About Page </h4>  <!-- Judul halaman -->
                        <ol class="breadcrumb p-0 m-0">          <!-- Breadcrumb -->
                            <li>
                                <a href="#">Pages</a>
                            </li>
                            <li class="active">
                                About us
                            </li>
                        </ol>
                        <div class="clearfix"></div>      <!-- Clear float -->
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-sm-6">
                    <!---Success Message--->
                    <?php if($msg){ ?>                    <!-- Jika ada pesan sukses -->
                    <div class="alert alert-success" role="alert">
                        <strong>Well done!</strong> <?php echo htmlentities($msg);?>  <!-- Tampilkan pesan sukses aman (HTML entities) -->
                    </div>
                    <?php } ?>

                    <!---Error Message--->
                    <?php if($error){ ?>                  <!-- Jika ada pesan error -->
                    <div class="alert alert-danger" role="alert">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error);?>  <!-- Tampilkan pesan error aman -->
                    </div>
                    <?php } ?>
                </div>
            </div>

            <?php 
$pagetype='aboutus';                                                    // PageName yang akan diambil
$query=mysqli_query($con,"select PageTitle,Description from tblpages where PageName='$pagetype'");
                                                                        // Ambil judul & deskripsi dari DB
while($row=mysqli_fetch_array($query))                                  // Loop hasil (kemungkinan 1 baris saja)
{
?>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="p-6">
                        <div class="">
                            <form name="aboutus" method="post">         <!-- Form update About Us (method POST) -->
                                <div class="form-group m-b-20">
                                    <label for="exampleInputEmail1">Page Title</label>
                                    <input type="text" class="form-control" id="pagetitle" name="pagetitle" 
                                           value="<?php echo htmlentities($row['PageTitle'])?>" required>
                                           <!-- Input judul: diisi nilai dari DB; htmlentities untuk mencegah XSS -->
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card-box">
                                            <h4 class="m-b-30 m-t-0 header-title"><b>Page Details</b></h4>
                                            <textarea class="summernote" name="pagedescription" required>
                                                <?php echo htmlentities($row['Description'])?>
                                            </textarea>
                                            <!-- Editor Summernote: isi dari DB, diproteksi htmlentities 
                                                 CATATAN: Summernote butuh HTML mentah; htmlentities akan meng-escape HTML 
                                                 sehingga tag tidak dirender sebagai format. Pertimbangkan menampilkan 
                                                 raw HTML (dengan sanitasi server-side) agar WYSIWYG menampilkan format. -->
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>                               <!-- Tutup while; diasumsikan satu baris -->

                                <button type="submit" name="update" class="btn btn-custom waves-effect waves-light btn-md">
                                    Update and Post
                                </button>                                 <!-- Tombol submit form -->
                            </form>
                        </div>
                    </div> <!-- end p-20 -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->

    <?php include('includes/footer.php');?>     <!-- Footer + script inisialisasi (DataTables, Summernote, Select2, dll.) -->
    <?php } ?>                                  <!-- Tutup blok else (user sudah login) -->
