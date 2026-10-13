<?php
include 'koneksi.php';

// ----- Create -----
if (isset($_POST['tambah'])) {
    $idsatuan = $_POST['idsatuan'];
    $nama_satuan = $_POST['nama_satuan'];
    $status = $_POST['status'];

    $query = "INSERT INTO satuan (idsatuan, nama_satuan, status)
    VALUES ('$idsatuan', '$nama_satuan', '$status')";

    mysqli_query($conn, $query);


    header("Location: satuan.php");
    exit;
}

// ----- UPDATE -----
if (isset($_POST['update'])) {
    $idsatuan = $_POST['idsatuan'];
    $nama_satuan = $_POST['nama_satuan'];
    $status = $_POST['status'];

    $query = "UPDATE satuan 
    SET nama_satuan = '$nama_satuan', 
        status = '$status' 
    WHERE idsatuan = '$idsatuan'";

    mysqli_query($conn, $query);
    header("Location: satuan.php");
    exit;
}

// ----- DELETE -----
if (isset($_GET['hapus'])) {
    $idsatuan = $_GET['hapus'];

    $query = "DELETE FROM satuan WHERE idsatuan = '$idsatuan'";

    mysqli_query($conn, $query);
    header("Location: satuan.php");
    exit;
}

// ----- Data yang diedit -----
$data_edit = null;

if (isset($_GET['edit'])) {
    $idsatuan = $_GET['edit'];

    $query = "SELECT * FROM satuan WHERE idsatuan = '$idsatuan'";

    $hasil = mysqli_query($conn, $query);
    $data_edit = mysqli_fetch_assoc($hasil);
}

// ----- Read -----
$query_satuan = "SELECT * FROM satuan ORDER BY idsatuan ASC";
$data_satuan = mysqli_query($conn, $query_satuan);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Satuan</title>
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
        <h1>Data Satuan</h1>

        <!-- Form Tambah -->
        <div class="card">
            <h2>
                <?= $data_edit ? "Edit Satuan" : "Tambah Satuan"; ?>
            </h2>
            <form method="POST">
                <div class="form-group">
                    <label>ID Satuan</label>
                    <input type="number" name="idsatuan" value="<?= $data_edit['idsatuan'] ?? ''; ?>"
                    <?= $data_edit ? 'readonly' : ''; ?>required> 
                </div>
                <div class="form-group">
                    <label>Nama Satuan</label>
                    <input type="text" name="nama_satuan" value="<?= $data_edit['nama_satuan'] ?? ''; ?>"required> 
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
        <div class="satuan">
            <h2>Daftar Satuan</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Satuan</th>
                        <th>Nama Satuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($satuan = mysqli_fetch_assoc($data_satuan)): ?>
                        <tr>
                            <td>
                                <?= $satuan['idsatuan']; ?>
                            </td>
                            <td>
                                <?= $satuan['nama_satuan'] ?>
                            </td>
                            <td>
                                <?php if ($satuan['status'] == 1): ?>
                                    Aktif
                                <?php else: ?>
                                    Tidak Aktif
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="satuan.php?edit=<?= $satuan['idsatuan']; ?>" class="btn edit">Edit</a>
                                <a href="satuan.php?hapus=<?= $satuan['idsatuan']; ?>" class="btn hapus" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>        
    </div>     
</body>
</html>