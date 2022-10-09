<?php
include 'assets/inc/koneksi.php';


if(isset($_POST['edit_ekstra'])){
  $id = $_POST['id_ekstra'];
  $nama = $_POST['nama_ekstra'];
  $desc = $_POST['desc_extra'];
  $tglinpt = date('Y-m-d');
  $filename = $_FILES['foto']['name'];
  $ukuran = $_FILES['foto']['size'];
  session_start();
  $query =  $query = "";
  if(!empty($filename)){
    $filenm = $rand.'_'.$filename;
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/ekstra/'.$filenm);
    $query = "UPDATE ekstra SET img_ekstra = '$filenm',nama_ekstra = '$nama',desc_ekstra = '$desc',tgl_upload = '$tglinpt',id_user = '$_SESSION[id_user]' WHERE id_ekstra = '$id';";
  }else{
    $query = "UPDATE ekstra SET nama_ekstra = '$nama',desc_ekstra = '$desc',tgl_upload = '$tglinpt',id_user = '$_SESSION[id_user]' WHERE id_ekstra = '$id';";
  }
    mysqli_query($koneksi, $query);
    header("location:index.php?page=ekstrak");

  

}
if(isset($_POST['delete_ekstra'])){
  $id = $_POST['id_ekstra'];
  $query = mysqli_query($koneksi,"DELETE FROM ekstra WHERE id_ekstra = '$id'");
  if($query){
    header('location:index.php?page=ekstrak');
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
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
              <a href="?page=tambah_ekstrak" class="btn btn-primary" id="btn_tambah" name="btn_tambah">Tambah</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <th>No</th>
                <th>Image</th>
                <th>Nama Ekstrakulikuler</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Penginput</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM ekstra INNER JOIN user ON ekstra.id_user = user.id_user;");
                if (mysqli_num_rows($query) > 0) {
                  while ($data = mysqli_fetch_array($query)) {

                ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><img src="uploads/ekstra/<?php echo $data['img_ekstra']; ?>" width="50" height="50"> </td>
                      <td><?php echo $data['nama_ekstra']; ?></td>
                      <td><?php echo $data['desc_ekstra']; ?></td>
                      <td><?php echo $data['tgl_upload']; ?></td>
                      <td><?php echo $data['nama_lengkap']; ?></td>
                      <td>
                        <a type="button" href="#" class="btn btn-warning" id="btn_edit" name="btn_edit" data-toggle="modal" data-target="#modal-edit-<?= $data['id_ekstra'] ?>">Edit</a>
                        <a type="button" href="#" class="btn btn-danger" id="btn_hapus" name="btn_hapus" data-toggle="modal" data-target="#modal-hapus-<?= $data['id_ekstra'] ?>">Hapus</a>
                      </td>
                    </tr>
                    <div class="modal fade" id="modal-edit-<?= $data['id_ekstra'] ?>">
                    <div class="modal-dialog">
                      <div class="modal-content bg-success">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="ekstrak.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                              <input type="hidden" name="id_ekstra" id="id_ekstra" value="<?=$data['id_ekstra'] ?>">
                              <div class="form-group">
                                  <label>Image</label>
                                  <input type="file" name="foto" id="foto" class="form-control">
                              </div>
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Nama Ekstra</label>
                                  <input type="text" class="form-control" id="nama_ekstra" value="<?=$data['nama_ekstra']?>"  name="nama_ekstra" placeholder="Nama Ekstra">
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Deskripsi Ekstra</label>
                                  <textarea name="desc_extra" class="form-control" id="desc_extra" placeholder="Deskripsi Ekstra" cols="30" rows="8"><?=$data['desc_ekstra']?></textarea>
                                </div>
                             </div>
                            
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-outline-light" name="edit_ekstra" id="edit_ekstra">Oke</button>
                            </div>
                          </form>
                          </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                    <div class="modal fade" id="modal-hapus-<?= $data['id_ekstra'] ?>">
                      <div class="modal-dialog">
                        <div class="modal-content bg-primary">
                          <div class="modal-header">
                            <h4 class="modal-title">Hapus</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="ekstrak.php" method="POST">
                            <div class="modal-body">
                              <input type="hidden" name="id_ekstra" id="id_ekstra" value="<?=$data['id_ekstra'] ?>">
                              <p>Apakah Anda Yakin Menghapus Data Ini ?</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-outline-light" name="delete_ekstra" id="delete_ekstra">Oke</button>
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
          <section class="content">
 </section>
                <!-- /.content -->