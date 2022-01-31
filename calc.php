<?php
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);
$min = 1000;
$max = 3000000;

if ($_POST["deposit"] < $min || $_POST["deposit"] > $max) {
  echo "Ошибка";
}

if (($_POST["everyMonth"] === "on" &&  isset($_POST["depositAddSum"])) && ($_POST["depositAddSum"] < $min || $_POST["depositAddSum"] > $max) ) {
  echo "Ошибка";
}

if ($_POST["percent"] < 3 || $_POST["percent"] > 100) {
  echo "Ошибка";
}



$date = explode(".", $_POST["date"]);


  //Количество дней в данном месяце,на которые приходился вклад.
  $daysCurrentMonth = (int) date("d", mktime(0, 0, 0, $date[0]+1, 1, $date[2]) - 1);

  $daysPrevMonth = (int) date("d", mktime(0, 0, 0, $date[0], 1, $date[2]) - 1);

//Количество дней в году
  $daysYear = 365 + (int) checkdate(2, 29, $date[2]);

  //Сумма на счете на N месяц (рублей)
  $sumn = $_POST['deposit'];

  //Проверка на ежемесячное пополнение и присвоение значения в случае если checkbox = on
  if ($data["everyMonth"] === "on") {
    $depositAdd = $data["depositAddSum"];
  } else {
    $depositAdd = 0;
  }

  //Ставка банка от 3 до 100
  $percent = (int) $_POST['percent'];
  $depositMonth = (int) $_POST['timeDeposit'];
  if($_POST['yearOrMonth'] === 'year') {
    $depositMonth = (int) $_POST['timeDeposit']*12;
  }

  echo $depositMonth;
$result = $sumn + ($sumn-1 + $depositAdd) * $daysCurrentMonth * (($percent / $daysYear)* $depositMonth);

echo round($result, 2);


//sumN = sumN-1 + (sumN-1 + sumAdd) * daysN * (percent / daysY)

// sumN – сумма на счете на N месяц (руб)
// sumN-1 – сумма на счете на конец прошлого месяца
// sumAdd – сумма ежемесячного пополнения
// daysN – количество дней в данном месяце, на которые приходился вклад
// percent – процентная ставка банка
// daysY – количество дней в году