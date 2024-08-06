<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../prelogin/login.php");
    exit;
}
require_once "../actions/db_config.php";
$sql = "SELECT * 
FROM medication_data
JOIN patient ON medication_data.patient_id = patient.patient_id";
$all_pres = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Prescriptions</title>
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div class="container">
        <div class="text-center mb-5">
            <h2>List of Prescriptions</h2>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Patient Age</th>
                    <th scope="col">Medicine Data</th>
                    <th scope="col">Created Date (Y-M-D HH:MM:SS)</th>
                </tr>
            </thead>
            <tbody>
                
                <?php 
                    $i = 0;
                while ($each_pres = mysqli_fetch_array(
                    $all_pres,
                    MYSQLI_ASSOC
                )) :;
                    $i++;
                ?>
                    <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $each_pres['patient_name'] ?></td>
                        <td><?php echo $each_pres['age'] ?></td>
                        <td>
                            <table class="table-sm table-borderless">
                                <tr class="border-bottom">
                                    <td scope="col">S.No </td>
                                    <td scope="col">Medicine</td>
                                    <td scope="col">Dosage</td>
                                </tr>
                                <?php
                                $medicineData = json_decode($each_pres['medicine_data'], true);
                                $count = 1;
                                foreach ($medicineData as $key => $value) {
                                ?>
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $value['medicine_'.$count]; ?></td>
                                        <td><?php echo $value['dosage_'.$count]; ?></td>
                                    </tr>
                                <?php
                                $count++;
                                }
                                ?>
                            </table>
                        </td>
                        <td><?php echo $each_pres['created_at'] ?></td>
                    </tr>
                <?php
                endwhile;
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>