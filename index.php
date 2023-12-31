<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Okegas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        /* Custom styles */
        
        .fixed-top {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1030;
        }
        .title-section {
        position:relative;
        background-color: #f8f9fa;
        padding: 30px 0;
        text-align: center;
        margin-top: 6vh;
        
        }
        .navbar {
          display: flex;
          justify-content: center;
          background-color: #007bff;
        }
        .navbar-brand {
          color: #ffffff;
        }
        .navbar-collapse {
          justify-content: flex-end;
        }
        .navbar-nav .nav-link {
          color: #ffffff !important;
        }

      </style>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>

<!-- GET DATABASE -->

<!-- NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg bg-primary fixed-top">
        <div class="container">
          <a class="navbar-brand" href="#">Okegas</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Other Okegas
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Laboratory</a></li>
                        <li><a class="dropdown-item" href="#">Industry</a></li>
                        <li><a class="dropdown-item" href="#">Kitchen</a></li>
                    </ul>
                    </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Homepage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Guide</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
                <button class="btn btn-light ml-auto" id="login" onclick="redirectToLogin()">Login</button>
                <script>
                    function redirectToLogin() {
                        window.location.href = "login.php";
                    }
                </script>
              
            </ul>
          </div>
        </div>
      </nav>

<!-- JUDUL -->
    <section class="title-section">
            <div class="container ">
        <h1>Okegas</h1>
        <h4>Bogor, Indonesia</h4>
        </div>
    </section>
    
<!-- DATA -->
<div class="container mt-3 text-center ">
    <h2 class="mb-4">Update Data</h2>
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">LPG</h4>
                    <div class="card mt-3">
                        <div class="card-body">
                            <?php
                            // Kode untuk mengambil data lpg dari database
                            $servername = "localhost";
                            $dbname = "id21605377_okegas";
                            $username = "id21605377_admingas";
                            $password = "Admingas12*";

                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $latest_sql = "SELECT lpg FROM sensor_data ORDER BY waktu DESC LIMIT 1";
                            $latest_result = $conn->query($latest_sql);

                            if ($latest_result->num_rows > 0) {
                                $row = $latest_result->fetch_assoc();
                                $lpg = $row["lpg"];
                                echo "<h4 class='card-text'>$lpg ppm</h4>";
                            } else {
                                echo "<p class='card-text'>No data available.</p>";
                            }

                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Nested Box 2: co -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">CO</h4>
                    <div class="card mt-3">
                        <div class="card-body">
                            <?php
                            $servername = "localhost";
                            $dbname = "id21605377_okegas";
                            $username = "id21605377_admingas";
                            $password = "Admingas12*";
                            
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            
                            $latest_sql = "SELECT co FROM sensor_data ORDER BY waktu DESC LIMIT 1";
                            $latest_result = $conn->query($latest_sql);
                            
                            if ($latest_result->num_rows > 0) {
                                $row = $latest_result->fetch_assoc();
                                $co = $row["co"];
                                echo "<h4 class='card-text'>$co ppm</h4>";
                            } else {
                                echo "<p class='card-text'>No data available.</p>";
                            }
                            
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nested Box 3: co2 -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">CO2</h4>
                    <div class="card mt-3">
                        <div class="card-body">
                             <?php
                            $servername = "localhost";
                            $dbname = "id21605377_okegas";
                            $username = "id21605377_admingas";
                            $password = "Admingas12*";
                            
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            
                            $latest_sql = "SELECT co2 FROM sensor_data ORDER BY waktu DESC LIMIT 1";
                            $latest_result = $conn->query($latest_sql);
                            
                            if ($latest_result->num_rows > 0) {
                                $row = $latest_result->fetch_assoc();
                                $co2 = $row["co2"];
                                echo "<h4 class='card-text'>$co2 ppm</h4>";
                            } else {
                                echo "<p class='card-text'>No data available.</p>";
                            }
                            
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--GRAFIK-->
    <div class="container mt-2">
        <h2 class ="text-center">Data Visualization</h2>
        <div class="row mt-4">
            <div class="col-md-6 mx-auto">
                <form method="POST" action="" class="d-flex flex-wrap justify-content-center"> <!-- Tambahkan kelas justify-content-center di sini -->
                    <div class="me-2">
                        <label for="startDate" class="form-label">Choose Date:</label>
                        <input type="date" class="form-control" name="startDate" id="startDate">
                    </div>
                    <div class="me-2">
                        <label for="endDate" class="form-label">Choose end Date:</label>
                        <input type="date" class="form-control" name="endDate" id="endDate">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 align-self-end">Show Visualization</button>
                </form>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mx-auto">
                <h2>LPG</h2>
                <canvas id="suhuChart"></canvas>
            </div>
            <div class="col-md-6 mx-auto">
                <h2>CO</h2>
                <canvas id="kelembapanChart"></canvas>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6 mx-auto">
                <h2>CO2</h2>
                <canvas id="amoniaChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Kode PHP untuk mengambil data dari database
        <?php
        $servername = "localhost";
        $dbname = "id21605377_okegas";
        $username = "id21605377_admingas";
        $password = "Admingas12*";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["startDate"]) && isset($_POST["endDate"])) {
            $startDate = $_POST["startDate"];
            $endDate = $_POST["endDate"];

            $sql = "SELECT * FROM sensor_data WHERE DATE(waktu) BETWEEN '$startDate' AND '$endDate' ORDER BY waktu ASC";
            $result = $conn->query($sql);

            $labels = [];
            $suhuData = [];
            $kelembapanData = [];
            $amoniaData = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $labels[] = date("M d, H:i", strtotime($row["waktu"]));
                    $suhuData[] = $row["lpg"];
                    $kelembapanData[] = $row["co"];
                    $amoniaData[] = $row["co2"];
                }
            }
        } else {
            $sql = "SELECT * FROM sensor_data ORDER BY waktu DESC LIMIT 10";
            $result = $conn->query($sql);

            $labels = [];
            $suhuData = [];
            $kelembapanData = [];
            $amoniaData = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $labels[] = date("M d, H:i", strtotime($row["waktu"]));
                    $suhuData[] = $row["lpg"];
                    $kelembapanData[] = $row["co"];
                    $amoniaData[] = $row["co2"];
                }
            }
        }

        $conn->close();
        ?>

        // Kode JavaScript untuk membuat grafik
        var suhuChart = new Chart(document.getElementById('suhuChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'lpg (°C)',
                    data: <?php echo json_encode($suhuData); ?>,
                    borderColor: 'rgb(255, 99, 132)',
                    fill: false
                }]
            },
            options: {}
        });

        var kelembapanChart = new Chart(document.getElementById('kelembapanChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'co (%)',
                    data: <?php echo json_encode($kelembapanData); ?>,
                    borderColor: 'rgb(54, 162, 235)',
                    fill: false
                }]
            },
            options: {}
        });

        var amoniaChart = new Chart(document.getElementById('amoniaChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'co2 (ppm)',
                    data: <?php echo json_encode($amoniaData); ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    fill: false
                }]
            },
            options: {}
        });
    </script>

<div class="container mt-5 text-center">
        <h2 class="mb-4">Data History</h2>
        <table class="table table-bordered">
            <thead class= "table-primary">
                <tr>
                    <th>Time</th>
                    <th>LPG (ppm)</th>
                    <th>CO (ppm)</th>
                    <th>CO2 (ppm)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $dbname = "id21605377_okegas";
                $username = "id21605377_admingas";
                $password = "Admingas12*";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM sensor_data ORDER BY waktu DESC LIMIT 10";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["waktu"] . "</td>";
                        echo "<td>" . $row["lpg"] . "</td>";
                        echo "<td>" . $row["co"] . "</td>";
                        echo "<td>" . $row["co2"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No data available</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    
    <div class="container">
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

  </body>
</html>