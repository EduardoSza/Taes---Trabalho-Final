<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];
    $cref = $_POST['cref'];
    $link_contato = $_POST['link_contato'];

    $sql = "INSERT INTO personal_trainers (nome, especialidade, cref, link_contato) 
            VALUES (:nome, :especialidade, :cref, :link_contato)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':especialidade', $especialidade);
    $stmt->bindParam(':cref', $cref);
    $stmt->bindParam(':link_contato', $link_contato);

    if ($stmt->execute()) {
        echo "Personal Trainer cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o Personal Trainer.";
    }
}
?>

<form action="cadastro_personal.php" method="POST">
    <input type="text" name="nome" placeholder="Nome" required><br>
    <input type="text" name="especialidade" placeholder="Especialidade"><br>
    <input type="text" name="cref" placeholder="CREF" required><br>
    <input type="url" name="link_contato" placeholder="Link para contato"><br>
    <button type="submit">Cadastrar Personal Trainer</button>
</form>
