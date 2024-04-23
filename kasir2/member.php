<?php
// Include file koneksi database
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $diskon = $_POST['diskon'] / 100;

    // Validasi form
    if (empty($nama) || empty($alamat) || empty($telepon)) {
        echo "
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Harap mengisi semua field yang diperlukan.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
        ";
    } else {
        $sql = "INSERT INTO member (nama, alamat, telepon, diskon) VALUES ('$nama', '$alamat', '$telepon', $diskon)";

        if (mysqli_query($conn, $sql)) {
            echo "
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Member baru berhasil ditambahkan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'member.php';
                    }
                });
            </script>
            ";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Query untuk mengambil data member dari database
$query = "SELECT * FROM member";
$result = mysqli_query($conn, $query);
?>

<?php include 'template/header.php'; ?>

<div class="card-b">
    <div class="card-header bg-purple">
        <div class="card-tittle text-white"><i class="fa fa-user-plus"></i> <b>Tambah Member</b></div>
    </div>
    <div class="card-body" style="background-color:#ffffff;">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="telepon">Nomor Telepon:</label>
                <input type="text" class="form-control" id="telepon" name="telepon" required>
            </div>
            <div class="form-group">
                <label for="diskon">Diskon (%):</label>
                <input type="number" class="form-control" id="diskon" name="diskon" min="0" max="100" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-purple">Tambah Member</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-purple">
        <div class="card-tittle text-white"><i class="fa fa-user"></i> <b>Daftar Member</b></div>
    </div>
    <div class="card-body">
        <table id="memberTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Diskon (%)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['telepon']; ?></td>
                        <td><?php echo $row['diskon'] * 100; ?>%</td>
                        <td>
                            <a href="#" class="btn btn-danger btn-sm" onclick="confirmDeleteMember(<?php echo $row['id']; ?>)"><i class="fa fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function confirmDeleteMember(memberId) {
        Swal.fire({
            title: "Konfirmasi Hapus",
            text: "Anda yakin ingin menghapus member ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteMember(memberId);
            }
        });
    }

    function deleteMember(memberId) {
        $.ajax({
            url: "delete_member.php",
            type: "POST",
            data: {
                id: memberId
            },
            success: function(response) {
                if (response === "success") {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Member berhasil dihapus.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan saat menghapus member.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat menghapus member.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    }
</script>


<?php include 'template/footer.php'; ?>