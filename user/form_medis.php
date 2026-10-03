<?php
include 'koneksi.php';
session_start();

$err = '';
$sukses = '';

if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'] ?? '';
    $penggalang = $_POST['penggalang'] ?? '';
    $target = $_POST['target'] ?? 0;
    $batas_waktu = $_POST['batas_waktu'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $nama_ibu = $_POST['nama_ibu'] ?? '';
    $provinsi = $_POST['provinsi'] ?? '';
    $kabKota = $_POST['kabKota'] ?? '';
    $kecamatan = $_POST['kecamatan'] ?? '';
    $desa = $_POST['desa'] ?? '';
    $rwRt = $_POST['rwRt'] ?? '';
    $kisah = $_POST['kisah']?? '';


    $direktori = "uploads/";
    $file_name = $_FILES['foto_gambar']['name'];
    $path = $direktori . $file_name;

    if (
        $judul == '' || $penggalang == '' || $target == '' || $batas_waktu == '' ||
        $nama == '' || $nama_ibu == '' || $provinsi == '' || $kabKota == '' ||
        $kecamatan == '' || $desa == '' || $rwRt == '' || $kisah == ''
    ) {
        $err = "Harap mengisi seluruh form";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM campaign WHERE nama ='$nama' AND nama_ibu = '$nama_ibu'");
        if (mysqli_num_rows($cek) > 0) {
            $err = "Data sudah ada";
        } else {
            if (move_uploaded_file($_FILES['foto_gambar']['tmp_name'], $path)) {

                $sql = "INSERT INTO campaign 
                    (judul, penggalang, target, batas_waktu, nama, nama_ibu, foto_gambar, provinsi, kabKota, kecamatan, desa, rwRt, kisah) 
                    VALUES 
                    ('$judul','$penggalang','$target','$batas_waktu','$nama','$nama_ibu','$path','$provinsi','$kabKota','$kecamatan','$desa','$rwRt', '$kisah')";
            
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $id_campaign = mysqli_insert_id($conn);

                $insert_donatur = mysqli_query($conn, 
                    "INSERT INTO donatur (id_campaign, nama, email, telpon, doa) 
                    VALUES ('$id_campaign', '$nama', '', '', '')");

                $sukses = "Data campaign dan donatur berhasil ditambahkan";
                header("Location: utama.php");
            } else {
                $err = "Gagal menyimpan data campaign.";
            }
        } else {
            $err = "Upload gambar gagal";
        }

        }
    }
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Campaign Medis</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-l from-[#3a59d1] to-[#3d90d7] min-h-screen flex items-center justify-center font-['Plus Jakarta Sans']">
<div class="bg-white w-[90%] sm:w-[600px] md:w-[700px] lg:w-[800px] xl:w-[900px] rounded-xl shadow-2xl p-6 sm:p-8 md:p-10 my-10">
    <h1 class="text-xl sm:text-2xl font-bold text-[#205781] mb-4 sm:mb-6 text-center">Tambah Campaign Donasi Medis</h1>
      <div class="mb-4 sm:mb-6">
        <a href="utama.php" class="text-sm text-blue-700 hover:underline">← Kembali</a>
    </div>

    <?php if ($err): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-md text-sm sm:text-base"><?= $err ?></div>
    <?php endif; ?>

    <?php if ($sukses): ?>
      <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-md text-sm sm:text-base"><?= $sukses ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block font-semibold mb-1">Judul Campaign</label>
        <input type="text" name="judul" class="w-full border border-gray-300 p-2 rounded" />
      </div>

      <div>
        <label class="block font-semibold mb-1">Nama Penggalang</label>
        <input type="text" name="penggalang" class="w-full border border-gray-300 p-2 rounded" />
      </div>

      <div>
        <label class="block font-semibold mb-1">Target Donasi</label>
        <input type="number" name="target" class="w-full border border-gray-300 p-2 rounded" />
      </div>

      <div>
        <label class="block font-semibold mb-1">Batas Waktu</label>
        <input type="date" name="batas_waktu" class="w-full border border-gray-300 p-2 rounded" />
      </div>

      <div>
        <label class="block font-semibold mb-1">Foto/Poster</label>
        <input type="file" name="foto_gambar" class="w-full border border-gray-300 p-2 rounded" />
      </div>

      <div>
        <label class="block font-semibold mb-1">Nama Lengkap yang Didonasikan</label>
        <input type="text" name="nama" class="w-full border border-gray-300 p-2 rounded" />
      </div>

      <div>
        <label class="block font-semibold mb-1">Nama Ibu</label>
        <input type="text" name="nama_ibu" class="w-full border border-gray-300 p-2 rounded" />
      </div>

      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="block font-semibold mb-1">Provinsi</label>
          <input type="text" name="provinsi" class="w-full border border-gray-300 p-2 rounded" />
        </div>

        <div>
          <label class="block font-semibold mb-1">Kota/Kabupaten</label>
          <input type="text" name="kabKota" class="w-full border border-gray-300 p-2 rounded" />
        </div>

        <div>
          <label class="block font-semibold mb-1">Kecamatan</label>
          <input type="text" name="kecamatan" class="w-full border border-gray-300 p-2 rounded" />
        </div>

        <div>
          <label class="block font-semibold mb-1">Desa/Kelurahan</label>
          <input type="text" name="desa" class="w-full border border-gray-300 p-2 rounded" />
        </div>

        <div class="sm:col-span-2">
          <label class="block font-semibold mb-1">RT/RW</label>
          <input type="text" name="rwRt" class="w-full border border-gray-300 p-2 rounded" />
        </div>
      </div>

      <div>
        <label class="block font-semibold mb-1">Kisah (maksimal 4 paragraf)</label>
        <textarea name="kisah" rows="5" class="w-full border border-gray-300 p-2 rounded" placeholder="Tuliskan kisah..."></textarea>
      </div>

      <div class="text-center">
        <button type="submit" name="tambah" value="upload" class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-6 rounded-2xl">Tambah</button>
      </div>
    </form>
  </div>
</body>
