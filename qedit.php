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
    <link rel="shortcut icon" href="pic/logo1.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Редактор вопроса</title>
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(88926432, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/88926432" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</head>
<body>
<?php 
    get_header();
    include 'db.php';  
    include 'api.php';
    include 'questions_query.php';

    $tkt_id = $_GET['tkt_id'];
    $q_id = $_GET['q_id'];
    $n = $_GET['n']; //порядковый номер билета

    $topic = getAllTopics($db);
    $tkt = getAllTickets($db);
    $qform = questionFormFill($db, $q_id);
    
    $pt = 'uploaded/' . $tkt_id . '_' . $q_id . '.jpg';
    if (file_exists($pt)) {
        $pathImg = 'uploaded/' . $tkt_id . '_' . $q_id . '.jpg';
    } else $pathImg = '/pic/no_pic.png';

    if(isset($_POST['img_del']) &&  $_POST['img_del'] == 'Yes') 
    { 
        if( $pathImg != '/pic/no_pic.png') {
            deleteImg($pathImg);
            $pathImg = '/pic/no_pic.png';
        }
    }
?>
       <!-- название билета и вопроса-->
       <div class="container">
       <?php echo "<h4>Вопрос №$n к билету №$tkt_id</h4>" ?>
    
    <form method="post" enctype="multipart/form-data">
    <div class="row"> 
  
    <img class= "illustration"  src="<?php echo $pathImg; ?>" alt="">
    <div class="col"> 
    <div class="form-group">
    <label for="upload_img">Загрузить новое изображение</label>
    <input type="file" id="upload_img" name="upload_img" accept=".jpg, .jpeg, .png" class="form-control-file" >
    </div> </div>
    </div>
    <?php if($pathImg != '/pic/no_pic.png') echo '
    <div class="row"><div class="form-group"> 
    <input type="checkbox" id="img_del" name="img_del" value="Yes"  class="form-check-input" style="margin-left: 10px; width: 20px;">
    <label for="img_del" class="form-check-label" style="margin-left: 35px;">Удалить картинку</label>
    </div></div>'; ?>  

<hr style="border-top:1px groovy #000;">
<div class="row">
<div class="col">
<?php foreach ($qform as $row1){ 
    $tp_id1 = $row1['tp_id'];
    questionTopic($db, $tp_id1);
 ?>
 </div>
 <div class="col">
 <div class="form-group">

        <label for="theme">Выбор новой темы вопроса:</label> 
            <select id="theme" name="theme" class="form-control">
            <?php foreach ($topic as $row){
                $id = $row['tp_id'];
                $name = $row['name'];
                echo "<option value=\"$id\">$name</option>";}?>
            </select>
            </div> </div>
        </div>
        <hr style="border-top:1px groovy #000;">    
            <div class="form-group row">
        <label for="question" class="col-sm-2 col-form-label">Вопрос*: </label> <!-- ввод вопроса -->
        <div class="col-sm-10">
            <input type="text" class="form-control" id="question" name="question" value="<?php echo $row1['task'];?>">
            </div> </div>
        <div class="form-group row">
         <!-- ввод ответов -->
        <label for="answer1" class="col-sm-2 col-form-label">Вариант ответа 1*: </label>
        <div class="col-sm-10">
        <textarea class="form-control" id="answer1" name="answer1"><?php echo $row1['ans1'];?></textarea>
            </div></div>
            <div class="form-group row">
        <label for="answer2" class="col-sm-2 col-form-label">Вариант ответа 2*:</label>
        <div class="col-sm-10">
        <textarea  class="form-control" id="answer2" name="answer2"><?php echo $row1['ans2'];?></textarea>
        </div></div>
        <div class="form-group row">
        <label for="answer3" class="col-sm-2 col-form-label">Вариант ответа 3:</label>
        <div class="col-sm-10">
        <textarea  class="form-control" id="answer3" name="answer3"><?php echo $row1['ans3'];?></textarea>
        </div></div>
        <div class="form-group row">
        <label for="answer4" class="col-sm-2 col-form-label">Вариант ответа 4:</label>
        <div class="col-sm-10">
        <textarea  class="form-control" id="answer4" name="answer4"><?php echo $row1['ans4'];?></textarea>
        </div></div>
        <div class="form-group row">
        <label for="answer5" class="col-sm-2 col-form-label">Вариант ответа 5:</label>
        <div class="col-sm-10">
        <textarea  class="form-control" id="answer5" name="answer5"><?php echo $row1['ans5'];?></textarea>
        </div></div>
        <div class="form-group row">
        <label for="answer" class="col-sm-2 col-form-label">Номер верного ответа*:</label> <!-- номер верного ответа -->
        <div class="col-sm-2">
        <input type="number" class="form-control" id="answer" name="answer" min="1" max="5" value="<?php echo $row1['true_ans'];?>">
        </div></div>
            
        <div class="form-group row">
        <label for="question" class="col-sm-2 col-form-label">Описание ответа, подсказка:</label>
        <div class="col-sm-10">
        <textarea class="form-control" id="description" name="description"><?php echo $row1['description'];}?></textarea>
        </div>
        </div>
        <div class="form-group">
        <input type="submit" value="Сохранить" class="btn btn-secondary">
            </div>
    </form>
<p>*-обязательные поля</p>
<?php echo "<a href=\"questions.php?tkt_id=$tkt_id\">Вернутья к списку вопросов</a></div>" ?>
            </div>
<?php
    if($_POST['question'] != '')  
{
$num=0;

$tp_id=$_POST['theme'];
$task=$_POST['question'];
if ($_POST['answer1'] == '') 
{
    $ans1 = null; echo "<script>alert('Не заполнено обязательное поле Ответ 1')</script>";} 
    else{
        $ans1=$_POST['answer1']; $num++;

        if ($_POST['answer2'] == '') { $ans2 = null; echo "<script>alert('Не заполнено обязательное поле Ответ 2')</script>";}
        else{
            $ans2=$_POST['answer2']; $num++;
        
            if ($_POST['answer3'] == '') $ans3 = null; else {$ans3=$_POST['answer3']; $num++;}
            if ($_POST['answer4'] == '') $ans4 = null; else {$ans4=$_POST['answer4']; $num++;}
            if ($_POST['answer5'] == '') $ans5 = null; else {$ans5=$_POST['answer5']; $num++;}

            if ($_POST['description'] == '') $description = null; else $description=$_POST['description'];

            if ($_POST['answer'] == '') {$true_ans = null;}
            elseif($_POST['answer'] > $num) echo '<script>alert("Вы ввели в качестве номера верного ответа '.$_POST['answer'].', но заполнили '.$num.' поля ответов")</script>';
            else{ 
                    $true_ans=$_POST['answer']; 
                    editQuestion($db, $q_id, $tkt_id, $tp_id, $task, $true_ans, $ans1, $ans2, $ans3, $ans4, $ans5, $description);
                    UploadImage($tkt_id, $q_id);
                    echo "<script>window.location = 'questions.php?tkt_id=$tkt_id';</script>
				";
            }
        }
    }  
}
?>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>
