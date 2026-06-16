# 📧 Configuração de Envio de Email - Abelardo Cardoso

## ✅ Rápido e Fácil - Método Recomendado

### Opção 1: Usar Gmail (RECOMENDADO - Mais Fácil)

Se você usa **Gmail**, siga estes passos simples:

#### **Passo 1: Gerar Senha de App**
1. Acesse: https://myaccount.google.com/apppasswords
2. Selecione:
   - Dispositivo: **Windows PC** (ou seu dispositivo)
   - Aplicativo: **Email**
3. Copie a senha gerada (16 caracteres)

#### **Passo 2: Configurar o arquivo `config-email.php`**

Abra o arquivo `config-email.php` e preencha:

```php
// Seu email Gmail
define('SMTP_USER', 'seu_email@gmail.com');

// Senha de app gerada no passo anterior
define('SMTP_PASS', 'xxxx xxxx xxxx xxxx');

// Email de origem (pode ser o mesmo)
define('SMTP_FROM', 'seu_email@gmail.com');

// Deixe como smtp
define('MAIL_METHOD', 'smtp');
```

#### **Passo 3: Pronto!**
O formulário agora enviará emails automaticamente para: `abelardocardoso.trabalhista@gmail.com`

---

## 🔄 Método Alternativo: Usar Hosting Web

Se você usar um **serviço de hosting web** (como Hostinger, HostGator, etc.):

1. Seu servidor provavelmente já tem `mail()` configurado
2. Basta deixar em `config-email.php`:
```php
define('MAIL_METHOD', 'php');
```
3. Os emails serão enviados automaticamente

---

## 🐳 Método Profissional: Docker (Para Produção)

Se quiser usar um **servidor SMTP dedicado**:

### Opção A: SendGrid (Gratuito até 100 emails/dia)
1. Cadastre-se em: https://sendgrid.com
2. Gere uma API Key
3. Configure em `config-email.php` os dados do SendGrid

### Opção B: Amazon SES (Muito barato)
1. Cadastre-se em: https://aws.amazon.com/ses/
2. Configure em `config-email.php` com as credenciais AWS

---

## 📝 Campos Disponíveis no `config-email.php`

```php
// Email onde você RECEBE as mensagens
COMPANY_EMAIL = 'abelardocardoso.trabalhista@gmail.com'

// Nome que aparece como remetente
COMPANY_NAME = 'Abelardo Cardoso - Advocacia Trabalhista'

// Método: 'php' ou 'smtp'
MAIL_METHOD = 'php'

// Credenciais SMTP (se usar 'smtp')
SMTP_HOST = 'smtp.gmail.com'
SMTP_PORT = 587
SMTP_USER = 'seu_email@gmail.com'
SMTP_PASS = 'sua_senha_app'
SMTP_FROM = 'seu_email@gmail.com'
```

---

## 🔒 Segurança

⚠️ **IMPORTANTE:**
- Nunca compartilhe seu `config-email.php` em repositórios públicos
- Adicione a linha ao `.gitignore`:
  ```
  config-email.php
  ```
- A senha de app é segura e pode ser revogada a qualquer momento

---

## ✅ Testar o Envio

1. Abra seu site localmente: `http://localhost/Dr-aberlado-adv/`
2. Vá até a seção **Contato**
3. Preencha o formulário
4. Clique em **"Enviar mensagem"**
5. Verifique seu email (pode levar 1-5 minutos)

---

## 🐛 Troubleshooting

### ❌ Mensagem: "Erro ao enviar mensagem"

**Possíveis soluções:**

1. **Verifique a senha de app:**
   - Confirme que copiou corretamente de: https://myaccount.google.com/apppasswords
   - Deve ter espaços a cada 4 caracteres

2. **Ative "Aplicativos menos seguros" (se necessário):**
   - https://myaccount.google.com/lesssecureapps

3. **Verifique sua conexão com a internet**

4. **Veja os logs:**
   - Abra seu browser (F12) → Aba Network
   - Veja a resposta do servidor em `send-email.php`

### ❌ Email não chega na caixa de entrada

1. Verifique a pasta **SPAM**
2. Adicione à lista de contatos permitidos
3. Confirme que o email está correto em `config-email.php`

---

## 📞 Suporte

Se tiver problemas:
1. Verifique o arquivo `config-email.php` novamente
2. Teste com um email diferente
3. Ative logs de erro do PHP

---

## ✨ Pronto!

Seu formulário agora:
✅ Envia emails para a empresa  
✅ Envia confirmação ao cliente  
✅ Valida dados antes de enviar  
✅ Mostra mensagem de sucesso/erro  

Boa sorte! 🚀
