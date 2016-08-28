<?php
    include('../connection.php');
    $query = "Select * from Files";
    $result = mysqli_query($connection , $query);
    if( !$result ){
        die("DB query failed from file_bars.php");
    }

    while( $row = mysqli_fetch_assoc($result) ){
        echo "<tr data-toggle='collapse' data-target='#demo1' class='accordion-toggle'>";
        echo "<td>".$row["r.num"]."</td>";
        echo "<td>".$row["r.name"]."</td>";
        echo "<td>".$row["r.id"]."</td>";
        echo "<td>".$row["r.sales"]."%</td>";
        echo "<td>".$row["r.rate"]."/5</td>";
        echo "<td class='text-success'>".$row["r.price"].".00$</td>";
    }

    mysqli_free_result($result);
    mysqli_close($connection);
?>
