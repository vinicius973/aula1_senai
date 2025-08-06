<?php
    $nome = "Emerson";
    $idade = 52;
    echo "Meu nome é ".$nome.", e tenho ".$idade." anos.";
    echo "<hr>";
    echo "<center><h2>SENAI - DEVELOPER</h2></center>";
    echo "<hr>";
    $valor1 = 8;
    $valor2 = 11;
    echo "A soma dos valores foi:".$valor1+$valor2."<br>";
    echo "A subtração dos valores foi:".$valor1-$valor2."<br>";
    echo "A multiplicação dos valores foi:".$valor1*$valor2."<br>";
    $result = $valor1/$valor2;
    $numformatado = number_format($result, 2, ',', '.');
    echo "A divisão dos valores foi:".$numformatado;
    echo "<hr>";
    $datahora = date('d/m/Y H:i:s');
    echo "Data atual: ".$datahora;
    echo "<hr>";
    $data1 = new DateTime('2025-01-01');
    //Data: 2025-01-01 22:30:23 = Y-m-d H:i:s
    $data2 = new DateTime('2025-08-06');
    $intervalo = $data1->diff($data2);
    echo "A diferença em anos :" .$intervalo->y."<br>";
    echo "A diferença em meses:" .$intervalo->m."<br>";
    echo "A diferença em dias: " .$intervalo->days."<br>";
    $horas= $intervalo->days*24;
    echo "A diferença em horas:" .$horas;
    echo "<hr>";
    echo "<hr> Função Condicional - IF</h2>";
    $a = 3;
    $b = 5;
    if ($a > $b) {
        echo "A é maior que B!";
    } else {
        echo "B é maior que A!";
    }
    echo "<br> Saiu do IF";
?>