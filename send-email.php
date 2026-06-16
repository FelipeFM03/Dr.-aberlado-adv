<?php
// ── INCLUIR CONFIGURAÇÃO ──
require_once 'config-email.php';

// ── HEADER PARA JSON ──
header('Content-Type: application/json; charset=UTF-8');

// ── VALIDAÇÃO DE MÉTODO ──
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

// ── SANITIZAR INPUTS ──
$fullName = trim(htmlspecialchars($_POST['fullName'] ?? '', ENT_QUOTES, 'UTF-8'));
$phone = trim(htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8'));
$email = trim(htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'));
$caseType = trim(htmlspecialchars($_POST['caseType'] ?? '', ENT_QUOTES, 'UTF-8'));
$message = trim(htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8'));

// ── VALIDAÇÃO DE CAMPOS ──
$errors = [];

if (empty($fullName) || strlen($fullName) < MIN_NAME_LENGTH) {
    $errors[] = "Nome deve ter pelo menos " . MIN_NAME_LENGTH . " caracteres";
}

if (empty($phone) || strlen($phone) < 10) {
    $errors[] = "Telefone inválido";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "E-mail inválido";
}

if (empty($caseType)) {
    $errors[] = "Selecione um tipo de caso";
}

if (empty($message) || strlen($message) < MIN_MESSAGE_LENGTH) {
    $errors[] = "Mensagem deve ter pelo menos " . MIN_MESSAGE_LENGTH . " caracteres";
}

if (strlen($message) > MAX_MESSAGE_LENGTH) {
    $errors[] = "Mensagem muito longa (máximo " . MAX_MESSAGE_LENGTH . " caracteres)";
}

// ── RETORNAR ERROS ──
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => implode('; ', $errors)
    ]);
    exit;
}

// ── CONSTRUIR EMAIL ──
$subject = "Novo contato: " . $caseType;

$emailBody = "
===========================================
NOVO CONTATO - ABELARDO CARDOSO ADVOCACIA
===========================================

DADOS DO CLIENTE:
-----------
Nome: {$fullName}
E-mail: {$email}
Telefone: {$phone}

TIPO DE CASO:
-----------
{$caseType}

MENSAGEM:
-----------
{$message}

===========================================
Recebido em: " . date('d/m/Y H:i:s', time()) . " (Horário de Brasília)
IP do cliente: " . $_SERVER['REMOTE_ADDR'] . "
===========================================
";

// ── HEADERS DO EMAIL ──
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/plain; charset=UTF-8" . "\r\n";
$headers .= "From: " . $email . " (" . $fullName . ")" . "\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "X-Mailer: Abelardo Cardoso Website" . "\r\n";

// ── ENVIAR EMAIL PARA EMPRESA ──
try {
    $mailSent = false;
    
    if (MAIL_METHOD === 'smtp' && function_exists('fsockopen')) {
        // ── MÉTODO SMTP (mais confiável) ──
        $mailSent = sendViaSMTP($email, $fullName, $subject, $emailBody, $headers);
    } else {
        // ── MÉTODO PHP MAIL (fallback) ──
        $mailSent = @mail(COMPANY_EMAIL, $subject, $emailBody, $headers);
    }
    
    if ($mailSent) {
        // ── ENVIAR EMAIL DE CONFIRMAÇÃO PARA O CLIENTE ──
        $confirmSubject = "Recebemos seu contato - Abelardo Cardoso Advocacia";
        
        $confirmBody = "Olá {$fullName},

Obrigado por entrar em contato conosco!

Recebemos sua mensagem sobre: {$caseType}

Nossa equipe analisará seu caso e retornará em breve.
Enquanto isso, você também pode nos contatar pelo WhatsApp:
📱 (91) 9.8734-5606
📧 abelardocardoso.trabalhista@gmail.com

Atenciosamente,
Abelardo Cardoso
Advocacia Trabalhista
Ananindeua - PA
";
        
        $confirmHeaders = "MIME-Version: 1.0" . "\r\n";
        $confirmHeaders .= "Content-type: text/plain; charset=UTF-8" . "\r\n";
        $confirmHeaders .= "From: " . COMPANY_EMAIL . " (" . COMPANY_NAME . ")" . "\r\n";
        
        @mail($email, $confirmSubject, $confirmBody, $confirmHeaders);
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => MSG_SUCCESS
        ]);
    } else {
        throw new Exception('Falha ao enviar email');
    }
    
} catch (Exception $e) {
    error_log("Email Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => MSG_ERROR_SEND
    ]);
}

// ── FUNÇÃO PARA ENVIAR VIA SMTP ──
function sendViaSMTP($replyTo, $replyToName, $subject, $body, $headers) {
    try {
        $host = SMTP_HOST;
        $port = SMTP_PORT;
        $user = SMTP_USER;
        $pass = SMTP_PASS;
        $from = SMTP_FROM;
        $to = COMPANY_EMAIL;

        $connection = fsockopen($host, $port, $errno, $errstr, 10);
        if (!$connection) {
            error_log("SMTP Connection failed: {$errno} - {$errstr}");
            return false;
        }

        // Autenticação SMTP simples via socket
        $server = fgets($connection, 515);
        fputs($connection, "EHLO localhost\r\n");
        $server = fgets($connection, 515);
        while (substr($server, 3, 1) != ' ') {
            $server = fgets($connection, 515);
        }

        fputs($connection, "STARTTLS\r\n");
        $server = fgets($connection, 515);
        if (substr($server, 0, 3) !== '220') {
            error_log("SMTP STARTTLS failed: {$server}");
            fclose($connection);
            return false;
        }

        stream_socket_enable_crypto($connection, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);

        fputs($connection, "EHLO localhost\r\n");
        $server = fgets($connection, 515);
        while (substr($server, 3, 1) != ' ') {
            $server = fgets($connection, 515);
        }

        fputs($connection, "AUTH LOGIN\r\n");
        $server = fgets($connection, 515);
        if (substr($server, 0, 3) !== '334') {
            error_log("SMTP AUTH failed: {$server}");
            fclose($connection);
            return false;
        }

        fputs($connection, base64_encode($user) . "\r\n");
        $server = fgets($connection, 515);
        fputs($connection, base64_encode($pass) . "\r\n");
        $server = fgets($connection, 515);
        if (substr($server, 0, 3) !== '235') {
            error_log("SMTP login failed: {$server}");
            fclose($connection);
            return false;
        }

        fputs($connection, "MAIL FROM: <{$from}>\r\n");
        $server = fgets($connection, 515);
        fputs($connection, "RCPT TO: <{$to}>\r\n");
        $server = fgets($connection, 515);
        fputs($connection, "DATA\r\n");
        $server = fgets($connection, 515);

        $headersString = "From: " . COMPANY_NAME . " <{$from}>\r\n" .
                         "Reply-To: {$replyTo}\r\n" .
                         "MIME-Version: 1.0\r\n" .
                         "Content-Type: text/plain; charset=UTF-8\r\n" .
                         "X-Mailer: Abelardo Cardoso Website\r\n";

        $message = "Subject: {$subject}\r\n" . $headersString . "\r\n" . $body . "\r\n.\r\n";
        fputs($connection, $message);
        $server = fgets($connection, 515);

        fputs($connection, "QUIT\r\n");
        fclose($connection);

        return substr($server, 0, 3) === '250';

    } catch (Exception $e) {
        error_log("SMTP Exception: " . $e->getMessage());
        return false;
    }
}

exit;
?>
