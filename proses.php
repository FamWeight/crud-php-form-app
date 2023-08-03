<?php
//Fungsi untuk koneksi ke database
function connectDB()
{
    $host = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "db_mhs";

    $connection = mysqli_connect($host, $username, $password, $dbname);

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    return $connection;
}
// Fungsi read untuk digunakan dalam page 'list'
function getAllSiswa()
{
    $connection = connectDB();
    $query = "SELECT * FROM siswa";
    $result = mysqli_query($connection, $query);

    $siswaList = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $siswaList[] = $row;
    }

    mysqli_close($connection);
    return $siswaList;
}

// Create yang di post oleh page 'form'
if (isset($_POST['create'])) {
    $connection = connectDB();
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah_asal = $_POST['sekolah_asal'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO siswa (nama, jenis_kelamin, agama, sekolah_asal, alamat) VALUES ('$nama', '$jenis_kelamin', '$agama', '$sekolah_asal', '$alamat')";

    if (mysqli_query($connection, $query)) {
        session_start();
        $_SESSION['update_success'] = array(
            'message' => 'Selamat data siswa berhasil disimpan! <a href="index.php?page=form" class="alert-link">Tekan jika ingin mengisi form kembali.</a><br>'
        );

        header("Location: index.php?page=list");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    mysqli_close($connection);
}

// Update yang di post oleh page 'list'
if (isset($_POST['update'])) {
    $connection = connectDB();
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah_asal = $_POST['sekolah_asal'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE siswa SET nama='$nama', jenis_kelamin='$jenis_kelamin', agama='$agama', sekolah_asal='$sekolah_asal', alamat='$alamat' WHERE id = $id";

    if (mysqli_query($connection, $query)) {
        session_start();
        $_SESSION['update_success'] = array(
            'message' => 'Berhasil Diupdate!'
        );

        header("Location: index.php?page=list");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    mysqli_close($connection);
}

// Delete yang di get di page 'list'
if (isset($_GET['id'])) {
    $connection = connectDB();
    $id = $_GET['id'];

    $query = "DELETE FROM siswa WHERE id = $id";
    if (mysqli_query($connection, $query)) {
        session_start();
        $_SESSION['update_success'] = array(
            'message' => 'Berhasil Dihapus!'
        );

        header("Location: index.php?page=list");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }


    mysqli_close($connection);
}

// Fungsi untuk menampilkan isi dari data siswa yang ingin di ubah pada page 'edit'
function getSiswaById($id)
{
    $connection = connectDB();
    $query = "SELECT * FROM siswa WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $siswaData = null;
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $siswaData = mysqli_fetch_assoc($result);
        }
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
    mysqli_close($connection);
    return $siswaData;
}

// Fungsi untuk menampilkan navbar di semua page
function printNavbar()
{
?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="btn btn-outline-light navbar-brand" href="index.php">
                <img src="./src/icon.png" alt="Bootstrap" width="60" height="60">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav nav-underline navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="btn btn-outline-light nav-link" aria-current="page" href="index.php?page=form">Formulir Pendaftaran Data Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light nav-link" aria-current="page" href="index.php?page=list">Daftar Data Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light nav-link" aria-current="page" href="index.php?page=about">Tentang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
}
