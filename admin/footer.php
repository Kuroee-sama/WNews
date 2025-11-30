<footer class="foot text-center" style=" position: sticky;
  top: 0;"> <!-- Elemen footer dengan kelas 'foot' dan 'text-center'; inline style membuatnya sticky di bagian atas viewport (top:0). -->
    <?php echo date('Y');?> <!-- PHP: menampilkan tahun berjalan (mis. 2025). -->
    © Design and Developed by <!-- Teks statis yang tampil setelah tahun. -->
    <a href="https://wa.me/6288210491045"> GROUP 8</a> <!-- Link ke situs (ada spasi di awal href, sebaiknya dihapus). Teks link: "MH RONY". -->
</footer> <!-- Penutup elemen footer. -->
</div> <!-- Menutup sebuah wrapper <div> yang dibuka di template lain. -->
</div> <!-- Menutup wrapper <div> lain (pastikan jumlahnya sesuai pembuka). -->
<!-- END wrapper --> <!-- Komentar penanda akhir blok wrapper di template. -->
<script>
var resizefunc = []; // Membuat array global untuk menampung fungsi-fungsi yang dipicu saat resize (dipakai beberapa template admin).
</script>
<!-- jQuery  --> <!-- Komentar penanda bagian library jQuery dan plugin. -->

<script src="assets/js/jquery.min.js"></script> <!-- Memuat jQuery; wajib sebelum plugin-plugin berbasis jQuery. -->
<script src="assets/js/bts.js"></script> <!-- Skrip UI kustom/bundle (kemungkinan bootstrap atau skrip tema). -->
<script src="assets/js/detect.js"></script> <!-- Deteksi device/fitur browser untuk penyesuaian UI. -->
<script src="assets/js/fastclick.js"></script> <!-- Mengurangi delay 300ms pada klik di perangkat sentuh (legacy). -->
<script src="assets/js/jquery.blockUI.js"></script> <!-- Plugin untuk memblokir UI (overlay) saat proses berlangsung. -->
<script src="assets/js/waves.js"></script> <!-- Efek gelombang (ripple) pada elemen tombol/klik. -->
<script src="assets/js/jquery.slimscroll.js"></script> <!-- Scrollbar kustom yang ramping untuk kontainer. -->
<script src="assets/js/jquery.scrollTo.min.js"></script> <!-- Helper untuk animasi scroll ke elemen/posisi. -->
<script src="../plugins/switchery/switchery.min.js"></script> <!-- Plugin switch/toggle bergaya iOS. -->

<script src="assets/js/jquery.core.js"></script> <!-- Skrip inti dari tema (mengikat komponen, utilitas). -->
<script src="assets/js/jquery.app.js"></script> <!-- Inisialisasi aplikasi/tema (memanggil fungsi dari core). -->

<script src="../plugins/summernote/summernote.min.js"></script> <!-- WYSIWYG editor (Summernote) untuk textarea. -->
<!-- Select 2 --> <!-- Komentar pemisah untuk bagian Select2. -->
<script src="../plugins/select2/js/select2.min.js"></script> <!-- Plugin Select2 (dropdown dengan pencarian). -->

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> <!-- Library DataTables inti (tabel interaktif). -->
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> <!-- Extension tombol (export/copy). -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> <!-- Dependensi export Excel (XLSX/ZIP). -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> <!-- Dependensi export PDF (PDFMake). -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> <!-- Font bawaan untuk PDFMake. -->
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> <!-- Tombol export HTML5 (copy/excel/csv/pdf). -->

<script>
$(document).ready(function() { // Menunggu DOM siap sebelum inisialisasi DataTable pertama.
    $('#example').DataTable({ // Mengaktifkan DataTables pada tabel dengan id="example".
        dom: 'Bfrtip', // Layout komponen: Buttons, filter, table, info, pagination.
        buttons: [
            'copyHtml5', // Tombol salin ke clipboard.
            'excelHtml5', // Tombol export ke Excel (butuh JSZip).
            'csvHtml5', // Tombol export ke CSV.
            'pdfHtml5' // Tombol export ke PDF (butuh pdfmake + vfs_fonts).
        ]
    });
});
$(document).ready(function() { // Handler DOM siap kedua (bisa digabung dengan yang pertama).
    $('#example1').DataTable({ // Mengaktifkan DataTables pada tabel dengan id="example1".
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });
});
</script>

<script>
jQuery(document).ready(function() { // Inisialisasi plugin form saat DOM siap.

    $('.summernote').summernote({ // Mengaktifkan editor Summernote untuk elemen dengan class "summernote".
        height: 240, // Tinggi editor 240px.
        minHeight: null, // Tidak ada batas tinggi minimum selain 'height'.
        maxHeight: null, // Tidak ada batas tinggi maksimum.
        focus: false // Tidak langsung fokus ke editor setelah inisialisasi.
    });
    // Select2
    $(".select2").select2(); // Mengaktifkan Select2 pada elemen dengan class "select2".

    $(".select2-limiting").select2({
        maximumSelectionLength: 2 // Membatasi pilihan maksimal (untuk multiple select) menjadi 2 item.
    });
});
</script>

<script src="../plugins/switchery/switchery.min.js"></script> <!-- (Duplikat) Memuat Switchery kedua kali; sebaiknya dihapus. -->

<!--Summernote js-->
<script src="../plugins/summernote/summernote.min.js"></script> <!-- (Duplikat) Memuat Summernote kedua kali; sebaiknya dihapus. -->

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> <!-- Memuat widget Google Translate; memanggil callback 'googleTranslateElementInit'. -->
<script type="text/javascript">
function googleTranslateElementInit() { // Callback inisialisasi yang dipanggil saat skrip Translate selesai dimuat.
    new google.translate.TranslateElement({
        pageLanguage: 'en' // Bahasa asli halaman diset ke Inggris (ubah ke 'id' jika konten utamanya Bahasa Indonesia).
    }, 'google_translate_element'); // ID elemen container untuk menempatkan widget terjemahan.
}
</script>

<style>
.goog-logo-link {
    display: none !important; /* Menyembunyikan tautan/logo Google pada widget (berpotensi melanggar ketentuan branding Google). */
}

.goog-te-gadget {
    color: transparent; /* Menyembunyikan teks default gadget (membuat tampil minimalis). */
}

.goog-te-gadget .goog-te-combo {
    margin: 0px 0; /* Margin atas-bawah 0. */
    padding: 8px; /* Padding dalam dropdown 8px. */
    color: #000; /* Warna teks dropdown hitam. */
    background: #eeee; /* Warna latar dropdown (sebaiknya gunakan #eee atau #eeeeee untuk konsistensi heksadesimal). */
}

#google_translate_element {
    padding-top: 13px; /* Ruang atas 13px untuk posisi widget. */
    position: absolute; /* Posisi absolut relatif terhadap ancestor berposisi (relative/absolute/fixed). */
    top: 7px; /* Jarak 7px dari atas ancestor. */
    right: 100px; /* Jarak 100px dari kanan ancestor. */
}
</style>

</body> <!-- Penutup elemen <body> halaman. -->

</html> <!-- Penutup dokumen HTML. -->