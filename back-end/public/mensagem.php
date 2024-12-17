<?php
include 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aluno_id = $_SESSION['usuario_id'];
    $personal_id = $_POST['personal_id'];
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];

    $sql = "INSERT INTO mensagens (aluno_id, personal_id, assunto, mensagem) 
            VALUES (:aluno_id, :personal_id, :assunto, :mensagem)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':aluno_id', $aluno_id);
    $stmt->bindParam(':personal_id', $personal_id);
    $stmt->bindParam(':assunto', $assunto);
    $stmt->bindParam(':mensagem', $mensagem);

    if ($stmt->execute()) {
        echo "Mensagem enviada com sucesso!";
    } else {
        echo "Erro ao enviar a mensagem.";
    }
}
?>

<form action="mensagem.php" method="POST">
    <select name="personal_id" required>
        <?php
        $sql = "SELECT id, nome FROM personal_trainers";
        foreach ($conn->query($sql) as $row) {
            echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
        }
        ?>
    </select><br>
    <input type="text" name="assunto" placeholder="Assunto" required><br>
    <textarea name="mensagem" placeholder="Mensagem" required></textarea><br>
    <button type="submit">Enviar Mensagem</button>
</form>
