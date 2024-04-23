<?php include 'config.php'; ?>

<?php
if (isset($_POST['id_cart'])) {
    $idCart = $_POST['id_cart'];
    $qty = $_POST['qty'];
    $nama = $_POST['nm_brg'];

    // Perform the delete operation
    $sql_delete = "DELETE FROM keranjang WHERE id_cart = '$idCart'";
    $result = $conn->query($sql_delete);
    // Update stock
    $sql_update_stock = "UPDATE barang SET stok = stok + $qty WHERE nama_barang = '$nama'";
    $results = $conn->query($sql_update_stock);
    var_dump($results);
    die();
} else {
    // id_cart not set in the POST request
    echo "Invalid request";
}
?>
