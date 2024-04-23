<?php include 'template/header.php';?>
  <div class="col-md-9 mb-2">
    <div class="row">

    <!-- table barang -->
    <div class="col-md-7 mb-2">
                
<?php
error_reporting(0);
if(isset($_POST['get'])){
  require "config.php";
    $id = $_POST['id_login'];
    // $user = $_POST['user'];
    // $pass = $_POST['pass'];
    $n_toko = $_POST['nama_toko'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $result = mysqli_query($conn, "UPDATE toko SET nama_toko='$n_toko',alamat='$alamat',telepon='$telp' WHERE id='$id'");
    if(!$result){
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
  <strong>NOOO!</strong> data gagal di update.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>
<meta http-equiv='refresh' content='1; url= pengaturan.php'/>
        ";
        } else{
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>YESSS!</strong> data berhasil di update.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>
<meta http-equiv='refresh' content='1; url= pengaturan.php'/>
        ";
        }
}?>
<?php
// $result1 = mysqli_query($conn, "SELECT * FROM login");
// $data = mysqli_fetch_array($result1);

$toko = mysqli_query($conn, "SELECT * FROM toko");
$data2 = mysqli_fetch_array($toko);


?>
        <div class="card">
        <div class="card-header bg-purple">
                <div class="card-tittle text-white"><i class="fa fa-cog"></i> <b>Account Setting</b></div>
            </div>
            <div class="card-body">
                <form method="POST">
                <fieldset>

                  <div class="form-group row">
                  <input type="hidden" name="id_login" value="<?= $data2['id'];?>">
                    <label class="col-sm-4 col-form-label"><b>Nama Toko :</b></label>
                    <div class="col-sm-8 mb-2">
                      <input type="text" name="nama_toko" class="form-control" value="<?= $data2['nama_toko'] ?>" required>
                    </div>
                    <label class="col-sm-4 col-form-label"><b>Telepon :</b></label>
                    <div class="col-sm-8 mb-2">
                      <input type="number" name="telp" class="form-control" value="<?= $data2['telepon'] ?>" required>
                    </div>
                    <label class="col-sm-4 col-form-label"><b>Alamat :</b></label>
                    <div class="col-sm-8 mb-2">
                      <input type="text" name="alamat" class="form-control" value="<?= $data2['alamat'] ?>" required>
                    </div>
                  </div>
                <div class="text-right">
                    <button class="btn btn-purple" name="get" type="submit">Update</button>
                </div>
                </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!-- end table barang -->

    </div><!-- end row col-md-9 -->
  </div>

<?php include 'template/footer.php';?>
