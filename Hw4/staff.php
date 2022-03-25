<?php
session_start();

if (!isset($_SESSION['loggined'])){
    header('Location: login.php');
}else{
    echo "<div align = center><h1><span class='glyphicon glyphicon-heart-empty'> Welcome ".$_SESSION['stf_name'] . "</span></h1></div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style = "background-color:#D8BFD8" >
    <div class="container">
        <h1>Employee | <a href='newstaff.php'><span class='glyphicon glyphicon-plus' style = "color:#FF1493"></span></a>
        |<a href='documents.php'><span class='glyphicon glyphicon-arrow-left' style = "color:#FF00FF"></span></a></h1>
        <form action="#" method="post">
            <input type="text" name="kw" placeholder="Enter ID Employee" value="" style = "background-color:#FFC0CB">
            <input type="submit"style = "background-color:#9370DB">
        </form>

        <?php
        require_once("dbconfig.php");
        @$kw = "%{$_POST['kw']}%";
        $sql = "SELECT *
                FROM staff
                WHERE concat(stf_code, stf_name) LIKE ? 
                ORDER BY stf_code";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s).";
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Employee</th>
                                <th scope='col'>Employee Name</th>
                                <th scope='col'>Edit/Delete</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
            $i = 1; 
            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td>" . $i++ . "</td>";
                $table.= "<td>$row->stf_code</td>";
                $table.= "<td>$row->stf_name</td>";
                $table.= "<td>";
                $table.= "<a href='editstaff.php?id=$row->id'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                $table.= " | ";
                $table.= "<a href='deletestaff.php?id=$row->id'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                $table.= "</td>";
                $table.= "</tr>";
            }

            $table.= "</tbody>";
            $table.= "</table>";
            
            echo $table;
        }
        ?>
    </div>
</body>

</html>