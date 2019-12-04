<?php

// configure
$from = 'Contato Site <contato@ucarealergia.com.br';
$sendTo = 'jefferson.fernandes@outlook.com';
$subject = 'Nova mensagem do formulario de contato do site!';
$fields = array('name' => 'Name', 'email' => 'Email', 'message' => 'Message'); // array variable name => Text to appear in the email
$okMessage = 'Obrigado pela sua mensagem, logo lhe responderemos.';
$errorMessage = 'Ocorreu um erro ao enviar o e-mail, por favor tente novamente.';

// let's do the sending

try
{
    $emailText = nl2br("Você tem uma nova mensagem do formulario de contato do site!\n");

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= nl2br("$fields[$key]: $value\n");
        }
    }

    $headers = array('Content-Type: text/html; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
