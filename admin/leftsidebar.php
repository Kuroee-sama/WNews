<!-- Kontainer utama sidebar di sisi kiri -->
<div class="left side-menu">
    <!-- Pembungkus isi sidebar + scrollbar custom (slimscrollleft mengaktifkan plugin slimscroll) -->
    <div class="sidebar-inner slimscrollleft">

        <!--- Sidemenu -->
        <div id="sidebar-menu"> <!-- ID utama untuk blok menu; sering dipakai JS untuk toggle/expand -->
            <ul> <!-- Root list untuk item-item navigasi -->
                <li class="menu-title">Navigation</li> <!-- Judul seksi menu (non-klik) -->

                <!-- Item tunggal (tanpa submenu) menuju dashboard -->
                <li class="has_sub"> <!-- has_sub: kelas tema untuk item yang bisa punya submenu (meski di sini tidak ada UL anak) -->
                    <a href="dashboard.php" class="waves-effect">
                        <i class="mdi mdi-view-dashboard"></i> <!-- Ikon (Material Design Icons) -->
                        <span> Dashboard </span> <!-- Teks label menu -->
                    </a>
                </li>

                <!-- Category: item dengan submenu -->
                <li class="has_sub">
                    <!-- Link "dummy" untuk trigger submenu (javascript:void(0); tidak berpindah halaman) -->
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-format-list-bulleted"></i> <!-- Ikon kategori -->
                        <span> Category </span>
                        <span class="menu-arrow"></span> <!-- Panah indikator ada submenu -->
                    </a>
                    <!-- Submenu tidak ber-bullet (Bootstrap utility) -->
                    <ul class="list-unstyled">
                        <li><a href="add-category.php">Add Category</a></li> <!-- Tautan ke halaman tambah kategori -->
                        <li><a href="manage-categories.php">Manage Category</a></li> <!-- Tautan ke halaman kelola kategori -->
                    </ul>
                </li>

                <!-- Sub Category: item dengan submenu -->
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="ti ti-layout-list-thumb"></i> <!-- Ikon (Themify Icons / ti-*) -->
                        <span>Sub Category </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="add-subcategory.php">Add Sub Category</a></li>
                        <li><a href="manage-subcategories.php">Manage Sub Category</a></li>
                    </ul>
                </li>

                <!-- Posts (News): item dengan submenu -->
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-newspaper"></i> <!-- Ikon berita -->
                        <span> Posts (News) </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="add-post.php">Add Posts</a></li>       <!-- Tambah posting -->
                        <li><a href="manage-posts.php">Manage Posts</a></li> <!-- Kelola posting -->
                        <li><a href="trash-posts.php">Trash Posts</a></li>   <!-- Tong sampah posting -->
                    </ul>
                </li>

                <!-- CMS: item dengan submenu -->
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="ti ti-files"></i> <!-- Ikon file/halaman -->
                        <span> CMS </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="aboutus.php">About us</a></li>     <!-- Halaman statis "About" -->
                        <li><a href="contactus.php">Contact us</a></li> <!-- Halaman statis "Contact" -->
                    </ul>
                </li>

                <!-- Comments: item dengan submenu -->
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-comment-account-outline"></i> <!-- Ikon komentar -->
                        <span> Comments </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="unapprove-comment.php">Waiting for Approval </a></li> <!-- Komentar pending -->
                        <li><a href="manage-comments.php">Approved Comments</a></li>     <!-- Komentar disetujui -->
                    </ul>
                </li>

                <!-- Tautan biasa (tanpa submenu): menonton video -->
                <li>
                    <a href="#" class="waves-effect">
                        <i class="ti ti-info-alt"></i> <!-- Ikon informasi -->
                        <span>Watch Video</span>
                    </a>
                </li>

                <!-- Tautan biasa: pratinjau website -->
                <li>
                    <a href="#" class="waves-effect">
                        <i class="fa fa-eye" aria-hidden="true"></i> <!-- Ikon FontAwesome (mata/preview) -->
                        <span>Website Preview</span>
                    </a>
                </li>
            </ul>
        </div> <!-- /#sidebar-menu -->

        <!-- Sidebar -->
        <div class="clearfix"></div> <!-- Utility untuk clear float agar layout rapi -->
    </div> <!-- /.sidebar-inner -->
    <!-- Sidebar -left -->
</div> <!-- /.left.side-menu -->
