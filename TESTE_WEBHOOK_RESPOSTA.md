# Teste de Resposta do Webhook - Agente IA

## Como Testar o Sistema de Resposta do Webhook

### 1. **Teste Manual na Interface**

1. Acesse: `http://localhost/dashboard/agente-ia`
2. Digite um texto ou faça upload de arquivos
3. Clique "Processar com IA"
4. Observe as seguintes informações na resposta:

#### **Indicadores Visuais de Status:**
- ✅ **Verde**: Webhook processou e retornou resultado
- ⚠️ **Amarelo**: Webhook recebeu mas não retornou resultado específico
- ❌ **Vermelho**: Erro na comunicação com webhook

#### **Informações Exibidas:**
- Badge colorido com status
- Resultado do processamento (se disponível)
- Tempo de processamento
- Tokens utilizados
- URL do webhook
- Status da comunicação

### 2. **Tipos de Resposta do Webhook**

#### **Resposta Ideal (com resultado):**
```json
{
  "result": "Texto traduzido/processado aqui...",
  "status": "success",
  "message": "Processamento concluído",
  "tokens_used": 150,
  "processing_time": "2.5s"
}
```

#### **Resposta Simples (confirmação):**
```json
{
  "status": "received",
  "message": "Dados recebidos para processamento"
}
```

#### **Resposta de Erro:**
```json
{
  "error": "Mensagem de erro",
  "status": "error"
}
```

### 3. **Teste com Script PHP**

Execute o script de teste:
```bash
php test_webhook.php
```

Este script envia dados simulados diretamente para o webhook e mostra a resposta.

### 4. **Verificação no Laravel**

#### **Logs da Aplicação:**
```bash
tail -f storage/logs/laravel.log
```

#### **Teste via API:**
```bash
curl -X POST http://localhost/api/agente-ia/process-text \
  -H "Content-Type: application/json" \
  -d '{
    "text": "Teste de envio para webhook",
    "processing_type": "translate",
    "target_language": "en",
    "processing_mode": "batch"
  }'
```

### 5. **Verificação no n8n**

1. Acesse o n8n: `https://sense-n8n.lbbcpb.easypanel.host`
2. Verifique o workflow conectado ao webhook
3. Observe se os dados estão chegando no formato esperado
4. Configure o n8n para retornar uma resposta estruturada

#### **Exemplo de Configuração de Resposta no n8n:**
```javascript
// No nó de resposta do n8n:
{
  "result": "Processamento concluído com sucesso!",
  "status": "success", 
  "tokens_used": 100,
  "processing_time": "1.2s",
  "message": "Dados processados pelo n8n"
}
```

### 6. **Estrutura de Dados Enviados**

#### **Para Texto Simples:**
```json
{
  "text": "Texto do usuário",
  "type": "translate|summarize|analyze|extract|categorize|custom|genealogy",
  "language": "pt|en|es|fr|de|it",
  "customInstructions": "Instruções personalizadas",
  "mode": "batch|individual",
  "settings": {
    "preserveFormatting": true,
    "removeEmptyLines": false
  },
  "has_files": false,
  "has_text": true,
  "files": [],
  "files_count": 0
}
```

#### **Para Arquivos:**
```json
{
  "session_id": "uuid-sessao",
  "text": "Texto adicional",
  "type": "translate",
  "language": "en",
  "files": [
    {
      "name": "documento.pdf",
      "size": 1024,
      "type": "pdf",
      "content": null
    }
  ],
  "files_count": 1,
  "has_files": true,
  "has_text": true
}
```

### 7. **Indicadores de Sucesso**

#### **✅ Sistema Funcionando Corretamente:**
- Badge verde com "Processado pelo Webhook"
- Resultado específico exibido
- Tokens e tempo mostrados
- Status "Webhook respondeu com resultado"

#### **⚠️ Webhook Recebendo mas Não Processando:**
- Badge amarelo com "Enviado"
- Mensagem "Aguardando resposta do webhook"
- Dados chegam no n8n mas resposta vazia

#### **❌ Erro de Comunicação:**
- Badge vermelho com "Erro"
- Mensagem de erro específica
- Status HTTP diferente de 200

### 8. **Solução de Problemas**

#### **Se o webhook não responder:**
1. Verifique se a URL está correta
2. Teste a URL diretamente no navegador
3. Verifique logs do n8n
4. Confirme que o workflow está ativo

#### **Se a resposta não aparecer:**
1. Verifique o console do navegador (F12)
2. Confirme se o JSON de resposta está bem formado
3. Teste com dados simples primeiro

#### **Para depuração:**
```javascript
// Adicione no console do navegador:
console.log('Response data:', response.data);
console.log('Webhook response:', response.data.webhook_response);
```

### 9. **Exemplo de Workflow n8n**

```
[Webhook] → [Processar Dados] → [Responder]
    ↓              ↓               ↓
  Recebe        Faz IA        Retorna JSON
   dados      processing      estruturado
```

O webhook deve sempre retornar uma resposta JSON para que o sistema funcione corretamente.