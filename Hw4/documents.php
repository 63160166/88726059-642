<!DOCTYPE html>
<html lang="en">

<head>
    <title>Documents</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style = "background-color:#D8BFD8">
    <div class="container">
        <h1>Orders | <a href='newactor.php'><span class='glyphicon glyphicon-plus' style = "color:#FF1493"></span></a>
        |<a href='staff.php?id=$row->id'><span class='glyphicon glyphicon-user' style = "color:#FF69B4"></span></a>
        |<a href='selectdocument.php'><span class='glyphicon glyphicon-search'style = "color:#C71585"></span></a></h1>
        <form action="#" method="post">
            <input type="text" name="kw" placeholder="Enter Order, Order name" value=""  style = "background-color:#FFC0CB">
            <input type="submit" style = "background-color:#9370DB">
        </form>
        <?php
        require_once("dbconfig.php");
        @$kw = "%{$_POST['kw']}%";
        $sql = "SELECT *
                FROM documents
                WHERE concat(doc_num, doc_title) LIKE ? 
                ORDER BY doc_num";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            echo "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s)." ;
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Order</th>
                                <th scope='col'>Order Name</th>
                                <th scope='col'>Start Date</th>
                                <th scope='col'>To Date</th>
                                <th scope='col'>Status</th>
                                <th scope='col'>File Name</th>
                                <th scope='col'>Employee</th>
                                <th scope='col'>Edit/Delete</th>
                            </tr>
                        </thead>
                        <tbody>";
            $i = 1; 
            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td>" . $i++ . "</td>";
                $table.= "<td>$row->doc_num</td>";
                $table.= "<td>$row->doc_title</td>";
                $table.= "<td>$row->doc_start_date</td>";
                $table.= "<td>$row->doc_to_date</td>";
                $table.= "<td>$row->doc_status</td>";
                $table.= "<td>$row->doc_file_name</td>";
                $table.= "<td>";
                $table.= "<center>";
                $table.= "<a href='addstafftodocument.php?id=$row->id'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></a>";
                $table.= "</td>";
                $table.= "<td>";
                $table.= "<center>";
                $table.= "<a href='editactor.php?id=$row->id'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                $table.= " | ";
                $table.= "<a href='deletedoc.php?id=$row->id'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                $table.= "</td>";
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