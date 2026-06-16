<?php
// ════════════════════════════════════════════════════════════
// CONFIGURAÇÃO DE EMAIL - ABELARDO CARDOSO
// ════════════════════════════════════════════════════════════
// 
// ⚠️ IMPORTANTE: Configure os valores abaixo
//
// ════════════════════════════════════════════════════════════

// ── Email da empresa (onde receberá as mensagens) ──
define('COMPANY_EMAIL', 'felipemonteiro121103@gmail.com');
define('COMPANY_NAME', 'Abelardo Cardoso - Advocacia Trabalhista');

// ── Método de envio ──
// Opções: 'php' (usa mail() do servidor) ou 'smtp' (recomendado)
define('MAIL_METHOD', 'smtp');

// ── CONFIGURAÇÃO SMTP (caso use MAIL_METHOD = 'smtp') ──
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'felipemonteiro121103@gmail.com');      // ← CONFIGURE SEU EMAIL
define('SMTP_PASS', 'wytk uyof kkem umcl');             // ← CONFIGURE SUA SENHA
define('SMTP_FROM', 'felipemonteiro121103@gmail.com');       // ← CONFIGURE SEU EMAIL

// ── VALIDAÇÃO ──
define('MIN_NAME_LENGTH', 3);
define('MIN_MESSAGE_LENGTH', 10);
define('MAX_MESSAGE_LENGTH', 5000);

// ── MENSAGENS ──
define('MSG_SUCCESS', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
define('MSG_ERROR_SEND', 'Erro ao enviar mensagem. Tente novamente mais tarde ou use WhatsApp.');
define('MSG_ERROR_INVALID', 'Por favor, verifique os dados e tente novamente.');

?>
