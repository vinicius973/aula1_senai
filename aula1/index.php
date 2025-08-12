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
$n1 = 3;
$n2 = 4;
$n3 = 8;
if ($n1 > $n2 && $n1 > $n3) {
    echo "A variavel " .$n1. " é o valor maior!";
    }
    elseif ($n2 > $n1 && $n2 > $n3) {
        echo "A variavel " .$n2. " é o valor maior!";
}
else {
    echo "A variavel " .$n3. " é o valor maior!";
}
echo "<hr>";
echo "<center><h2>NÚMEROS RANDOMICOS</h2></center>";
$num = rand(1, 10);
echo "O número sorteado foi :" .$num;
$valor = 5;
if ($num == $valor) {
    echo " Valor da sua variável: " .$valor. " Você ganhou"; 
}
else {
    echo "<br>Não foi dessa vez";
}
echo "<hr>";
for ($i=0; $i < 10 ; $i++) {
    echo "Passagem do laço for nº: ".$i. "<br>";
}
echo "<h2>Tabuada</h2>";
$numtabu = 10;
for ($i=1; $i <= 10 ; $i++) {
    echo $numtabu. "X" .$i. " = " .$numtabu*$i. "<br>";
}
echo "<hr>";
echo "<h2>Laço WHILE</h2>";
$x = 1;
while ($x <6) {
    echo "laço nº: " .$x. "<br>";
    $x++;
}
$a = 0;
while ($a <100) {
    echo $a. "<br>";
    $a+=10;
}
echo "<hr";
echo "<h2>FOREACH</h2>";
$cores = array("azul", "marrom", "bege", "amarelo", "branco");
foreach ($cores as $cor) {
    echo $cor. "<br>";
}
?>
  