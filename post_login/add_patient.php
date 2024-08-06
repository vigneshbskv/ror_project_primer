<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../prelogin/login.php");
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <style>
        #rowAdder {
            margin-left: 17px;
        }
    </style>
</head>
<?php
require_once "../actions/db_config.php";
$patient = $medicine = $dosage = "";
$patient_err = $medicine_err = $dosage_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty(trim($_POST["patient_name"])) && !empty(trim($_POST['patient_age']))) {
        $param_patient_name = trim($_POST["patient_name"]);
        $param_patient_age = trim($_POST["patient_age"]);

        $sql = "INSERT INTO patient (patient_name,age) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_patient_name, $param_patient_age);
            if (mysqli_stmt_execute($stmt)) {
                echo '<script language="javascript">';
                echo 'alert("Patient Record Saved Successfully"); location.href="add_patient.php"';
                echo '</script>';
            } else {
                echo '<script language="javascript">';
                echo 'alert("There is some issue, not able to save your record"); location.href="add_patient.php"';
                echo '</script>';
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<body>
    <?php
    include('header.php');
    ?>
    <div class="container">
    <div class="text-center mb-5">
            <h2>Add Patient Form</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="patient_name">Patient</label>
                    <input type="text" name="patient_name" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="patient_age">Age</label>
                    <input type="number" name="patient_age" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add Patient</button>
            <button type="reset" class="btn btn-warning">Clear</button>
        </form>
    </div>
</body>

</html>