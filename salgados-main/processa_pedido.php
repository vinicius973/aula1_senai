<?php
session_start();
include 'conecta.php'; // Inclui sua conexão

// Verifica se o usuário está logado e se os dados foram enviados via POST
if (!isset($_SESSION["user"]) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Se não, redireciona ou mostra erro
    header('Location: index.php');
    exit;
}

// 1. PEGAR OS DADOS DO FORMULÁRIO
$id_cliente = $_POST['id_cliente'];
$data_entrega = $_POST['data_entrega'];
$data_pedido = date('Y-m-d'); // Pega a data atual para o pedido
$itens_json = $_POST['itens_pedido'];

// Decodifica o JSON dos itens para um array PHP
$itens = json_decode($itens_json, true);

// 2. CALCULAR O TOTAL DO PEDIDO (cálculo feito no servidor por segurança)
$total_pedido = 0;
foreach ($itens as $item) {
    $total_pedido += (float) $item['subtotal'];
}

// --- INÍCIO DA TRANSAÇÃO NO BANCO DE DADOS ---
// Usar transação garante que ou tudo é salvo, ou nada é salvo.
mysqli_autocommit($conn, false);

$erro = false;

// 3. INSERIR NA TABELA `pedidos`
$sql_pedido = "INSERT INTO pedidos (id_cliente, data_pedido, data_entrega, total) VALUES (?, ?, ?, ?)";
$stmt_pedido = mysqli_prepare($conn, $sql_pedido);
mysqli_stmt_bind_param($stmt_pedido, 'issd', $id_cliente, $data_pedido, $data_entrega, $total_pedido);

if (mysqli_stmt_execute($stmt_pedido)) {
    // Se o pedido foi inserido com sucesso, pegamos o ID dele
    $id_pedido_gerado = mysqli_insert_id($conn);
    
    // 4. INSERIR CADA ITEM NA TABELA `pedidos_salgados`
    $sql_item = "INSERT INTO pedidos_salgados (id_pedido, id_salgado, quantidade, subtotal) VALUES (?, ?, ?, ?)";
    $stmt_item = mysqli_prepare($conn, $sql_item);

    foreach ($itens as $item) {
        $id_salgado = $item['id_salgado'];
        $quantidade = $item['quantidade'];
        $subtotal = $item['subtotal'];

        mysqli_stmt_bind_param($stmt_item, 'iiid', $id_pedido_gerado, $id_salgado, $quantidade, $subtotal);
        
        // Se a execução de qualquer item falhar, marca o erro
        if (!mysqli_stmt_execute($stmt_item)) {
            $erro = true;
            break; // Para o loop
        }
    }

} else {
    // Se falhou ao inserir o pedido principal
    $erro = true;
}


// 5. FINALIZAR A TRANSAÇÃO
if ($erro) {
    mysqli_rollback($conn); // Desfaz todas as operações
    echo "<script>
            alert('Ocorreu um erro ao salvar o pedido. Tente novamente.');
            window.history.back(); // Volta para a página anterior
          </script>";
} else {
    mysqli_commit($conn); // Confirma todas as operações
    echo "<script>
            alert('Pedido realizado com sucesso!');
            window.location.href = 'pedidos.php'; // Redireciona para uma página de sucesso ou listagem
          </script>";
}

// Fecha as preparações e a conexão
mysqli_stmt_close($stmt_pedido);
if(isset($stmt_item)) {
  mysqli_stmt_close($stmt_item);
}
mysqli_close($conn);
?>  