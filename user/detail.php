<?php
include 'koneksi.php';

$id = $_GET['id'] ?? ''; 

if ($id != '') {
    $sql = "SELECT * FROM campaign WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}

$err ='';
$sukses = '';

$id = $_GET['id'] ?? '';

$result = mysqli_query($conn, "SELECT * FROM campaign WHERE id='$id'");
$data = mysqli_fetch_assoc($result); 

$tanggal_sekarang = date("Y-m-d");
$batas_waktu = $data['batas_waktu'];

if ($tanggal_sekarang > $batas_waktu) {
    mysqli_query($conn, "DELETE FROM campaign WHERE id='$id'");

    header("Location: utama.php");
    exit;
}


if (isset($_POST['input'])) {
    if (!is_numeric($_POST['input_donasi']) || intval($_POST['input_donasi']) <= 1000) {
        $_SESSION['error_form'] = "nilai_tidak_valid";
        $err = "Masukkan nilai donasi yang valid (lebih dari Rp.1000)";

    } else {
        $nama = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        $telpon = $_POST['telpon'] ?? '';
        $doa = $_POST['doa'] ?? '';

        if (isset($_POST['anonim'])) {
        $nama = 'Sahabat Peduli';
        }

        if($nama == '' || $email==''|| $telpon ==''){
            $_SESSION['error_form'] = "kosong";
            
        }else{
            $update = mysqli_query($conn, "INSERT INTO donatur(id_campaign, nama, email, telpon, doa) VALUES ('$id', '$nama', '$email', '$telpon', '$doa')");

        $terkumpul_baru = intval($_POST['input_donasi']);
        $terkumpul_lama = intval($data['terkumpul']);
        $total = $terkumpul_lama + $terkumpul_baru;
        $donatur = intval($data['donatur']) + 1;

        $update = mysqli_query($conn, "UPDATE campaign SET terkumpul='$total', donatur='$donatur' WHERE id='$id'");
        

        if ($update) {
            $target = intval($data['target']);
            
            if ($total >= $target) {
                $hapus = mysqli_query($conn, "DELETE FROM campaign WHERE id='$id'");
                if ($hapus) {
                    $sukses = "Target tercapai dan campaign telah dihapus.";
                    header("Location: utama.php");
                } else {
                    $err = "Target tercapai tapi gagal menghapus campaign.";
                    header("Location: utama.php");
                exit;
                }
            } else {
                $sukses = "Donasi berhasil ditambahkan!";
                $_SESSION['sukses_form'] = "berisi";
            }
        } else {
            $err = "Gagal menambahkan donasi.";
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
    <title>Data Donasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php if (!empty($_SESSION['error_form']) && $_SESSION['error_form'] === "kosong" ): ?>
    <div id="popup" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center w-[350px] sm:w-[300px] lg:w-[350px]">
            <h2 class="text-xl font-bold text-red-600 mb-4">Input gagal</h2>
            <p class="text-gray-700 mb-4">Form tidak boleh Kosong</p>
            <button onclick="document.getElementById('popup').classList.add('hidden')" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
<?php unset($_SESSION['error_form']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['sukses_form']) && $_SESSION['sukses_form'] === "berisi" ): ?>
    <div id="popup" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center w-[350px] sm:w-[300px] lg:w-[350px]">
            <h2 class="text-xl font-bold text-green-600 mb-4">Donasi Berhasil</h2>
            <p class="text-gray-700 mb-4">Terima Kasih</p>
            <button onclick="document.getElementById('popup').classList.add('hidden')" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
<?php unset($_SESSION['sukses_form']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error_form']) && $_SESSION['error_form'] === "nilai_tidak_valid" ): ?>
    <div id="popup" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center w-[350px] sm:w-[300px] lg:w-[350px]">
            <h2 class="text-xl font-bold text-red-600 mb-4">Input Gagal</h2>
            <p class="text-gray-700 mb-4">Nilai yang dimasukkan tidak Valid.</p>
            <button onclick="document.getElementById('popup').classList.add('hidden')" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
<?php unset($_SESSION['sukses_form']); ?>
<?php endif; ?>

<body class="bg-gradient-to-l from-[#3a59d1] to-[#3d90d7]">
    <div class="w-full max-w-[900px] mx-auto shadow-2xl pt-[50px] pb-[20px] rounded-xl bg-white px-4 sm:px-6 md:px-8">
        <div class="ml-4 mb-[10px]">
            <a href="utama.php">← Kembali</a>
        </div>
        <div>
            <img src="<?= $data['foto_gambar'] ?>" class="w-full max-w-[800px] h-[400px] sm:h-[600px] mx-auto object-cover">
        </div>
        <div class="mx-4 sm:mx-[50px]">
            <h1 class="font-['outfit'] text-[#205781] text-[20px] text-left mt-[30px] font-bold"><?= $data['judul'] ?></h1>
            <h2><?= $data['nama'] ?></h2>
        </div>
        <div class="mx-4 sm:mx-[50px]">
            <p class="font-['outfit'] text-blue-600 text-[16px] text-left mt-[10px]">Penggalang: <?= $data['penggalang'] ?></p>
        </div>
        <div class="mx-4 sm:mx-[50px]">
            <p class="font-['outfit']">Target: Rp <?= number_format($data['target'], 0, ',', '.') ?></p>
        </div>
        <div class="mx-4 sm:mx-[50px]">
            <p>Sampai: <?= $data['batas_waktu'] ?></p>
        </div>
        <div class="mx-4 sm:mx-[50px]">
            <p>Terkumpul : <?= number_format($data['terkumpul'], 0, ',', '.') ?></p>
        </div>
        <div class="mx-4 sm:mx-[50px]">
            <p>Jumlah donatur :<?= $data['donatur'] ?></p>
        </div>
        <hr class="mt-[10px] border-t-4 mx-4 sm:mx-[50px] mb-[20px]">
        <div class="mx-4 sm:mx-[50px] justify-center">
            <p id="text" class="text-gray-700 font-['Plus Jakarta Sans']">
                <span id="full" class="hidden"><?= $data['kisah']?></span>
            </p>
            <button id="toggle" class="mb-4 text-blue-600 font-semibold hover:underline mx-auto">Selengkapnya</button>
        </div>
        <div class="mx-4 sm:mx-[50px]">
        <?php if ($err): ?>
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-md text-sm sm:text-base"><?= $err ?></div>
        <?php endif; ?>

        <?php if ($sukses): ?>
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-md text-sm sm:text-base"><?= $sukses ?></div>
        <?php endif; ?>

            <?php
                $donatur_result = mysqli_query($conn, "SELECT * FROM donatur WHERE id_campaign = '$id' ORDER BY id DESC");
                while ($row = mysqli_fetch_assoc($donatur_result)) {
                    if (!empty(trim($row['doa']))) {
                        echo "<div class='mt-4 p-3 border rounded bg-gray-100'>";
                        echo "<p class='font-bold'>{$row['nama']}</p>";
                        echo "<p class='italic'>{$row['doa']}</p>";
                        echo "</div>";
                    }

            }
            ?>

            <form method="post">
                <label>Jumlah Donasi untuk <?= $data['nama'] ?></label>
                <input type="number" name="input_donasi" class="w-full border border-gray-300 p-2 rounded"><br><br>

                <label>Nama Donatur</label>
                <input type="text" name="nama" class="w-full border border-gray-300 p-2 rounded"><br><br>

                <input type="checkbox" name="anonim" id="anonim" class="mr-2">
                <label for="anonim">Sembunyikan Nama (Donasi Anonim)</label><br><br>

                <label>Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded"><br><br>

                <label>No. Telpon</label>
                <input type="text" name="telpon" class="w-full border border-gray-300 p-2 rounded"><br><br>

                <label>Doa / Pesan</label>
                <textarea name="doa" class="w-full border border-gray-300 p-2 rounded"></textarea><br><br>

                <button type="submit" name="input" class="text-white font-bold bg-red-400 w-full sm:w-auto lg:w-[500px] sm:px-[360px] rounded-2xl p-[5px] mt-[10px]">Donasikan</button>
            </form>
        </div>

    </div>

    <script>
        const toggleBtn = document.getElementById('toggle');
        const shortText = document.getElementById('short');
        const fullText = document.getElementById('full');
        let isExpanded = false;

        toggleBtn.addEventListener('click', () => {
            isExpanded = !isExpanded;
            fullText.classList.toggle('hidden');
            shortText.classList.toggle('hidden');
            toggleBtn.textContent = isExpanded ? 'Sembunyikan' : 'Selengkapnya';
        });
    </script>
</body>
</html>