<?php include 'template/header.php'; ?>
<?php
include 'config.php';

if (isset($_POST['add_barang'])) {
    $id = $_POST['id_barang'];
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga_barang'];
    $tgl = $_POST['tgl_input'];
    $stok = $_POST['stok'];

    mysqli_query($conn, "INSERT INTO barang (id_barang, nama_barang, harga_barang, tgl_input, stok) VALUES ('$id', '$nama', '$harga', '$tgl', '$stok')")
        or die(mysqli_error($conn));
    echo '<script>window.location="barang.php"</script>';
}

if (isset($_POST['submit_penjualan'])) {
    $id_barang = $_POST['id_barang_terjual'];
    $jumlah_terjual = $_POST['jumlah_terjual'];

    // Ambil stok barang yang tersedia
    $query_stok = mysqli_query($conn, "SELECT stok FROM barang WHERE id_barang = '$id_barang'");
    $data_stok = mysqli_fetch_assoc($query_stok);
    $stok_sekarang = $data_stok['stok'];

    // Kurangi stok barang yang tersedia sesuai dengan jumlah yang terjual
    $stok_baru = $stok_sekarang - $jumlah_terjual;

    // Update stok barang yang tersedia
    mysqli_query($conn, "UPDATE barang SET stok = '$stok_baru' WHERE id_barang = '$id_barang'")
        or die(mysqli_error($conn));

    echo '<script>window.location="barang.php"</script>';
}

$query = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(id_barang, 4) AS UNSIGNED)) AS kodeTerbesar FROM barang");
$data = mysqli_fetch_array($query);
$kodeBarang = $data['kodeTerbesar'];
$urutan = (int) $kodeBarang;
$urutan++;
$huruf = "BRG";
$kodeBarang = $huruf . sprintf("%03s", $urutan);
?>

<div class="col-md-9 mb-2">
    <div class="row">
        <!-- barang -->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header bg-purple">
                    <div class="card-tittle text-white"><i class="fa fa-shopping-cart"></i> <b>Tambah Barang</b></div>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><b>Kode Barang</b></label>
                                <input type="text" name="id_barang" class="form-control" value="<?php echo $kodeBarang; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label><b>Nama Barang</b></label>
                                <input type="text" name="nama_barang" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label><b>Harga Barang</b></label>
                                <input type="number" name="harga_barang" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label><b>Stok Barang</b></label>
                                <input type="number" name="stok" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label><b>Tanggal Input</b></label>
                                <input type="text" name="tgl_input" class="form-control" value="<?php echo date("j F Y, G:i"); ?>" readonly>
                            </div>
                            <div class="form-group  col-md-6" style="margin-top: 33px;"> 
                                <button name="add_barang" class="btn btn-purple" type="submit">Tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end barang -->

        <!-- table barang -->
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header bg-purple">
                    <div class="card-tittle text-white"><i class="fa fa-table"></i> <b>Data Barang</b></div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-sm dt-responsive nowrap" id="table_barang" width="100%">
                        <thead class="thead-purple">
                            <tr>
                                <th>No</th>
                                <th>Id Barang</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Tanggal Input</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $data_barang = mysqli_query($conn, "SELECT * FROM barang");
                            while ($d = mysqli_fetch_array($data_barang)) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $d['id_barang']; ?></td>
                                    <td><?php echo $d['nama_barang']; ?></td>
                                    <td><?php echo $d['harga_barang']; ?></td>
                                    <td><?php echo $d['stok']; ?></td>
                                    <td><?php echo $d['tgl_input']; ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-xs" href="edit.php?id=<?php echo $d['id']; ?>">
                                            <i class="fa fa-pen fa-xs"></i> Edit
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="#" onclick="confirmDelete('?id=<?php echo $d['id_barang']; ?>')">
                                            <i class="fa fa-trash fa-xs"></i> Hapus
                                        </a>

                                        <script>
                                            function confirmDelete(url) {
                                                Swal.fire({
                                                    title: 'Hapus Data Barang?',
                                                    text: 'Anda tidak akan dapat mengembalikan data yang telah dihapus!',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#3085d6',
                                                    confirmButtonText: 'Ya, Hapus!',
                                                    cancelButtonText: 'Batal'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = url;
                                                    }
                                                });
                                            }
                                        </script>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end table barang -->
    </div><!-- end row col-md-9 -->
</div>
<?php
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $hapus_data = mysqli_query($conn, "DELETE FROM barang WHERE id_barang ='$id'");
    echo '<script>window.location="barang.php"</script>';
}
?>
<?php include 'template/footer.php'; ?>