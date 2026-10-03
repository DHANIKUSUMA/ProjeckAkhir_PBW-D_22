<?php
require_once('../config/koneksi.php');

$id = $_GET['id'] ?? ''; 

if ($id != '') {
    $sql = "SELECT * FROM campaign2 WHERE id = '$id'";
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

    $result = mysqli_query($conn, "SELECT * FROM campaign2 WHERE id='$id'");
    $data = mysqli_fetch_assoc($result);

    $tanggal_sekarang = date("Y-m-d");
    $batas_waktu = $data['batas_waktu'];

    if ($tanggal_sekarang > $batas_waktu) {
        mysqli_query($conn, "DELETE FROM campaign WHERE id='$id'");
        
        header("Location: utama.php");
        exit;
}

$result2 = mysqli_query($conn, "SELECT * FROM campaign2 WHERE id='$id'");  
$data = mysqli_fetch_assoc($result2); 


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
            $update2 = mysqli_query($conn, "INSERT INTO donatur2 (id_campaign2, nama, email, telpon, doa) VALUES ('$id', '$nama', '$email', '$telpon', '$doa')");

            $terkumpul_baru = intval($_POST['input_donasi']);
            $terkumpul_lama = intval($data['terkumpul']);
            $total = $terkumpul_lama + $terkumpul_baru;
            $donatur = intval($data['donatur']) + 1;

            $update = mysqli_query($conn, "UPDATE campaign2 SET terkumpul='$total', donatur='$donatur' WHERE id='$id'");
            $_SESSION['sukses_form'] = "berisi";

        if ($update) {
            $target = intval($data['target']);

            
            if ($total >= $target ) {
                $hapus = mysqli_query($conn, "DELETE FROM campaign2 WHERE id='$id'");
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
require_once('../path/app.php');

?>
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
    <div class="w-full max-w-[900px] mx-auto shadow-2xl pt-[50px] pb-[20px] rounded-xl bg-white px-4 sm:px-6 md:px-10">
        <div class="mb-[10px]">
            <a href="../landingPage.php">← Kembali</a>
        </div>
        <div>
            <img src="<?= $data['foto_gambar'] ?>" class="w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px] object-cover rounded-md">
        </div>
        <div class="mt-[10px]">
            <p class="font-bold text-[18px] sm:text-[20px] font-['roboto'] text-[#205781] text-left"><?= $data['judul'] ?></p>
        </div>
        <div>
            <p class="font-['outfit'] text-blue-600 text-[14px] sm:text-[16px] text-left mt-[10px]">Penggalang: <?= $data['penggalang'] ?></p>
        </div>
        <div>
            <p class="font-['outfit'] text-sm sm:text-base">Target: Rp <?= number_format($data['target'], 0, ',', '.') ?></p>
        </div>
        <div>
            <p class="text-sm sm:text-base">Sampai: <?= $data['batas_waktu'] ?></p>
        </div>
        <div>
            <p>Terkumpul : <?= $data['terkumpul']?></p>
        </div>
        <div>
            <p class="text-sm sm:text-base">Jumlah Donatur : <?= $data['donatur'] ?></p>
        </div>
        <hr class="mt-4 border-t-4 mb-[20px]">
        <div class="text-center sm:text-left">
            <p id="text" class="text-gray-700 font-['Plus Jakarta Sans'] text-sm sm:text-base">
                <span id="short" class="font-bold">Kisah </span>
                <span id="full" class="hidden"><?= $data['kisah']?></span>
            </p>
            <button id="toggle" class="mb-4 text-blue-600 font-semibold hover:underline">Selengkapnya</button>
        </div>
    </div>

    <div class="w-full max-w-[900px] mx-auto shadow-2xl pt-[50px] pb-[20px] rounded-xl bg-white mt-[20px] px-4 sm:px-6 md:px-10">
        <div>
            <?php if ($err): ?>
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-md text-sm sm:text-base"><?= $err ?></div>
            <?php endif; ?>

            <?php if ($sukses): ?>
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-md text-sm sm:text-base"><?= $sukses ?></div>
            <?php endif; ?>

            <p class="font-semibold">Doa dan Pesan dari Sahabat Peduli</p>
            <?php
                $donatur_result = mysqli_query($conn, "SELECT * FROM donatur2 WHERE id_campaign2 = '$id' ORDER BY id DESC");
                while ($row = mysqli_fetch_assoc($donatur_result)) {
                    if (!empty(trim($row['doa']))) {
                        echo "<div class='mt-4 p-3 border rounded bg-gray-100'>";
                        echo "<p class='font-bold'>{$row['nama']}</p>";
                        echo "<p class='italic'>{$row['doa']}</p>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </div>

    <div class="w-full max-w-[900px] mx-auto shadow-2xl pt-[50px] pb-[20px] rounded-xl bg-white mt-[20px] px-4 sm:px-6 md:px-10">
        <form method="post">
            <p class="text-lg font-semibold mb-2">Mari Bantu Saudara Kita yang Membutuhkan</p>

            <label class="block mb-1">Jumlah Donasi untuk <?= $data['judul'] ?></label>
            <input type="number" name="input_donasi" class="w-full border border-gray-300 p-2 rounded mb-4">

            <label class="block mb-1">Nama Donatur</label>
            <input type="text" name="nama" class="w-full border border-gray-300 p-2 rounded mb-4">

            <div class="mb-4">
                <input type="checkbox" name="anonim" id="anonim" class="mr-2">
                <label for="anonim">Sembunyikan Nama (Donasi Anonim)</label>
            </div>

            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded mb-4">

            <label class="block mb-1">No. Telpon</label>
            <input type="text" name="telpon" class="w-full border border-gray-300 p-2 rounded mb-4">

            <label class="block mb-1">Doa / Pesan</label>
            <textarea name="doa" class="w-full border border-gray-300 p-2 rounded mb-4"></textarea>

            <button type="submit" name="input" class="text-white font-bold bg-blue-600 hover:bg-blue-700 w-full sm:w-auto sm:px-10 py-2 rounded-2xl transition">Donasikan</button>
        </form>
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

