<?php
session_start();
include 'conecta.php';
if(!isset($_SESSION['user'])){
    echo "<script language='javascript' type= 'text/javascript'> 
    window.location.href='index.php';
    </script>";
exit;
}
//1- Buscar os clientes
$clientes = [];
$query_clientes = mysqli_query($conn, "SELECT id,nome from clientes order by nome asc");
while ($clientes = mysqli_fetch_assoc($query_clientes)){
    $cliente[] = $clientes;
}
//2 Buscar os salgados
$salgados = [];
$query_salgados = mysqli_query($conn, "SELECT id,nome,valor from salgados order by nome asc");
while ($salgados = mysqli_fetch_assoc($query_salgados )){
    $salgado[] = $salgados;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
<meta charset="utf-8">
<meta http-equiv="content-language" content="pr-br">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SALGADOS DA MAMÃE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
    body{
        padding: 5px;
        margin: 5px;
    }
    h2 {
        color: gray
    }
    .main-header{ display: flex; justify-content: space-between; align-items: center; padding: 15px 10px;}
    .user-info{ display: flex; align-items: center; gap: 8px; color:gray;}
    .username{ font-weight: bold;}
    .logout-link{color: red; font-weight: bold; text-decoration: none;}
    .logout-link:hover{text-decoration:underline;}
        </style>
</head>
<body>
    <script scr="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min"> </script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <header class="main header">
<h2 class="main title">SALGADOS DA MAMÃE</h2>
<div class="user-info">
<?php
if (!empty($_SESSION['user'])) {
   $usuario = $_SESSION['user'];
   echo "<span class='username'".htmlspecialchars($usuario)." | </span><a class='logout-linl' href='sair.php'>SAIR</a>";
}
?>
</div>
    </header>
    <hr>
    <nav>
        <?php include 'menu.php'?>
    </nav>
    <br>
    <br>
    <div class="container">
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h2 class="my 0 fw-normal"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="gray" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/></svg>&nbsp;&nbsp;<b>REALIZAR PEDIDO</b></h2>
</div>
<div class="card-body">
    <form id="form pedido" method="POST" action="pedidos_processa.php">
<div class="row mb-3">
<div class="col-md-6">
<label for="cliente" class="from-label">CLIENTE</label>
<select id="cliente" name="id_cliente" class="form-select" required>
    <option value="">Selecione um cliente...</option>
    <?php foreach($cliente as $clientes):?>
        <option value="<?php echo $clientes['id']; ?>"><?php echo htmlspecialchars($clientes['nome']); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="col-md-6">
    <label for="data-entrega" class="from-label">DATA DE ENTREGA</label>
    <input type="date" id="data_entrega" name="data_entrega" class="form-contol" required>   
    </div>
    </div>
    <hr>
    <h5 class="mb-3">ADICIONAR ITENS AO PEDIDO</h5>
    <div class="row align-items-end g3">
        <div class="col-md-6">
        <label for="salgado" class="from-label">SALGADOS</label>
<select id="salgado" name="id_salgado" class="form-select" required>
<option value="">Selecione um salgado...</option>
    <?php foreach($salgado as $salgados):?>
        <option value="<?php echo $salgados['id']; ?>"><?php echo htmlspecialchars($salgados['nome']); ?></option>
        <?php endforeach; ?>
                </select>
                </div>
                <div class ="col-md-3">
                    <label for ="quantidade" class="form-label">QUANTIDADE</label>
                    <input type="number" id="quantidade" class="form-control" min="1" placeholder="Ex: 50">
                </div>
                <div class="col-md-3">
                    <button type="button" id="btn-adicionar" class="btn btn-primary w-100">ADICIONAR</button>
                </div>
                </div>
                <hr>
                <h5 class="mt-4">ITENS DO PEDIDO</h5>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                      <th>SALGADOS</th>
                      <th width="120px">QUANTIDADE</th>
                      <th width="120px">UNITÁRIOS(R$)</th>
                      <th width="150px">SUBTOTAL(R$)</th>
                      <th width="80px">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-itens">
                    </tbod>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><storng>TOTAL DO PEDIDO</strong></td>
                            <td colspan="2"><strong id="total-pedido">R$ 0,00</strong></td>
                        </tr>
                    </tfoot>
    </table>
    <input type="hidden" name="itens_pedido" id="itens_pedido">
    <div class="d-grid gap-2 mt-4">
        <button type="submit" class="btn btn-sucess btn-lg">FINALIZAR PEDIDO</button>
                </form>             
                </div>
                </div>
               </div>
    </div>
</div>
<script>
    $(document).ready(function(){}
//Função para atualizar o total de pedido
function atualizarTotal(){
    let total = 0;
    $('#tabela-itens tr').each(function(){

    //Pegar o valor do subtotal de cada linha e somar o total
    total += parseFloat($(this).data('subtotal'));
});
//Formatar como moeda brasileira
$('#total_pedido').text('R$'+ total.toFixed(2).replace('.',','));{

}
//Ação do botão Adicionar
$('#btn-adicionar').on('click', function(){
let salgadoSelect = $('#salgado');
let salgadoId = salgadoSelect.val();
let salgadoNome = salgadoSelect.find('option:selected').text().trim();
let salgadoValor = parseFloat(salgadoSelect.find('option:selected').data('valor'))
let quantidade = parseInt($('#quantidade').val());
if (!salgadoId){
    alert('Por Favor, selecione um salgado.');
    
}
if (isNaN(quantidade)|| quantidade <= 0 ) {
    alert('Por favor,informe uma quantidade válida');
    return;
}
let subtotal = salgadovalor * quantidade;
//cria uma nova linha da tabela de dados
//usamos data atributos para guardar os valores que enviamos ao PHP
let novalinha=`
<tr data id="$(salgadoid)" data-quantidade "$(quantidade)" data-subtotal "$(subtotal)">
<td>${salgadonome}</td>
<td>${quantidade}</td>
<td>R$ ${salgadovalor.toFixed(2).replace('.',',')}</td>
<td>R$ ${subtotal.toFixed(2).replace('.',',')}</td>
<td><button type="button" class="btn btn-danger btn-sm-btn-remover">REMOVER</td>
</tr>`;
//Adicionar a nova linha
$('#tabela-itens').append(novalinha);
//Limpa os campos
$('#salgado').val('');
$('#quantidade').val('');
//Atualizar o valor total 
atualizarTotal();
});
//Ação para o botão remover 
$('#tabela-itens').on('click', 'btn-remover', function(){
    //Remova a linha pai
    $(this).closet('tr').remove();
      //Atualiza o total
      atualizarTotal();
});
//Ação para submeter o fomulário
$('#form-pedido').on('submit', function(event){
    //Verifica se há pelo menos um item pedido
    if ($('#tabela-itens tr').length === 0) {
        alert('Você precisa adicionar pelo menos um item, antes de finalizar o pedido!')
        event.preventDefault(); //Impede o envio do formulário
        return;
    }
})
});
</script>
</body>
</html>