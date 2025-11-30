<?php 
   session_start();                                   // Mulai sesi: dipakai untuk autentikasi & ambil user (postedBy)
   include('includes/config.php');                    // Koneksi DB ($con) dan konfigurasi lain
   error_reporting(0);                                // Menyembunyikan error di output (baiknya log saja, lihat catatan)

   if(strlen($_SESSION['login'])==0)                  // Cek apakah user belum login (session 'login' kosong)
     { 
   header('location:index.php');                      // Redirect ke halaman login
   }                                                  // (disarankan tambahkan exit; setelah header)
   else{
  
   // get the image extension
   $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile)); // Ambil 4 char terakhir sebagai "ekstensi"
   // Catatan: trik ini mendukung ".jpg", ".png", ".gif" dan "jpeg" (tanpa titik) tapi rapuh untuk variasi lain.

   // allowed extensions
   $allowed_extensions = array(".jpg","jpeg",".png",".gif");          // Daftar ekstensi yang diizinkan

   // Validation for allowed extensions .in_array() function searches an array for a specific value.
   if(!in_array($extension,$allowed_extensions))      // Jika ekstensi tidak ada di daftar allowed
   {
   echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>"; // Peringatan
   }
   else
   {
   //rename the image file
   $imgnewfile=md5($imgfile).$extension;              // Nama baru: md5 dari nama lama + ekstensi (mengurangi tabrakan, tapi tidak unik 100%)

   // Code for move image into directory
   move_uploaded_file($_FILES["postimage"]["tmp_name"],"postimages/".$imgnewfile); // Pindahkan file ke folder 'postimages'
   
   $status=1;                                         // Status aktif (published) default
   $query=mysqli_query($con,"insert into tblposts(PostTitle,CategoryId,SubCategoryId,PostDetails,PostUrl,Is_Active,PostImage,postedBy) values('$posttitle','$catid','$subcatid','$postdetails','$url','$status','$imgnewfile','$postedby')");
                                                     // Insert post ke DB (saat ini masih raw SQL tanpa prepared)

   if($query)
   {
   $msg="Post successfully added ";                   // Pesan sukses untuk alert
   }
   else{
   $error="Something went wrong . Please try again."; // Pesan gagal untuk alert
   } 
   
   }                                                  // end if ekstensi valid
   }                                                  // end if submit
   ?>
<!-- Top Bar Start -->
<?php include('includes/topheader.php');?>            <!-- Header + CSS/JS awal dan topbar -->
<style>
  /* Hanya editor Post Details di halaman ini */
  .summernote-post + .note-editor .note-editable {
    min-height: 600px; /* ubah sesuai kebutuhan */
  }
</style>
<script>
function getSubCat(val) {                              // JS: ambil subkategori via AJAX ketika kategori berubah
    $.ajax({
        type: "POST",
        url: "get_subcategory.php",                    // Endpoint yang mengembalikan <option> subkategori
        data: 'catid=' + val,                          // Kirim catid (ID kategori) ke server
        success: function(data) {
            $("#subcategory").html(data);              // Isi <select id="subcategory"> dengan hasil
        }
    });
}
</script>
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>          <!-- Sidebar kiri -->
<!-- Left Sidebar End -->

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">                             <!-- Area konten kanan -->
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Add Post </h4>             <!-- Judul halaman -->
                        <ol class="breadcrumb p-0 m-0">                   <!-- Breadcrumb -->
                            <li>
                                <a href="#">Post</a>
                            </li>
                            <li>
                                <a href="#">Add Post </a>
                            </li>
                            <li class="active">
                                Add Post
                            </li>
                        </ol>
                        <div class="clearfix"></div>                      <!-- Clear float -->
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-sm-6">
                    <!---Success Message--->
                    <?php if($msg){ ?>                                     <!-- Jika ada pesan sukses -->
                    <div class="alert alert-success" role="alert">
                        <strong>Well done!</strong> <?php echo htmlentities($msg);?>  <!-- Tampilkan aman -->
                    </div>
                    <?php } ?>
                    <!---Error Message--->
                    <?php if($error){ ?>                                   <!-- Jika ada pesan error -->
                    <div class="alert alert-danger" role="alert">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error);?>  <!-- Tampilkan aman -->
                    </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Form tambah post -->
            <form name="addpost" method="post" class="row" enctype="multipart/form-data"> <!-- multipart untuk upload file -->
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Post Title</label>
                    <input type="text" class="form-control" id="posttitle" name="posttitle" placeholder="Enter title" required> <!-- Judul wajib -->
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Category</label>
                    <select class="form-control" name="category" id="category" onChange="getSubCat(this.value);" required>
                        <option value="">Select Category </option>
                        <?php
                          // Feching active categories
                          $ret=mysqli_query($con,"select id,CategoryName from  tblcategory where Is_Active=1");
                          while($result=mysqli_fetch_array($ret)) // Loop melalui kategori aktif
                          {    
                        ?>
                        <option value="<?php echo htmlentities($result['id']);?>"><?php echo htmlentities($result['CategoryName']);?></option>
                        <?php } ?>
                    </select>                                                <!-- Pilih kategori, memicu pengambilan subkategori -->
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Sub Category</label>
                    <select class="form-control" name="subcategory" id="subcategory" required>
                    </select>                                               <!-- Akan terisi via AJAX dari kategori yang dipilih -->
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="m-b-30 m-t-0 header-title"><b>Post Details</b></h4>
                           <textarea class="summernote summernote-post" name="postdescription" required></textarea>
<!-- Konten WYSIWYG -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="m-b-30 m-t-0 header-title"><b>Feature Image</b></h4>
                            <input type="file" class="form-control" id="postimage" name="postimage" required> <!-- File gambar -->
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" name="submit" class="btn btn-custom waves-effect waves-light btn-md">Save and Post</button>
                <button type="button" class="btn btn-danger waves-effect waves-light">Discard</button> <!-- Saat ini tidak melakukan apa-apa -->
            </form>

        </div> <!-- container -->
    </div> <!-- content -->

    <?php include('includes/footer.php');?>           <!-- Footer + script inisialisasi plugin -->
    <?php } ?>                                        <!-- Tutup blok else (sudah login) -->
