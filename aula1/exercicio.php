<?php
$nome = "Vinicius";
$idade = 15;
echo " Olá, meunome é " .$nome." e tenho " .$idade. "anos";
echo "<hr>";
$n1 = 9;                                                   
$n2 = 10;
if ($n1 > $n2) {
    echo "9 é maior que 10!";
} 
else {
    echo "10 é maior que 9!";
}
echo "<hr>";
$nota = rand(1, 10);
echo "O número sorteado foi :" .$nota;
$valor = 7;
if ($nota== $valor) {
    echo " Valor da sua variável: " .$valor. " aprovado"; 
}
else {
    echo "<br>reprovado";
}
echo "<hr>";
$idade = 15;
if ($idade < 12){
    echo "criança";
} elseif ($idade >= 12 && $idade <= 17){
    echo "adolescente";
} else {
    echo "adulto";
}
$x = 1;
while ($x <6) {
    echo " nº: " .$x. "<br>";
    $x++;
}
echo "<hr>";
for ($i=0; $i <=10 ; $i+=2){
echo $i."<br>";
}

?>