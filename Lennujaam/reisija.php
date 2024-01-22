<?php require("index.php");

    if (isset($_REQUEST["submit"])){
        if($_REQUEST["kohad"] < $_REQUEST["reisijad"]){
            echo "
            <script>
            alert('Reisijate arv ei saa olla rohkem kui kohtade arv ning peab olema integer!');
            </script>
            ";
        }else{
            $sql=$conn->prepare("UPDATE lend set reisijate_arv=? where id=?");
            $sql->bind_param("ii", $_REQUEST["reisijad"], $_REQUEST["id"]);
            $sql->execute();
        }
    }

    $sql= $conn->prepare( 
    "SELECT id, lennu_nr, kohtade_arv, reisijate_arv,  ots, siht, valjumisaeg FROM lend where kohtade_arv != reisijate_arv and lopetatud='0000-00-00 00:00:00';");
    $sql->bind_result($id, $lennu_nr, $kohtade_arv, $reisijate_arv, $ots, $siht, $valjumisaeg); 
    $sql->execute();

    function findTimeDiff($departureTime){
        $timeDiff = strtotime($departureTime) - strtotime("now GMT");
        if ($timeDiff >= 3600){
            return true;
        }else{
            return false;
        }
    }
?>
<body>
    <h1>Reisijate lisamine</h1>
    <h3>Reisijaid saab lisade lendudele, kus on vabu kohti ning mille väljumisaeg on rohkem kui tunni pärast</h3>
    <table>
        <tr>
            <th>Lennu number</th> 
            <th>Kohtade arv</th> 
            <th>Reisijate arv</th> 
            <th>Ots</th> 
            <th>Siht</th> 
            <th>Väljumisaeg</th>
            <th>Reisjate lisamine</th>
        </tr>
    <?php
    while($sql->fetch()){
        if (findTimeDiff($valjumisaeg)) {
            echo "
            <tr>
            <td>$lennu_nr</td> 
            <td>$kohtade_arv</td> 
            <td>$reisijate_arv</td> 
            <td>$ots</td> 
            <td>$siht</td>
            <td>$valjumisaeg</td>
            <td><form action='?'>
            <input type='hidden' name='id' value='$id'>
            <input type='hidden' name='kohad' value='$kohtade_arv'>
            <label for='reisijad'>Sisesta reisijate arv: </label>
            <input name='reisijad' type='text' placeholder='0'>
            <input type='submit' name='submit'>
            </form></td>
            </tr>
            "; 
        }
    }
    ?>
    </table>
</body>
</html>