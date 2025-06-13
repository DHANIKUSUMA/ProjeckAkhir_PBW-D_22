<?php
include 'koneksi.php';

$err = '';
$sukses = '';

if (isset($_POST['daftar'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == '' || $password == '') {
        $err = "Username dan password tidak boleh kosong";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($cek) > 0) {
            $err = "Username sudah terdaftar";
        } else {
            $password_hashed = md5($password);
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password_hashed')";
            $q = mysqli_query($conn, $sql);

            if ($q) {
                $sukses = "Registrasi berhasil. Silakan login.";
            } else {
                $err = "Gagal mendaftar: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
</head>
<body id="main-body" class="bg-gradient-to-l from-[#3a59d1] to-[#3d90d7] min-h-screen flex items-center justify-center font-['Outfit'] opacity-100 transition-opacity duration-500">

<?php if ($err): ?>
<div id="popup" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg text-center w-[350px] sm:w-[400px]">
        <h2 class="text-xl font-bold text-red-600 mb-4">Registrasi Gagal</h2>
        <p class="text-gray-700 mb-4"><?= $err ?></p>
        <button onclick="document.getElementById('popup').classList.add('hidden')" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
    </div>
</div>
<?php endif; ?>

<?php if ($sukses): ?>
<div id="popup" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg text-center w-[350px] sm:w-[400px]">
        <h2 class="text-xl font-bold text-green-600 mb-4">Registrasi Berhasil</h2>
        <p class="text-gray-700 mb-4"><?= $sukses ?> <a href="login.php" class="text-blue-600 underline">Login di sini</a></p>
        <button onclick="document.getElementById('popup').classList.add('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Tutup</button>
    </div>
</div>
<?php endif; ?>

<section class="flex flex-col lg:flex-row items-center justify-center h-auto lg:h-screen w-full p-4">
        <div class="h-[500px] w-[500px] text-white items-center justify-center rounded-[25px] p-[20px] lg:block hidden min-h-screen lg:mt-[300px]">
            <div class="flex-col mt-[0px]">
                <div>
                    <img src="Peduli_Bersama.png" class="w-[100px] rounded-[25px]">
                </div>
                <div>
                    <h1 class="text-[40px] sm:text-[45px] md:text-[50px] font-bold font-['outfit'] drop-shadow-md p-[0px]">SELAMAT DATANG</h1>   
                </div>
                <div>
                    <h1 class="text-[24px] sm:text-[28px] md:text-[30px] font-bold py-[1px] drop-shadow-md">SILAHKAN DAFTAR</h1>
                </div>
                <div>
                    <h2 class="text-[10px] sm:text-[11px] md:text-[12px] drop-shadow-md">WWW.PEDULI BERSAMA.COM</h2>
                </div>   
            </div>
        </div>
        <div class="bg-white rounded-[25px] shadow-2xl p-[30px] sm:p-[40px] md:p-[50px] w-[350px] sm:w-[450px] md:w-[500px] ">
            <h1 class="text-[20px] sm:text-[22px] md:text-[24px] font-bold mb-[20px] sm:mb-[25px]">Form Registrasi</h1>
            <form method="POST">
                <div class="mb-4 sm:mb-5">
                    <label class="block mb-2 text-sm font-medium">Username</label>
                    <input type="text" name="username" class="border border-gray-500 w-full h-[40px] rounded-[10px] p-[10px] sm:p-[12px] md:p-[15px]">
                </div>
                <div class="mb-4 sm:mb-5">
                    <label class="block mb-2 text-sm font-medium">Password</label>
                    <input type="password" name="password" class="border border-gray-500 w-full h-[40px] rounded-[10px] p-[10px] sm:p-[12px] md:p-[15px]">
                </div>
                <button type="submit" name="daftar" value="daftar" class="bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded hover:bg-blue-700 text-sm sm:text-base">Daftar</button>
                <p class="mt-3 sm:mt-4 text-sm">Sudah punya akun? <a href="login.php" class="text-blue-600 underline">Login di sini</a></p>
            </form>
        </div>
    </div>
</section>

<script>
      const links = document.querySelectorAll("a[href]");
  const body = document.getElementById("main-body");

    links.forEach(link => {
    link.addEventListener("click", function (e) {
      const target = link.getAttribute("href");
      
        if (target && !target.startsWith('#') && !target.startsWith('javascript')) {
        e.preventDefault();
      
        body.classList.remove("opacity-100");
        body.classList.add("opacity-0");

        setTimeout(() => {
          window.location.href = target;
        }, 500);
      }
    });
  });
</script>
</body>
</html>
