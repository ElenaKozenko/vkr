<?php
//РАБОТА С ТАБЛИЦЕЙ "Вопросы"  ВЫВОД ВСЕЙ ИНФОРМАЦИИ ИЗ "Вопросы" по коду билета
function getQuestionsByTicket($db, $tkt_id)
{
$sql="SELECT q_id, task, true_ans, ans1, ans2, ans3, ans4, ans5, questions.description FROM questions WHERE questions.tkt_id = $tkt_id";
$result=array();
$stmt=$db->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
{
    $result[$row['q_id']] = $row;
}
return $result;
print_r($result);
}

?>