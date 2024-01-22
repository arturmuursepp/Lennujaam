<?php require("index.php");
if(isSet($_REQUEST["submit"])){
    $sql = $conn->prepare("INSERT INTO lend (lennu_nr, kohtade_arv, ots, siht, valjumisaeg) values (?, ?, ?, ?, ?)");
    $sql->bind_param("sssss", $_REQUEST["lennu_nr"], $_REQUEST["kohtade_arv"], $_REQUEST["ots"], $_REQUEST["siht"], $_REQUEST["valjumisaeg"]);
    $sql->execute();
    $conn->close();
}
?>
    <h1>Lendude lisamine</h1>
    <h3>Siin saab lendusi lisada</h3>
    <form action="?">
        <label for="lennu_nr">Lennu number: </label><br>
        <input type="text" name="lennu_nr" placeholder="0">
        <br>
        <label for="kohtade_arv">Kohtade arv: </label><br>
        <input type="text" name="kohtade_arv" placeholder="0"> 
        <br>
        <label for="ots">Ots: </label><br>
        <input type="text" name="ots" placeholder="Tallinn"> 
        <br>
        <label for="siht">Siht: </label><br>
        <input type="text" name="siht" placeholder="Tallinn"> 
        <br>
        <label for="valjumisaeg">Väljumisaeg: </label><br>
        <input type="datetime-local" name="valjumisaeg"> 
        <input type="submit" name="submit" value="Esita">
    </form>
</body>
</html>