<?php
$arquivo_json = 'series.json';

// Funções para ler e salvar JSON
function ler_series($arquivo) {
    if(!file_exists($arquivo)) file_put_contents($arquivo, json_encode([]));
    return json_decode(file_get_contents($arquivo), true);
}

function salvar_series($arquivo, $series) {
    file_put_contents($arquivo, json_encode(array_values($series), JSON_PRETTY_PRINT));
}

// Carregar séries
$series = ler_series($arquivo_json);

$id_edicao = '';
$nome_edicao = '';
$telefone_edicao = '';
$titulo_edicao = '';
$genero_edicao = '';
$preco_compra_edicao = '';
$preco_aluguel_edicao = '';
$status_edicao = 'Disponível';
$modo_edicao = false;

// DELETE via GET
if(isset($_GET['acao']) && $_GET['acao']=='deletar' && isset($_GET['id'])) {
    foreach($series as $i=>$s) if($s['id']==$_GET['id']) unset($series[$i]);
    salvar_series($arquivo_json,$series);
    header('Location:index.php'); exit;
}

// Comprar/Alugar via GET
if(isset($_GET['acao']) && in_array($_GET['acao'],['comprar','alugar']) && isset($_GET['id'])) {
    foreach($series as $i=>$s) {
        if($s['id']==$_GET['id']) {
            $series[$i]['status'] = ($_GET['acao']=='comprar')?'Comprado':'Alugado';
            break;
        }
    }
    salvar_series($arquivo_json,$series);
    header('Location:index.php'); exit;
}

// Preparar edição
if(isset($_GET['acao']) && $_GET['acao']=='editar' && isset($_GET['id'])) {
    foreach($series as $s) {
        if($s['id']==$_GET['id']) {
            $id_edicao = $s['id'];
            $nome_edicao = $s['nome'];
            $telefone_edicao = $s['telefone'];
            $titulo_edicao = $s['titulo'];
            $genero_edicao = $s['genero'];
            $preco_compra_edicao = $s['preco_compra'];
            $preco_aluguel_edicao = $s['preco_aluguel'];
            $status_edicao = $s['status'];
            $modo_edicao = true;
            break;
        }
    }
}

// Criar ou atualizar via POST
if($_SERVER['REQUEST_METHOD']=='POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $preco_compra = isset($_POST['preco_compra'])?(float)$_POST['preco_compra']:0;
    $preco_aluguel = isset($_POST['preco_aluguel'])?(float)$_POST['preco_aluguel']:0;
    $status = $_POST['status'];

    if(!empty($_POST['id'])) {
        foreach($series as $i=>$s) if($s['id']==$_POST['id']) {
            $series[$i] = [
                'id'=>$s['id'],
                'nome'=>$nome,
                'telefone'=>$telefone,
                'titulo'=>$titulo,
                'genero'=>$genero,
                'preco_compra'=>$preco_compra,
                'preco_aluguel'=>$preco_aluguel,
                'status'=>$status
            ];
            break;
        }
    } else {
        $series[] = [
            'id'=>uniqid(),
            'nome'=>$nome,
            'telefone'=>$telefone,
            'titulo'=>$titulo,
            'genero'=>$genero,
            'preco_compra'=>$preco_compra,
            'preco_aluguel'=>$preco_aluguel,
            'status'=>$status
        ];
    }
    salvar_series($arquivo_json,$series);
    header('Location:index.php'); exit;
}

// Filtrar carrinho
$compradas = array_filter($series, fn($s)=>$s['status']=='Comprado');
$alugadas  = array_filter($series, fn($s)=>$s['status']=='Alugado');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Cadastro da Conecta Store </title>
<style>
body {font-family:'Segoe UI',Tahoma,sans-serif;margin:20px;background:#f0f2f5;}
h1{text-align:center;color:#333;margin-bottom:30px;}
.container{max-width:1000px;margin:auto;}
form{margin-bottom:25px;background:#fff;padding:25px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.1);transition:0.3s all;}
form:hover{transform:translateY(-3px);box-shadow:0 6px 15px rgba(0,0,0,0.15);}
label{display:block;margin-top:12px;font-weight:600;color:#555;}
input,select{width:100%;padding:12px;margin-top:6px;border:1px solid #ccc;border-radius:8px;outline:none;transition:0.2s;border-color;}
input:focus,select:focus{border-color:#007bff;}
button{padding:12px 20px;border:none;border-radius:8px;cursor:pointer;margin-top:18px;font-weight:600;transition:0.2s;}
button.add{background:#28a745;color:white;}
button.add:hover{background:#218838;}
button.update{background:#007bff;color:white;}
button.update:hover{background:#0069d9;}
table{width:100%;margin-top:20px;border-collapse:collapse;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.08);}
th,td{padding:14px;text-align:center;border-bottom:1px solid #eee;}
th{background:#007bff;color:white;text-transform:uppercase;font-weight:600;}
tr:hover{background:#f1f7ff;}
a{text-decoration:none;margin:0 4px;font-weight:600;transition:0.2s;}
a.edit{color:#007bff;} a.edit:hover{color:#0056b3;}
a.delete{color:#dc3545;} a.delete:hover{color:#a71d2a;}
a.buy{color:#28a745;} a.buy:hover{color:#1e7e34;}
a.rent{color:#ffc107;} a.rent:hover{color:#e0a800;}
td.status-disponivel{color:#28a745;font-weight:bold;}
td.status-comprado{color:#007bff;font-weight:bold;}
td.status-alugado{color:#ffc107;font-weight:bold;}
.carrinho{background:#fff;padding:20px;border-radius:12px;margin-bottom:20px;box-shadow:0 4px 12px rgba(0,0,0,0.1);}
.carrinho h2{margin-top:0;color:#007bff;}
.carrinho h3{margin-bottom:8px;color:#333;}
.carrinho ul{list-style:none;padding-left:0;margin-bottom:12px;}
.carrinho ul li{padding:6px 0;border-bottom:1px solid #eee;}
.carrinho ul li:last-child{border-bottom:none;}
@media(max-width:768px){
table,thead,tbody,th,td,tr{display:block;}
th{display:none;}
td{display:flex;justify-content:space-between;padding:10px;border-bottom:1px solid #eee;}
td::before{content:attr(data-label);font-weight:600;}
}
</style>
</head>
<body>
<div class="container">
<h1>Cadastro da Conecta Store </h1>

<form method="POST">
<input type="hidden" name="id" value="<?= htmlspecialchars($id_edicao) ?>">
<label>Nome:</label>
<input type="text" name="nome" value="<?= htmlspecialchars($nome_edicao) ?>" required>
<label>Telefone:</label>
<input type="number" name="telefone" value="<?= htmlspecialchars($telefone_edicao) ?>" required>
<label>Título:</label>
<input type="text" name="titulo" value="<?= htmlspecialchars($titulo_edicao) ?>" required>
<label>Gênero:</label>
<input type="text" name="genero" value="<?= htmlspecialchars($genero_edicao) ?>" required>
<label>Preço Compra (R$):</label>
<input type="number" step="0.01" name="preco_compra" value="<?= htmlspecialchars($preco_compra_edicao) ?>">
<label>Preço Aluguel (R$):</label>
<input type="number" step="0.01" name="preco_aluguel" value="<?= htmlspecialchars($preco_aluguel_edicao) ?>">
<label>Status:</label>
<select name="status">
<option value="Disponível" <?= $status_edicao=='Disponível'?'selected':'' ?>>Disponível</option>
<option value="Comprado" <?= $status_edicao=='Comprado'?'selected':'' ?>>Comprado</option>
<option value="Alugado" <?= $status_edicao=='Alugado'?'selected':'' ?>>Alugado</option>
</select>
<button type="submit" class="<?= $modo_edicao?'update':'add' ?>"><?= $modo_edicao?'Atualizar Série':'Adicionar Série' ?></button>
</form>

<?php if(!empty($compradas) || !empty($alugadas)): ?>
<div class="carrinho">
<h2>📦 Meu Carrinho</h2>
<?php if(!empty($compradas)): ?>
<h3>Compradas:</h3>
<ul>
<?php $total=0; foreach($compradas as $s){ $total+=$s['preco_compra']; ?>
<li><?= htmlspecialchars($s['titulo']) ?> (R$ <?= number_format($s['preco_compra'],2,',','.') ?>)</li>
<?php } ?>
<li><strong>Total Compras: R$ <?= number_format($total,2,',','.') ?></strong></li>
</ul>
<?php endif; ?>
<?php if(!empty($alugadas)): ?>
<h3>Alugadas:</h3>
<ul>
<?php $total=0; foreach($alugadas as $s){ $total+=$s['preco_aluguel']; ?>
<li><?= htmlspecialchars($s['titulo']) ?> (R$ <?= number_format($s['preco_aluguel'],2,',','.') ?>)</li>
<?php } ?>
<li><strong>Total Aluguéis: R$ <?= number_format($total,2,',','.') ?></strong></li>
</ul>
<?php endif; ?>
</div>
<?php endif; ?>

<table>
<tr>
<th>nome</th><th>telefone</th><th>titulo</th><th>genero</th><th>Compra (R$)</th><th>Aluguel (R$)</th><th>Status</th><th>Ações</th>
</tr>
<?php if(empty($series)): ?>
<tr><td colspan="8">Nenhuma série cadastrada.</td></tr>
<?php else: ?>
<?php foreach($series as $s):
$status_class=$s['status']=='Disponível'?'status-disponivel':($s['status']=='Comprado'?'status-comprado':'status-alugado'); ?>
<tr>
<td><?= htmlspecialchars($s['nome']) ?></td>
<td><?= htmlspecialchars($s['telefone']) ?></td>
<td><?= htmlspecialchars($s['titulo']) ?></td>
<td><?= htmlspecialchars($s['genero']) ?></td>
<td><?= $s['preco_compra']>0?'R$ '.number_format($s['preco_compra'],2,',','.'):'-' ?></td>
<td><?= $s['preco_aluguel']>0?'R$ '.number_format($s['preco_aluguel'],2,',','.'):'-' ?></td>
<td class="<?= $status_class ?>"><?= $s['status'] ?></td>
<td>
<a href="index.php?acao=editar&id=<?= $s['id'] ?>" class="edit">Editar</a>
<a href="index.php?acao=deletar&id=<?= $s['id'] ?>" class="delete" onclick="return confirm('Excluir esta série?')">Excluir</a>
<?php if($s['status']=='Disponível'): ?>
<a href="index.php?acao=comprar&id=<?= $s['id'] ?>" class="buy">Comprar</a>
<a href="index.php?acao=alugar&id=<?= $s['id'] ?>" class="rent">Alugar</a>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</table>

</div>
</body>
</html>