<?php
include 'koneksi.php';

// ===== CREATE =====
if (isset($_POST['tambah'])) {
    $iduser = $_POST['iduser'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $idrole = $_POST['idrole'];

    $query = "INSERT INTO user (iduser, username, password, idrole)
    VALUES ('$iduser', '$username', '$password', '$idrole')";

    mysqli_query($conn, $query);
    header("Location: user.php");
    exit;
}

// ----- UPDATE -----
if (isset($_POST['update'])) {
    $iduser = $_POST['iduser'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $idrole = $_POST['idrole'];

    $query = "UPDATE user 
    SET username = '$username',
        password = '$password',
        idrole = '$idrole' 
    WHERE iduser = '$iduser'";

    mysqli_query($conn, $query);
    header("Location: user.php");
    exit;
}

// ----- DELETE -----
if (isset($_GET['hapus'])) {
    $iduser = $_GET['hapus'];

    $query = "DELETE FROM user WHERE iduser = '$iduser'";

    mysqli_query($conn, $query);
    header("Location: user.php");
    exit;
}

// ----- Data yang diedit -----
$data_edit = null;

if (isset($_GET['edit'])) {
    $iduser = $_GET['edit'];

    $query = "SELECT * FROM user WHERE iduser = '$iduser'";

    $hasil = mysqli_query($conn, $query);
    $data_edit = mysqli_fetch_assoc($hasil);
}

// ----- Read -----
$query_role = "SELECT * FROM role ORDER BY idrole ASC";
$data_role = mysqli_query($conn, $query_role);
$query_user = "SELECT u.iduser, u.username, u.password, u.idrole, r.nama_role
FROM user u JOIN role r 
ON u.idrole = r.idrole
ORDER BY u.iduser ASC";
$data_user= mysqli_query($conn, $query_user);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Data User</title>

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

    <h1>Data User</h1>


    <!-- ================================= -->
    <!-- FORM TAMBAH / EDIT -->
    <!-- ================================= -->

    <div class="card">

        <h2>
            <?= $data_edit ? "Edit User" : "Tambah User"; ?>
        </h2>

        <form method="POST">


            <!-- ID USER -->
            <div class="form-group">

                <label>ID User</label>

                <input
                    type="number"
                    name="iduser"
                    value="<?= $data_edit['iduser'] ?? ''; ?>"
                    <?= $data_edit ? 'readonly' : ''; ?>
                    required>

            </div>


            <!-- USERNAME -->
            <div class="form-group">

                <label>Username</label>

                <input
                    type="text"
                    name="username"
                    value="<?= $data_edit['username'] ?? ''; ?>"
                    required>

            </div>


            <!-- PASSWORD -->
            <div class="form-group">

                <label>Password</label>

                <input
                    type="text"
                    name="password"
                    value="<?= $data_edit['password'] ?? ''; ?>"
                    required>

            </div>


            <!-- ROLE -->
            <div class="form-group">

                <label>Role</label>

                <select name="idrole" required>

                    <option value="">
                        -- Pilih Role --
                    </option>

                    <?php while ($role = mysqli_fetch_assoc($data_role)): ?>

                        <option
                            value="<?= $role['idrole']; ?>"

                            <?= $data_edit &&
                               $data_edit['idrole'] == $role['idrole']
                               ? 'selected'
                               : ''; ?>
                        >

                            <?= $role['nama_role']; ?>

                        </option>

                    <?php endwhile; ?>

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
                    href="user.php"
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
    <!-- TABEL USER -->
    <!-- ================================= -->

    <div class="card">

        <h2>Daftar User</h2>

        <table>

            <thead>

                <tr>
                    <th>ID User</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

            <?php while ($user = mysqli_fetch_assoc($data_user)): ?>

                <tr>

                    <td>
                        <?= $user['iduser']; ?>
                    </td>

                    <td>
                        <?= $user['username']; ?>
                    </td>

                    <td>
                        <?= $user['password']; ?>
                    </td>

                    <td>
                        <?= $user['nama_role']; ?>
                    </td>

                    <td>

                        <a
                            href="user.php?edit=<?= $user['iduser']; ?>"
                            class="btn edit">

                            Edit

                        </a>

                        <a
                            href="user.php?hapus=<?= $user['iduser']; ?>"
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