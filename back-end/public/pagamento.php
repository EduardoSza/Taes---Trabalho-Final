<?php
include 'conexao.php';
session_start();

// Carregar o SDK do PayPal
require __DIR__ . '/vendor/autoload.php';

// Configuração do PayPal
$clientId = 'YOUR_PAYPAL_CLIENT_ID';
$secret = 'YOUR_PAYPAL_SECRET';

// Criação do objeto de pagamento
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential($clientId, $secret)
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aluno_id = $_SESSION['usuario_id'];
    $valor = $_POST['valor'];

    // Criando uma transação no PayPal
    $payment = new \PayPal\Api\Payment();
    $payment->setIntent('sale')
            ->setPayer(new \PayPal\Api\Payer('paypal'))
            ->setTransactions([new \PayPal\Api\Transaction([
                'amount' => new \PayPal\Api\Amount('{
                    "total": "' . $valor . '",
                    "currency": "BRL"
                }'),
                'description' => 'Pagamento pelo serviço'
            ])])
            ->setRedirectUrls(new \PayPal\Api\RedirectUrls([
                'return_url' => 'http://localhost/portal_vida_saudavel/retorno_pagamento.php',
                'cancel_url' => 'http://localhost/portal_vida_saudavel/cancelamento_pagamento.php'
            ]));

    try {
        // Criar o pagamento
        $payment->create($apiContext);

        // Redirecionar para a página do PayPal
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                header("Location: " . $link->getHref());
                exit;
            }
        }
    } catch (Exception $e) {
        echo "Erro no pagamento: " . $e->getMessage();
    }
}
?>

<form action="pagamento.php" method="POST">
    <input type="number" name="valor" placeholder="Valor do Pagamento" required><br>
    <button type="submit">Pagar com PayPal</button>
</form>
