<?php
include 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aluno_id = $_POST['aluno_id'];
    $personal_id = $_SESSION['usuario_id'];
    $objetivo = $_POST['objetivo'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    $sql = "INSERT INTO treinos (aluno_id, personal_id, objetivo, data_inicio, data_fim) 
            VALUES (:aluno_id, :personal_id, :objetivo, :data_inicio, :data_fim)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':aluno_id', $aluno_id);
    $stmt->bindParam(':personal_id', $personal_id);
    $stmt->bindParam(':objetivo', $objetivo);
    $stmt->bindParam(':data_inicio', $data_inicio);
    $stmt->bindParam(':data_fim', $data_fim);

    if ($stmt->execute()) {
        echo "Treino cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o treino.";
    }
}
?>

<form action="gerenciar_treino.php" method="POST">
    <input type="number" name="aluno_id" placeholder="ID do Aluno" required><br>
    <input type="text" name="objetivo" placeholder="Objetivo do Treino" required><br>
    <input type="date" name="data_inicio" required><br>
    <input type="date" name="data_fim" required><br>
    <button type="submit">Cadastrar Treino</button>
</form>
