<?php
$page = isset($_GET['page']) ? $_GET['page'] : '';
include 'proses.php';
switch ($page) {
    case 'form': ?>

        <html>

        <head>
            <meta charset="utf-8">
            <title>Proyek P13</title>
            <link rel="stylesheet" href="./bs/css/bootstrap.min.css">
        </head>

        <body>
            <?php printNavbar(); ?>

            <div class="container-fluid">
                <h1 class="mt-5">Formulir Pendaftaran Data Siswa</h1>
                <form method="POST" action="proses.php" class="row g-3">
                    <input type='hidden' name='create' value="true">
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama :</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Contoh : Nama Kamu Siapa" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin :</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                            <option value="" selected>Pilih Jenis Kelamin</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="agama" class="form-label">Agama :</label>
                        <input type="text" class="form-control" name="agama" id="agama" placeholder="Islam, Kristen, Hindu, dll..." required>
                    </div>
                    <div class="col-md-6">
                        <label for="sekolah_asal" class="form-label">Asal Sekolah :</label>
                        <input type="text" class="form-control" name="sekolah_asal" id="sekolah_asal" placeholder="Contoh : SMAN 4 Kota Depok" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat :</label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Contoh : Jl. Nama Jalan No.... " required></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" value="Submit" name="submit" class="btn btn-outline-primary">Simpan</button>
                    </div>
                </form>
            </div>

            <script src="./bs/js/bootstrap.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#sidebarToggle").click(function() {
                        $("#sidebar").toggleClass("open");
                    });
                });
            </script>
        </body>

        </html>

    <?php
        break;
    case 'list':
        $siswaList = getAllSiswa();
    ?>

        <html>

        <head>
            <meta charset="utf-8">
            <title>Proyek P13</title>
            <link rel="stylesheet" href="./bs/css/bootstrap.min.css">
            <style>
                /* CSS untuk membuat kolom tetap terlihat */
                .sticky-col {
                    position: sticky;
                    left: 0;
                    z-index: 1;
                    background-color: #f9f9f9;
                }
            </style>
        </head>

        <body>
            <?php printNavbar(); ?>

            <div class="container-fluid mt-5">
                <h1 class="mt-4">Daftar Data Siswa</h1>

                <?php
                session_start();
                if (isset($_SESSION['update_success'])) :
                ?>
                    <div id="alert" class="alert alert-success" role="alert">
                        <?php echo $_SESSION['update_success']['message']; ?>
                        <button type="button" onclick="hideAlert()" class="btn btn-outline-success btn-sm">Oke</button>
                    </div>
                <?php
                endif;
                unset($_SESSION['update_success']);
                ?>

                <div class="table-responsive">
                    <table class="table table-hover table-light table-striped-columns align-middle table-borderless">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap text-center">ID</th>
                                <th class="text-nowrap text-center sticky-col">Nama Siswa</th>
                                <th class="text-nowrap text-center">Jenis Kelamin</th>
                                <th class="text-nowrap text-center">Agama</th>
                                <th class="text-nowrap text-center">Asal Sekolah</th>
                                <th class="text-nowrap text-center">Alamat</th>
                                <th class="text-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($siswaList as $row) : ?>
                                <tr>
                                    <td class="text-nowrap text-center"><?php echo $row['id']; ?></td>
                                    <td class="text-nowrap text-center sticky-col"><?php echo $row['nama']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $row['jenis_kelamin']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $row['agama']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $row['sekolah_asal']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $row['alamat']; ?></td>
                                    <td class="text-nowrap text-center">
                                        <a class="btn btn-outline-warning" href='index.php?page=edit&cari=<?php echo $row['id']; ?>'>Ubah</a>
                                        <a class="btn btn-outline-danger" href='proses.php?id=<?php echo $row['id']; ?>' onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <script src="./bs/js/bootstrap.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $("#sidebarToggle").click(function() {
                            $("#sidebar").toggleClass("open");
                        });
                    });
                </script>
                <script>
                    function hideAlert() {
                        var alertElement = document.getElementById('alert');
                        if (alertElement) {
                            alertElement.style.display = 'none';
                        }
                    }
                </script>
        </body>

        </html>


        <?php
        break;
    case 'edit':
        if (isset($_GET['cari'])) {
            $id = $_GET['cari'];
            $siswaData = getSiswaById($id);
            if ($siswaData) { ?>

                <html>

                <head>
                    <meta charset="utf-8">
                    <title>Proyek P13</title>
                    <link rel="stylesheet" href="./bs/css/bootstrap.min.css">
                </head>

                <body>
                    <?php printNavbar(); ?>

                    <div class="container-fluid mt-5">
                        <h1 class="mt-4">Edit List Siswa</h1>

                        <div class="table-responsive">
                            <table class="table table-light table-striped">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Siswa</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Agama</th>
                                    <th>Asal Sekolah</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                                <tr>
                                    <form method='POST' action='proses.php'>
                                        <input type='hidden' name='update' value='true'>
                                        <input type='hidden' name='id' value='<?php echo $siswaData['id']; ?>'>
                                        <td><?php echo $siswaData['id']; ?></td>
                                        <td><input type='text' name='nama' value='<?php echo $siswaData['nama']; ?>'></td>
                                        <td><input type='text' name='jenis_kelamin' value='<?php echo $siswaData['jenis_kelamin']; ?>'></td>
                                        <td><input type='text' name='agama' value='<?php echo $siswaData['agama']; ?>'></td>
                                        <td><input type='text' name='sekolah_asal' value='<?php echo $siswaData['sekolah_asal']; ?>'></td>
                                        <td><input type='text' name='alamat' value='<?php echo $siswaData['alamat']; ?>'></td>
                                        <td><button type='submit' class='btn btn-outline-primary' name='submit' onclick="return confirm('Apakah Anda yakin ingin memperbarui data ini?')">Simpan</button></td>
                                    </form>
                                </tr>

                            </table>
                        </div>
                    </div>

                    <script src="./bs/js/bootstrap.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $("#sidebarToggle").click(function() {
                                $("#sidebar").toggleClass("open");
                            });
                        });
                    </script>

                </body>

                </html>


        <?php }
        }
        break;
    case 'about': ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Data Diri</title>
            <link rel="stylesheet" href="./bs/css/bootstrap.css">
        </head>

        <body>
            <?php printNavbar(); ?>

            <div class="container-fluid mt-5">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h1>Data Diri</h1>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Nama :</strong> Wahyu Tri Novianto</li>
                            <li class="list-group-item"><strong>Email :</strong> Wahyu23.wtn@gmail.com</li>
                            <li class="list-group-item"><strong>Telepon :</strong> 081398502323</li>
                            <li class="list-group-item"><strong>Program Studi :</strong> Teknik Informatika</li>
                            <li class="list-group-item"><strong>Sosial Media :</strong> <a href="https://www.linkedin.com/in/wahyu-tri-novianto-761868172"> LinkedIn</a> </li>
                        </ul>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <img src="./src/fotdir.png" alt="Wahyu Tri Novianto" class="img-fluid rounded-circle" style="max-width: 250px;">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h1>Tentang</h1>
                        <p></p>
                    </div>
                </div>
            </div>

            <script src="./bs/js/bootstrap.js"></script>
            <script>
                $(document).ready(function() {
                    $("#sidebarToggle").click(function() {
                        $("#sidebar").toggleClass("open");
                    });
                });
            </script>
        </body>

        </html>


    <?php
        break;
    default: ?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <title>Proyek P13</title>
            <link rel="stylesheet" href="./bs/css/bootstrap.min.css">
        </head>

        <body>
            <?php printNavbar(); ?>

            <div class="container-fluid mt-5">
                <h1 class="mt-4">Halaman Utama</h1>
                <ul class="list-group">
                    <div class="card">
                        <a href="index.php?page=form" class="list-group-item btn btn-outline-light">Formulir Pendaftaraan Data Siswa</a>
                    </div>
                    <div class="card">
                        <a href="index.php?page=list" class="list-group-item btn btn-outline-light">Daftar Data Siswa</a>
                    </div>
                </ul>
            </div>

            <script src="./bs/js/bootstrap.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#sidebarToggle").click(function() {
                        $("#sidebar").toggleClass("open");
                    });
                });
            </script>
        </body>

        </html>

<?php
        break;
} ?>