<?php
    $where = '';
    if (isset($_REQUEST['city'])){
        $city = $_REQUEST['city'];
        if ($city != '') {
         $where = "WHERE d.City = '$city'";
        }
    }
    if (isset($_REQUEST['periodicity'])){
        $periodicity = $_REQUEST['periodicity'];
        if ($periodicity != ""){
            if ($where == ""){
                $where = " WHERE co.Periodicity  = '$periodicity'";
            }
        }
    }
    if (isset($_REQUEST['Coordinator_id'])){
        $Coordinator_id = $_REQUEST['Coordinator_id'];
        if ($Coordinator_id != ""){
            if ($where == ""){
                $where = " WHERE c.Coordinator_id = '$Coordinator_id'";
            }
        }
    }
    //Conexión a la base de datos
    $host = "localhost";
    $dbname = "contractors_claro";
    $username = "root";
    $password = "";

    $cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    //Construir la sentencia sql
    $sql = "SELECT d.Name as dealer_name, c.Name as coordinator_name, co.Coordinator_id, d.City, co.Periodicity FROM dealers as d JOIN coordinator as c ON d.Coordinator_id = c.Coordinator_id JOIN commissions co ON c.Coordinator_id = co.Coordinator_id $where ORDER BY d.Name ASC";

    //Prepara la sentencia SQL
    $q = $cnx->prepare($sql);
    
    // Ejecutar sentencia SQL
    $result = $q->execute();  
    $reports = $q->fetchAll();
    $dealers = $q->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Reports</title>
</head>
<body>
    <form action="complete_reports.php">
        City
        <select name="city">
            <option value="">Select</option>
            <option value="Manizales">Manizales</option>
            <option value="Pereira">Pereira</option>
            <option value="Manzanarez">Manzanarez</option>
            <option value="Aranzazu">Aranzazu</option>
        </select>
        
        Periodicity
        <select name="periodicity">
            <option value="">Select</option>
            <option value="Weekly">Weekly</option>
            <option value="Diary">Diary</option>
            <option value="Monthly">Monthly</option>
        </select>
        
        Coordinator_id
        <select name="Coordinator_id">
            <option value="">Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <input type="submit" value="Search by Where"/>
    </form>
    <h1>Reports List</h1>
        <table> 
            <tr>
                <td>Dealers Name</td>
                <td>Coordinator_Name</td>
                <td>Coordinator_id</td>
                <td>City</td>
                <td>Periodicity</td>
               
            </tr>

    <?php
        for($i = 0; $i<count($reports); $i++){
    ?>       
            <tr>
                <td>
                    <?php echo $reports[$i]["dealer_name"] ?>
                </td>
                <td><?php echo $reports[$i]["coordinator_name"] ?></td>
                <td><?php echo $reports[$i]["Coordinator_id"] ?></td>
                <td><?php echo $reports[$i]["City"] ?></td>
                <td><?php echo $reports[$i]["Periodicity"] ?></td>
                
            </tr>
    <?php
        }
    ?>

        </table>
</body>
</html>