<?php
include 'koneksi.php';
$err = '';
$sukses = '';

if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'] ?? '';
    $penggalang = $_POST['penggalang'] ?? '';
    $target = $_POST['target'] ?? 0;
    $batas_waktu = $_POST['batas_waktu'] ?? '';
    $negara = $_POST['negara'] ?? '';
    $provinsi = $_POST['provinsi'] ?? '';
    $kabKota = $_POST['kabKota'] ?? '';
    $kecamatan = $_POST['kecamatan'] ?? '';
    $kisah = $_POST['kisah'] ?? '';

    $direktori = "uploads/";
    $file_name = $_FILES['foto_gambar']['name'];
    $path = $direktori . $file_name;

    if (
        $judul == '' || $penggalang == '' || $target == '' || $batas_waktu == ''
        || $negara == '' || $provinsi == '' || $kabKota == '' || $kecamatan == '' || $kisah == ''
    ) {
        $err = "Harap mengisi seluruh form";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM campaign2 WHERE judul ='$judul' and provinsi='$provinsi' and kabKota ='$kabKota' and kecamatan = '$kecamatan'");
        if (mysqli_num_rows($cek) > 0) {
            $err = "Data sudah ada";
        } else {
            if (move_uploaded_file($_FILES['foto_gambar']['tmp_name'], $path)) {
                $sql = "INSERT INTO campaign2 
                        (judul, penggalang, target, batas_waktu, negara, foto_gambar, provinsi, kabKota, kecamatan, kisah) 
                        VALUES 
                        ('$judul','$penggalang','$target','$batas_waktu','$negara','$path','$provinsi','$kabKota','$kecamatan','$kisah')";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    $id_campaign = mysqli_insert_id($conn);
                    $insert_donatur = mysqli_query($conn, 
                        "INSERT INTO donatur2 (id_campaign2, nama, email, telpon, doa) VALUES ('$id_campaign', '', '', '', '')");

                    $sukses = "Data campaign dan donatur berhasil ditambahkan";
                    header("Location: utama.php");
                    exit;
                } else {
                    $err = "Upload gambar gagal";
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Campaign Sosial</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-l from-[#3a59d1] to-[#3d90d7] min-h-screen flex items-center justify-center font-['Plus Jakarta Sans']">
    <div class="bg-white w-[90%] sm:w-[600px] md:w-[700px] lg:w-[800px] xl:w-[900px] rounded-xl shadow-2xl p-6 sm:p-8 md:p-10 my-10">
        <h1 class="text-xl sm:text-2xl font-bold text-[#205781] mb-4 sm:mb-6 text-center">Tambah Campaign Donasi Sosial</h1>
        <div class="mb-4 sm:mb-6">
            <a href="utama.php" class="text-sm text-blue-700 hover:underline">← Kembali</a>
        </div>

        <?php if ($err): ?>
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-md text-sm sm:text-base"><?= $err ?></div>
        <?php endif; ?>

        <?php if ($sukses): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $sukses ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="space-y-4 sm:space-y-5">
            <div>
                <label class="block font-semibold">Judul</label>
                <input type="text" name="judul" class="w-full border p-2 sm:p-3 rounded" >
            </div>
            <div>
                <label class="block font-semibold">Nama Penggalang</label>
                <input type="text" name="penggalang" class="w-full border p-2 sm:p-3 rounded">
            </div>
            <div>
                <label class="block font-semibold">Target Donasi</label>
                <input type="number" name="target" class="w-full border p-2 sm:p-3 rounded">
            </div>
            <div>
                <label class="block font-semibold">Batas Waktu</label>
                <input type="date" name="batas_waktu" class="w-full border p-2 sm:p-3 rounded">
            </div>
            <div>
                <label class="block font-semibold">Foto / Poster</label>
                <input type="file" name="foto_gambar" class="w-full border p-2 sm:p-3 rounded">
            </div>
            <div>
                <label class="block font-semibold">Negara</label>
                <input type="text" name="negara" class="w-full border p-2 sm:p-3 rounded">
            </div>
            <div>
                <label class="block font-semibold">Provinsi</label>
                <input type="text" name="provinsi" class="w-full border p-2 sm:p-3 rounded">
            </div>
            <div>
                <label class="block font-semibold">Kabupaten / Kota</label>
                <input type="text" name="kabKota" class="w-full border p-2 sm:p-3 rounded">
            </div>
            <div>
                <label class="block font-semibold">Kecamatan</label>
                <input type="text" name="kecamatan" class="w-full border p-2 sm:p-3 rounded">
            </div>
            <div>
                <label class="block font-semibold">Kisah</label>
                <textarea name="kisah" rows="4" placeholder="Tuliskan maksimal 4 paragraf" class="w-full border p-2 sm:p-3 rounded"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" name="tambah" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 sm:px-8 rounded-full">Tambah Campaign</button>
            </div>
        </form>
    </div>
</body>
</html>
