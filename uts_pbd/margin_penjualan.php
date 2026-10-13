<?php
include 'koneksi.php';

// ===== CREATE =====
if (isset($_POST['tambah'])) {
    $idmargin_penjualan = $_POST['idmargin_penjualan'];
    $persen = $_POST['persen'];
    $status = $_POST['status'];
    $iduser = $_POST['iduser'];
    $updated_at = $_POST['updated_at'];

    $query = "INSERT INTO margin_penjualan (idmargin_penjualan, persen, status, iduser, updated_at)
    VALUES ('$idmargin_penjualan', '$persen', '$status', '$iduser', '$updated_at')";

    mysqli_query($conn, $query);
    header("Location: margin_penjualan.php");
    exit;
}

// ----- UPDATE -----
if (isset($_POST['update'])) {

    $idmargin_penjualan = $_POST['idmargin_penjualan'];
    $persen = $_POST['persen'];
    $status = $_POST['status'];
    $iduser = $_POST['iduser'];
    $updated_at = $_POST['updated_at'];

    $query = "UPDATE margin_penjualan
            SET persen = '$persen',
            status = '$status',
            iduser = '$iduser',
            updated_at = '$updated_at'
            WHERE idmargin_penjualan = '$idmargin_penjualan'";

    $hasil = mysqli_query($conn, $query);
    header("Location: margin_penjualan.php");
    exit;
}

// ----- DELETE -----
if (isset($_GET['hapus'])) {
    $idmargin_penjualan = $_GET['hapus'];

    $query = "DELETE FROM margin_penjualan WHERE idmargin_penjualan = '$idmargin_penjualan'";

    mysqli_query($conn, $query);
    header("Location: margin_penjualan.php");
    exit;
}

// ----- Data yang diedit -----
$data_edit = null;

if (isset($_GET['edit'])) {
    $idmargin_penjualan = $_GET['edit'];

    $query = "SELECT * FROM margin_penjualan WHERE idmargin_penjualan = '$idmargin_penjualan'";

    $hasil = mysqli_query($conn, $query);
    $data_edit = mysqli_fetch_assoc($hasil);
}

// ----- Read -----
$query_user = "SELECT * FROM user ORDER BY iduser ASC";
$data_user = mysqli_query($conn, $query_user);

$query_margin = "SELECT m.idmargin_penjualan, m.created_at, m.persen, m.status, m.iduser, m.updated_at, u.username
FROM margin_penjualan m JOIN user u
ON m.iduser = u.iduser
ORDER BY m.idmargin_penjualan ASC";
$data_margin= mysqli_query($conn, $query_margin);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Data Margin Penjualan</title>

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
            max-width: 1150px;
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

        .aksi {
            white-space: nowrap;
            width: 150px;
        }

        .aksi .btn {
            margin-right: 5px;
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

    <h1>Data Margin Penjualan</h1>


    <!-- ================================= -->
    <!-- FORM TAMBAH / EDIT -->
    <!-- ================================= -->

    <div class="card">

        <h2>
            <?= $data_edit ? "Edit Margin Penjualan" : "Tambah Margin Penjualan"; ?>
        </h2>

        <form method="POST">

            <!-- ID -->
            <div class="form-group">

                <label>ID</label>

                <input
                    type="number"
                    name="idmargin_penjualan"
                    value="<?= $data_edit['idmargin_penjualan'] ?? ''; ?>"
                    <?= $data_edit ? 'readonly' : ''; ?>
                    required>

            </div>

            <!-- PERSEN -->
            <div class="form-group">

                <label>Persen</label>

                <input
                    type="number"
                    name="persen"
                    step="0.01"
                    min="0"
                    value="<?= $data_edit['persen'] ?? ''; ?>"
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

            <!-- ID USER -->
            <div class="form-group">

                <label>User</label>

                <select name="iduser" required>

                    <option value="">
                        -- Pilih User --
                    </option>

                    <?php while ($user = mysqli_fetch_assoc($data_user)): ?>

                        <option
                            value="<?= $user['iduser']; ?>"

                            <?= $data_edit && $data_edit['iduser'] == $user['iduser']? 'selected': ''; ?>
                        >

                            <?= $user['username']; ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <div class="form-group">
                <label>Updated At</label>
                    <input
                        type="datetime-local"
                        name="updated_at"
                        value="<?= $data_edit && $data_edit['updated_at'] ? date('Y-m-d\TH:i', strtotime($data_edit['updated_at'])): ''; ?>"
                        >
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
                    href="margin_penjualan.php"
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
                    <th>ID</th>
                    <th>Persen</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Dibuat</th>
                    <th>Diubah</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

            <?php while ($margin_penjualan = mysqli_fetch_assoc($data_margin)): ?>

                <tr>

                    <td>
                        <?= $margin_penjualan['idmargin_penjualan']; ?>
                    </td>

                    <td>
                        <?= $margin_penjualan['persen']; ?>
                    </td>

                    <td>
                        <?php if ($margin_penjualan['status'] == 1): ?>
                            Aktif
                        <?php else: ?>
                            Tidak Aktif
                        <?php endif; ?>
                    </td>

                    <td>
                        <?= $margin_penjualan['username'] ?>
                    </td>

                    <td>
                        <?= $margin_penjualan['created_at']; ?>
                    </td>

                    <td>
                        <?= $margin_penjualan['updated_at']; ?>
                    </td>

                    <td class="aksi">
                        <a
                            href="margin_penjualan.php?edit=<?= $margin_penjualan['idmargin_penjualan']; ?>"
                            class="btn edit">

                            Edit

                        </a>

                        <a
                            href="margin_penjualan.php?hapus=<?= $margin_penjualan['idmargin_penjualan']; ?>"
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