<?php require("index.php");
$sql= $conn->prepare( 
    "SELECT id, lennu_nr, kohtade_arv, reisijate_arv,  ots, siht, valjumisaeg, lopetatud, kestvus FROM lend WHERE lopetatud != '0000-00-00 00:00:00';");
    $sql->bind_result($id, $lennu_nr, $kohtade_arv, $reisijate_arv, $ots, $siht, $valjumisaeg, $lopetatud, $kestvus); 
    $sql->execute();
?>
    <h1>Lennud</h1>
    <h3>Siin saab vaadata kõiki lõpetatud lendusi</h3>
    <table>
        <tr>
            <th>Lennu number</th> 
            <th>Kohtade arv</th> 
            <th>Reisijate arv</th> 
            <th>Ots</th> 
            <th>Siht</th> 
            <th>Väljumisaeg</th> 
            <th>Lõpetatud</th>
            <th>Kestvus</th> 
        </tr> 
    <?php
    while($sql->fetch()){ 
        echo " 
        <tr>
        <td>$lennu_nr</td> 
        <td>$kohtade_arv</td> 
        <td>$reisijate_arv</td> 
        <td>$ots</td> 
        <td>$siht</td>
        <td>$valjumisaeg</td>
        <td>$lopetatud</td>
        <td>$kestvus</td>
        </tr> 
        "; 
    }
    ?>
    </table>
</body>
</html>