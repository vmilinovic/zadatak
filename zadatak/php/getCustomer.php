<?php include 'connection.php';?>

<?php
$limit              = $_GET["limit"];


$sql = "SELECT * FROM customer";

if(isset($_GET['firstname'])) {
    $firstname = $_GET['firstname'];
    $sql = $sql." WHERE firstname LIKE '%".$firstname."%'";
    if(isset($_GET['lastname'])) {
        $lastname = $_GET['lastname'];
        $sql = $sql." AND lastname LIKE '%".$lastname."%'";
    }
} else {
    if(isset($_GET['lastname'])) {
        $lastname = $_GET['lastname'];
        $sql = $sql." WHERE lastname LIKE '%".$lastname."%'";
    }
}
$sql = $sql." LIMIT ".$limit;

$return = $conn->query($sql);
$customers = array();
if ($return->num_rows >= 0) {

    while($row = mysqli_fetch_array($return)){
        $customer = array(
            'id'=>$row['id'],
            'firstname'=>$row['firstname'],
            'lastname'=>$row['lastname'],
            'street'=>$row['street'],
            'streetNumber'=>$row['streetNumber'],
            'zipCode'=>$row['zipCode'],
            'phone'=>$row['phone'],
            'birthDate'=>$row['birthDate'],
            'userId'=>$row['userId'],
            'img'=>$row['img'],
            'pdf'=>$row['pdf'],
            'word'=>$row['word']);
        array_push($customers,$customer);
    }

    $result = array('code' => 0, 'customers' => $customers);
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "Patient not found!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
}

?>