<?php
include 'koneksi.php';

// ----- CREATE -----
if (isset($_POST['tambah'])) {
    $idrole = $_POST['idrole'];
    $nama_role = $_POST['nama_role'];

    $query = "INSERT INTO role (idrole, nama_role) VALUES ('$idrole', '$nama_role')";

    mysqli_query($conn, $query);
    header("Location: role.php");
    exit;
}

// ----- UPDATE -----
if (isset($_POST['update'])) {
    $idrole = $_POST['idrole'];
    $nama_role = $_POST['nama_role'];

    $query = "UPDATE role SET nama_role = '$nama_role' WHERE idrole = '$idrole'";

    mysqli_query($conn, $query);
    header("Location: role.php");
    exit;
}

// ----- DELETE -----
if (isset($_GET['hapus'])) {
    $idrole = $_GET['hapus'];

    $query = "DELETE FROM role WHERE idrole = '$idrole'";

    mysqli_query($conn, $query);
    header("Location: role.php");
    exit;
}

// ----- Data yang diedit -----
$data_edit = null;

if (isset($_GET['edit'])) {
    $idrole = $_GET['edit'];

    $query = "SELECT * FROM role WHERE idrole = '$idrole'";

    $hasil = mysqli_query($conn, $query);
    $data_edit = mysqli_fetch_assoc($hasil);
}

// ----- Read -----
$query_role = "SELECT * FROM role ORDER BY idrole ASC";
$data_role = mysqli_query($conn, $query_role);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Role</title>
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
        <h1>Data Role</h1>

        <!-- Form Tambah -->
        <div class="card">
            <h2>
                <?= $data_edit ? "Edit Role" : "Tambah Role"; ?>
            </h2>
            <form method="POST">
                <div class="form-group">
                    <label>ID Role</label>
                    <input type="number" name="idrole" value="<?= $data_edit['idrole'] ?? ''; ?>"
                    <?= $data_edit ? 'readonly' : ''; ?>required> 
                </div>
                <div class="form-group">
                    <label>Nama Role</label>
                    <input type="text" name="nama_role" value="<?= $data_edit['nama_role'] ?? ''; ?>"required> 
                </div>

                <?php if ($data_edit): ?>
                    <button type="submit" name="update" class="btn update">Update</button>
                    <a href="role.php" class="btn cancel">Batal</a>

                <?php else: ?>
                    <button type="submit" name="tambah" class="btn tambah">Tambah</button>

                <?php endif; ?>
            </form>

        </div>
        
        <!-- Tabel Data Role -->
        <div class="role">
            <h2>Daftar Role</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Role</th>
                        <th>Nama Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($role = mysqli_fetch_assoc($data_role)): ?>
                        <tr>
                            <td>
                                <?= $role['idrole']; ?>
                            </td>
                            <td>
                                <?= $role['nama_role'] ?>
                            </td>
                            <td>
                                <a href="role.php?edit=<?= $role['idrole']; ?>" class="btn edit">Edit</a>
                                <a href="role.php?hapus=<?= $role['idrole']; ?>" class="btn hapus" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>