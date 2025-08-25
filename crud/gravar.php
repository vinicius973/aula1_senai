<?php
$json_file = 'series.json';

// Função para ler JSON
function ler_series($json_file) {
    if (!file_exists($json_file)) {
        file_put_contents($json_file, json_encode([]));
    }
    $json = file_get_contents($json_file);
    return json_decode($json, true);
}

// Função para salvar JSON
function salvar_series($json_file, $series) {
    file_put_contents($json_file, json_encode($series, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Verifica se veio via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $series = ler_series($json_file);

    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $email = $_POST['email'] ?? '';
    $preco_compra = isset($_POST['preco_compra']) ? (float) $_POST['preco_compra'] : 0;
    $preco_aluguel = isset($_POST['preco_aluguel']) ? (float) $_POST['preco_aluguel'] : 0;
    $status = $_POST['status'] ?? 'Disponível';

    if (!empty($_POST['id'])) {
        // Atualizar série existente
        $id_para_atualizar = $_POST['id'];
        foreach ($series as $indice => $serie) {
            if ($serie['id'] == $id_para_atualizar) {
                $series[$indice] = [
                    'id' => $id_para_atualizar,
                    'nome' => $nome,
                    'telefone' => $telefone,
                    'titulo' => $titulo,
                    'genero' => $genero,
                    'email' => $email,
                    'preco_compra' => $preco_compra,
                    'preco_aluguel' => $preco_aluguel,
                    'status' => $status
                ];
                break;
            }
        }
    } else {
        // Criar nova série
        $nova_serie = [
            'id' => uniqid(),
            'nome' => $titulo,
            'telefone' => $genero,
            'titulo' => $ano,
            'genero' => $plataforma,
            'email' => $email,
            'preco_compra' => $preco_compra,
            'preco_aluguel' => $preco_aluguel,
            'status' => $status
        ];
        $series[] = $nova_serie;
    }

    salvar_series($json_file, $series);

    // Redireciona para a página principal
    header('Location: index.php');
    exit;
}
?>