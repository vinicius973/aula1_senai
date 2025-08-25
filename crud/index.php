<?php
    session_start();
    if (!isset($_SESSION['series'])) {
        $_SESSION['series'] = [];
    }

    $id_edicao = null;
    $titulo_edicao = '';
    $genero_edicao = '';
    $ano_edicao = '';
    $plataforma_edicao = '';
    $preco_compra_edicao = '';
    $preco_aluguel_edicao = '';
    $status_edicao = 'Disponível';
    $modo_edicao = false;

    // DELETE via GET
    if (isset($_GET['acao']) && $_GET['acao'] == 'deletar' && isset($_GET['id'])) {
        $id_para_deletar = $_GET['id'];
        foreach ($_SESSION['series'] as $indice => $serie) {
            if ($serie['id'] == $id_para_deletar) {
                unset($_SESSION['series'][$indice]);
                break;
            }
        }
        header('Location: index.php');
        exit;
    }

    // Comprar/Alugar via GET
    if (isset($_GET['acao']) && in_array($_GET['acao'], ['comprar', 'alugar']) && isset($_GET['id'])) {
        foreach ($_SESSION['series'] as $indice => $serie) {
            if ($serie['id'] == $_GET['id']) {
                $_SESSION['series'][$indice]['status'] = ($_GET['acao'] == 'comprar') ? 'Comprado' : 'Alugado';
                break;
            }
        }
        header('Location: index.php');
        exit;
    }

    // Preparar edição
    if (isset($_GET['acao']) && $_GET['acao'] == 'editar' && isset($_GET['id'])) {
        $id_para_editar = $_GET['id'];
        foreach ($_SESSION['series'] as $serie) {
            if ($serie['id'] == $id_para_editar) {
                $id_edicao = $serie['id'];
                $titulo_edicao = $serie['titulo'];
                $genero_edicao = $serie['genero'];
                $ano_edicao = $serie['ano'];
                $plataforma_edicao = $serie['plataforma'];
                $preco_compra_edicao = $serie['preco_compra'];
                $preco_aluguel_edicao = $serie['preco_aluguel'];
                $status_edicao = $serie['status'];
                $modo_edicao = true;
                break;
            }
        }
    }

    // Criar ou Atualizar via POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = $_POST['titulo'];
        $genero = $_POST['genero'];
        $ano = $_POST['ano'];
        $plataforma = $_POST['plataforma'];
        $preco_compra = isset($_POST['preco_compra']) ? (float) $_POST['preco_compra'] : 0;
        $preco_aluguel = isset($_POST['preco_aluguel']) ? (float) $_POST['preco_aluguel'] : 0;
        $status = $_POST['status'];

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Atualizar
            $id_para_atualizar = $_POST['id'];
            foreach ($_SESSION['series'] as $indice => $serie) {
                if ($serie['id'] == $id_para_atualizar) {
                    $_SESSION['series'][$indice]['titulo'] = $titulo;
                    $_SESSION['series'][$indice]['genero'] = $genero;
                    $_SESSION['series'][$indice]['ano'] = $ano;
                    $_SESSION['series'][$indice]['plataforma'] = $plataforma;
                    $_SESSION['series'][$indice]['preco_compra'] = $preco_compra;
                    $_SESSION['series'][$indice]['preco_aluguel'] = $preco_aluguel;
                    $_SESSION['series'][$indice]['status'] = $status;
                    break;
                }
            }
        } else {
            // Criar
            $nova_serie = [
                'id' => uniqid(),
                'titulo' => $titulo,
                'genero' => $genero,
                'ano' => $ano,
                'plataforma' => $plataforma,
                'preco_compra' => $preco_compra,
                'preco_aluguel' => $preco_aluguel,
                'status' => $status
            ];
            $_SESSION['series'][] = $nova_serie;
        }

        header('Location: index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de Séries</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f4f6f9; }
        h1 { text-align: center; color: #444; }
        .container { max-width: 1000px; margin: auto; }
        form { margin-bottom: 20px; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; }
        button { padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; margin-top: 15px; }
        button.add { background: #28a745; color: white; }
        button.update { background: #007bff; color: white; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: center; }
        th { background: #007bff; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        a { text-decoration: none; margin: 0 5px; }
        a.edit { color: #007bff; }
        a.delete { color: #dc3545; }
        a.buy { color: #28a745; font-weight: bold; }
        a.rent { color: #ffc107; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Loja de Séries 📺</h1>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id_edicao; ?>">
            <label>Título:</label>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($titulo_edicao); ?>" required>
            
            <label>Gênero:</label>
            <input type="text" name="genero" value="<?php echo htmlspecialchars($genero_edicao); ?>" required>
            
            <label>Ano:</label>
            <input type="number" name="ano" value="<?php echo htmlspecialchars($ano_edicao); ?>" required>
            
            <label>Plataforma:</label>
            <input type="text" name="plataforma" value="<?php echo htmlspecialchars($plataforma_edicao); ?>" required>
            
            <label>Preço Compra (R$):</label>
            <input type="number" step="0.01" name="preco_compra" value="<?php echo htmlspecialchars($preco_compra_edicao); ?>">
            
            <label>Preço Aluguel (R$):</label>
            <input type="number" step="0.01" name="preco_aluguel" value="<?php echo htmlspecialchars($preco_aluguel_edicao); ?>">
            
            <label>Status:</label>
            <select name="status">
                <option value="Disponível" <?php if($status_edicao=='Disponível') echo 'selected'; ?>>Disponível</option>
                <option value="Comprado" <?php if($status_edicao=='Comprado') echo 'selected'; ?>>Comprado</option>
                <option value="Alugado" <?php if($status_edicao=='Alugado') echo 'selected'; ?>>Alugado</option>
            </select>

            <?php if ($modo_edicao): ?>
                <button type="submit" class="update">Atualizar Série</button>
            <?php else: ?>
                <button type="submit" class="add">Adicionar Série</button>
            <?php endif; ?>
        </form>

        <table>
            <tr>
                <th>Título</th>
                <th>Gênero</th>
                <th>Ano</th>
                <th>Plataforma</th>
                <th>Compra (R$)</th>
                <th>Aluguel (R$)</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            <?php if (empty($_SESSION['series'])): ?>
                <tr><td colspan="8">Nenhuma série cadastrada.</td></tr>
            <?php else: ?>
                <?php foreach ($_SESSION['series'] as $serie): ?>
                <tr>
                    <td><?php echo htmlspecialchars($serie['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($serie['genero']); ?></td>
                    <td><?php echo htmlspecialchars($serie['ano']); ?></td>
                    <td><?php echo htmlspecialchars($serie['plataforma']); ?></td>
                    <td>
                        <?php 
                            echo $serie['preco_compra'] > 0 
                                ? 'R$ ' . number_format($serie['preco_compra'], 2, ',', '.') 
                                : '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            echo $serie['preco_aluguel'] > 0 
                                ? 'R$ ' . number_format($serie['preco_aluguel'], 2, ',', '.') 
                                : '-';
                        ?>
                    </td>
                    <td><?php echo $serie['status']; ?></td>
                    <td>
                        <a href="index.php?acao=editar&id=<?php echo $serie['id']; ?>" class="edit">Editar</a>
                        <a href="index.php?acao=deletar&id=<?php echo $serie['id']; ?>" class="delete" onclick="return confirm('Excluir esta série?')">Excluir</a>
                        <?php if($serie['status'] == 'Disponível'): ?>
                            <a href="index.php?acao=comprar&id=<?php echo $serie['id']; ?>" class="buy">Comprar</a>
                            <a href="index.php?acao=alugar&id=<?php echo $serie['id']; ?>" class="rent">Alugar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</body>
</html