<?php
session_start();
include 'koneksi.php';

$error = "";
$sukses = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        if ($password == $data['password']) {

            $_SESSION['user_id'] = $data['id_users'];
            $_SESSION['role']    = $data['role'];

            // 🔥 ROLE REDIRECT
            if ($data['role'] == 'admin') {
                echo "<script>
alert('Login berhasil');
window.location.href='dashboard.php';
</script>";
exit;
            } elseif ($data['role'] == 'kasir') {
                
                echo "<script>
alert('Login berhasil');
window.location.href='index.php';
</script>";
exit;
            } else {
                $error = "User tidak ditemukan";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .wrapper {
            width: 420px;
            height: 500px;
            background: rgb(112, 200, 235);
            opacity: 100%;
            color: rgb(239, 248, 248);
            border-radius: 15px;
            /* untuk membuat lengkungan pada ujung persegi*/
            padding: 10px 40px;

        }
    </style>
</head>

<body>

    <div class="wrapper">
        <form action="login.php" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password">
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox">Remember Me</label>
                <a href="#">Forgot Password</a>
            </div>

            <button type="submit" class="btn" name="login"><strong>Login</strong></button>

            <div class="register-link">
                <p>Belum punya Akun? <a href="register.php">DAFTAR</a></p>
            </div>
            <p>___________________________________________________</p>
            <h3><?php echo $error ?></h3>
            <h3><?php echo $sukses ?></h3>

        </form>
    </div>

</body>

</html>