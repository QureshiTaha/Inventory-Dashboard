<?php
// $file = "import.csv";
// $csv = file_get_contents($file);

// $rows = explode("\n", $csv);
// $header = str_getcsv(array_shift($rows));

// $data = [];
// foreach ($rows as $row) {
//     $row = str_getcsv($row);
//     $rowData = [];
//     foreach ($header as $i => $heading) {
//         $rowData[$heading] = isset($row[$i]) ? $row[$i] : ''; // Check if index exists
//     }
//     $data[] = (object)$rowData;
// }

// echo json_encode($data);



$file = "import.csv";
$csv = file_get_contents($file);

$rows = explode("\n", $csv);
$header = str_getcsv(array_shift($rows));

$mysqli = new mysqli("localhost", "root", "", "makendsc_decor");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

foreach ($rows as $row) {
    $row = str_getcsv($row);
    $rowData = [];
    foreach ($header as $i => $heading) {
        $rowData[$heading] = isset($row[$i]) ? $mysqli->real_escape_string($row[$i]) : ''; // Check if index exists and sanitize data
    }
   
    
    $rowData['wash_care-anysolventexcepttertachlorethylene.svg'] = "anysolventexcepttertachlorethylene.svg";
    $rowData['wash_care-nobleach.svg'] = "nobleach.svg";
    $rowData['wash_care-watertemp30.svg'] = "watertemp30.svg";
    $rowData['wash_care-iron.svg'] = "iron.svg";
    $rowData['end_use-sofa.svg'] = "sofa.svg";
    $rowData['end_use-chair.svg'] = "chair.svg";

    // $rowData = json_encode($rowData);

    // echo($rowData);
    
    $sql = "INSERT INTO data_meta (field_ID, meta_key, meta_value) VALUES ('', 'product', '" . json_encode($rowData) . "');";
    // if ($mysqli->query($sql) === TRUE) {
        // echo "Record inserted successfully";
    // } else {
        // echo "Error inserting record: " . $mysqli->error;
    // }
    echo $sql."<br>";
}

$mysqli->close();
