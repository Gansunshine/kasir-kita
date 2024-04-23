<?php
// Include file koneksi database
include 'config.php';
session_start();

// Ambil ID member dari permintaan AJAX
$memberId = $_POST['id'];

// Query untuk menghapus member dari database
$query = "DELETE FROM member WHERE id = $memberId";

if (mysqli_query($conn, $query)) {
    // Jika berhasil, kirim respon sukses
    echo "success";
} else {
    // Jika gagal, kirim respon kesalahan
    echo "error";
}