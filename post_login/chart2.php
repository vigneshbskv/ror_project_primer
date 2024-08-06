<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../prelogin/login.php");
    exit;
}
require_once "../actions/db_config.php";
$query = "SELECT * FROM medication_data";

$runQuery = mysqli_query($link, $query);

$overtime = [];
while ($eachrow = mysqli_fetch_array(
    $runQuery,
    MYSQLI_ASSOC
)) :;

    $timestamp = strtotime($eachrow['created_at']);
    $date = date('d-m-Y', $timestamp);
    array_push($overtime, $date);
endwhile;
$datetime = '';
$volume = '';

$vals = array_count_values($overtime);
foreach ($vals as $key => $value) {
    $datetime = $datetime . '"' . ucwords($key) . '",';
    $volume = $volume . '"' . ucwords($value) . '",';
}
$datetime = trim($datetime, ",");
$volume = trim($volume, ",");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graph View</title>
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div class="container">
        <div class="text-center">
            <h4>Prescription count over time </h4>
        </div>
        <div class="row my-2">
            <div class="col py-1">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chLine"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var chLine = document.getElementById("chLine");
        var chartData = {
            labels: [<?php echo $datetime; ?>],
            datasets: [{
                data: [<?php echo $volume; ?>],
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                borderWidth: 4,
                pointBackgroundColor: '#28a745'
            }]
        };
        if (chLine) {
            new Chart(chLine, {
                type: 'line',
                data: chartData,
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    },
                    legend: {
                        display: false
                    },
                    responsive: true
                }
            });
        }
    </script>
</body>

</html>