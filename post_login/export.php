<?php
require_once "../actions/db_config.php";

$query = "SELECT medication_data.record_id as s_no, patient.patient_name as patient_name, patient.age as patient_age, medication_data.medicine_data as prescription_information, medication_data.created_at as created_date_time
FROM medication_data
JOIN patient ON medication_data.patient_id = patient.patient_id";
$result = mysqli_query($link, $query);

$number_of_fields = mysqli_num_fields($result);
$headers = array();
for ($i = 0; $i < $number_of_fields; $i++) {
    $headers[] = mysqli_field_name($result, $i);
}
$fp = fopen('php://output', 'w');
if ($fp && $result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="export.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, $headers);
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        fputcsv($fp, array_values($row));
    }
    die;
}

function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}
