<?php include 'connection.php';?>

<?php

$sql = "SELECT * FROM illness";
$return = $conn->query($sql);
$illnesses = array();
if ($return->num_rows >= 0) {

    while($row = mysqli_fetch_array($return)){
        $illness = array(
            'id'=>$row['id'],
            'name'=>$row['name'],
            'description'=>$row['description']
        );
        array_push($illnesses,$illness);
    }

    $result = array('code' => 0, 'illnesses' => $illnesses);
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "Customers not found!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
}

?>