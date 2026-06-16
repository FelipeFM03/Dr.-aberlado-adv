<?php
// ════════════════════════════════════════════════════════════
// EXEMPLO DE CONFIGURAÇÃO PARA GMAIL
// ════════════════════════════════════════════════════════════
// 
// 📌 INSTRUÇÕES:
// 1. Copie este arquivo e renomeie para: config-email.php
// 2. Preencha com seus dados (veja comentários abaixo)
// 3. Salve o arquivo
// 4. Pronto! O formulário funcionará
//
// ════════════════════════════════════════════════════════════

// ── Email da empresa (onde você RECEBERÁ as mensagens) ──
// 📧 Mude para seu email Gmail ou de trabalho
define('COMPANY_EMAIL', 'abelardocardoso.trabalhista@gmail.com');
define('COMPANY_NAME', 'Abelardo Cardoso - Advocacia Trabalhista');

// ── Método de envio ──
// 'php' = usar função mail() do servidor (mais simples)
// 'smtp' = usar Gmail ou outro servidor SMTP (mais confiável)
// 👉 Deixe como 'php' se você estiver em um hosting
define('MAIL_METHOD', 'php');

// ── CONFIGURAÇÃO SMTP (para usar com Gmail) ──
// Se MAIL_METHOD = 'smtp', preencha os dados abaixo:

// 1️⃣ Seu email Gmail
define('SMTP_USER', 'seu_email@gmail.com');

// 2️⃣ Senha de app gerada em: https://myaccount.google.com/apppasswords
// ⚠️ NÃO é sua senha normal do Gmail!
define('SMTP_PASS', 'xxxx xxxx xxxx xxxx');

// 3️⃣ Email que aparecerá como remetente (pode ser o mesmo)
define('SMTP_FROM', 'seu_email@gmail.com');

// 4️⃣ Servidor SMTP (já pré-configurado para Gmail)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);

// ── VALIDAÇÃO ──
define('MIN_NAME_LENGTH', 3);
define('MIN_MESSAGE_LENGTH', 10);
define('MAX_MESSAGE_LENGTH', 5000);

// ── MENSAGENS ──
define('MSG_SUCCESS', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
define('MSG_ERROR_SEND', 'Erro ao enviar mensagem. Tente novamente mais tarde ou use WhatsApp.');
define('MSG_ERROR_INVALID', 'Por favor, verifique os dados e tente novamente.');

// ════════════════════════════════════════════════════════════
// 📚 DIFERENTES SERVIDORES SMTP
// ════════════════════════════════════════════════════════════
//
// GMAIL:
//   Host: smtp.gmail.com
//   Port: 587
//   User: seu_email@gmail.com
//   Pass: [Senha de App]
//
// HOTMAIL/OUTLOOK:
//   Host: smtp-mail.outlook.com
//   Port: 587
//   User: seu_email@outlook.com
//   Pass: sua_senha
//
// YAHOO:
//   Host: smtp.mail.yahoo.com
//   Port: 587
//   User: seu_email@yahoo.com
//   Pass: sua_senha_app
//
// ════════════════════════════════════════════════════════════

?>
