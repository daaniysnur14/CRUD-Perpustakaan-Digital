<?php
$pesan = "";
$status = "";

// Kode ini jalan hanya kalau tombol Simpan ditekan
if (isset($_POST['simpan'])) {

    // 1. Ambil data dari form
    $nomor     = $_POST['nomor'];
    $judul     = $_POST['judul'];
    $isbn      = $_POST['isbn'];
    $tahun     = $_POST['tahun_terbit'];
    $pengarang = $_POST['pengarang'];
    $kategori  = $_POST['kategori'];

    // 2. Hubungkan ke database
    $conn = mysqli_connect("localhost", "root", "", "perpustakaan");

    // 3. Simpan data (pakai prepared statement supaya aman)
    try {
        $stmt = mysqli_prepare($conn, "INSERT INTO buku VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ississ", $nomor, $judul, $isbn, $tahun, $pengarang, $kategori);
        mysqli_stmt_execute($stmt);

        $pesan = "Buku berhasil ditambahkan!";
        $status = "sukses";
    } catch (Exception $e) {
        $pesan = "Gagal menyimpan. Nomor buku mungkin sudah dipakai.";
        $status = "gagal";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAMBAH BUKU</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="card">
        <h2>📚 Form Tambah Buku</h2>

        <!-- Pesan sukses / gagal -->
        <?php if ($pesan != "") { ?>
            <div class="pesan <?php echo $status; ?>">
                <?php echo $pesan; ?>
            </div>
        <?php } ?>

        <form method="POST" action="">
            <label>Nomor</label>
            <input type="number" name="nomor" required>

            <label>Judul Buku</label>
            <input type="text" name="judul" required>

            <label>ISBN</label>
            <input type="text" name="isbn" required>

            <label>Tahun Terbit</label>
            <input type="number" name="tahun_terbit" required>

            <label>Pengarang</label>
            <input type="text" name="pengarang" required>

            <label>Kategori</label>
            <select name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option>Novel</option>
                <option>Komik</option>
                <option>Pendidikan</option>
                <option>Teknologi</option>
                <option>Lainnya</option>
            </select>

            <button type="submit" name="simpan">Simpan</button>
        </form>
    </div>

</body>
</html>