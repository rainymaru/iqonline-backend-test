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

if ((int) $date[1] - 1 === 0) {
  $prevDay = 12;
  $year = (int) $date[2] - 1;
} else {
  $prevDay = (int) $date[1] - 1;
  $year = (int) $date[2];
}

  //Количество дней в данном месяце,на которые приходился вклад.
  $daysCurrentMonth = cal_days_in_month(CAL_GREGORIAN, (int) $date[1], (int) $date[2]);
  //Количество дней в прошлом месяце.
  $daysPrevMonth = cal_days_in_month(CAL_GREGORIAN, $prevDay, $year);

//Количество дней в году
  $daysYear = 365 + (int) checkdate(2, 29, $date[2]);

  //Сумма на счете на N месяц (рублей)
  $deposit = $_POST['deposit'];

  //Проверка на ежемесячное пополнение и присвоение значения в случае если checkbox = on
  if ($_POST["everyMonth"] === "on") {
    $depositAdd = (int) $_POST["depositAddSum"];
  } else {
    $depositAdd = 1;
  }

  //Ставка банка от 3 до 100
  $percent = (int) $_POST['percent'];
  $depositMonth = (int) $_POST['timeDeposit'];
  if($_POST['yearOrMonth'] === 'year') {
    $depositMonth = (int) $_POST['timeDeposit'] * 12;
  }

$prevResult = $prevResult = $deposit + $depositAdd * ($daysYear * (1 + $percent / $daysCurrentMonth));
for ($i = 0; $i < $depositMonth - 1; $i++) {
  if ((int) $date[1] + 1 === 13) {
    $nextDate = 1;
    $yearInFor = (int) $date[2] + 1;
  } else {
    $nextDate = (int) $date[1] + 1;
    $yearInFor = (int) $date[2];
  }

  $daysCurrentMonthinFor = cal_days_in_month(CAL_GREGORIAN, $nextDate, $yearInFor);
  $result += ($prevResult + ($prevResult + $depositAdd)) * ($daysCurrentMonthinFor * ($percent / $daysYear));
}

if ((int) $depositMonth === 1) {
  echo round($prevResult, 0);
} else {
  echo round($result, 0);
}

