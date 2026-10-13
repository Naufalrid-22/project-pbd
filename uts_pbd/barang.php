<?php
include 'koneksi.php';

// ===== CREATE =====
if (isset($_POST['tambah'])) {
    $idbarang = $_POST['idbarang'];
    $jenis = $_POST['jenis'];
    $nama = $_POST['nama'];
    $status = $_POST['status'];
    $harga = $_POST['harga'];
    $idsatuan = $_POST['idsatuan'];

    $query = "INSERT INTO barang (idbarang, jenis, nama, status, harga, idsatuan)
    VALUES ('$idbarang', '$jenis', '$nama', '$status', '$harga', '$idsatuan')";

    mysqli_query($conn, $query);
    header("Location: barang.php");
    exit;
}

// ----- UPDATE -----
if (isset($_POST['update'])) {
    $idbarang = $_POST['idbarang'];
    $jenis = $_POST['jenis'];
    $nama = $_POST['nama'];
    $status = $_POST['status'];
    $harga = $_POST['harga'];
    $idsatuan = $_POST['idsatuan'];

    $query = "UPDATE barang 
    SET jenis = '$jenis',
        nama = '$nama',
        status = '$status',
        harga = '$harga',
        idsatuan = '$idsatuan'
    WHERE idbarang = '$idbarang'";

    mysqli_query($conn, $query);
    header("Location: barang.php");
    exit;
}

// ----- DELETE -----
if (isset($_GET['hapus'])) {
    $idbarang = $_GET['hapus'];

    $query = "DELETE FROM barang WHERE idbarang = '$idbarang'";

    mysqli_query($conn, $query);
    header("Location: barang.php");
    exit;
}

// ----- Data yang diedit -----
$data_edit = null;

if (isset($_GET['edit'])) {
    $idbarang = $_GET['edit'];

    $query = "SELECT * FROM barang WHERE idbarang = '$idbarang'";

    $hasil = mysqli_query($conn, $query);
    $data_edit = mysqli_fetch_assoc($hasil);
}

// ----- Read -----
$query_satuan = "SELECT * FROM satuan ORDER BY idsatuan ASC";
$data_satuan = mysqli_query($conn, $query_satuan);

$query_barang = "SELECT b.idbarang, b.jenis, b.nama, b.idsatuan, s.nama_satuan, b.status, b.harga
FROM barang b JOIN satuan s 
ON b.idsatuan = s.idsatuan
ORDER BY b.idbarang ASC";
$data_barang= mysqli_query($conn, $query_barang);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Data Barang</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f5f6fa;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
        }

        h1 {
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f1f2f6;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .tambah {
            background: #2ecc71;
            color: white;
        }

        .update {
            background: #3498db;
            color: white;
        }

        .edit {
            background: #f1c40f;
            color: black;
        }

        .hapus {
            background: #e74c3c;
            color: white;
        }

        .cancel {
            background: #7f8c8d;
            color: white;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Data Barang</h1>


    <!-- ================================= -->
    <!-- FORM TAMBAH / EDIT -->
    <!-- ================================= -->

    <div class="card">

        <h2>
            <?= $data_edit ? "Edit Barang" : "Tambah Barang"; ?>
        </h2>

        <form method="POST">

            <!-- ID BARANG -->
            <div class="form-group">

                <label>ID Barang</label>

                <input
                    type="number"
                    name="idbarang"
                    value="<?= $data_edit['idbarang'] ?? ''; ?>"
                    <?= $data_edit ? 'readonly' : ''; ?>
                    required>

            </div>


            <!-- JENIS -->
            <div class="form-group">
                <label>Jenis</label>
                    <select name="jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="M" <?= isset($data_edit) && $data_edit['jenis'] == 'M' ? 'selected': ''; ?>>Makanan</option>
                        <option value="N" <?= isset($data_edit) && $data_edit['jenis'] == 'M' ? 'selected': ''; ?>>Non Makanan</option>
                    </select>
            </div>


            <!-- NAMA -->
            <div class="form-group">

                <label>Nama</label>

                <input
                    type="text"
                    name="nama"
                    value="<?= $data_edit['nama'] ?? ''; ?>"
                    required>

            </div>      

            <!-- ID SATUAN -->
            <div class="form-group">

                <label>Satuan</label>

                <select name="idsatuan" required>

                    <option value="">
                        -- Pilih Satuan --
                    </option>

                    <?php while ($satuan = mysqli_fetch_assoc($data_satuan)): ?>

                        <option
                            value="<?= $satuan['idsatuan']; ?>"

                            <?= $data_edit && $data_edit['idsatuan'] == $satuan['idsatuan']? 'selected': ''; ?>
                        >

                            <?= $satuan['nama_satuan']; ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <!-- ID BARANG -->
            <div class="form-group">

                <label>Harga</label>

                <input
                    type="number"
                    name="harga"
                    min="0"
                    value="<?= $data_edit['harga'] ?? ''; ?>"
                    required>
            </div>


            <!-- Status -->
            <div class="form-group">
                <label>Status</label>
                    <select name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="1" <?= isset($data_edit) && $data_edit['status'] == 1 ? 'selected': ''; ?>>Aktif</option>
                        <option value="0" <?= isset($data_edit) && $data_edit['status'] == 0 ? 'selected': ''; ?>>Tidak Aktif</option>
                    </select>
            </div>

            <!-- BUTTON -->
            <?php if ($data_edit): ?>

                <button
                    type="submit"
                    name="update"
                    class="btn update">

                    Update

                </button>

                <a
                    href="barang.php"
                    class="btn cancel">

                    Batal

                </a>

            <?php else: ?>

                <button
                    type="submit"
                    name="tambah"
                    class="btn tambah">

                    Tambah

                </button>

            <?php endif; ?>

        </form>

    </div>


    <!-- ================================= -->
    <!-- TABEL BARANG -->
    <!-- ================================= -->

    <div class="card">

        <h2>Daftar Barang</h2>

        <table>

            <thead>

                <tr>
                    <th>ID Barang</th>
                    <th>Jenis</th>
                    <th>Nama</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

            <?php while ($barang = mysqli_fetch_assoc($data_barang)): ?>

                <tr>

                    <td>
                        <?= $barang['idbarang']; ?>
                    </td>

                    <td>
                        <?php if ($barang['jenis'] == "M"): ?>
                            Makanan
                        <?php else: ?>
                            Non Makanan
                        <?php endif; ?>
                    </td>

                    <td>
                        <?= $barang['nama']; ?>
                    </td>

                    <td>
                        <?= $barang['nama_satuan']; ?>
                    </td>

                    <td>
                        <?= $barang['harga'] ?>
                    </td>

                    <td>
                        <?php if ($barang['status'] == 1): ?>
                            Aktif
                        <?php else: ?>
                            Tidak Aktif
                        <?php endif; ?>
                    </td>

                    <td>

                        <a
                            href="barang.php?edit=<?= $barang['idbarang']; ?>"
                            class="btn edit">

                            Edit

                        </a>

                        <a
                            href="barang.php?hapus=<?= $barang['idbarang']; ?>"
                            class="btn hapus"
                            onclick="return confirm('Yakin ingin menghapus user ini?')">

                            Hapus

                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>