<?php
session_start();

if (!isset($_SESSION['loggined'])){
    header('Location: login.php');
}
require_once("dbconfig.php");

if ($_POST){
    $id = $_POST['id'];
    $sql = "DELETE 
    FROM doc_staff
    WHERE doc_staff.doc_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();   

    $sql = "DELETE 
            FROM documents
            WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("location: documents.php");
}else {
    $id = $_GET['id'];
    $sql = "SELECT *
            FROM documents
            WHERE id = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_object();
    echo "<div align = center><h1><span class='glyphicon glyphicon-heart-empty'> Welcome ".$_SESSION['stf_name'] . "</span></h1></div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>DeleteDocument</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style = "background-color:#D8BFD8">
    <div class="container">
        <h1>Delete Order</h1>
        <table class="table table-hover">
            <tr>
                <th style='width:120px'>Order</th>
                <td><?php echo $row->doc_num;?></td>
            </tr>
            <tr>
                <th>Order name</th>
                <td><?php echo $row->doc_title;?></td>
            </tr>
            <tr>

        </table>
        <form action="deletedoc.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row->id;?>">
            <input type="submit" value="Confirm delete" class="btn btn-danger" style = "background-color:#F08080" >
            <button type="button" class="btn btn-warning" onClick="window.history.back()" style = "background-color:#20B2AA">Cancel Delete</button>
        </form>
</body>

</html>