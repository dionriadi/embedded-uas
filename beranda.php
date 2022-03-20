<?php session_start();
      include("koneksi.php");
      if(isset($_SESSION["id_user"])){
        if($_SESSION["id_user"]=="admin"){

        $penonton = mysqli_query($koneksi,"SELECT `id_hitung` FROM hitung"); 
            // menghitung data anggota
        $jumlah_penonton = mysqli_num_rows($penonton);

        $sql_k = "SELECT `nilai_suhu`, `nilai_lembab` FROM `sensor` ORDER BY `id_sensor` ASC ";
        $query_k = mysqli_query($koneksi,$sql_k);    
        while($data_k = mysqli_fetch_row($query_k)){
            $suhu = $data_k[0];
            $lembab = $data_k[1];
        }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IOT Kelompok 4 T3A</title>
    <script type="text/javascript" src="chartjs/Chart.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
<link rel="stylesheet" href="assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>

<body>
    <div id="app">
    <div id="main">
    <?php include("sidebar.php"); ?>
            <div class="page-heading">
    <h3>Beranda Sensor</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Pengguna</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo $jumlah_penonton;?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Anggota</h6>
                                    <h6 class="font-extrabold mb-0">3</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Nilai Sensor</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                            <script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ["Suhu", "Kelembaban"],
				datasets: [{
					data: [<?php echo $suhu;?>, <?php echo $lembab;?>],
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Nilai Sensor</h4>
                        </div>
                        <div class="card-body">
                        <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sensor</th>
                            <th>Nilai Suhu</th>
                            <th>Nilai Kelembaban</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $posisi=0;
                        $sql_k = "SELECT `id_sensor`,`nama_sensor`, `nilai_suhu`, `nilai_lembab` FROM `sensor` ORDER BY `id_sensor` DESC ";
                        $query_k = mysqli_query($koneksi,$sql_k);
                        $posisi+1;
                        while($data_k = mysqli_fetch_row($query_k)){
                          $id_user = $data_k[0];
                          $nama = $data_k[1];
                          $suhu = $data_k[2];
                          $lembab = $data_k[3];

                      ?>
                        <tr>
                            <td><?php echo $posisi+1; ?></td>
                            <td><?php echo $nama; ?></td>
                            <td><?php echo $suhu; ?></td>
                            <td><?php echo $lembab; ?></td>
                            </td>
                        </tr>
                        <?php $posisi++;}?>
                    </tbody>
                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Kelompok 4 TIK 3A</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    
<script src="assets/vendors/apexcharts/apexcharts.js"></script>
<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="assets/js/pages/dashboard.js"></script>
    <script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
<script src="assets/js/mazer.js"></script>
</body>

</html>
<?php }else{
    header("Location:index.php");
}}?>