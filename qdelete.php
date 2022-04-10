<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
<body>
<?php 
    include 'db.php';
    include 'api.php';
    include 'questions_query.php';
    
    //получение из questions.php
    $q_id = $_GET['q_id'];
    $tkt_id = $_GET['tkt_id'];

    if($q_id) { 
        deleteQuestion($db, $q_id); 
        echo "<h1>Вопрос удалён</h1>";
        echo "<a href=\"questions.php?tkt_id=$tkt_id\">Вернуться к вопросам</a>"; 
    }
    else
    {
		echo "<h1>При удаление призошла ошибка</h1>";
    exit();
    }

?>
</body>
</html>