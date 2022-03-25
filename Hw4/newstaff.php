<?php

session_start();
if(!isset($_SESSION['loggined'])){
    header('Location: login.php');
}

require_once("dbconfig.php");
if ($_POST){
    $stf_code = $_POST['stf_code'];
    $stf_name = $_POST['stf_name'];
    $sql = "INSERT 
            INTO staff ( stf_code,stf_name) 
            VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $stf_code, $stf_name);
    $stmt->execute();

    header("location: staff.php");
}else{
    echo "<div align = center><h1><span class='glyphicon glyphicon-heart-empty'> Welcome ".$_SESSION['stf_name'] . "</span></h1></div>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>New Staff</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style = "background-color:#D8BFD8">
    <div class="container">
        <h1>Add Employee</h1>
        <form action="newstaff.php" method="post">
            <div class="form-group">
                <label for="stf_code">Employee</label>
                <input type="text" class="form-control" name="stf_code" id="stf_code" style = "background-color:#DDA0DD">
            </div>
            <div class="form-group">
                <label for="stf_name">Employee Name</label>
                <input type="text" class="form-control" name="stf_name" id="stf_name" style = "background-color:#DDA0DD">
            </div>
            <button type="button" class="btn btn-warning" onclick="history.back();" style = "background-color:#FFC0CB">Back</button>
            <button type="submit" class="btn btn-success" style = "background-color:#20B2AA">Save</button>
        </form>
</body>

</html>
