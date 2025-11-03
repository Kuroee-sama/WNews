<!DOCTYPE html> <!-- Deklarasi tipe dokumen HTML5 -->
<html lang="en"> <!-- Dokumen HTML dengan bahasa utama Inggris -->

<head>
    <title>Live W'News Portal</title> <!-- Judul tab/browser -->

    <link rel="icon" type="image/x-icon" href="assets/images/favicon.png"> <!-- Favicon situs -->

    <!-- Stylesheet inti tema dan dependency UI -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> <!-- Bootstrap CSS -->
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />          <!-- Core style tema -->
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />    <!-- Komponen UI -->
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />         <!-- Icon font (MDI/TI/FA) -->
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />         <!-- Style per halaman -->
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />          <!-- Style untuk menu/sidebar -->
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />    <!-- Responsif layout -->

    <link rel="stylesheet" href="../plugins/switchery/switchery.min.css"> <!-- CSS plugin Switchery (toggle) -->

    <script src="assets/js/modernizr.min.js"></script> <!-- Modernizr: deteksi fitur browser (dimuat di head) -->

    <!-- Summernote css -->
    <link href="../plugins/summernote/summernote.css" rel="stylesheet" /> <!-- CSS editor WYSIWYG Summernote -->

    <!-- Select2 -->
    <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" /> <!-- CSS Select2 -->

    <!-- Jquery filer css -->
    <link href="../plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" /> <!-- CSS jQuery Filer (unggah file) -->
    <link href="../plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" /> <!-- Tema Filer -->

    <!-- DataTables + Buttons CSS dari CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"> <!-- Buttons CSS -->

    <script>
    function checkAvailability() {                 // Fungsi JS untuk cek ketersediaan username via AJAX
        $("#loaderIcon").show();                   // Tampilkan indikator loading (elemen dengan id=loaderIcon)
        jQuery.ajax({                              // Panggilan AJAX (menggunakan jQuery)
            url: "check_availability.php",         // Endpoint server untuk pengecekan
            data: 'username=' + $("#sadminusername").val(), // Kirim data: ambil nilai dari input #sadminusername
            type: "POST",                           // Metode POST
            success: function(data) {               // Callback sukses
                $("#user-availability-status").html(data); // Tampilkan respon di elemen #user-availability-status
                $("#loaderIcon").hide();                    // Sembunyikan loading
            },
            error: function() {}                    // Callback error (kosong; bisa diisi pesan/log)
        });
    }
    </script>
</head>

<body class="fixed-left"> <!-- Body dengan kelas 'fixed-left' (layout tema: sidebar kiri fixed) -->
    <!-- Begin page -->
    <div id="wrapper"> <!-- Pembungkus seluruh halaman (dipakai untuk layouting) -->

        <div class="topbar"> <!-- Baris atas (top navigation/header) -->

            <!-- LOGO -->
            <div class="topbar-left"> <!-- Area kiri topbar untuk logo -->

                <a href="index.php" class="logo"> <!-- Tautan logo ke halaman index -->
                    <span>
                        <img src="assets/images/logo.png" alt="" height="60"> <!-- Gambar logo tinggi 60px -->
                    </span>
                </a>

            </div> <!-- /topbar-left -->

            <!-- Tombol tampilan mobile untuk collapse sidebar menu -->
            <div class="navbar navbar-default" role="navigation"> <!-- Navbar Bootstrap (default skin) -->
                <div class="container"> <!-- Kontainer lebar tetap Bootstrap -->

                    <!-- Navbar-left -->
                    <ul class="nav navbar-nav navbar-left"> <!-- Grup item navbar di kiri -->
                        <li>
                            <button class="button-menu-mobile open-left waves-effect"> <!-- Tombol toggle sidebar kiri -->
                                <i class="mdi mdi-menu"></i> <!-- Ikon burger menu (Material Design Icons) -->
                            </button>
                        </li>
                    </ul>

                    <!-- Marquee pengumuman/trending -->
                    <ul class="nav navbar-nav" style=" width: 50%; margin-top: 23px; color: red;"> <!-- List navbar tengah -->
                        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                            <b>Today Trending News : </b>Online news portal.
                        </marquee> <!-- <marquee> adalah tag usang (obsolete). Di-pause saat mouseover. -->
                        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                            <b> Notes : </b>This is an educational project from where you can gain knowledge. No one can claim it as their own or sell it for their own sake. If you want to create any project, contact us through Facebook, YouTube or website.
                        </marquee>
                    </ul>

                    <div id="google_translate_element"> <!-- Kontainer widget Google Translate (diisi via JS di footer) -->
                    </div>

                    <!-- Right(Notification) -->
                    <ul class="nav navbar-nav navbar-right"> <!-- Grup item navbar di kanan (user/profile, notif, dll.) -->

                        <li class="dropdown user-box"> <!-- Item dropdown untuk user -->
                            <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                <img src="assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle user-img"> <!-- Avatar bulat -->
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                                <li>
                                    <h5>Hi, Admin</h5> <!-- Sapaan pengguna -->
                                </li>
                                <li><a href="change-password.php"><i class="ti-settings m-r-5"></i> Change Password</a></li> <!-- Menu ubah password -->
                                <li><a href="logout.php"><i class="ti-power-off m-r-5"></i> Logout</a></li>               <!-- Menu logout -->
                            </ul>
                        </li>

                    </ul> <!-- end navbar-right -->

                </div><!-- end container -->
            </div><!-- end navbar -->
        </div> <!-- end topbar -->
