<?php
header("Content-Type: text/html; charset=utf-8");
require __DIR__.'/vendor/autoload.php';
$api = new \Yandex\Geo\Api();
$vis = 'none';
$vis_map = 'none';
if (isset($_POST['search']) && isset($_POST['address'])) {
	$vis = 'inline';
	$api->setQuery($_POST['address']);
	
	// Настройка фильтров	
	$api
    	->setLimit(100) 
    	->setLang(\Yandex\Geo\Api::LANG_US) 
    	->load();
	$response = $api->getResponse();
	$response->getFoundCount(); 
	$response->getQuery();
	$response->getLatitude(); 
	$response->getLongitude(); 
	$collection = $response->getList();
}
$Latitude = 0;
$Longitude = 0;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Менеджер зависимостей Composer</title>
	<style>
		table {
			margin-top: 5px;
			border-collapse: collapse;
		}
		th, td {
			padding: 5px;
			border: 1px solid grey;
		}
	</style>
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
</head>
<body>
	<h1>Поиск координат по указанному адресу</h1>
	<span>Введите адрес:</span>
	<form action="" method="post">
		<input type="text" name="address">
		<input type="submit" name="search" value="Найти">
	</form>
	<br>
	<table style="display: <?= $vis ?>">
		<tr style="background-color: #eeeeee">
			<td>Адрес</td>
			<td>Широта</td>
			<td>Долгота</td>
		</tr>
		<?php if (isset($collection)) { if($response->getFoundCount() > 1) { foreach ($collection as $item) { ?>
		<tr>
			<td><?php echo '<a href="maps.php?Latitude='.$item->getLatitude().'&Longitude='.$item->getLongitude().'">'.$item->getAddress().'</a>' ?></td>
			<td><?php echo $item->getLatitude() ?></td>
			<td><?php echo $item->getLongitude() ?></td>
		</tr>
		<?php } } else if ($response->getFoundCount() === 1) { $vis_map = 'block'; foreach ($collection as $item) { ?>
		<tr>
			<td><?php echo $item->getAddress(); ?></td>
			<td><?php $Latitude = $item->getLatitude(); echo $Latitude; ?></td>
			<td><?php $Longitude = $item->getLongitude(); echo $Longitude; ?></td>
		</tr>
		<?php } } } ?>
	</table>
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
    <div id="map" style="width: 600px; height: 400px; margin-top: 10px; display: <?= $vis_map ?>"></div>
</body>
</html>
