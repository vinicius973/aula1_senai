<?php
    include 'conecta.php';
    $sql = "SELECT 
                c.cidade, 
                COUNT(p.id) AS numero_de_pedidos 
            FROM clientes AS c 
            INNER JOIN pedidos AS p ON c.id = p.id_cliente 
            GROUP BY c.cidade 
            ORDER BY numero_de_pedidos DESC";
    $resultado = $conn->query($sql);
    $dados_grafico = [['Cidade', 'Número de Pedidos']];
    if ($resultado && $resultado->num_rows > 0) {
        while($linha = $resultado->fetch_assoc()) {
            $dados_grafico[] = [$linha['cidade'], (int)$linha['numero_de_pedidos']];
        }
    }
    $conn->close();
    $dados_json = json_encode($dados_grafico);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pedidos por Cidade</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable(<?php echo $dados_json; ?>);
            var options = {
                width: 300,
                height: 200,
                is3D: true,
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="piechart_div" style="width: 300px; height: 200px;"></div>
</body>
</html>