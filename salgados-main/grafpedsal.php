<?php
    include 'conecta.php';
    $sql = "SELECT 
                s.nome, 
                SUM(ip.quantidade) AS total_vendido 
            FROM salgados AS s 
            INNER JOIN pedidos_salgados AS ip ON s.id = ip.id_salgado 
            GROUP BY s.id, s.nome 
            ORDER BY total_vendido DESC";
    $resultado = $conn->query($sql);
    $dados_grafico = [['Salgado', 'Quantidade Vendida']];
    if ($resultado && $resultado->num_rows > 0) {
        while($linha = $resultado->fetch_assoc()) {
            $dados_grafico[] = [$linha['nome'], (int)$linha['total_vendido']];
        }
    }
    $conn->close();
    $dados_json = json_encode($dados_grafico);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gráfico de Salgados Mais Vendidos</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable(<?php echo $dados_json; ?>);
            var options = {
                width: 300, 
                height: 150,
                legend: { position: 'none' }
            };
            var chart = new google.visualization.BarChart(document.getElementById('grafico_salgados'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="grafico_salgados" style="width: 300px; height: 150px;"></div>
</body>
</html>