<?php
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

