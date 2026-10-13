<?php
include 'koneksi.php';

// ----- Create -----
if (isset($_POST['tambah'])) {
    $idvendor = $_POST['idvendor'];
    $nama_vendor = $_POST['nama_vendor'];
    $badan_hukum = $_POST['badan_hukum'];
    $status = $_POST['status'];

    $query = "INSERT INTO vendor (idvendor, nama_vendor, badan_hukum, status)
    VALUES ('$idvendor', '$nama_vendor', '$badan_hukum', '$status')";

    mysqli_query($conn, $query);
    header("Location: vendor.php");
    exit;
}

// ----- UPDATE -----
if (isset($_POST['update'])) {
    $idvendor = $_POST['idvendor'];
    $nama_vendor = $_POST['nama_vendor'];
    $badan_hukum = $_POST['badan_hukum'];
    $status = $_POST['status'];

    $query = "UPDATE vendor 
    SET nama_vendor = '$nama_vendor',
        badan_hukum = '$badan_hukum',
        status = '$status' 
    WHERE idvendor = '$idvendor'";

    mysqli_query($conn, $query);
    header("Location: vendor.php");
    exit;
}

// ----- DELETE -----
if (isset($_GET['hapus'])) {
    $idvendor = $_GET['hapus'];

    $query = "DELETE FROM vendor WHERE idvendor = '$idvendor'";

    mysqli_query($conn, $query);
    header("Location: vendor.php");
    exit;
}

// ----- Data yang diedit -----
$data_edit = null;

if (isset($_GET['edit'])) {
    $idvendor = $_GET['edit'];

    $query = "SELECT * FROM vendor WHERE idvendor = '$idvendor'";

    $hasil = mysqli_query($conn, $query);
    $data_edit = mysqli_fetch_assoc($hasil);
}

// ----- Read -----
$query_vendor = "SELECT * FROM vendor ORDER BY idvendor ASC";
$data_vendor= mysqli_query($conn, $query_vendor);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Vendor</title>
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

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
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

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: white;
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
        <h1>Data Vendor</h1>

        <!-- Form Tambah -->
        <div class="card">
            <h2>
                <?= $data_edit ? "Edit Vendor" : "Tambah Vendor"; ?>
            </h2>
            <form method="POST">
                <div class="form-group">
                    <label>ID Vendor</label>
                    <input type="number" name="idvendor" value="<?= $data_edit['idvendor'] ?? ''; ?>"
                    <?= $data_edit ? 'readonly' : ''; ?>required> 
                </div>
                <div class="form-group">
                    <label>Nama Vendor</label>
                    <input type="text" name="nama_vendor" value="<?= $data_edit['nama_vendor'] ?? ''; ?>"required> 
                </div>
                <div class="form-group">
                    <label>Badan Hukum</label>
                    <select name="badan_hukum" required>
                        <option value="">-- Pilih Badan Hukum --</option>
                        <option value="P" <?= isset($data_edit) && $data_edit['badan_hukum'] == 'P' ? 'selected': ''; ?>>PT</option>
                        <option value="C" <?= isset($data_edit) && $data_edit['badan_hukum'] == 'C' ? 'selected': ''; ?>>CV</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="1" <?= isset($data_edit) && $data_edit['status'] == 1 ? 'selected': ''; ?>>Aktif</option>
                        <option value="0" <?= isset($data_edit) && $data_edit['status'] == 0 ? 'selected': ''; ?>>Tidak Aktif</option>
                    </select>
                </div>

                <?php if ($data_edit): ?>
                    <button type="submit" name="update" class="btn update">Update</button>
                    <a href="satuan.php" class="btn cancel">Batal</a>

                <?php else: ?>
                    <button type="submit" name="tambah" class="btn tambah">Tambah</button>

                <?php endif; ?>
            </form>
        </div>
        <!-- Tabel Data Role -->
        <div class="vendor">
            <h2>Daftar Vendor</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Vendor</th>
                        <th>Nama Vendor</th>
                        <th>Badan Hukum</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($vendor = mysqli_fetch_assoc($data_vendor)): ?>
                        <tr>
                            <td>
                                <?= $vendor['idvendor']; ?>
                            </td>
                            <td>
                                <?= $vendor['nama_vendor'] ?>
                            </td>
                            <td>
                                <?php if ($vendor['badan_hukum'] == 'P'): ?>
                                    PT
                                <?php else: ?>
                                    CV
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($vendor['status'] == 1): ?>
                                    Aktif
                                <?php else: ?>
                                    Tidak Aktif
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="vendor.php?edit=<?= $vendor['idvendor']; ?>" class="btn edit">Edit</a>
                                <a href="vendor.php?hapus=<?= $vendor['idvendor']; ?>" class="btn hapus" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>        
    </div>     
</body>
</html>