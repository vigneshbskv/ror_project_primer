<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../prelogin/login.php");
    exit;
}
require_once "../actions/db_config.php";
$sql = "SELECT * from patient";
$all_patient = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients Info</title>
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div class="container">
        <div class="text-center mb-5">
            <h2>List of Patients</h2>
        </div>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Created Date (Y-M-D HH:MM:SS)</th>
                </tr>
            </thead>
            <tbody>
                
                <?php 
                    $i = 0;
                while ($each_patient= mysqli_fetch_array(
                    $all_patient,
                    MYSQLI_ASSOC
                )) :;
                    $i++;
                ?>
                    <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $each_patient['patient_name'] ?></td>
                        <td><?php echo $each_patient['age'] ?></td>
                        <td><?php echo $each_patient['created_at'] ?></td>
                    </tr>
                <?php
                endwhile;
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>