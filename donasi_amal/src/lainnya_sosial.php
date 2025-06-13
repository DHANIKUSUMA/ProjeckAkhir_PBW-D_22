<?php
include "koneksi.php";
session_start();
$sql2 = "SELECT * FROM campaign2 ";
$result2 = mysqli_query($conn, $sql2);
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
<body>
    <header class="fixed top-0 left-0 w-full z-50 bg-white shadow-xl">
        <nav class="flex items-center justify-between flex-wrap p-4 sm:px-6 md:px-10 lg:px-[100px] xl:px-[150px]">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
            <img src="Peduli_Bersama.png" class="w-[50px] lg:w-[70px]" alt="Logo">
            </div>
            <div class="block lg:hidden">
            <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-[#205781] border-[#205781] hover:text-[#16423c] hover:border-[#16423c]">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20">
                <path d="M0 3h20v2H0zM0 9h20v2H0zM0 15h20v2H0z"/>
                </svg>
            </button>
            </div>

            <div id="nav-menu" class="w-full hidden lg:flex lg:items-center lg:w-auto mt-4 lg:mt-0">
            <div class="text-sm lg:flex-grow flex flex-col lg:flex-row lg:gap-8 items-start lg:items-center">
                <div class="relative">
                <?php if (isset($_SESSION['session_username'])): ?>
                    <button id="galang_dana" class="block font-semibold text-[#205781] hover:text-[#16423c] text-sm lg:text-base font-['Outfit']">Galang Dana</button>
                <?php else: ?>
                    <a href="login.php" class="block font-semibold text-[#205781] hover:text-[#16423c] text-sm lg:text-base font-['Outfit']">Galang Dana</a>
                <?php endif; ?>
                <div id="kategori" class="hidden absolute bg-white p-[20px] rounded-[10px] z-50 mt-2 w-max shadow-lg">
                    <ul class="text-sm lg:text-base font-['Outfit']">
                    <li><a href="form_medis.php" class="text-[#0000ffc7] block py-1">Galang dana untuk kebutuhan medis</a></li>
                    <li><a href="form_sosial.php" class="text-[#0000ffc7] block py-1">Galang dana untuk kebutuhan sosial</a></li>
                    </ul>
                </div>
                </div>
                <?php if (isset($_SESSION['session_username'])): ?>
                <span class="block mt-3 lg:mt-0 text-[#205781] font-['Outfit'] text-sm lg:text-base">Halo, <?= htmlspecialchars($_SESSION['session_username']) ?></span>
                <a href="logout.php" class="block font-semibold text-[#205781] hover:text-[#16423c] mt-2 lg:mt-0 text-sm lg:text-base font-['Outfit']">Logout</a>
                <?php else: ?>
                <a href="login.php" class="block font-semibold text-[#205781] hover:text-[#16423c] mt-2 lg:mt-0 text-sm lg:text-base font-['Outfit']">Login</a>
                <a href="daftar.php" class="block font-semibold text-white bg-[#205781] hover:bg-white hover:text-[#205781] border border-[#205781] rounded-lg mt-2 px-4 py-2 text-sm lg:text-base font-['Outfit']">Daftar</a>
                <?php endif; ?>
            </div>
            </div>
        </nav>
    </header>
<div class="lg:pt-[90px] pt-[80px]">
    <div class="overflow-hidden z-0">
        <div id="slides" class="flex transition-transform duration-700 ease-in-out">
            <img src="1.png" alt="Gambar 1" class="w-full flex-shrink-0">
            <img src="2.png" alt="Gambar 2" class="w-full flex-shrink-0">
            <img src="3.png" alt="Gambar 3" class="w-full flex-shrink-0">
        </div>
    </div>

    <h2 class="font-semibold text-[#205781] font-['Outfit'] text-[24px] sm:text-[28px] md:text-[32px] text-center mt-[50px]">Mari Donasikan Sebagian Rezeki Anda!</h2>
    
    <div class="w-full sm:w-[90%] md:w-[700px] mx-auto mt-[30px] px-4 text-center font-['Plus Jakarta Sans'] text-[14px] sm:text-[16px]">
        <p>"Perumpamaan orang yang menginfakkan hartanya di jalan Allah seperti sebutir biji yang menumbuhkan tujuh bulir; 
        pada setiap bulir ada seratus biji. Allah melipatgandakan bagi siapa yang Dia kehendaki. Dan Allah Maha Luas, Maha Mengetahui. (QS. Al-Baqarah: 261)</p>
    </div>

    <div>
        <hr class="mx-[20px] sm:mx-[80px] lg:mx-[150px] mt-[50px] sm:mt-[100px] border-t-4">
    </div>

    <div class="flex justify-between items-center mx-[20px] sm:mx-[80px] lg:mx-[150px] mt-[30px] sm:mt-[50px] text-[14px]">
        <a href="utama.php">← Kembali</a>
        <a href="Lainnya2.php">lihat Lainnya</a>
    </div>

    <div class="flex flex-wrap justify-center gap-4 px-4 mt-[30px] sm:mt-[50px]">
        <?php if (mysqli_num_rows($result2) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result2)) : ?>
            <a href="detail2.php?id=<?= $row['id'] ?>">
                <div class="border border-gray-150 shadow-lg p-[15px] rounded-[15px] w-full sm:w-[280px] md:w-[300px] h-[420px]">
                    <img src="<?= $row['foto_gambar'] ?>" class="w-full h-[200px] object-cover">
                    <h1 class="font-bold text-[18px] sm:text-[20px] font-['roboto'] text-[#205781] mt-[10px]"><?= $row['judul'] ?></h1>
                    <hr class="mt-[10px] border-t-4">
                    <p class="font-['outfit'] text-[12px] text-[#0000ffc7]"><?= $row['penggalang'] ?></p>
                    <p class="text-[#205781bf] font-['outfit']">Target: Rp <?= number_format($row['target'], 0, ',', '.') ?></p>
                    <p class="text-[#205781bf] font-['outfit']">Donasi Terkumpul: Rp <?= number_format($row['terkumpul'], 0, ',', '.') ?></p>
                    <p class="text-[#205781bf] font-['outfit'] text-[12px]">Jumlah Donatur: <?= $row['donatur'] ?></p>
                </div>
            </a>
        <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada data.</p>
        <?php endif; ?>
    </div>
</div>
    <footer class="bg-[#0A061F] px-4 sm:px-8 md:px-[94px] py-[80px] mt-[80px]">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h2 class="text-lg font-semibold mb-2 text-blue-500">Masukkan atau saran</h2>
                <div class="flex items-center bg-gray-700 rounded-md overflow-hidden">
                    <input type="email" placeholder="Saran" class="bg-gray-700 text-white px-4 py-2 w-full focus:outline-none" />
                    <button class="bg-blue-500 px-4 py-2 hover:bg-blue-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M2 21l21-9L2 3v7l15 2-15 2v7z" />
                        </svg>
                    </button>
                </div>
                <p class="text-sm mt-3 text-gray-300">
                    <a href="#" class="text-blue-400 underline">peduliBersama.id</a> atau <strong>Yayasan Peduli Bersama Indonesia</strong> adalah nonprofit terdaftar...
                </p>
            </div>
            <div class="flex items-center space-x-2 text-white">
                <i class="fas fa-envelope"></i>
                <a href="mailto:dhaniksmpr@gmail.com">support@peduliBersama.id</a>
            </div>
            <div class="space-y-4">
                <div class="flex space-x-3 text-white text-2xl">
                    <i class="fab fa-whatsapp"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-youtube"></i>
                    <i class="fab fa-tiktok"></i>
                </div>
                <div class="flex space-x-2">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="h-10">
                </div>
            </div>
        </div>
        <div class="text-center mt-8 lg:text-sm text-[10px] text-gray-400">
            Copyrights ©2025 Yayasan Peduli Bersama | DhaniKusumaPrasetyo. All Rights Reserved
        </div>
    </footer>

    <script>
        const slides = document.getElementById('slides');
        const totalSlides = slides.children.length;
        let index = 0;

        setInterval(() => {
            index = (index + 1) % totalSlides;
            slides.style.transform = `translateX(-${index * 100}%)`;
        }, 5000);

        const navToggle = document.getElementById('nav-toggle');
        const navMenu = document.getElementById('nav-menu');
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('hidden');
        });

        const buttonToggle = document.querySelector('#galang_dana');
        const kategori = document.querySelector('#kategori');

        buttonToggle.addEventListener('click', () => {
            kategori.classList.toggle('hidden');
        });
    </script>
</body>
</html>
