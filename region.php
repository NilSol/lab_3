<?php
$id = $_GET['id'];
session_start();
if($_GET['id'] != ''){
    $_SESSION['id'] = $_GET['id'];
}
if($_GET['page'] != ''){
    $page = $_GET['page'];
} else {
    $page = 1;
}
require 'bootstrap.php';
$dbh = new PDO('pgsql:dbname=countries;host=127.0.0.1;','postgres');
$query = sprintf('SELECT city_id, title_ru FROM _cities where region_id = :id');
$query=$dbh->prepare($query);
$query->bindParam(':id', $_SESSION['id'],PDO::PARAM_INT,7);
$query->execute();
$rows=$query->fetchAll(PDO::FETCH_ASSOC);
$countOfNotes = 30;?>
    <form>
        <p><input type="search" name="city" placeholder="Таромское">
            <input type="submit" value="Найти"></p>
    </form>
<?php
$cityFind = $_GET['city'];
if($cityFind != ''){
    search($cityFind);
} else{
    printCities($rows,$countOfNotes,$page);
}
function printCities($rows,$countOfNotes,$page){
    $countCity = count($rows);#к-во городов
?>

<div class="buttons" text align="center">
    <?php for($i = 1; $i <= round($countCity/$countOfNotes, 0); $i++){ ?>
        <a href="region.php?page=<?php echo $i?>"><?php echo $i . " " ?> </a>
    <?php } ?>
</div>

<?php
$index = 0; # индекс текущего элемента массива
$from = ($page - 1) * $countOfNotes; #с какого города по счёту выводить города
?>

<table border="1">
    <tr>
        <td>Count</td>
        <td>City</td>
    </tr>
    <?php foreach ($rows as $key => $row) {
        if($index >= $from && $index < $from + $countOfNotes){ ?>
            <tr>
                <td><?php echo $index+1 ?></td>
                <td><a href="welcome.php?idCity=<?php echo $row['city_id']?>"><?php echo $row['title_ru']?></a> </td>
            </tr>
        <?php }

        $index++;
    } ?>
</table>
<?php }
function search($cityFind){
    $dbh = new PDO('pgsql:dbname=countries;host=127.0.0.1;','postgres');
    $query = "SELECT city_id, title_ru FROM _cities where region_id = :id AND title_ru LIKE :cityFind";
    $query=$dbh->prepare($query);
    $query->bindParam(':id', $_SESSION['id'],PDO::PARAM_INT,7);
    $query->bindParam(':cityFind', $cityFind,PDO::PARAM_STR,25);
    $query->execute();
    $rows=$query->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table border="1">
        <tr>
            <td>City</td>
        </tr>
        <?php foreach ($rows as $key => $row) { ?>
            <tr>
                <td><a href="welcome.php?idCity=<?php echo $row['city_id']?>"><?php echo $row['title_ru']?></a> </td>
            </tr>
            <?php
        } ?>
    </table>
<?php }
?>