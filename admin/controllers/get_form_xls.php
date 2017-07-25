<?php
$fname='forms_'.$_GET['under'] . ".csv";
@unlink('tmp/'.$fname);

       
$csv = iconv( 'UTF-8', 'Windows-1251',"Id;Дата создания;Время создания;Обработано;Имя;E-mail;Телефон;Cообщение;\n");


$q = "SELECT id,pub_date,pub_time,status,name,email, phone, msg
FROM forms WHERE form_id=$_GET[under] ORDER BY name";

$res = mQuery($q);
//echo mysqli_error();

$num = mysqli_num_rows($res);

$sum=0;

for($i=0;$i<$num;$i++)
{
	$row = mysqli_fetch_assoc($res);
	$csv .= iconv( 'UTF-8', 'Windows-1251',implode(";", $row)."\n");
    
}

    file_put_contents('tmp/'.$fname, $csv);
    
    echo '<strong><a href="tmp/'.$fname.'">Скачать таблицу</a></strong>';
?>
