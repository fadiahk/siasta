<?php

include 'assets/inc/koneksi.php';

if (isset($_POST['tambah_product'])) {

    $nama = $_POST['nama_produk'];
    $desc = $_POST['desc_produk'];
    $toko = $_POST['toko'];
    $tglinpt = date('Y-m-d');
    $filename = $_FILES['foto']['name'];
    $ukuran = $_FILES['foto']['size'];

    $rand = rand();
    if ($ukuran < 1044070) {
        session_start();
        $filenm = $rand . '_' . $filename;
        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploadsproduct' . $filenm);
        mysqli_query($koneksi, "INSERT INTO produk(img_produk,nama_produk,desc_produk,tgl_upload,toko,id_user) VALUES('$filenm','$nama','$desc','$tglinpt','$toko','$_SESSION[id_user]')");
        header("location:index.php?page=product");
    } else {
?>
        <script>
            alert("Ukuran Gambar Terlalu Besar")
        </script>
<?php
    }
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Produk</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">produk</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Di Sini</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="tambahproduct.php" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nama Produk</label>
                    <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Toko</label>
                    <input type="text" class="form-control" id="toko" name="toko" placeholder="Toko">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Deskripsi Produk</label>
                    <textarea name="desc_produk" class="form-control" id="desc_produk" placeholder="Deskripsi Produk" cols="30" rows="8"></textarea>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="tambah_produk" id="tambah_produk">Submit</button>
                <a href="product.php" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</section>