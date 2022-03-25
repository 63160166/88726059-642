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
    <title> Order</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style = "background-color:#D8BFD8">
    <div align =left class="container">
    <h1 align =left>Search for Order |
        <a href='documents.php'><span class='glyphicon glyphicon-circle-arrow-left' style = "color:#FF00FF"></span></a></h1>
        <form align =left action="#" method="post">
            <input type="text" name="kw" placeholder="Enter document name" value="" size=50 style = "background-color:#FFC0CB">
            <button type="submit" class="glyphicon glyphicon-search btn btn-info" style = "background-color:#9370DB"></button>
        </form>

        <?php
        require_once("dbconfig.php");

        @$kw = "%{$_POST['kw']}%";

        $sql = "SELECT DISTINCT documents.* 
FROM documents LEFT JOIN doc_staff ON documents.id=doc_staff.doc_id
      LEFT JOIN staff ON doc_staff.stf_id=staff.id 
WHERE concat(doc_num, doc_title,stf_name) LIKE ?
ORDER BY doc_num;";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo  "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s).";
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Order</th>
                                <th scope='col'>Order Name</th>
                                <th scope='col'>Strat Date</th>
                                <th scope='col'>To Date</th>
                                <th scope='col'>Status</th>
                                <th scope='col'>File name</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
             
            $i = 1; 

            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td>" . $i++ . "</td>";
                $table.= "<td>$row->doc_num &emsp;</td>";
                $table.= "<td>$row->doc_title</td>";
                $table.= "<td>$row->doc_start_date</td>";
                $table.= "<td>$row->doc_to_date</td>";
                $table.= "<td>$row->doc_status</td>";
                $table.= "<td><a href='uploads/$row->doc_file_name'>$row->doc_file_name</a></td>";
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