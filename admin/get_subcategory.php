<?php
include('includes/config.php'); //Mengimpor file konfigurasi yang berisi koneksi database.
if(!empty($_POST["catid"])) //Memeriksa apakah ada data POST dengan nama 'catid'.
{
 $id=intval($_POST['catid']); //Query SQL untuk mengambil semua data subkategori aktif (Is_Active=1) yang punya CategoryId sama dengan $id. Misal $id = 3, maka semua subkategori dari kategori ke-3 akan ditampilkan.
$query=mysqli_query($con,"SELECT * FROM tblsubcategory WHERE CategoryId=$id and Is_Active=1"); //Menjalankan query SQL untuk mengambil semua subkategori yang memiliki CategoryId sesuai dengan $id dan status aktif (Is_Active=1).
?>
        <option value="">Select Subcategory</option> 
        <?php
 while($row=mysqli_fetch_array($query)) //Looping untuk setiap baris hasil query.
 {
  ?>
        <option value="<?php echo htmlentities($row['SubCategoryId']); ?>"><?php echo htmlentities($row['Subcategory']); ?></option> <!--Artinya setiap subkategori akan dibuat jadi pilihan dropdown-->
        <?php
 }
}
?>