<?php
      //mengambil input user dari form
      include("koneksi.php");
        $user = $_POST['username'];
        $pass = $_POST['pass'];
        // $username = mysqli_real_escape_string($koneksi, $user);
        // $password = mysqli_real_escape_string($koneksi, MD5($pass));
        
      //mengambil data dari database
        // $sql="select `id_admin`, `level`, `username`, `password` from `admin` 
        //         where `username`='$username' and
        //        `password`='$password'";
        // $query = mysqli_query($koneksi, $sql);  
        // while($data = mysqli_fetch_row($query)){
        //   $id_user = $data[0];
        //   $level = $data[1]; 
        //   $userDb = $data[2];
        //   $passDb = $data[3];
          
        // }
        
        //pengecekan salah/benar input
        if(($user != "sensoriot4" ) && ($pass != "sensor")){
          header("Location:index.php?halaman=login&notif=salah");       
        }else{
          session_start();
          $_SESSION['id_user'] = "admin";
          mysqli_query($koneksi,"insert into hitung values(NULL,'masuk')");
          header("Location:beranda.php");
        }
?>
