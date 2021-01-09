<?php
require_once 'PDOAdapter.php';
require_once 'MyLogger.php';

$logger = new MyLogger('log.txt');
$pdoa = new PDOAdapter('mysql:host=178.250.157.125;dbname=test1', 'test1', '12345678', $logger);

// 1) Определить максимальный возраст
$maxAge = $pdoa->execute('selectOne', 'select max(`age`) as `age` from `person`')->age;
$maxAge = ($maxAge !== false) ? $maxAge : null;

// 2) Найти любую персону, у которой mother_id не задан и возраст меньше максимального
$anyPerson = $pdoa->execute('selectOne', 'select * from `person` where `mother_id` is null and `age` < :maxAge', [':maxAge' => $maxAge]);

$anyPerson = ($anyPerson !== false) ? $anyPerson : null;

// 3) изменить у нее возраст на максимальный
if ($anyPerson)
{
	$prepareUpdateAge = $pdoa->prepare('update `person` set `age` = :age where `id` = :id');
	$pdoa->executePrepared($prepareUpdateAge, [':age' => $maxAge, ':id' => $anyPerson->id]);
}
else
{
	$logger->error('person not found');	
}

// 4) Получить список персон максимального возраста (фамилия, имя). Желательно НЕ ИСПОЛЬЗУЯ полученное на шаге 1 значение.
$maxAgePersons = $pdoa->execute('selectAll', 'select * from `person` where `age` = (select max(`age`) from `person`) order by `lastname`, `firstname`');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Тестовое задание</title>
</head>
<body>
	
	<h1>Список персон максимального возраста</h1>

	<p>максильный возраст: <?=$maxAge;?></p>
	
	<table border="1">
		<thead>
			<tr>
				<th>Фамилия</th>
				<th>Имя</th>
				<th>Возраст</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($maxAgePersons as $key => $person)
			{
				echo '<tr>';
				echo '<td>' . $person->lastname . '</td>';
				echo '<td>' . $person->firstname . '</td>';
				echo '<td>' . $person->age . '</td>';
				echo '</tr>';
			}
		?>
		</tbody>
	</table>

</body>
</html>