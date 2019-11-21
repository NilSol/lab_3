<?php
require 'exit.php';
$idCity = $_GET['idCity'];
$dbh = new PDO('pgsql:dbname=countries;host=127.0.0.1;','postgres');
$query = sprintf('SELECT title_ru FROM _cities where city_id = (%s)',$idCity);
$query=$dbh->prepare($query);
$query->execute();
$rows=$query->fetchAll(PDO::FETCH_ASSOC);
if(isset($_POST['submit']))
{
    __exit();
}
require 'bootstrap.php';
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>town</title>
</head>
<body>
<table border="1" cellpadding="4" cellspacing="0">
    <caption>City Information</caption>
    <tr>
        <td>City</td>
        <td>Id</td>
    </tr>
    <?php
    foreach ($rows as $key => $row) {
    ?>
    <tr>
        <td><?php echo $row['title_ru']?></td>
        <td> <?php echo $idCity;?></td>
    </tr>
    <?php } ?>
</table>
<form method="post">
    <div class="select-arrow"></div>
    <button type="submit" name="submit" class="btn btn-outline-primary">Exit</button>
</form>

</body>
</html>