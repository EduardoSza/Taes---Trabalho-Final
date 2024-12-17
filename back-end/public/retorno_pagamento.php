<?php
include 'conexao.php';
session_start();

// Carregar o SDK do PayPal
require __DIR__ . '/vendor/autoload.php';

// Configuração do PayPal
$clientId = 'YOUR_PAYPAL_CLIENT_ID';
$secret = 'YOUR_PAYPAL_SECRET';

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential($clientId, $secret)
);

if (isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
    $paymentId = $_GET['paymentId'];
    $payerId = $_GET['PayerID'];

    $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
    $execution = new \PayPal\Api\PaymentExecution();
    $execution->setPayerId($payerId);

    try {
        $result = $payment->execute($execution, $apiContext);

        // Registrar o pagamento no banco de dados
        $aluno_id = $_SESSION['usuario_id'];
        $numero_transacao = $result->getId();
        $valor = $_POST['valor']; // Pode vir de um campo escondido ou da sessão
        $metodo_pagamento = "PayPal";

        $sql = "INSERT INTO pagamentos (aluno_id, numero_transacao, valor, metodo_pagamento) 
                VALUES (:aluno_id, :numero_transacao, :valor, :metodo_pagamento)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':aluno_id', $aluno_id);
        $stmt->bindParam(':numero_transacao', $numero_transacao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':metodo_pagamento', $metodo_pagamento);
        
        if ($stmt->execute()) {
            echo "Pagamento realizado com sucesso!";
        } else {
            echo "Erro ao registrar pagamento.";
        }
    } catch (Exception $e) {
        echo "Erro na execução do pagamento: " . $e->getMessage();
    }
}
?>
