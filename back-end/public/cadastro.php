<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $idade = $_POST['idade'];
    $sexo = $_POST['sexo'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $objetivo = $_POST['objetivo'];
    $descricao_objetivo = $_POST['descricao_objetivo'];

    $sql = "INSERT INTO usuarios (nome, email, senha, idade, sexo, altura, peso, objetivo, descricao_objetivo)
            VALUES (:nome, :email, :senha, :idade, :sexo, :altura, :peso, :objetivo, :descricao_objetivo)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':idade', $idade);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':altura', $altura);
    $stmt->bindParam(':peso', $peso);
    $stmt->bindParam(':objetivo', $objetivo);
    $stmt->bindParam(':descricao_objetivo', $descricao_objetivo);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao realizar o cadastro.";
    }
}
?>

<form action="cadastro.php" method="POST">
    <input type="text" name="nome" placeholder="Nome" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <input type="number" name="idade" placeholder="Idade" required><br>
    <select name="sexo" required>
        <option value="M">Masculino</option>
        <option value="F">Feminino</option>
    </select><br>
    <input type="text" name="altura" placeholder="Altura (em metros)" required><br>
    <input type="text" name="peso" placeholder="Peso (em kg)" required><br>
    <input type="text" name="objetivo" placeholder="Objetivo do Treino" required><br>
    <textarea name="descricao_objetivo" placeholder="Descrição do Objetivo"></textarea><br>
    <button type="submit">Cadastrar</button>
</form>
