<?php

//include '/home/aswill/Desktop/mysqlq.php';


include 'header.php';
include 'tree.php';


echo "It\'s work. Finally<p>";

$dsn = 'mysql:dbname=test;host=127.0.0.1';
$user = 'root';
$password = 'root';

/*
    
*/
try {
    $dbh = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    print("Connection is established<p>");
    $first_check = $dbh->prepare("SELECT * FROM `branch`");
    $first_check->execute(); //Выполняем запрос
        //Читаем все строчки и записываем в переменную $result
    $result = $first_check->fetchAll(PDO::FETCH_OBJ);
    //print_r($first_check->fetchAll(PDO::FETCH_OBJ));

     if(empty($result)){
        print("Rez is empty");
        echo "<p><div>
                    <form method='post'>
                        <button type='submit'>Create Root</button></form><div>";
        CreateRoot ($dbh);
    }
    else{
        $tree = new Tree($dbh);
        $tree->outTree(0, 0); //Выводим дерево
    }

    //print("REZ = $result");
    //include '';
} catch (PDOException $e) {
    echo 'Соединение оборвалось: ' . $e->getMessage();
    exit;
}

// Следующий запрос приводит к ошибке уровня E_WARNING вместо исключения (когда таблица не существует)
//$dbh->query("SELECT wrongcolumn FROM wrongtable");


/*
$link = mysqli_connect("localhost", "root", "root", "test");

if ($link == false){
    print("Error - " . mysqli_connect_error());
}
else {
    
    print("Connection is established<p> link =  <p>");

    echo "<p><div><button><div>";

}
*/
?>
