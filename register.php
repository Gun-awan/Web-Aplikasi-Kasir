<?php
    include "koneksi.php";

    $error      ="";
    $sukses     ="";

    if(isset($_POST["daftar"])){

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if($username == "" || $password == ""){
        $error = "Username dan Password wajib diisi";
    } else {

        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

        if($conn->query($sql)){
            $sukses = "Daftar akun berhasil";
            header("refresh:2;url=login.php");
        } else {
            $error = "Daftar akun gagal";
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
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="css/style2.css"> 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .wrapper {
    width: 420px;
    height: 450px;
    background: rgb(56, 56, 56);
    opacity: 100%;
    color: rgb(239, 248, 248);
    border-radius: 15px; /* untuk membuat lengkungan pada ujung persegi*/
    padding: 10px 40px;
    
}
body {
    display: flex;
    opacity: 88%;
    justify-content: center;
    align-items: center;
    background-position: left;
    margin-top: 50px;
    background: rgb(252, 255, 255);


}
    </style>
</head>

<body>
    <div class="wrapper">
        <form action="register.php" method="POST">
            <h1>Daftar Akun</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                    <input type="password" placeholder="Password" name="password">
                    <i class='bx bxs-lock-alt' ></i>
            </div>

            <button type="submit" class="btn" name="daftar"><strong>Daftar</strong></button>
            <p>___________________________________________________</p>
        </form>

        <p><?php echo $sukses ?></p>
        <h4><?php echo $error ?></h4>
    </div>
    
</body>
</html>