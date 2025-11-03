-->                                       <!-- Karakter penutup komentar HTML yang tersisa di awal file (output literal ">"). -->
<?php
   session_start();                       // Memulai sesi PHP agar bisa menggunakan $_SESSION (mis. status login).
   include('includes/config.php');        // Menyertakan file konfigurasi (termasuk koneksi database $con).
   error_reporting(0);                    // Menonaktifkan penampilan error di output (error tetap terjadi).
   if(strlen($_SESSION['login'])==0)      // Mengecek apakah user belum login (string 'login' kosong).
     { 
   header('location:index.php');          // Jika belum login, alihkan ke halaman index.php (login).
   }
   else{                                  // Jika sudah login, lanjutkan pemrosesan halaman.
   if(isset($_POST['submit']))            // Jika form disubmit dengan tombol bernama 'submit'.
   {
   $aid=intval($_GET['said']);            // Ambil ID subadmin dari parameter URL 'said', paksa menjadi integer.
   $email=$_POST['emailid'];              // Ambil nilai email baru dari input form 'emailid'.
   $query=mysqli_query($con,"Update  tbladmin set AdminEmailId='$email'  where userType=0 && id='$aid'");
                                          // Menjalankan query UPDATE untuk mengubah email subadmin dengan id & userType=0.
   if($query)                             // Jika query berhasil dijalankan.
   {
   echo "<script>alert('Sub-admin details updated.');</script>";
                                          // Tampilkan alert JS bahwa data subadmin berhasil diperbarui.
   }
   else{
   echo "<script>alert('Something went wrong . Please try again.');</script>";
                                          // Jika gagal, tampilkan alert JS kesalahan umum.
   } 
   }
   

   ?>
        <?php include('includes/topheader.php');?>   // Menyertakan bagian top header (head/topbar/CSS/JS awal).
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->
        <?php include('includes/leftsidebar.php');?> // Menyertakan sidebar kiri navigasi.
        <!-- Left Sidebar End -->
        <div class="content-page">                   <!-- Kontainer area konten sisi kanan. -->
            <!-- Start content -->
            <div class="content">                    <!-- Bagian konten utama. -->
                <div class="container">              <!-- Kontainer Bootstrap untuk lebar responsif. -->
                    <div class="row">                <!-- Baris judul halaman & breadcrumb. -->
                        <div class="col-xs-12">
                            <div class="page-title-box">      <!-- Kotak judul halaman. -->
                                <h4 class="page-title">Edit Subadmin</h4>  <!-- Judul halaman. -->
                                <ol class="breadcrumb p-0 m-0">            <!-- Breadcrumb tanpa padding & margin. -->
                                    <li>
                                        <a href="#">Admin</a>             <!-- Level breadcrumb: Admin. -->
                                    </li>
                                    <li>
                                        <a href="#">Subadmin </a>         <!-- Level breadcrumb: Subadmin. -->
                                    </li>
                                    <li class="active">
                                        Edit Subadmin                      <!-- Level breadcrumb aktif: Edit Subadmin. -->
                                    </li>
                                </ol>
                                <div class="clearfix"></div>               <!-- Elemen pembersih float. -->
                            </div>
                        </div>
                    </div>
                    <!--                                      <!-- Pembuka komentar HTML (bagian ini dikomentari). -->
                                                            <!-- end row -->
                    <div class="row">                       <!-- Baris untuk card form edit. -->
                        <div class="col-sm-12">
                            <div class="card-box">          <!-- Card/container untuk form. -->
                                <h4 class="m-t-0 header-title"><b>Edit Subadmin </b></h4> <!-- Judul card. -->
                                <hr />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!---Success Message--->
                                        <?php if($msg){ ?>   <!-- Jika variabel $msg terisi (pesan sukses). -->
                                        <div class="alert alert-success" role="alert">
                                            <strong>Well done!</strong> <?php echo htmlentities($msg);?> <!-- Tampilkan pesan sukses (di-escape). -->
                                        </div>
                                        <?php } ?>
                                        <!---Error Message--->
                                        <?php if($error){ ?>  <!-- Jika variabel $error terisi (pesan error). -->
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error);?> <!-- Tampilkan pesan error (di-escape). -->
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--                                      <!-- Pembuka komentar HTML (bagian form data). -->

                                <?php 
                              $aid=intval($_GET['said']);         // Mengambil kembali ID subadmin dari parameter 'said' (integer).
                              $query=mysqli_query($con,"Select * from  tbladmin where userType=0 && id='$aid'");
                                                                   // Query SELECT mengambil data subadmin dengan userType=0 dan id tertentu.
                              $cnt=1;                              // Variabel penghitung (tidak digunakan pada tampilan).
                              while($row=mysqli_fetch_array($query)) // Loop hasil query (diharapkan satu baris).
                              {
                              ?>
                                <div class="row">                 <!-- Baris berisi form edit subadmin. -->
                                    <form class="row" name="suadmin" method="post">  <!-- Form POST untuk menyimpan perubahan. -->
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Username</label> <!-- Label input username. -->
                                            <input type="text" class="form-control" value="<?php echo htmlentities($row['AdminUserName']);?>" name="adminusernmae" readonly>
                                                                                           <!-- Input username (readonly) diisi dari DB. -->
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class=" control-label">Emailid</label> <!-- Label input email. -->
                                            <div class="">
                                                <input type="text" class="form-control" value="<?php echo htmlentities($row['AdminEmailId']);?>" name="emailid" required>
                                                                                           <!-- Input email (required) diisi dari DB. -->
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Creation Dtae</label> <!-- Label tanggal pembuatan. -->
                                            <input type="text" class="form-control" value="<?php echo htmlentities($row['CreationDate']);?>" name="cdate" readonly>
                                                                                               <!-- Input readonly tanggal pembuatan akun. -->
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Updation date</label> <!-- Label tanggal pembaruan. -->
                                            <input type="text" class="form-control" value="<?php echo htmlentities($row['UpdationDate']);?>" name="udate" readonly>
                                                                                               <!-- Input readonly tanggal terakhir diperbarui. -->
                                        </div>
                                        <?php } ?>                 <!-- Penutup loop while setelah menampilkan field. -->
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                                                Update            <!-- Tombol submit untuk menyimpan perubahan email subadmin. -->
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>                              <!-- Penutup .container -->
                <!-- container -->
            </div>                                  <!-- Penutup .content -->
            <!-- content -->
            <?php include('includes/footer.php');?>  <!-- Menyertakan footer (script JS penutup, plugin, dsb). -->
            <!--                                      <!-- Pembuka komentar HTML (bagian yang dikomentari). -->
            <?php } ?>                               <!-- Penutup blok else awal (jika user sudah login). -->
