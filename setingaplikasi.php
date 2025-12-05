<?php
// ===============================
//  FILE PROFILE JSON
// ===============================
$file = "profile.json";

// Buat default jika file belum ada
if(!file_exists($file)){
    $default = [
        "nama"      => "Trianinsi Hasan S.Pd",
        "username"  => "admin",
        "jabatan"   => "Admin Sekolah",
        "instansi"  => "PAUD Amal Tododara TIKEP",
        "umur"      => "33",
        "npwp"      => "67375375",
        "foto"      => ""
    ];
    file_put_contents($file, json_encode($default, JSON_PRETTY_PRINT));
}

// Ambil data
$data = json_decode(file_get_contents($file), true);

// Jika disimpan
if(isset($_POST['simpan'])){

    // Cek upload foto
    if(!empty($_FILES['foto']['name'])){
        $namaFile = "foto_" . time() . ".jpg";
        move_uploaded_file($_FILES['foto']['tmp_name'], $namaFile);
        $data['foto'] = $namaFile;
    }

    // Text form
    $data['nama']     = $_POST['nama'];
    $data['username'] = $_POST['username'];
    $data['jabatan']  = $_POST['jabatan'];
    $data['instansi'] = $_POST['instansi'];
    $data['umur']     = $_POST['umur'];
    $data['npwp']     = $_POST['npwp'];

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

    echo "<script>alert('Data profile berhasil diperbarui!');</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Setelan Profile</title>
<style>
/* Layout */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f4f4;
}
.sidebar {
    width: 260px;
    background: #263238;
    color: white;
    height: 100vh;
    position: fixed;
}
.sidebar h2 {
    padding: 20px;
}
.sidebar a {
    display: block;
    padding: 15px 20px;
    border-bottom: 1px solid #37474F;
    color: white;
    text-decoration: none;
}
.sidebar a:hover {
    background: #455A64;
}

/* Main Content */
.main {
    margin-left: 260px;
    padding: 35px;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    width: 75%;
}

/* Tabs */
.tabs {
    display: flex;
    border-bottom: 1px solid #ddd;
    margin-bottom: 20px;
}
.tab {
    padding: 12px 20px;
    cursor: pointer;
    border-right: 1px solid #ddd;
}
.tab.active {
    background: #f4f4f4;
    font-weight: bold;
}

/* Form */
.row {
    display: flex;
    margin-bottom: 15px;
    align-items: center;
}
.row label {
    width: 200px;
    font-weight: bold;
}
.row input[type=text] {
    width: 60%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
.row input[type=file] {
    width: 60%;
}
.btn {
    padding: 10px 15px;
    background: #0288D1;
    border: none;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}
.umur-box {
    display: flex;
    align-items: center;
}
.umur-box input {
    width: 150px !important;
}
.umur-box span {
    margin-left: 10px;
    font-weight: bold;
}
.foto-preview {
    width: 120px;
    height: 120px;
    border-radius: 5px;
    border: 1px solid #ccc;
    object-fit: cover;
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Absensi Online</h2>

    <a href="#">⚙ Settings Aplikasi</a>

    <div style="padding:15px; margin-top:200px; font-size:14px;">
        Selamat Datang:<br>
        <b><?php echo $data['nama']; ?></b>
    </div>
</div>

<!-- MAIN PAGE -->
<div class="main">
    <h1>⚙ Setelan</h1>

    <div class="card">

        <!-- Tabs -->
        <div class="tabs">
            <div class="tab active">Setelan Dasar</div>
            <div class="tab">🔐 Ganti Password</div>
            <div class="tab">🔑 Remember Me</div>
        </div>

        <!-- FORM -->
        <form method="POST" enctype="multipart/form-data">

            <div class="row">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?php echo $data['nama']; ?>">
            </div>

            <div class="row">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $data['username']; ?>">
            </div>

            <div class="row">
                <label>Jabatan</label>
                <input type="text" name="jabatan" value="<?php echo $data['jabatan']; ?>">
            </div>

            <div class="row">
                <label>Instansi</label>
                <input type="text" name="instansi" value="<?php echo $data['instansi']; ?>">
            </div>

            <div class="row">
                <label>Umur</label>
                <div class="umur-box">
                    <input type="text" name="umur" value="<?php echo $data['umur']; ?>">
                    <span>Tahun</span>
                </div>
            </div>

            <div class="row">
                <label>NPWP</label>
                <input type="text" name="npwp" value="<?php echo $data['npwp']; ?>">
            </div>

            <div class="row">
                <label>Pas Foto</label>

                <?php if($data['foto'] != ""){ ?>
                    <img src="<?php echo $data['foto']; ?>" class="foto-preview">
                <?php } ?>

                <input type="file" name="foto">
            </div>

            <button class="btn" name="simpan">Simpan Perubahan</button>
        </form>

    </div>
</div>

</body>
</html>
