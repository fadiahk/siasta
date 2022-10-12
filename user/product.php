<?php
include 'assets/inc/koneksi.php';

if(isset($_POST['edit_product'])){
  $id = $_POST['id_product'];
  $nama = $_POST['nama_produk'];
  $desc = $_POST['desc_produk'];
  $toko = $_POST['toko'];
  $tglinpt = date('Y-m-d');
  $filename = $_FILES['foto']['name'];
  $ukuran = $_FILES['foto']['size'];
  session_start();
  $query =  $query = "";
  if(!empty($filename)){
    $filenm = $rand.'_'.$filename;
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploadsproduct'.$filenm);
    $query = "UPDATE produk SET img_produk = '$filenm',nama_produk = '$nama',desc_produk = '$desc',tgl_upload = '$tglinpt',id_user = '$_SESSION[id_user]' WHERE id_produk = '$id';";
  }else{
    $query = "UPDATE produk SET nama_produk = '$nama',desc_produk = '$desc',tgl_upload = '$tglinpt',id_user = '$_SESSION[id_user]' WHERE id_produk = '$id';";
  }
    mysqli_query($koneksi, $query);
    header("location:index.php?page=product");

  

}
if(isset($_POST['delete_product'])){
  $id = $_POST['id_produk'];
  $query = mysqli_query($koneksi,"DELETE FROM produk WHERE id_produk = '$id'");
  if($query){
    header('location:index.php?page=product');
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
          <li class="breadcrumb-item active">Produk</li>
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
              <a href="?page=tambah_product" class="btn btn-primary" id="btn_tambah" name="btn_tambah">Tambah</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <th>No</th>
                <th>Image</th>
                <th>Nama Produk</th>
                <th>Deskripsi</th>
                <th>Tanggal Upload</th>
                <th>Toko</th>
                <th>Penginput</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM produk INNER JOIN user ON produk.id_user = user.id_user;");
                if (mysqli_num_rows($query) > 0) {
                  while ($data = mysqli_fetch_array($query)) {

                ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $data['img_produk']; ?></td>
                      <td><?php echo $data['nama_produk']; ?></td>
                      <td><?php echo $data['desc_produk']; ?></td>
                      <td><?php echo $data['tgl_upload']; ?></td>
                      <td><?php echo $data['toko']; ?></td>
                      <td><?php echo $data['nama_lengkap']; ?></td>
                      <td>
                        <a type="button" href="#" class="btn btn-warning" id="btn_edit" name="btn_edit" data-toggle="modal" data-target="#modal-edit-<?= $data['id_produk']?>">Edit</a>
                        <a type="button" href="#" class="btn btn-danger" id="btn_hapus" name="btn_hapus" data-toggle="modal" data-target="#modal-hapus-<?= $data['id_produk']?> ">Hapus</a>
                      </td>
                    </tr>
                    <div class="modal fade" id="modal-edit-<?= $data['id_produk'] ?>">
                    <div class="modal-dialog">
                      <div class="modal-content bg-success">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="produk.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                              <input type="hidden" name="id_produk" id="id_produk" value="<?=$data['id_data'] ?>
                              <div class="from-group>
                                <label>Image</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                              </div>
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Nama Produk</label>
                                  <input type="text" class="form-control" id="nama_produk" value="<?=$data['nama_roduk']?>"  name="nama_produk" placeholder="Nama Produk">
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Deskripsi Produk</label>
                                  <textarea name="desc_extra" class="form-control" id="desc_produk" placeholder="Deskripsi Produk" cols="30" rows="8"><?=$data['desc_produk']?></textarea>
                                </div>
                             </div>
                            
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-outline-light" name="edit_produk" id="edit_produk">Oke</button>
                            </div>
                          </form>
                          </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                    <div class="modal fade" id="modal-hapus-<?= $data['id_produk'] ?>">
                      <div class="modal-dialog">
                        <div class="modal-content bg-primary">
                          <div class="modal-header">
                            <h4 class="modal-title">Hapus</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="produk.php" method="POST">
                            <div class="modal-body">
                              <input type="hidden" name="id_produk" id="id_produk" value="<?=$data['id_produk'] ?>">
                              <p>Apakah Anda Yakin Menghapus Data Ini ?</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-outline-light" name="delete_produk" id="delete_produk">Oke</button>
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