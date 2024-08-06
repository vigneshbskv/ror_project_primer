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
    <title>Add Prescription</title>
    <style>
        #rowAdder {
            margin-left: 17px;
        }
    </style>
</head>
<?php
require_once "../actions/db_config.php";


$sql = "SELECT * FROM `patient`";
$all_patient = mysqli_query($link, $sql);
$patient = $medicine = $dosage = "";
$patient_err = $medicine_err = $dosage_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicinefieldIndex = $_POST["medicinefieldIndex"];
    $medicineInfo = [];
    for ($i = 1; $i <= $medicinefieldIndex; $i++) {  
        $temp = [];
        $temp['medicine_' . $i] = $_POST['medicine_' . $i];
        $temp['dosage_' . $i] = $_POST['dosage_' . $i];
        array_push($medicineInfo, $temp);
    }
    $param_medication = json_encode($medicineInfo);
  
    if (!empty(trim($_POST["patient"]))) {
        $param_patient_id = trim($_POST["patient"]);
    }
    if (empty($patient_err) && empty($medicine_err) && empty($dosage_err)) {

        $sql = "INSERT INTO medication_data (patient_id,medicine_data) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_patient_id, $param_medication);
            if (mysqli_stmt_execute($stmt)) {
                echo '<script language="javascript">';
                echo 'alert("Prescription Saved Successfully"); location.href="add_prescription.php"';
                echo '</script>';
            } else {
                echo '<script language="javascript">';
                echo 'alert("There is some issue, not able to save your record"); location.href="add_prescription.php"';
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
            <h2>Add Prescription Form</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="patient">Patient</label>
                    <select id="patient" name="patient" class="form-control" required>
                        <option value="" selected>select patient</option>

                        <?php
                        
                        while ($patient_list = mysqli_fetch_array(
                            $all_patient,
                            MYSQLI_ASSOC
                        )) :;
                        ?>
                            <option value="<?php echo $patient_list["patient_id"];
                                            ?>">
                                <?php echo $patient_list["patient_name"] . ' (Age:' . $patient_list['age'] . ')';
                                ?>
                            </option>
                        <?php
                        endwhile;
                        ?>
                    </select>
                </div>
            </div>
            <hr>
            <div id="inputContainer"></div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <button id="addButton" type="button" class="btn btn-dark">
                        Add Medicine Row
                    </button>
                </div>
            </div>
            <input type="hidden" id="medicinefieldIndex" name="medicinefieldIndex" value="0">
            <button type="submit" class="btn btn-primary">Create a Prescription</button>
            <button type="reset" class="btn btn-warning">Clear</button>
        </form>


        <script type="text/javascript">
            $(document).ready(function() {
                var maxFields = 50;
                var addButton = $('#addButton');
                var inputContainer = $('#inputContainer');
                var fieldIndex = 0;

                addButton.click(function() {
                    if (fieldIndex < maxFields) {
                        fieldIndex++;
                        var newField = '<div class="form-row" id="row"> <div class="form-group col-md-6"> <label for="medicine">Medicine</label> <input type="text" class="form-control" id="medicine" name="medicine_' + fieldIndex + '" required> </div> <div class="form-group col-md-4"> <label for="dosage">Dosage</label> <input type="text" class="form-control" id="dosage" name="dosage_' + fieldIndex + '" required> </div> <div class="form-group col-md-2">' +
                            '<label for="dosage">Action</label> <button class="btn btn-danger form-control removeButton" type="button">' +
                            '<i class="bi bi-trash"></i> Delete</button> </div> </div>';
                        inputContainer.append(newField);
                        $('input[name=medicinefieldIndex]').val(fieldIndex);
                    }
                });

                $(document).on('click', '.removeButton', function() {
                    $(this).parents("#row").remove();
                    fieldIndex--;
                    $('input[name=medicinefieldIndex]').val(fieldIndex);
                });

            });
        </script>
    </div>
</body>

</html>