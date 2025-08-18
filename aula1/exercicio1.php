<?php

   $frutas = array("maçã", "melão", "melancia","uva","banana");
   $proc = "uva";
   $index = array_search($proc, $frutas);
   if ($index !== false) {
echo "O elemento $proc esta na posição $index";
   } else {
       echo "Elemento não encontrado";
   }
   echo "<hr>";
   $cores = array("azul", "vermelho","amarelo","verde");
   $proc = "verde";
   $index = array_search($proc, $cores);
   if ($index !== false) {
echo "O elemento $proc esta na posição $index";
   } else {
       echo "Elemento não encontrado";
   }
   echo "<hr>";
   $animais = array("lobo", "gato", "urubu", "leão",);
   array_unshift($animais, "passaro");
   print_r($animais);
   echo "<hr>";
   $dias = ["segunda","terça","quarta","quinta","sexta","sabado","domingo"];
echo count($dias);
echo "<hr>";
$num = [1,2,3,4,5,];
for ($i=0; $i <=5; $i++) { 
  echo $i. "<br>";
}
echo "<hr>";
$cidades = array("barcelona","rio de janeiro","tokyo", "madrid");
foreach ($cidades as $cidade){
    echo $cidade. " eu gostaria de visitar ";
  echo  "<br>";
}
echo "<hr>";
$arr = array("nome" => "Assis", "sobrenome" => "vinicius", "idade" => 15, "cidade" => " maringá ");
echo "Nome: " .$arr["sobrenome"]. "<br>";
echo "idade: " .$arr["idade"]. "<br>";
echo "cidade" .$arr["cidade"]. "<br>";
echo "<hr>";
$notas = [8, 7, 9, 6, 5];
$notas[1] = 10;
print_r($notas);
echo "<hr>";
$tarefas = array("Comprar pão", "Lavar roupa", "Estudar PHP", "Fazer compras");
array_pop($tarefas);
print_r($tarefas);
echo "<hr>";

?>