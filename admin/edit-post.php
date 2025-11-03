<?php 
   session_start();                                   // Memulai sesi PHP untuk memakai $_SESSION (mis. autentikasi).
   include('includes/config.php');                    // Memuat file konfigurasi (termasuk koneksi database $con).
   error_reporting(0);                                // Menonaktifkan penampilan error di output.
   if(strlen($_SESSION['login'])==0)                  // Mengecek apakah user belum login (string 'login' kosong).
     { 
   header('location:index.php');                      // Jika belum login, redirect ke index.php.
   }
   else{                                              // Jika sudah login, lanjutkan proses halaman.
   if(isset($_POST['update']))                        // Jika form disubmit dengan tombol bernama 'update'.
   {
   $posttitle=$_POST['posttitle'];                    // Ambil judul post dari input form.
   $catid=$_POST['category'];                         // Ambil ID kategori dari input form.
   $subcatid=$_POST['subcategory'];                   // Ambil ID subkategori dari input form.
   $postdetails=$_POST['postdescription'];            // Ambil detail/konten post dari editor (textarea).
   $lastuptdby=$_SESSION['login'];                    // Ambil nama/identitas user dari session (yang melakukan update).
   $arr = explode(" ",$posttitle);                    // Pecah judul per spasi menjadi array kata.
   $url=implode("-",$arr);                            // Gabungkan kembali dengan tanda '-' untuk membentuk slug URL sederhana.
   $status=1;                                         // Set status aktif (1).
   $postid=intval($_GET['pid']);                      // Ambil ID post dari parameter 'pid' (paksa integer).
   $query=mysqli_query($con,"update tblposts set PostTitle='$posttitle',CategoryId='$catid',SubCategoryId='$subcatid',PostDetails='$postdetails',PostUrl='$url',Is_Active='$status',lastUpdatedBy='$lastuptdby' where id='$postid'");
                                                      // Jalankan query UPDATE untuk memperbarui kolom-kolom post berdasarkan id.
   if($query)                                         // Jika query berhasil dieksekusi.
   {
   $msg="Post updated ";                              // Set pesan sukses ke variabel $msg.
   }
   else{
   $error="Something went wrong . Please try again."; // Set pesan error ke variabel $error jika gagal.
   } 
   }
   ?>
<?php include('includes/topheader.php');?>           <!-- Menyertakan bagian header atas (head/topbar/CSS/JS awal). -->
<script>
function getSubCat(val) {                             // Fungsi JS untuk mengambil subkategori via AJAX saat kategori berubah.
    $.ajax({
        type: "POST",                                 // Metode HTTP POST.
        url: "get_subcategory.php",                   // Endpoint yang dipanggil untuk mengambil data subkategori.
        data: 'catid=' + val,                         // Data yang dikirim: parameter catid dengan nilai kategori terpilih.
        success: function(data) {                     // Callback ketika request sukses.
            $("#subcategory").html(data);             // Isi elemen select #subcategory dengan HTML hasil dari server.
        }
    });
}
</script>
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>          <!-- Menyertakan sidebar kiri navigasi. -->
<!-- Left Sidebar End -->
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">                             <!-- Kontainer area konten sisi kanan. -->
    <!-- Start content -->
    <div class="content">                              <!-- Bagian konten utama. -->
        <div class="container">                        <!-- Kontainer Bootstrap agar lebar responsif. -->
            <div class="row">                          <!-- Baris untuk judul halaman & breadcrumb. -->
                <div class="col-xs-12">
                    <div class="page-title-box">       <!-- Kotak judul halaman. -->
                        <h4 class="page-title">Edit Post </h4>        <!-- Judul halaman. -->
                        <ol class="breadcrumb p-0 m-0">               <!-- Breadcrumb tanpa padding & margin. -->
                            <li>
                                <a href="#">Admin</a>                 <!-- Level breadcrumb: Admin. -->
                            </li>
                            <li>
                                <a href="#"> Posts </a>               <!-- Level breadcrumb: Posts. -->
                            </li>
                            <li class="active">
                                Add Post                              <!-- Level breadcrumb aktif (teks tampilan). -->
                            </li>
                        </ol>
                        <div class="clearfix"></div>                  <!-- Elemen pembersih float. -->
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">                          <!-- Baris untuk area alert pesan. -->
                <div class="col-sm-6">
                    <!---Success Message--->
                    <?php if($msg){ ?>                 <!-- Jika variabel $msg ada (pesan sukses). -->
                    <div class="alert alert-success" role="alert">
                        <strong>Well done!</strong> <?php echo htmlentities($msg);?>
                                                       <!-- Tampilkan pesan sukses (di-escape). -->
                    </div>
                    <?php } ?>
                    <!---Error Message--->
                    <?php if($error){ ?>               <!-- Jika variabel $error ada (pesan error). -->
                    <div class="alert alert-danger" role="alert">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error);?>
                                                       <!-- Tampilkan pesan error (di-escape). -->
                    </div>
                    <?php } ?>
                </div>
            </div>
            <!--  
            <?php
                     $postid=intval($_GET['pid']);   // Ambil ID post dari parameter 'pid' (integer).
                     $query=mysqli_query($con,"select tblposts.id as postid,tblposts.PostImage,tblposts.PostTitle as title,tblposts.PostDetails,tblcategory.CategoryName as category,tblcategory.id as catid,tblsubcategory.SubCategoryId as subcatid,tblsubcategory.Subcategory as subcategory from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join tblsubcategory on tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$postid' and tblposts.Is_Active=1 ");// Query SELECT untuk mengambil detail post + relasi kategori & subkategori yang aktif.
                     while($row=mysqli_fetch_array($query)) // Loop hasil query (diharapkan satu baris).
                     {
                     ?>
                <form name="addpost" method="post" class="row">     <!- Form untuk mengedit post (method POST). -->
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Post Title</label>        <!-- Label input judul. -->
                    <input type="text" class="form-control" id="posttitle" value="<?php echo htmlentities($row['title']);?>" name="posttitle" placeholder="Enter title" required>   <!-- Input judul diisi nilai dari DB; wajib. -->
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Category</label>    <!-- Label select kategori. -->
                    <select class="form-control" name="category" id="category" onChange="getSubCat(this.value);" required>
                        <option value="<?php echo htmlentities($row['catid']);?>"><?php echo htmlentities($row['category']);?></option>
                        <!-- Opsi pertama: kategori saat ini. -->
                        <?php
                                       // Feching active categories
                                       $ret=mysqli_query($con,"select id,CategoryName from  tblcategory where Is_Active=1");
                                       while($result=mysqli_fetch_array($ret)) // Loop melalui kategori aktif.
                                       {    
                                       ?>
                        <option value="<?php echo htmlentities($result['id']);?>"><?php echo htmlentities($result['CategoryName']);?></option> <!-- Opsi-opsi kategori aktif lainnya. -->
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Sub Category</label>  <!-- Label select subkategori. -->
                    <select class="form-control" name="subcategory" id="subcategory" required>
                        <option value="<?php echo htmlentities($row['subcatid']);?>"><?php echo htmlentities($row['subcategory']);?></option> <!-- Opsi awal: subkategori saat ini; akan diperbarui via AJAX saat kategori diubah. -->
                    </select>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="m-b-30 m-t-0 header-title"><b>Post Details</b></h4>   <!-- Judul bagian konten post. -->
                            <textarea class="summernote" name="postdescription" required><?php echo htmlentities($row['PostDetails']);?></textarea> <!-- Editor Summernote berisi konten post dari DB. -->
                        </div>
                    </div>
                </div>
                <div class="row">      <!-- Bagian pratinjau gambar post. -->
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="m-b-30 m-t-0 header-title"><b>Post Image</b></h4>       <!-- Judul bagian gambar. -->
                            <img src="postimages/<?php echo htmlentities($row['PostImage']);?>" width="300" />
                            <!-- Menampilkan gambar fitur saat ini (lebar 300px). -->
                            <br />
                            <a href="change-image.php?pid=<?php echo htmlentities($row['postid']);?>">Update Image</a>
                            <!-- Tautan ke halaman untuk mengubah gambar post. -->
                        </div>
                    </div>
                </div>
                <?php } ?> <!-- Penutup loop while. -->
                <button type="submit" name="update" class="btn btn-custom waves-effect waves-light btn-md">Update </button>
                <!-- Tombol submit untuk menyimpan perubahan post. -->
        </div> <!--   container -->
    </div> <!-- Penutup div .content -->
    <!-- content -->
    <?php include('includes/footer.php');?>        <!-- Menyertakan footer (script JS penutup, plugin, dsb). -->
    <?php } ?>                                     <!-- Menutup blok else awal (jika user sudah login). -->
