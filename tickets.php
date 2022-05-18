<?php session_start();
include('header.php'); 
get_session();?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf8mb4">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Билеты</title>
    <style>
        .blk{
    margin: 10px;
	padding: 10px;
	float: left;
	width: 100px;
        }
    </style>
</head>

<body>
    <?php
    get_header();
    include 'db.php';
    include 'api.php';
    $tickets = getAllTickets($db);
    ?>
    <div class="container">
        <p>Нажмите на название билета, чтобы перейти к списку вопросов.</p>
        
        <?php foreach ($tickets as $row) {
        $tkt_id = $row['tkt_id'];
        $name = $row['name'];
        echo "<a class=\"blk btn btn-outline-dark\" href=\"questions.php?tkt_id=$tkt_id\">$name</a>";}?>

        
        <br>
        <div style="display: inline-block; width:100%">
        <p>Создание нового билета. Введите название билета в поле:</p>
        <form name="form_ed">
            <div class="form-group">
                <input type="text" name="tkt_name" placeholder="Билет N" class="form-control" style="width: 150px;">
            </div>
            <input type="submit" name="add" value="Добавить новый билет" class="btn btn-secondary">
        </form>
        </div>
    </div>
    <?php
    if (isset($_POST['add'])) {
        $tkt_name = $_POST['tkt_name'];
        addTicket($db, $tkt_name);
    }
    ?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>