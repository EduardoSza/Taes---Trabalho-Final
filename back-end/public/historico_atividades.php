<?php
include 'conexao.php';
session_start();

$aluno_id = $_SESSION['usuario_id'];

$sql = "SELECT a.tipo_exercicio, a.series, a.repeticoes, a.tempo_minutos, a.intensidade, ha.data_execucao 
        FROM atividades a 
        JOIN historico_atividades ha ON a.id = ha.atividade_id 
        WHERE ha.aluno_id = :aluno_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':aluno_id', $aluno_id);
$stmt->execute();

$atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h1>Histórico de Atividades</h1>";
foreach ($atividades as $atividade) {
    echo "<p>Exercício: " . $atividade['tipo_exercicio'] . "<br>
            Séries: " . $atividade['series'] . "<br>
            Repetições: " . $atividade['repeticoes'] . "<br>
            Tempo: " . $atividade['tempo_minutos'] . " minutos<br>
            Intensidade: " . $atividade['intensidade'] . "<br>
            Data: " . $atividade['data_execucao'] . "</p>";
}
?>
