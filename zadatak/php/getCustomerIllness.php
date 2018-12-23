<?php include 'connection.php';?>

<?php
$customerId            = $_GET["customerId"];

$sql = "SELECT ind,name,comment,arrivalDate FROM illness_customer ic 
        JOIN illness i ON ic.illnessId=i.id
        JOIN customer c ON ic.customerId=c.id
        WHERE customerId=?";

if ($stmt = $conn->prepare($sql)){
    $stmt->bind_param("i", $customerId);
    $stmt->execute();
    $stmt->bind_result($ind,$name, $comment, $arrivalDate);
    $illnesses = array();
    while ($stmt->fetch()) {
        $illness = array(
            'ind'=>$ind,
            'name'=>$name,
            'comment'=>$comment,
            'arrivalDate'=>$arrivalDate
        );
        array_push($illnesses,$illness);
    }
    $stmt->close();

    $result = array('code' => 0, 'illnesses' => $illnesses);
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "Patients not found!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
}

?>