<?php require("index.php");

function calcFlightLength($departureDate, $lopetatudDate) {
    $departureDateTime = new DateTime($departureDate);
    $lopetatudDateTime = new DateTime($lopetatudDate);
    
    if ($lopetatudDateTime < $departureDateTime) {
        return null;
    } else {
        $interval = $lopetatudDateTime->diff($departureDateTime);

        $formattedInterval = $interval->format('%y aastat, %m kuud, %d päeva, %H tundi, %I minutit, %S sekundit');

        return $formattedInterval;
    }
}

if (isset($_REQUEST["submit"])){
    $lopetatud = $_REQUEST["lopetatud"];

    $flightLenght = calcFlightLength($_REQUEST["valjumisaeg"], $lopetatud);
    echo $flightLenght;
    if ($flightLenght != null){
        $id = $_REQUEST["id"];
        $sql=$conn->prepare("UPDATE lend SET lopetatud=?, kestvus=? WHERE id=?");
        $sql->bind_param("ssi", $lopetatud, $flightLenght, $id);
        $sql->execute();
    }else{
        echo "
            <script>
            alert('Lendu ei saa lõpetada minevikus!');
            </script>
            ";
    }
}

$sql= $conn->prepare( 
    "SELECT id, lennu_nr, kohtade_arv, reisijate_arv,  ots, siht, valjumisaeg, lopetatud, kestvus FROM lend where lopetatud='0000-00-00 00:00:00';");
    $sql->bind_result($id, $lennu_nr, $kohtade_arv, $reisijate_arv, $ots, $siht, $valjumisaeg, $lopetatud, $kestvus); 
    $sql->execute();
?>
    <h1>Lendude lõppetamine</h1>
    <h3>Siin saab lõpetada lendusi, lendu ei saa lõpetada minevikus</h3>
    <table>
        <tr>
            <th>Lennu number</th> 
            <th>Kohtade arv</th> 
            <th>Reisijate arv</th> 
            <th>Ots</th> 
            <th>Siht</th> 
            <th>Väljumisaeg</th> 
            <th>Lõpetatud</th>
            <th>Lõpeta lend</th> 
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
        <td><form action='?'>
        <input type='hidden' name='id' value='$id'>
        <input type='hidden' name='valjumisaeg' value='$valjumisaeg'>
        <label for='lopetatud'>Lõpetatud: </label>
        <input type='datetime-local' name='lopetatud'>
        <input type='submit' name='submit' value='Lõpeta'>
        </form>
        </td>
        </tr>
        ";
    }
    ?>
    </table>
</body>
</html>