<?php
require_once('config/koneksi.php');
session_start();

$err = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == '' || $password == '') {
        $_SESSION['error_login'] = "kosong";
        header("Location: login.php");
        exit();
    } else {
        $sql1 = "SELECT * FROM users WHERE username = '$username'";
        $q1 = mysqli_query($conn, $sql1);

        if (!$q1) {
            $err = "Query gagal: " . mysqli_error($conn);
        } else {
            $r1 = mysqli_fetch_array($q1);

            if (!$r1) {
                $_SESSION['error_login'] = "Username tidak tersedia";
            } elseif ($r1['password'] != md5($password)) {
                $err = "Password salah";
                $_SESSION['error_login'] = "Password salah";
            } else {
                $_SESSION['session_username'] = $username;
                $_SESSION['session_password'] = md5($password);

                header("Location: landingPage.php");
                exit();
            }
        }
    }
}

require_once('path/app.php')

?>

<body id="main-body" class="bg-gradient-to-l from-[#3a59d1] to-[#3d90d7] min-h-screen flex items-center justify-center font-['Outfit'] opacity-100 transition-opacity duration-500">

<?php if (!empty($_SESSION['error_login']) && $_SESSION['error_login'] === "Password salah" ): ?>
    <div id="popup" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center w-[350px] sm:w-[300px] lg:w-[350px]">
            <h2 class="text-xl font-bold text-red-600 mb-4">Login Gagal</h2>
            <p class="text-gray-700 mb-4">Password salah. Silakan coba lagi.</p>
            <button onclick="document.getElementById('popup').classList.add('hidden')" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
<?php unset($_SESSION['error_login']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error_login']) && $_SESSION['error_login'] === "Username tidak tersedia" ): ?>
    <div id="popup" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center w-[350px] sm:w-[300px] lg:w-[350px]">
            <h2 class="text-xl font-bold text-green-600 mb-4">Username Tidak Tersedia</h2>
            <p class="text-gray-700 mb-4"> Silakan coba Daftar.</p>
            <button onclick="document.getElementById('popup').classList.add('hidden')" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
<?php unset($_SESSION['error_login']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error_login']) && $_SESSION['error_login'] === "kosong"): ?>
    <div id="kosong" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center w-[350px] sm:w-[300px] lg:w-[350px]">
            <h2 class="text-xl font-bold text-red-600 mb-4">Username dan Password</h2>
            <p class="text-gray-700 mb-4">Tidak boleh kosong. Silakan coba lagi.</p>
            <button onclick="document.getElementById('kosong').classList.add('hidden')" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
<?php unset($_SESSION['error_login']); ?>
<?php endif; ?>

<section class="min-h-screen flex items-center justify-center bg-transparent w-full p-4">
    <div class="flex flex-col lg:flex-row items-center w-full max-w-5xl">
        <div class="w-full max-w-md lg:max-w-xl bg-white rounded-[25px] shadow-2xl mb-8 lg:mb-0 lg:mr-8">
        <form method="POST" class="p-[30px] sm:p-[40px] md:p-[50px]">
            <h1 class="text-[24px] font-bold font-['Outfit']">Login</h1>
            <div class="mt-[25px]">
                <label for="username"><p class="font-['Outfit']">Username</p>
                    <input type="text" name="username" class="border border-gray-500 h-[40px] w-full rounded-[10px] mt-[10px] p-[15px]">
            </label>
            </div>
            <div class="mt-[25px]">
            <label for="password"><p class="font-['Outfit']">Password</p>
                <input type="password" name="password" class="border border-gray-500 h-[40px] w-full rounded-[10px] mt-[10px] p-[15px]">
            </label>
            </div>
            <div class="mt-[25px]">
                <button type="submit" name="login" value="login" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim</button>
            </div>
            <div class="mt-[25px] flex flex-col sm:flex-row sm:items-center">
                <p class="mr-2">Belum punya akun?</p>
                <a href="register.php" class="text-blue-600 underline">Daftar di sini</a>
            </div>
      </form>
    </div>

    <div class="h-[500px] w-full max-w-md lg:max-w-[500px] text-white items-center justify-center rounded-[25px] p-[20px] lg:mt-[300px] flex flex-col">
    <div class="flex-col mt-[50px] sm:mt-[80px] lg:mt-[0px] lg:block hidden text-left h-[500px] w-[500px] text-white items-center justify-center rounded-[25px] p-[20px] min-h-screen ">
        <div>
            <img src="asset/Peduli_Bersama.png" class="w-[100px] rounded-[25px]">
        </div>
        <div>
            <h1 class="text-[40px] sm:text-[50px] font-bold font-['outfit'] drop-shadow-md p-[0px]">SELAMAT DATANG</h1>   
        </div>
        <div>
            <h1 class="text-[24px] sm:text-[30px] font-bold drop-shadow-md">SILAHKAN LOGIN</h1>
        </div>
        <div>
            <h2 class="text-[12px] drop-shadow-md">WWW.PEDULI BERSAMA.COM</h2>
        </div>   
    </div>
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
