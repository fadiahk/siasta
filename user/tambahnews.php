<?php

include 'assets/inc/koneksi.php';

if (isset($_POST['tambah_news'])) {

  $judul = $_POST['judul_news'];
  $isi = $_POST['isi_news'];
  $tglinpt = date('Y-m-d');
  $filename = $_FILES['foto']['name'];
  $ukuran = $_FILES['foto']['size'];

  $rand = rand();
  if ($ukuran < 1044070) {
    session_start();
    $filenm = $rand . '_' . $filename;
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploadsnews/' . $filenm);
    mysqli_query($koneksi, "INSERT INTO news(judul_news,img_news,isi_news,tgl_upload,id_user) VALUES('$judul','$filenm','$isi','$tglinpt','$_SESSION[id_user]')");
    header("location:index.php?page=news");
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
        <h1 class="m-0">News</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">News</li>
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
      <h3 class="card-title">Tambah News </h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
  </div>
  <form action="tambahnews.php" method="POST" enctype="multipart/form-data">
    <div class="card-body">
      <div class="form-group">
        <label for="exampleInputPassword1">Judul</label>
        <input type="text" class="form-control" id="judul_news" name="judul_news" placeholder="Judul News">
      </div>
      <div class="form-group">
        <label>Image</label>
        <input type="file" name="foto" id="foto" class="form-control">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Isi</label>
        <textarea name="isi_news" class="form-control" id="isi_news" placeholder="Isi News" cols="30" rows="8"></textarea>
      </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary" name="tambah_news" id="tambah_news">Submit</button>
      <a href="news.php" class="btn btn-danger">Cancel</a>
    </div>
  </form>
  </div>
</section>