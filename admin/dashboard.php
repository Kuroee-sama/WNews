<?php
   session_start();                                // Memulai sesi PHP untuk memakai $_SESSION (mis. status login).
   include('includes/config.php');                 // Menyertakan konfigurasi, termasuk koneksi database ($con).
   error_reporting(0);                             // Menonaktifkan penampilan error (tidak ditampilkan ke output).
   if(strlen($_SESSION['login'])==0)               // Mengecek apakah variabel sesi 'login' kosong (belum login).
     { 
   header('location:index.php');                   // Jika belum login, alihkan ke halaman index.php.
   }
   else{                                           // Jika sudah login, lanjutkan eksekusi halaman.
       ?>
<?php include('includes/topheader.php');?>         // Menyertakan bagian top header (head, CSS/JS awal, topbar).
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> <!-- Memuat library ApexCharts dari CDN. -->
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>       <!-- Menyertakan sidebar kiri navigasi. -->
<!-- Left Sidebar End -->
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">                          <!-- Kontainer area konten sisi kanan (layout utama). -->
    <!-- Start content -->
    <div class="content">                           <!-- Bagian konten utama. -->
        <div class="container">                     <!-- Kontainer Bootstrap untuk lebar responsif. -->
            <div class="row">                       <!-- Baris untuk judul halaman & breadcrumb. -->
                <div class="col-xs-12">
                    <div class="page-title-box">    <!-- Kotak judul halaman. -->
                        <h4 class="page-title">Dashboard</h4>  <!-- Judul halaman yang ditampilkan. -->
                        <ol class="breadcrumb p-0 m-0">        <!-- Breadcrumb tanpa padding & margin. -->
                            <li>
                                <a href="#">NewsPortal</a>     <!-- Level breadcrumb: nama aplikasi. -->
                            </li>
                            <li>
                                <a href="#">Admin</a>          <!-- Level breadcrumb: bagian admin. -->
                            </li>
                            <li class="active">
                                Dashboard                      <!-- Level breadcrumb aktif: Dashboard. -->
                            </li>
                        </ol>
                        <div class="clearfix"></div>           <!-- Elemen untuk membersihkan float agar layout rapi. -->
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">                                   <!-- Baris pertama berisi 3 kolom kartu. -->

                <div class="col-md-4">                          <!-- Kolom 1/3 lebar medium. -->
                    <div class="card-box h-100">                <!-- Kartu dengan tinggi penuh kolom. -->
                        <div class="card-header">               <!-- Header kartu. -->
                            <h2 class="card-title mb-2">Welcome Admin </h2> <!-- Judul kartu. -->
                            <span class="d-block mb-4 text-nowrap">Freelancer from Indonesia</span> <!-- Subjudul. -->
                        </div>
                        <br><br>                                <!-- Jeda visual. -->
                        <div class="card-body">                 <!-- Isi kartu. -->
                            <div class="row ">                  <!-- Baris internal untuk grid dua kolom. -->
                                <div class="col-md-6">          <!-- Kolom kiri info. -->
                                    <h1 class="display-6 text-primary mb-2 pt-4 pb-1">2+ Years of Exprience</h1> <!-- Teks besar pengalaman. -->
                                    <small class="d-block mb-3">In <br>PHP, Laravel, Python, Dart, Flutter, C and Etc.</small> <!-- Daftar teknologi. -->
                                    <br>
                                    <br>
                                </div>
                                <div class="col-md-6">          <!-- Kolom kanan gambar. -->
                                    <img src="assets/images/prize-light.png" width="140" height="150" class="rounded-start"> <!-- Gambar ilustrasi. -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">                          <!-- Kolom 2/3 lebar medium. -->
                    <div class="card-box h-100">                <!-- Kartu untuk grafik kunjungan. -->
                        <div class="card-body">                 <!-- Isi kartu. -->
                            <div class="row ">                  <!-- Baris internal. -->
                                <div class="card-header">       <!-- Header kartu. -->
                                    <h4 class="card-title m-0">Visits of 2025</h4> <!-- Judul grafik. -->
                                </div>
                                <div id="chart">                <!-- Kontainer elemen grafik ApexCharts. -->
                                    <apexchart type="radialBar" height="265" :options="chartOptions" :series="series"></apexchart>
                                    <!-- Tag kustom (placeholder) tidak dipakai oleh ApexCharts vanilla; div #chart akan dipakai oleh JS di bawah. -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="manage-categories.php">                <!-- Tautan membungkus kartu statistik kategori. -->
                    <div class="col-lg-2 col-md-2 col-sm-6">    <!-- Kolom kecil responsif. -->
                        <div class="card-box widget-box-one text-center"> <!-- Kartu widget. -->
                            <i class="mdi mdi-chart-areaspline widget-one-icon"></i> <!-- Ikon MDI untuk widget. -->
                            <div class="wigdet-one-content">    <!-- Konten widget. -->
                                <p class="m-0 text-secondary" title="Statistics">Categories Listed</p> <!-- Label statistik. -->
                                <?php $query=mysqli_query($con,"select * from tblcategory where Is_Active=1");
                           $countcat=mysqli_num_rows($query);
                           ?>                                   <!-- PHP: Query menghitung kategori aktif. -->
                                <h2><?php echo htmlentities($countcat);?> <small></small></h2> <!-- Menampilkan jumlah kategori. -->
                            </div>
                        </div>
                    </div>
                </a>                                             <!-- Penutup tautan kartu kategori. -->
                <!-- end col -->
                <a href="manage-posts.php">                     <!-- Tautan membungkus kartu statistik posting aktif. -->
                    <div class="col-lg-2 col-md-2 col-sm-6">    <!-- Kolom kecil responsif. -->
                        <div class="card-box widget-box-one text-center"> <!-- Kartu widget. -->
                            <i class="mdi mdi-layers widget-one-icon"></i> <!-- Ikon MDI. -->
                            <div class="wigdet-one-content">    <!-- Konten widget. -->
                                <p class="m-0 text-secondary" title="User This Month">Live News</p> <!-- Label statistik posting. -->
                                <?php $query=mysqli_query($con,"select * from tblposts where Is_Active=1");
                           $countposts=mysqli_num_rows($query);
                           ?>                                   <!-- PHP: Query menghitung posting aktif. -->
                                <h2><?php echo htmlentities($countposts);?> <small></small></h2> <!-- Menampilkan jumlah posting. -->
                            </div>
                        </div>
                    </div>
                </a>                                             <!-- Penutup tautan kartu posting. -->
                <a href="manage-subcategories.php">             <!-- Tautan membungkus kartu statistik subkategori. -->
                    <div class="col-lg-4 col-md-4 col-sm-6">    <!-- Kolom lebih lebar untuk subkategori. -->
                        <div class="card-box widget-box-one text-center"> <!-- Kartu widget. -->
                            <i class="mdi mdi-layers widget-one-icon"></i> <!-- Ikon MDI. -->
                            <div class="wigdet-one-content">    <!-- Konten widget. -->
                                <p class="m-0 text-secondary" title="User This Month">Listed Subcategories</p> <!-- Label statistik subkategori. -->
                                <?php $query=mysqli_query($con,"select * from tblsubcategory where Is_Active=1");
                           $countsubcat=mysqli_num_rows($query);
                           ?>                                   <!-- PHP: Query menghitung subkategori aktif. -->
                                <h2><?php echo htmlentities($countsubcat);?> <small></small></h2> <!-- Menampilkan jumlah subkategori. -->
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </a>                                             <!-- Penutup tautan kartu subkategori. -->

            </div>                                              <!-- Penutup baris pertama kartu. -->
            <div class="row">                                   <!-- Baris kedua (komentar berisi widget sampah yang dinonaktifkan). -->
                <!--  <a href="trash-posts.php">
               <div class="col-lg-4 col-md-4 col-sm-6">
                  <div class="card-box widget-box-one">
                     <i class="mdi mdi-layers widget-one-icon"></i>
                     <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Trash News</p>
                        <?php $query=mysqli_query($con,"select * from tblposts where Is_Active=0");
                  $countposts=mysqli_num_rows($query);
                  ?>
                        <h2><?php echo htmlentities($countposts);?> <small></small></h2>
                     </div>
                  </div>
               </div>
               </a> -->
            </div>
            <div class="col-sm-12">                            <!-- Kolom penuh untuk tabel berita terbaru. -->
                <div class="card-box">                         <!-- Kartu berisi tabel. -->
                    <h2>Recent News Post</h2>                  <!-- Judul bagian. -->
                    <div class="table-responsive">             <!-- Wrapper agar tabel responsif (scroll horizontal). -->
                        <table class="table table-bordered" id="example"> <!-- Tabel dengan border, id 'example' (untuk DataTables). -->
                            <thead>
                                <tr>
                                    <th>Title</th>             <!-- Header kolom judul. -->
                                    <th>Category</th>          <!-- Header kolom kategori. -->
                                    <th>Subcategory</th>       <!-- Header kolom subkategori. -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                           $query=mysqli_query($con,"select tblposts.id as postid,tblposts.PostTitle as title,tblcategory.CategoryName as category,tblsubcategory.Subcategory as subcategory from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join tblsubcategory on tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=1 ");
                           $rowcount=mysqli_num_rows($query);   // Menghitung jumlah baris hasil query (jumlah berita aktif).
                           if($rowcount==0)                     // Jika tidak ada data.
                           {
                           ?>
                                <tr>
                                    <td colspan="4" align="center">
                                        <h3 style="color:red">No record found</h3> <!-- Pesan tidak ada data. -->
                                    </td>
                                <tr>
                                    <?php 
                              } else {                          // Jika ada data, iterasi setiap baris.
                              while($row=mysqli_fetch_array($query))
                              {
                              ?>
                                <tr>
                                    <td><?php echo htmlentities($row['title']);?></td>       <!-- Sel judul berita (di-escape). -->
                                    <td><?php echo htmlentities($row['category'])?></td>     <!-- Sel nama kategori (di-escape). -->
                                    <td><?php echo htmlentities($row['subcategory'])?></td>  <!-- Sel nama subkategori (di-escape). -->
                                </tr>
                                <?php } }?>                     <!-- Penutup while & if. -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>                                                  <!-- Penutup .container. -->
    </div>                                                      <!-- Penutup .content. -->
    <?php include('includes/footer.php');?>                     <!-- Menyertakan footer (script JS akhir, plugin, dll). -->
</div>                                                          <!-- Penutup .content-page. -->
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

<!-- Right Sidebar -->
<div class="side-bar right-bar">                                <!-- Sidebar kanan (panel pengaturan). -->
    <a href="javascript:void(0);" class="right-bar-toggle">     <!-- Tombol untuk menutup panel kanan. -->
        <i class="mdi mdi-close-circle-outline"></i>            <!-- Ikon close (MDI). -->
    </a>
    <h4 class="">Settings</h4>                                   <!-- Judul panel pengaturan. -->
    <div class="setting-list nicescroll">                       <!-- Daftar pengaturan dengan custom scroll. -->

        <div class="row m-t-20">                                <!-- Item pengaturan: Notifications. -->
            <div class="col-xs-8">
                <h5 class="m-0">Notifications</h5>
                <p class="text-muted m-b-0"><small>Do you need them?</small></p>
            </div>
            <div class="col-xs-4 text-right">
                <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small" />
                <!-- Switch (Switchery) default aktif. -->
            </div>
        </div>

        <div class="row m-t-20">                                <!-- Item pengaturan: API Access. -->
            <div class="col-xs-8">
                <h5 class="m-0">API Access</h5>
                <p class="m-b-0 text-muted"><small>Enable/Disable access</small></p>
            </div>
            <div class="col-xs-4 text-right">
                <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small" />
            </div>
        </div>

        <div class="row m-t-20">                                <!-- Item pengaturan: Auto Updates. -->
            <div class="col-xs-8">
                <h5 class="m-0">Auto Updates</h5>
                <p class="m-b-0 text-muted"><small>Keep up to date</small></p>
            </div>
            <div class="col-xs-4 text-right">
                <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small" />
            </div>
        </div>

        <div class="row m-t-20">                                <!-- Item pengaturan: Online Status. -->
            <div class="col-xs-8">
                <h5 class="m-0">Online Status</h5>
                <p class="m-b-0 text-muted"><small>Show your status to all</small></p>
            </div>
            <div class="col-xs-4 text-right">
                <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small" />
            </div>
        </div>
    </div>

</div>
<!-- /Right-bar -->
</div>                                                          <!-- Penutup #wrapper (jika dibuka di header). -->
<!-- END wrapper -->
<script>
var options = {                                                 // Obyek konfigurasi untuk ApexCharts.
    series: [44, 55, 67],                                       // Nilai seri data (tiga angka untuk radial bars).
    chart: {
        height: 265,                                            // Tinggi chart 265px.
        type: 'radialBar',                                      // Jenis chart: radialBar.
    },
    plotOptions: {
        radialBar: {
            dataLabels: {
                name: {
                    fontSize: '40px',                           // Ukuran font label 'name'.
                },
                value: {
                    fontSize: '16px',                           // Ukuran font label 'value'.
                },
                total: {
                    show: true,                                  // Menampilkan bagian total di tengah chart.
                    label: 'Total',                              // Label teks 'Total'.
                    formatter: function(w) {                     // Fungsi untuk menentukan nilai total yang ditampilkan.
                        // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                        return 249                               // Mengembalikan angka total kustom (249).
                    }
                }
            }
        }
    },
    labels: ['Apples', 'Oranges', 'Bananas'],                   // Label untuk masing-masing seri.
};

var chart = new ApexCharts(document.querySelector("#chart"), options); // Membuat instance chart pada elemen #chart.
chart.render();                                                 // Merender chart ke dalam DOM.
</script>
<?php } ?>                                                      <!-- Menutup blok else awal (jika user sudah login). -->
