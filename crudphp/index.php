<?php
    session_start();
    if (!isset($_SESSION['pessoas'])) {
        $_SESSION['pessoas'] = [];
    }
    $id_edicao = null;
    $nome_edicao = '';
    $email_edicao = '';
    $celular_edicao = '';
    $modo_edicao = false;
    //coração do CRUD
    //DELETE via GET
    if (isset($_GET['acao']) && $_GET['acao'] == 'deletar' && isset($_GET['id'])) {
        $id_para_deletar = $_GET['id'];
        foreach ($_SESSION['pessoas'] as $indice => $pessoa) {
            if ($pessoa['id'] == $id_para_deletar) {
                unset($_SESSION['pessoas'][$indice]);
                break;
            }
        }
        header('Location: index.php');
        exit;
    }
    //Preparar a edição
    if (isset($_GET['acao']) && $_GET['acao'] == 'editar' && isset($_GET['id'])) {
        $id_para_editar = $_GET['id'];
        foreach ($_SESSION['pessoas'] as $pessoa) {
            if ($pessoa['id'] == $id_para_editar) {
                $id_edicao = $pessoa['id'];
                $nome_edicao = $pessoa['nome'];
                $email_edicao = $pessoa['email'];
                $celular_edicao = $pessoa['celular'];
                $modo_edicao = true; //ativa a edicao no form
                break;
            }
        }
    }
    //criar e atualizar via POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $celular = $_POST['celular'];
        //atualizar
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id_para_atualizar = $_POST['id'];
            foreach ($_SESSION['pessoas'] as $indice => $pessoa) {
                if ($pessoa['id'] == $id_para_atualizar) {
                    $_SESSION['pessoas'][$indice]['nome'] = $nome;
                    $_SESSION['pessoas'][$indice]['email'] = $email;
                    $_SESSION['pessoas'][$indice]['celular'] = $celular;
                    break;
                }
            }
        }
        //criar
        else {
            $nova_pessoa = [
                'id' => uniqid(),
                'nome' => $nome,
                'email' => $email,
                'celular' => $celular
            ];
            $_SESSION['pessoas'][] = $nova_pessoa;
        }
        header('Location: index.php');
        exit;
    }
?>
<DOCTYPE html>
    <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>CRUD - PHP/Array</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1, h2 {color: #333; }
                .container { max-width: 800px; margin: auto; }
                form { margin-bottom: 20px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
                form div { margin-bottom: 10px; }
                label { display: block; margin-bottom: 5px; }
                input[type="text"], input[type="email"] { width: calc(100% - 16px); padding: 8px; border: 1px solid #ccc; border-radius: 3px; }
                button { padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 3px; cursor: pointer; }
                button.update { background-color: #007bff; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                a { color: #007bff; text-decoration: none; }
                a.delete { color: #dc3545; margin-left: 10px; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>CADASTRO DE PESSOAS</h1>
                <form action="index.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id_edicao; ?>">
                    <div>
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome_edicao); ?>" required>
                    </div>
                    <div>
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email_edicao); ?>" required>
                    </div>
                    <div>
                        <label for="celular">Celular:</label>
                        <input type="text" id="celular" name="celular" value="<?php echo htmlspecialchars($celular_edicao); ?>" required>
                    </div>
                    <div>
                        <?php if ($modo_edicao): ?>
                            <button type="submit" class="update">Atualizar pessoa</button>
                        <?php else: ?>
                            <button type="submit">Adicionar pessoa</button>
                        <?php endif; ?>
                    </div>
                </form>
                <a href="gravar.php">Gravar dados...</a>
                <h2>Pessoas Cadastradas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Celular</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($_SESSION['pessoas'])): ?>
                            <tr>
                                <td colspan="4">Nenhuma pessoa cadastrada!</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($_SESSION['pessoas'] as $pessoa): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pessoa['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($pessoa['email']); ?></td>
                                    <td><?php echo htmlspecialchars($pessoa['celular']); ?></td>
                                    <td>
                                        <a href="index.php?acao=editar&id=<?php echo $pessoa['id']; ?>">Editar</a>
                                        <a href="index.php?acao=deletar&id=<?php echo $pessoa['id']; ?>" class="delete" onclick="return confirm('Tem certeza que deseja excluir esta pessoa?');">Deletar</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </body>
    </html>