<?php
include 'assets/inc/koneksi.php';


if (isset($_POST['edit_news'])) {
  $id = $_POST['id_news'];
  $judul = $_POST['judul_news'];
  $isi = $_POST['isi_news'];
  $tglinpt = date('Y-m-d');
  $filename = $_FILES['foto']['name'];
  $ukuran = $_FILES['foto']['size'];
  session_start();
  $query =  $query = "";
  if (!empty($filename)) {
    $filenm = $rand . '_' . $filename;
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/news/' . $filenm);
    $query = "UPDATE news SET img_news = '$filenm',judul_news = '$judul',isi_news= '$isi',tgl_upload = '$tglinpt',id_user = '$_SESSION[id_user]' WHERE id_news = '$id';";
  } else {
    $query = "UPDATE news SET judul_news = '$judul',isi_news = '$isi',tgl_upload = '$tglinpt',id_user = '$_SESSION[id_user]' WHERE id_news = '$id';";
  }
  mysqli_query($koneksi, $query);
  header("location:index.php?page=news");
}
if (isset($_POST['delete_news'])) {
  $id = $_POST['id_news'];
  $query = mysqli_query($koneksi, "DELETE FROM news WHERE id_news = '$id'");
  if ($query) {
    header('location:index.php?page=news');
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
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
              <a href="?page=tambah_news" class="btn btn-primary" id="btn_tambah" name="btn_tambah">Tambah</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <th>No</th>
                <th>Image</th>
                <th>Judul</th>
                <th>Isi</th>
                <th>Tanggal</th>
                <th>Penginput</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM news INNER JOIN user ON news.id_user = user.id_user;");
                if (mysqli_num_rows($query) > 0) {
                  while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><img src="uploadsnews/<?php echo $data['img_news']; ?>" width="50" height="50"> </td>
                      <td><?php echo $data['judul_news']; ?></td>
                      <td><?php echo $data['isi_news']; ?></td>
                      <td><?php echo $data['tgl_upload']; ?></td>
                      <td><?php echo $data['nama_lengkap']; ?></td>
                      <td>
                        <a type="button" href="#" class="btn btn-warning" id="btn_edit" name="btn_edit" data-toggle="modal" data-target="#modal-edit-<?= $data['id_news'] ?>">Edit</a>
                        <a type="button" href="#" class="btn btn-danger" id="btn_hapus" name="btn_hapus" data-toggle="modal" data-target="#modal-hapus-<?= $data['id_news'] ?>">Hapus</a>
                      </td>
                    </tr>
                    <div class="modal fade" id="modal-edit-<?= $data['id_news'] ?>">
                      <div class="modal-dialog">
                        <div class="modal-content bg-success">
                          <div class="modal-header">
                            <h4 class="modal-title">Edit</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="news.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="exampleInputPassword1"> Judul </label>
                              <input type="text" class="form-control" id="judul_news" value="<?= $data['judul_news'] ?>" name="judul_news" placeholder="Judul ">
                            </div>
                            <div class="modal-body">
                              <input type="hidden" name="id_news" id="id_news" value="<?= $data['id_news'] ?>">
                              <div class="form-group">
                                <label>Image</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                              </div>
                              <div class="form-group">
                                <label for="exampleInputPassword1">Isi News</label>
                                <textarea name="isi_news" class="form-control" id="isi_news" placeholder="Isi News" cols="30" rows="8"><?= $data['isi_news'] ?></textarea>
                              </div>
                            </div>

                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-outline-light" name="edit_news" id="edit_news">Oke</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <div class="modal fade" id="modal-hapus-<?= $data['id_news'] ?>">
                      <div class="modal-dialog">
                        <div class="modal-content bg-primary">
                          <div class="modal-header">
                            <h4 class="modal-title">Hapus</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="news.php" method="POST">
                            <div class="modal-body">
                              <input type="hidden" name="id_news" id="id_news" value="<?= $data['id_news'] ?>">
                              <p>Apakah Anda Yakin Menghapus Data Ini ?</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-outline-light" name="delete_news" id="delete_news">Oke</button>
                            </div>
                          </form>

                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan="7" class="text-center text-muted">Tidak Ada Data</td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->

        </div>
      </div>
    </div>
  </div>

</section>
<!-- /.content -->