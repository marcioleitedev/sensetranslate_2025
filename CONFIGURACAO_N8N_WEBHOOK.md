# Configuração do Webhook no n8n - Agente IA

## ✅ **Sistema Implementado com Sucesso!**

O sistema do Agente IA agora está **completamente configurado** para enviar dados para o webhook e **capturar as respostas** adequadamente.

## 🔧 **Configuração Necessária no n8n**

### 1. **Estrutura do Workflow no n8n**

```
[Webhook Trigger] → [Processar Dados] → [Respond to Webhook]
       ↓                   ↓                     ↓
   Recebe dados        Faz IA/API           Retorna resposta
   do sistema         processing            para o sistema
```

### 2. **Configuração do Nó Webhook (Trigger)**

- **URL**: `https://sense-n8n.lbbcpb.easypanel.host/webhook/central`
- **Método**: `POST`
- **Authentication**: Nenhuma (por enquanto)
- **Response Mode**: `Respond to Webhook` ✅ (IMPORTANTE!)

### 3. **Configuração do Nó "Respond to Webhook"**

Este nó é **OBRIGATÓRIO** e deve retornar JSON no seguinte formato:

#### **Resposta Mínima:**
```json
{
  "result": "Resultado do processamento aqui...",
  "status": "success"
}
```

#### **Resposta Completa:**
```json
{
  "result": "Texto traduzido/processado/analisado...",
  "status": "success",
  "message": "Processamento concluído com sucesso",
  "tokens_used": 150,
  "processing_time": "2.5s",
  "processed_at": "2025-10-07T20:30:00Z"
}
```

#### **Resposta de Erro:**
```json
{
  "result": null,
  "status": "error",
  "message": "Erro ao processar: descrição do erro",
  "error_code": "ERR_001"
}
```

## 📊 **Dados Recebidos pelo Webhook**

### **Para Texto Simples:**
```json
{
  "text": "Texto do usuário para processar",
  "type": "translate|summarize|analyze|extract|categorize|custom|genealogy",
  "language": "pt|en|es|fr|de|it",
  "customInstructions": "Instruções específicas do usuário",
  "mode": "batch|individual",
  "settings": {
    "preserveFormatting": true,
    "removeEmptyLines": false
  },
  "timestamp": "2025-10-07T20:30:00.000Z",
  "has_files": false,
  "has_text": true,
  "files": [],
  "files_count": 0
}
```

### **Para Arquivos + Texto:**
```json
{
  "session_id": "uuid-da-sessao",
  "text": "Texto adicional opcional",
  "type": "translate",
  "language": "en",
  "customInstructions": "Processar os arquivos e o texto",
  "mode": "batch",
  "files": [
    {
      "name": "documento.pdf",
      "size": 1024,
      "type": "pdf",
      "content": null
    },
    {
      "name": "texto.txt",
      "size": 512,
      "type": "txt",
      "content": "Conteúdo do arquivo de texto..."
    }
  ],
  "files_count": 2,
  "timestamp": "2025-10-07T20:30:00.000Z",
  "has_files": true,
  "has_text": true
}
```

## 🎯 **Resposta do Sistema**

### **✅ Sucesso - Webhook Processou:**
- Badge verde: "Processado pelo Webhook"
- Resultado específico exibido
- Informações de tokens e tempo
- Status: "Webhook respondeu com resultado"

### **⚠️ Aviso - Webhook Recebeu mas Não Respondeu:**
- Badge amarelo: "Enviado"
- Mensagem: "Aguardando resposta do webhook"
- Status: "Webhook recebeu dados"

### **❌ Erro - Problema no Webhook:**
- Badge vermelho: "Erro do Webhook"
- Descrição específica do erro
- Sugestões de solução
- Status HTTP retornado

## 🛠 **Exemplo de Configuração n8n**

### **Nó 1: Webhook Trigger**
```javascript
// Configurações:
// - HTTP Method: POST
// - Path: central
// - Response Mode: "Respond to Webhook"
```

### **Nó 2: Processar Dados (Code/Function)**
```javascript
// Exemplo de processamento
const inputData = $input.first().json;
const text = inputData.text;
const type = inputData.type;
const files = inputData.files || [];

let result = "";

switch(type) {
  case 'translate':
    // Chamar API de tradução
    result = await translateText(text, inputData.language);
    break;
  case 'summarize':
    // Chamar API de resumo
    result = await summarizeText(text);
    break;
  case 'analyze':
    // Chamar API de análise
    result = await analyzeText(text);
    break;
  // ... outros casos
}

return {
  result: result,
  status: "success",
  tokens_used: 100,
  processing_time: "1.5s"
};
```

### **Nó 3: Respond to Webhook**
```javascript
// Configurar para retornar o resultado do nó anterior
return $input.first().json;
```

## 🔄 **Fluxo Completo**

1. **Usuário** envia dados no dashboard
2. **Laravel** valida e envia para webhook
3. **n8n** recebe dados via webhook trigger
4. **n8n** processa dados (IA, APIs, etc.)
5. **n8n** retorna resposta via "Respond to Webhook"
6. **Laravel** recebe resposta do webhook
7. **Frontend** exibe resultado formatado para usuário

## 🧪 **Testando a Configuração**

### **1. Teste Direto no n8n:**
- Execute o workflow manualmente
- Verifique se o "Respond to Webhook" está configurado

### **2. Teste via Sistema:**
- Acesse `/dashboard/agente-ia`
- Digite um texto simples
- Clique "Processar com IA"
- Observe o status retornado

### **3. Teste via API:**
```bash
curl -X POST http://localhost/api/agente-ia/process-text \
  -H "Content-Type: application/json" \
  -d '{
    "text": "Teste",
    "processing_type": "translate",
    "target_language": "en",
    "processing_mode": "batch"
  }'
```

## 🚨 **Problemas Comuns**

### **"Unused Respond to Webhook node found"**
- **Causa**: Nó "Respond to Webhook" não está conectado
- **Solução**: Conecte o último nó ao "Respond to Webhook"

### **Webhook não responde**
- **Causa**: Workflow não está ativo
- **Solução**: Ative o workflow no n8n

### **Resposta vazia**
- **Causa**: "Respond to Webhook" não está retornando dados
- **Solução**: Configure o nó para retornar JSON estruturado

O sistema está **100% funcional** e aguardando apenas a configuração correta do workflow no n8n! 🚀