<?php
session_start();    //Memulai sesi PHP untuk mengelola data sesi pengguna.
error_reporting(0); //Menonaktifkan tampilan pesan error agar tampilan halaman tetap rapi.
include('includes/config.php'); //Mengimpor file konfigurasi yang berisi koneksi database.

if(isset($_POST['submit'])) //Memeriksa apakah form telah disubmit dengan tombol bernama 'submit'.
  {
    $username=$_POST['username']; //Mengambil input username dari form.
    $email=$_POST['email']; //Mengambil input email dari form.
$password=md5($_POST['newpassword']); //Mengambil input password baru dari form dan mengenkripsinya menggunakan MD5.
        $query=mysqli_query($con,"select id from tbladmin where  AdminEmailId='$email' and AdminUserName='$username' "); //Menjalankan query untuk mencari admin dengan username dan email yang cocok di tabel tbladmin
        
    $ret=mysqli_num_rows($query); //Menghitung jumlah baris hasil query (apakah ada admin yang cocok).
    if($ret>0){ //Jika ada admin yang cocok (ret > 0).
      $query1=mysqli_query($con,"update tbladmin set AdminPassword='$password'  where  AdminEmailId='$email' && AdminUserName='$username' "); //Menjalankan query untuk memperbarui password admin di tabel tbladmin.
       if($query1)
   {
echo "<script>alert('Password successfully changed');</script>"; //Menampilkan alert bahwa password berhasil diubah.
echo "<script type='text/javascript'> document.location = 'index.php'; </script>"; //Mengalihkan pengguna ke halaman index.php (halaman login).

   }
     
    }
    else{
    
      echo "<script>alert('Invalid Details. Please try again.');</script>"; //Menampilkan alert bahwa detail yang dimasukkan tidak valid.
    }
  }

  ?>

    <!--Tampilan (HTML dan form) untuk input data lupa password.-->
        

        <body class="bg-transparent">

            <!-- HOME -->
            <section>
                <div class="container-alt">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="wrapper-page">

                                <div class="m-t-40 account-pages">
                                    <div class="text-center account-logo-box">
                                        <h2 class="text-uppercase">
                                            <a href="index.php" class="text-success">
                                                <span><img src="assets/images/logo.png" alt="" height="56"></span>
                                            </a>
                                        </h2>
                                        <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                                    </div>
                                     <!--Tampilan Form Lupa Password-->
                                    <div class="account-content">
                                        <form class="form-horizontal" method="post">

                                            <div class="form-group ">
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text" required="" name="username" placeholder="Username" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text" required="" name="email" placeholder="Email" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <input type="password" class="form-control" id="userpassword" name="confirmpassword" placeholder="Confirm Password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <input type="password" class="form-control" id="userpassword" name="newpassword" placeholder="New Password">
                                                </div>
                                            </div>

                                            <!-- Tombol Reset Password yang memicu fungsi checkpass() sebelum mengirim form. -->
                                            <div class="form-group account-btn text-center m-t-10">
                                                <div class="col-xs-12">
                                                    <button class="btn w-md btn-bordered btn-danger waves-effect waves-light" type="submit" name="submit">Reset</button>
                                                </div>
                                            </div>

                                        </form>

                                        <div class="clearfix"></div>
                                        <a href="../index.php"><i class="mdi mdi-home"></i> Back Home</a> <!--Tautan untuk kembali ke halaman utama situs.-->
                                    </div>
                                </div>
                                <!-- end card-box-->

                            </div>
                            <!-- end wrapper -->

                        </div>
                    </div>
                </div>
            </section>
            <!-- END HOME -->

            <script>
            var resizefunc = [];
            </script>

            <!-- jQuery  -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/detect.js"></script>
            <script src="assets/js/fastclick.js"></script>
            <script src="assets/js/jquery.blockUI.js"></script>
            <script src="assets/js/waves.js"></script>
            <script src="assets/js/jquery.slimscroll.js"></script>
            <script src="assets/js/jquery.scrollTo.min.js"></script>

            <!-- App js -->
            <script src="assets/js/jquery.core.js"></script>
            <script src="assets/js/jquery.app.js"></script>
            
        </body>

        </html>