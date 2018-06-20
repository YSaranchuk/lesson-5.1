<?php
header("Content-Type: text/html; charset=utf-8");
if (isset($_GET['Latitude']) && isset($_GET['Longitude'])) {
	$Latitude = $_GET['Latitude'];
	$Longitude = $_GET['Longitude'];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Карта</title>
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
        ymaps.ready(init);
        var myMap, 
            myPlacemark;
        function init(){ 
            myMap = new ymaps.Map("map", {
                center: [<?= $Latitude ?>, <?= $Longitude ?>],
                zoom: 7
            }); 
            
            myPlacemark = new ymaps.Placemark([<?= $Latitude ?>, <?= $Longitude ?>], {
                hintContent: 'Вы выбрали это место',
                balloonContent: 'Вы уверены, что вам именно сюда?'
            });
            
            myMap.geoObjects.add(myPlacemark);
        }
    </script>
</head>
<body>
	<div id="map" style="width: 600px; height: 400px"></div>
	<a href="index.php">Вернуться к поиску</a>
</body>
</html>
