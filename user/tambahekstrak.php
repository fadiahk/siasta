<?php

include 'assets/inc/koneksi.php';

if (isset($_POST['tambah_ekstra'])) {

  $nama = $_POST['nama_ekstra'];
  $desc = $_POST['desc_extra'];
  $tglinpt = date('Y-m-d');
  $filename = $_FILES['foto']['name'];
  $ukuran = $_FILES['foto']['size'];

  $rand = rand();
  if ($ukuran < 1044070) {
    session_start();
    $filenm = $rand . '_' . $filename;
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/ekstra/' . $filenm);
    mysqli_query($koneksi, "INSERT INTO ekstra(img_ekstra,nama_ekstra,desc_ekstra,tgl_upload,id_user) VALUES('$filenm','$nama','$desc','$tglinpt','$_SESSION[id_user]')");
    header("location:index.php?page=ekstrak");
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
        <h1 class="m-0">Ekstrak</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Ekstrak</li>
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
    <form action="tambahekstrak.php" method="POST" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group">
          <label>Image</label>
          <input type="file" name="foto" id="foto" class="form-control">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Nama Ekstra</label>
          <input type="text" class="form-control" id="nama_ekstra" name="nama_ekstra" placeholder="Nama Ekstra">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Deskripsi Ekstra</label>
          <textarea name="desc_extra" class="form-control" id="desc_extra" placeholder="Deskripsi Ekstra" cols="30" rows="8"></textarea>
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary" name="tambah_ekstra" id="tambah_ekstra">Submit</button>
        <a href="ekstrak.php" class="btn btn-danger">Cancel</a>
      </div>
    </form>
  </div>
</section>