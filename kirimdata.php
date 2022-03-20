<?php
$servername = "localhost";
$username = "id18038228_sensorusername";
$password = "_*cnF})<*&fhOKs4";
$dbname = "id18038228_dbsensor";
 
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
$nama_sensor=htmlspecialchars($_GET["nama"]) ; // 'sensor_A';
$suhu=htmlspecialchars($_GET["suhu"]) ; //34; 
$lembab=htmlspecialchars($_GET["lembab"]) ; 
 
$sql = "INSERT INTO sensor(id_sensor,nama_sensor,nilai_suhu, nilai_lembab) VALUES (NULL,'$nama_sensor','$suhu','$lembab')";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "New record created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
 
$conn = null;
;
 
?>
