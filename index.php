<?php
//Koneksi ke database
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "webdinamis";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$nama       = "";
$jenis_kelamin         = "";
$email      = "";
$alamat     = "";
$jurusan_prodi   = "";
$tahun     = "";
$sukses      = "";
$error      = "";



if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
//Fungsi Delete (Menghapus data Dari php)
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from dataalumni where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
//Fungsi Edit (Mengedit data Dari php)
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from dataalumni where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama                = $r1['nama'];
    $jenis_kelamin                = $r1['jenis_kelamin'];
    $email               = $r1['email'];
    $alamat              = $r1['alamat'];
    $jurusan_prodi       = $r1['jurusan_prodi'];
    $tahun               = $r1['tahun'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}
//Fungsi create (Menambahkan data ke php)
if (isset($_POST['simpan'])) { 
    $nama               = $_POST['nama'];
    $jenis_kelamin      = $_POST['jenis_kelamin'];
    $email              = $_POST['email'];
    $alamat             = $_POST['alamat'];
    $jurusan_prodi      = $_POST['jurusan_prodi'];
    $tahun              = $_POST['tahun'];

//Program untuk memasukkan data dalam form edit data
    if ($nama && $jenis_kelamin && $email && $alamat && $jurusan_prodi && $tahun) {
        if ($op == 'edit') { 
            $sql1       = "update dataalumni set nama='$nama',jenis_kelamin='$jenis_kelamin',
             email = '$email',alamat = '$alamat',jurusan_prodi='$jurusan_prodi',tahun = '$tahun' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert ke php
            $sql1   = "insert into dataalumni(nama,jenis_kelamin,email,alamat,jurusan_prodi,tahun) 
            values ('$nama','$jenis_kelamin','$email','$alamat','$jurusan_prodi','$tahun')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Silahkan memasukkan data";
            }
        }
    } else { //Pesan error jika ada data yang belum di masukkan
        $error = "Silakan masukkan semua data";
    }
}
?>

<!-- HTML CODE -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- -Style html-->
    <style>
    .mx-auto {
        width: 1000px
    }

    .card {
        margin-top: 10px;
    }

    body {
        background-color: #DFDEEE;
    }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error ?>
                </div>
                <?php
                    header("refresh:3;url=index.php");//  Refresh page dalam 3 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses ?>
                </div>
                <?php
                    header("refresh:3;url=index.php");
                }
                ?>
                <!-- Form Input -->
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10 form-check pt-2" size="100px" name="jenis_kelamin" id="jenis_kelamin">
                            <label>
                                <input type="checkbox" name="jenis_kelamin" id="jenis_kelamin" value="Laki-laki"
                                    <?php if ($jenis_kelamin == "Laki-laki") echo "checked"; ?>> Laki-laki &ensp;
                            </label>
                            <label>
                                <input type="checkbox" name="jenis_kelamin" id="jenis_kelamin" value="Perempuan"
                                    <?php if ($jenis_kelamin == "Perempuan") echo "checked"; ?>> Perempuan
                            </label>

                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email"
                                value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jurusan_prodi" class="col-sm-2 col-form-label">Jurusan/Prodi</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jurusan_prodi" id="jurusan_prodi">
                                <option value="">- Pilih Jurusan/Prodi -</option>
                                <option value="TEKKOM/TEKKOM"
                                    <?php if ($jurusan_prodi == "TEKKOM/TEKKOM") echo "selected" ?>>TEKKOM/TEKKOM
                                </option>
                                <option value="TEKKOM/TIMD"
                                    <?php if ($jurusan_prodi == "TEKKOM/TIMD") echo "selected" ?>>
                                    TEKKOM/TIMD
                                </option>
                            </select>

                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tahun" name="tahun"
                                value="<?php echo $tahun ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk menampilkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Alumni
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Email</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Jurusan/Prodi</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <!-- Mengambil data dari database untuk ditampilkan ke html form -->
                    <tbody>
                        <?php
                        $sql2   = "select * from dataalumni order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id              = $r2['id'];
                            $nama            = $r2['nama'];
                            $jenis_kelamin            = $r2['jenis_kelamin'];
                            $email           = $r2['email'];
                            $alamat          = $r2['alamat'];
                            $jurusan_prodi   = $r2['jurusan_prodi'];
                            $tahun           = $r2['tahun'];

                        ?>
                        <tr>
                            <th scope="row"><?php echo $urut++ ?></th>
                            <td scope="row"><?php echo $nama ?></td>
                            <td scope="row"><?php echo $jenis_kelamin ?></td>
                            <td scope="row"><?php echo $email ?></td>
                            <td scope="row"><?php echo $alamat ?></td>
                            <td scope="row"><?php echo $jurusan_prodi ?></td>
                            <td scope="row"><?php echo $tahun ?></td>
                            <td scope="row">
                                <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button"
                                        class="btn btn-warning">Edit</button></a>
                                <a href="index.php?op=delete&id=<?php echo $id?>"
                                    onclick="return confirm('Yakin mau delete data?')"><button type="button"
                                        class="btn btn-danger">Delete</button></a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>

</html>
