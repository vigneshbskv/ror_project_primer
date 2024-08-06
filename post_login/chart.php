<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../prelogin/login.php");
    exit;
}
require_once "../actions/db_config.php";
$query = "SELECT * 
FROM medication_data
JOIN patient ON medication_data.patient_id = patient.patient_id";

$runQuery = mysqli_query($link, $query);

$medicineList = [];
while ($eachrow = mysqli_fetch_array(
    $runQuery,
    MYSQLI_ASSOC
)) :;

    $medicineData = json_decode($eachrow['medicine_data'], true);
    $count = 1;
    
    foreach ($medicineData as $key => $value) {
        array_push($medicineList, $value['medicine_' . $count]);
        $count++;
    }
endwhile;
$medicine = '';
$volume = '';

$vals = array_count_values($medicineList);
foreach ($vals as $key => $value) {
    $medicine = $medicine . '"' . ucwords($key) . '",';
    $volume = $volume . '"' . ucwords($value) . '",';
}
$medicine = trim($medicine, ",");
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
            <h4>Most prescribed medications</h4>
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
            labels: [<?php echo $medicine; ?>],
            datasets: [{
                    data: [<?php echo $volume; ?>],
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    borderWidth: 4,
                    pointBackgroundColor:'#28a745'
                }
            ]
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