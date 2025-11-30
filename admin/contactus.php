<?php 
session_start();                                // Memulai sesi PHP untuk menggunakan $_SESSION (mis. status login).
include('includes/config.php');                 // Menyertakan konfigurasi, termasuk koneksi database ($con).
error_reporting(0);                             // Menonaktifkan penampilan error (error tetap terjadi, hanya tidak ditampilkan).
if(strlen($_SESSION['login'])==0)               // Mengecek apakah variabel sesi 'login' kosong (belum login).
  { 
header('location:index.php');                   // Jika belum login, alihkan ke halaman index.php.
}
else{                                           // Jika sudah login, lanjutkan eksekusi halaman.
if(isset($_POST['update']))                     // Jika form dikirim dengan tombol bernama 'update'.
{
$pagetype='contactus';                          // Menetapkan tipe halaman yang ditarget ('contactus').
$pagetitle=$_POST['pagetitle'];                 // Mengambil judul halaman dari input form.
$pagedetails=$_POST['pagedescription'];         // Mengambil isi/detail halaman dari input form.

$query=mysqli_query($con,"update tblpages set PageTitle='$pagetitle',Description='$pagedetails' where PageName='$pagetype' ");
                                                // Menjalankan query UPDATE untuk mengubah judul dan deskripsi pada baris 'contactus'.
if($query)                                      // Jika query berhasil dieksekusi.
{
$msg="About us  page successfully updated ";     // Menetapkan pesan sukses ke variabel $msg (teks pesan).
}
else{
$error="Something went wrong . Please try again.";    
                                                // Jika gagal, menetapkan pesan error ke variabel $error.
} 

}
?>                                              // Menutup blok PHP pertama.

<!-- Top Bar Start -->
<?php include('includes/topheader.php');?>      <!-- Menyertakan bagian header atas (head/topbar/CSS-utama/JS-utama). -->
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>    <!-- Menyertakan sidebar kiri navigasi. -->
<!-- Left Sidebar End -->



<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">                       <!-- Kontainer area konten di sisi kanan. -->
    <!-- Start content -->
    <div class="content">                        <!-- Bagian konten utama. -->
        <div class="container">                  <!-- Kontainer Bootstrap untuk pembatas lebar. -->


            <div class="row">                    <!-- Baris judul halaman + breadcrumb. -->
                <div class="col-xs-12">
                    <div class="page-title-box"> <!-- Kotak judul halaman. -->
                        <h4 class="page-title">Contact us Page </h4>  <!-- Judul halaman yang ditampilkan. -->
                        <ol class="breadcrumb p-0 m-0">               <!-- Breadcrumb tanpa padding dan margin. -->
                            <li>
                                <a href="#">Pages</a>                 <!-- Level breadcrumb: Pages. -->
                            </li>

                            <li class="active">
                                Contact us                            <!-- Level breadcrumb aktif: Contact us. -->
                            </li>
                        </ol>
                        <div class="clearfix"></div>                  <!-- Elemen untuk membersihkan float. -->
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">                    <!-- Baris untuk menampilkan alert pesan sukses/error. -->
                <div class="col-sm-6">
                    <!---Success Message--->
                    <?php if($msg){ ?>           <!-- Jika variabel $msg berisi pesan sukses. -->
                    <div class="alert alert-success" role="alert">
                        <strong>Well done!</strong> <?php echo htmlentities($msg);?> 
                                                <!-- Menampilkan pesan sukses (di-escape untuk keamanan). -->
                    </div>
                    <?php } ?>

                    <!---Error Message--->
                    <?php if($error){ ?>         <!-- Jika variabel $error berisi pesan error. -->
                    <div class="alert alert-danger" role="alert">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error);?>
                                                <!-- Menampilkan pesan error (di-escape untuk keamanan). -->
                    </div>
                    <?php } ?>


                </div>
            </div>
            <?php 
$pagetype='contactus';                           // Menetapkan tipe halaman yang ingin diambil dari tabel.
$query=mysqli_query($con,"select PageTitle,Description from tblpages where PageName='$pagetype'");
                                                 // Menjalankan query SELECT untuk mengambil judul dan deskripsi halaman 'contactus'.
while($row=mysqli_fetch_array($query))           // Melakukan iterasi setiap baris hasil query (biasanya satu baris).
{

?>

            <div class="row">                    <!-- Baris yang berisi form pengeditan konten halaman. -->
                <div class="col-md-10 col-md-offset-1">
                    <div class="p-6">            <!-- Padding wrapper untuk konten form. -->
                        <div class="">
                            <form name="aboutus" method="post">      <!-- Form pengiriman data (method POST). -->
                                <div class="form-group m-b-20">
                                    <label for="exampleInputEmail1">Page Title</label> <!-- Label input judul. -->
                                    <input type="text" class="form-control" id="pagetitle" name="pagetitle" 
                                           value="<?php echo htmlentities($row['PageTitle'])?>" required>
                                           <!-- Input teks yang diisi dengan judul dari database; wajib diisi. -->
                                </div>

                                <div class="row">                    <!-- Baris untuk editor konten. -->
                                    <div class="col-sm-12">
                                        <div class="card-box">
                                            <h4 class="m-b-30 m-t-0 header-title"><b>Page Details</b></h4>
                                            <textarea class="summernote" name="pagedescription" required>
                                                <?php echo htmlentities($row['Description'])?>
                                            </textarea>
                                            <!-- Textarea dengan kelas 'summernote' untuk WYSIWYG; diisi deskripsi dari DB. -->
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>      <!-- Menutup blok while setelah menampilkan form dengan data yang diambil. -->

                                <button type="submit" name="update" 
                                        class="btn btn-custom waves-effect waves-light btn-md">
                                    Update and Post
                                </button>        <!-- Tombol submit untuk mengirim perubahan (name='update'). -->

                            </form>             <!-- Menutup form. -->
                        </div>
                    </div> <!-- end p-20 -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
    <?php include('includes/footer.php');?>     <!-- Menyertakan footer (script JS penutup, plugin, dsb). -->
    <?php } ?>                                  <!-- Menutup blok else awal (ketika user sudah login). -->
