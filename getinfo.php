<?php
session_start();

$naam = $_POST['naam'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$optie = $_POST['selected'];
$datum = $_POST['date'];
$tijd = $_POST['time'];

$timeObj = DateTime::createFromFormat('H:i', $tijd);

//How many minuts or hours the appointment is going to take! M = Minutes, H = Hours, you can safely edit this if you want.
switch ($optie) {
    case 'SmallMeeting':
        $timeObj->add(new DateInterval('PT15M'));
        break;
    case 'BigMeeting':
        $timeObj->add(new DateInterval('PT25M'));
        break;
    case 'PhoneCall':
        $timeObj->add(new DateInterval('PT5M'));
        break;
    case 'VisitUs':
        $timeObj->add(new DateInterval('PT1H'));
        break;
    default:

        break;
}


$maxtijd = $timeObj->format('H:i');

include "conn.php";


$sql = "SELECT * FROM YOUR_DATABASE_TABLE WHERE datum = ? AND ((tijd <= ? AND maxtijd > ?) OR (tijd < ? AND maxtijd >= ?))";
$stmt = $conn->prepare($sql);
$stmt->execute([$datum, $tijd, $tijd, $maxtijd, $maxtijd]);

if ($stmt->rowCount() > 0) {

    echo "There is an overlapping meeting on the selected date. Please choose a different time.";
} else {

    $sql = "INSERT INTO YOUR_DATABASE_TABLE (naam, email, tel, optie, datum, tijd, maxtijd) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$naam, $email, $tel, $optie, $datum, $tijd, $maxtijd]);

    $selected = $_POST['selected'];

    echo 'Selected: ' . $selected;
    echo 'Max time: ' . $maxtijd;
}

?>