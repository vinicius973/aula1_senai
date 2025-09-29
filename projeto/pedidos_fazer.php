<?php
  session_start();
  include 'conecta.php'; // Sua conexão com o banco
  if(!isset($_SESSION["user"]))
  {
    echo "<script language='javascript' type='text/javascript'> 
    window.location.href='index.php';
    </script>";
    exit;
  }

  // --- INÍCIO: BUSCAR DADOS DO BANCO ---
  
  // 1. Buscar todos os clientes
  $clientes = [];
  $query_clientes = mysqli_query($conn, "SELECT id, nome FROM clientes ORDER BY nome ASC");
  while($cliente = mysqli_fetch_assoc($query_clientes)) {
      $clientes[] = $cliente;
  }

  // 2. Buscar todos os salgados
  $salgados = [];
  $query_salgados = mysqli_query($conn, "SELECT id, nome, valor FROM salgados ORDER BY nome ASC");
  while($salgado = mysqli_fetch_assoc($query_salgados)) {
      $salgados[] = $salgado;
  }

  // --- FIM: BUSCAR DADOS DO BANCO ---
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="content-language" content="pt-br">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SALGADINHOS DA MAMÃE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style> 
        /* Seus estilos aqui... (mantive os que você já tinha) */
        .main-header { display: flex; justify-content: space-between; align-items: center; padding: 15px 10px; }
        .user-info { display: flex; align-items: center; gap: 8px; color: gray; }
        .username { font-weight: bold; }
        .logout-link { color: red; font-weight: bold; text-decoration: none; }
        .logout-link:hover { text-decoration: underline; }
    </style>
  </head>
  <body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> 
    
    <header class="main-header">
      <h2 class="main-title">SALGADINHOS DA MARIA</h2>
      <div class="user-info">
        <?php
        if (!empty($_SESSION["user"])) {
            $usuario = $_SESSION["user"];
            echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-square' viewBox='0 0 16 16'><path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'/><path d='M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z'/></svg>"
            . "<span class='username'>" . htmlspecialchars($usuario) . " | </span>"
            . "<a class='logout-link' href='sair.php'> Sair</a>";
        }
        ?>
      </div>
    </header>
    <hr>
    <nav>
      <?php include 'menu.php'; ?>
    </nav>
    <br>
    <br>
    <div class="container"> <div class="row justify-content-center">
        <div class="col-lg-10"> <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
              <h4 class="my-0 fw-normal"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="brown" class="bi bi-cart-check" viewBox="0 0 16 16"><path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/><path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>&nbsp;&nbsp;<b>REALIZAR PEDIDO</b></h4>
            </div>
            <div class="card-body">
              
              <form id="form-pedido" method="POST" action="processa_pedido.php">
                
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="cliente" class="form-label">Cliente</label>
                    <select id="cliente" name="id_cliente" class="form-select" required>
                      <option value="">Selecione um cliente...</option>
                      <?php foreach ($clientes as $cliente): ?>
                        <option value="<?php echo $cliente['id']; ?>"><?php echo htmlspecialchars($cliente['nome']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="data_entrega" class="form-label">Data de Entrega</label>
                    <input type="date" id="data_entrega" name="data_entrega" class="form-control" required>
                  </div>
                </div>
                
                <hr>
                
                <h5 class="mb-3">Adicionar Itens ao Pedido</h5>
                <div class="row align-items-end g-3">
                  <div class="col-md-6">
                    <label for="salgado" class="form-label">Salgado</label>
                    <select id="salgado" class="form-select">
                      <option data-valor="0" value="">Selecione um salgado...</option>
                      <?php foreach ($salgados as $salgado): ?>
                        <option value="<?php echo $salgado['id']; ?>" data-valor="<?php echo $salgado['valor']; ?>">
                          <?php echo htmlspecialchars($salgado['nome']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" id="quantidade" class="form-control" min="1" placeholder="Ex: 50">
                  </div>
                  <div class="col-md-3">
                    <button type="button" id="btn-adicionar" class="btn btn-primary w-100">Adicionar</button>
                  </div>
                </div>

                <hr>

                <h5 class="mt-4">Itens do Pedido</h5>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Salgado</th>
                      <th width="120px">Quantidade</th>
                      <th width="150px">Valor Unit.</th>
                      <th width="150px">Subtotal</th>
                      <th width="80px">Ação</th>
                    </tr>
                  </thead>
                  <tbody id="tabela-itens">
                    </tbody>
                  <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>TOTAL DO PEDIDO:</strong></td>
                        <td colspan="2"><strong id="total-pedido">R$ 0,00</strong></td>
                    </tr>
                  </tfoot>
                </table>

                <input type="hidden" name="itens_pedido" id="itens_pedido">

                <div class="d-grid gap-2 mt-4">
                  <button type="submit" class="btn btn-success btn-lg">FINALIZAR PEDIDO</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      $(document).ready(function() {

        // Função para atualizar o total do pedido
        function atualizarTotal() {
          let total = 0;
          $('#tabela-itens tr').each(function() {
            // Pega o valor do subtotal de cada linha e soma ao total
            total += parseFloat($(this).data('subtotal'));
          });
          // Formata como moeda brasileira e exibe na tela
          $('#total-pedido').text('R$ ' + total.toFixed(2).replace('.', ','));
        }

        // Ação ao clicar no botão "Adicionar"
        $('#btn-adicionar').on('click', function() {
          let salgadoSelect = $('#salgado');
          let salgadoId = salgadoSelect.val();
          let salgadoNome = salgadoSelect.find('option:selected').text().trim();
          let salgadoValor = parseFloat(salgadoSelect.find('option:selected').data('valor'));
          let quantidade = parseInt($('#quantidade').val());

          // Validação simples
          if (!salgadoId) {
            alert('Por favor, selecione um salgado.');
            return;
          }
          if (isNaN(quantidade) || quantidade <= 0) {
            alert('Por favor, informe uma quantidade válida.');
            return;
          }

          let subtotal = salgadoValor * quantidade;

          // Cria a nova linha da tabela com os dados
          // Usamos data attributes para guardar os valores que enviaremos ao PHP
          let novaLinha = `
            <tr data-id="${salgadoId}" data-quantidade="${quantidade}" data-subtotal="${subtotal}">
              <td>${salgadoNome}</td>
              <td>${quantidade}</td>
              <td>R$ ${salgadoValor.toFixed(2).replace('.', ',')}</td>
              <td>R$ ${subtotal.toFixed(2).replace('.', ',')}</td>
              <td><button type="button" class="btn btn-danger btn-sm btn-remover">Remover</button></td>
            </tr>
          `;

          // Adiciona a linha na tabela
          $('#tabela-itens').append(novaLinha);
          
          // Limpa os campos para a próxima inserção
          $('#salgado').val('');
          $('#quantidade').val('');
          
          // Atualiza o valor total
          atualizarTotal();
        });

        // Ação para o botão "Remover" de qualquer linha (delegação de evento)
        $('#tabela-itens').on('click', '.btn-remover', function() {
          // Remove a linha pai (tr) do botão clicado
          $(this).closest('tr').remove();
          // Atualiza o total após remover
          atualizarTotal();
        });
        
        // Ação ao submeter o formulário principal
        $('#form-pedido').on('submit', function(event) {
          // Verifica se há pelo menos um item no pedido
          if ($('#tabela-itens tr').length === 0) {
            alert('Você precisa adicionar pelo menos um item ao pedido antes de finalizar!');
            event.preventDefault(); // Impede o envio do formulário
            return;
          }

          // Coleta os dados de todas as linhas da tabela
          let itens = [];
          $('#tabela-itens tr').each(function() {
            let item = {
              id_salgado: $(this).data('id'),
              quantidade: $(this).data('quantidade'),
              subtotal: $(this).data('subtotal')
            };
            itens.push(item);
          });
          
          // Coloca os dados coletados (em formato JSON) no campo hidden para serem enviados
          $('#itens_pedido').val(JSON.stringify(itens));
        });

      });
    </script>
    </body>
</html>