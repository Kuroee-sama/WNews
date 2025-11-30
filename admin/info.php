<?php 
session_start(); //Mengaktifkan sesi PHP agar sistem bisa mengenali admin yang sudah login.
include('includes/config.php'); //Mengimpor konfigurasi database untuk menjalankan query.
error_reporting(0); //Menyembunyikan pesan error dari browser.
if(strlen($_SESSION['login'])==0) //Mengecek apakah variabel sesi 'login' kosong → artinya admin belum login.
  { 
header('location:index.php'); //Jika belum login, arahkan ke halaman index.php (halaman login).
}
else{  //Jika sudah login, lanjutkan ke bagian berikutnya.
if(isset($_POST['update'])) //Mengecek apakah form update dikirim oleh admin
{
$pagetype='aboutus'; //Menentukan halaman mana yang diubah,di sini adalah halaman 'aboutus'.
$pagetitle=$_POST['pagetitle']; //Mengambil data dari form input dengan nama 'pagetitle'.
$pagedetails=$_POST['pagedescription']; //Mengambil data dari form input dengan nama 'pagedescription'.

$query=mysqli_query($con,"update tblpages set PageTitle='$pagetitle',Description='$pagedetails' where PageName='$pagetype' "); //Menjalankan query SQL untuk memperbarui judul dan deskripsi halaman 'aboutus' di tabel tblpages.
if($query)
{
$msg="About us  page successfully updated "; //Jika query berhasil, simpan pesan sukses ke variabel $msg.
}
else{
$error="Something went wrong . Please try again."; //Jika query gagal, simpan pesan error ke variabel $error.   
} 

}
?>

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
                                <h4 class="page-title">About Source Code </h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li>
                                        <a href="#">Pages</a>
                                    </li>

                                    <li class="active">
                                        Source Code
                                    </li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
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
//Mengambil data halaman 'aboutus' dari tabel tblpages untuk ditampilkan di form.
$pagetype='aboutus';
$query=mysqli_query($con,"select PageTitle,Description from tblpages where PageName='$pagetype'");
while($row=mysqli_fetch_array($query)) //dipakai untuk menampilkan datanya ke dalam form (biasanya hanya satu baris hasil).
{

?>
                    <!--Form untuk mengedit data-->
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="p-6">
                                <div class="">
                                    <form name="aboutus" method="post">
                                        <div class="form-group m-b-20">
                                            <label for="exampleInputEmail1">Page Title</label>
                                            <input type="text" class="form-control" id="pagetitle" name="pagetitle" value="<?php echo htmlentities($row['PageTitle'])?>" required>
                                        </div>

                                        <!--Textarea untuk isi halaman-->>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box">
                                                    <h4 class="m-b-30 m-t-0 header-title"><b>Page Details</b></h4>
                                                    <textarea class="summernote" name="pagedescription" required><?php echo htmlentities($row['Description'])?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <!--Tombol Update-->
                                        <button type="submit" name="update" class="btn btn-custom waves-effect waves-light btn-md">Update and Post</button> <!--Ketika tombol ini diklik, form akan mengirim data POST ke halaman yang sama. Blok PHP di awal file akan memproses dan memperbarui database.-->

                                    </form>
                                </div>
                            </div> <!-- end p-20 -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->

            <?php include('includes/footer.php');?>

            <?php } ?>