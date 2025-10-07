# Exemplos de Uso - Novo Formato Webhook

## 🧪 **Exemplos Práticos de Teste**

### **Exemplo 1: Pergunta Simples**
**Input no dashboard:** "Me explique o que é inteligência artificial"

**Payload enviado ao webhook:**
```json
{
  "message": "Me explique o que é inteligência artificial",
  "sessionId": "sense-website"
}
```

---

### **Exemplo 2: Upload de Arquivo TXT**
**Arquivo:** `conceitos.txt` (conteúdo: "IA é uma tecnologia...")
**Input no dashboard:** "Analise este arquivo sobre IA"

**Payload enviado ao webhook:**
```json
{
  "message": "Analise este arquivo sobre IA

Arquivos anexados:
- conceitos.txt (txt, 234 bytes)

Conteúdo do arquivo conceitos.txt:
IA é uma tecnologia que permite máquinas simularem inteligência humana...",
  "sessionId": "sense-website"
}
```

---

### **Exemplo 3: Upload de PDF + Texto**
**Arquivo:** `documento.pdf` (500KB)
**Input no dashboard:** "Faça um resumo deste documento"

**Payload enviado ao webhook:**
```json
{
  "message": "Faça um resumo deste documento

Arquivos anexados:
- documento.pdf (pdf, 512000 bytes)",
  "sessionId": "sense-website"
}
```

---

### **Exemplo 4: Múltiplos Arquivos**
**Arquivos:** 
- `dados.csv` (conteúdo: "nome,idade\nJoão,25")
- `imagem.jpg` (2MB)

**Input no dashboard:** "Analise os dados e descreva a imagem"

**Payload enviado ao webhook:**
```json
{
  "message": "Analise os dados e descreva a imagem

Arquivos anexados:
- dados.csv (csv, 1024 bytes)
- imagem.jpg (jpg, 2048000 bytes)

Conteúdo do arquivo dados.csv:
nome,idade
João,25
Maria,30
Pedro,22",
  "sessionId": "sense-website"
}
```

---

## 🔧 **Como Configurar o n8n para Receber**

### **Workflow Básico:**

```
[1] Webhook Trigger
    ↓
[2] Code Node (Processar)
    ↓
[3] Respond to Webhook
```

### **Nó 1: Webhook Trigger**
```javascript
// Configurações:
// - Path: central
// - Method: POST
// - Response Mode: Respond to Webhook
```

### **Nó 2: Code Node**
```javascript
// Processar a mensagem recebida
const inputData = $input.first().json;
const message = inputData.message;
const sessionId = inputData.sessionId;

// Exemplo de processamento simples
let response = "";

if (message.includes("inteligência artificial") || message.includes("IA")) {
  response = "Inteligência Artificial (IA) é um campo da ciência da computação que se concentra na criação de sistemas capazes de realizar tarefas que normalmente requerem inteligência humana.";
} else if (message.includes("arquivo")) {
  response = "Arquivo processado com sucesso. Conteúdo analisado e resumo gerado.";
} else {
  response = "Sua solicitação foi processada. Como posso ajudar mais?";
}

return {
  result: response,
  status: "success",
  message: "Processamento concluído",
  session_id: sessionId,
  processed_at: new Date().toISOString()
};
```

### **Nó 3: Respond to Webhook**
```javascript
// Simplesmente retornar o resultado do nó anterior
return $input.first().json;
```

---

## 🧪 **Testando Passo a Passo**

### **Passo 1: Ativar Workflow**
1. Acesse n8n: https://sense-n8n.lbbcpb.easypanel.host
2. Crie ou edite workflow com webhook "central"
3. Configure conforme exemplo acima
4. **ATIVE** o workflow (toggle superior direito)

### **Passo 2: Testar via Interface**
1. Acesse: `http://localhost/dashboard/agente-ia`
2. Digite: "Me explique o que é inteligência artificial"
3. Clique "Processar com IA"
4. Observe a resposta

### **Passo 3: Testar com Arquivo**
1. Crie um arquivo `teste.txt` com conteúdo: "Este é um teste"
2. Faça upload do arquivo
3. Digite: "Analise este arquivo"
4. Clique "Processar com IA"

### **Passo 4: Verificar Logs**
```bash
# No servidor Laravel
tail -f storage/logs/laravel.log

# No n8n
# Verifique executions list para ver as chamadas
```

---

## 📊 **Respostas Esperadas do Webhook**

### **Formato Mínimo:**
```json
{
  "result": "Sua resposta aqui",
  "status": "success"
}
```

### **Formato Completo:**
```json
{
  "result": "Inteligência Artificial é...",
  "status": "success",
  "message": "Processamento concluído com sucesso",
  "tokens_used": 150,
  "processing_time": "1.2s",
  "session_id": "sense-website"
}
```

### **Formato de Erro:**
```json
{
  "result": null,
  "status": "error",
  "message": "Erro ao processar solicitação"
}
```

---

## 🚀 **Status Atual**

✅ **Implementado:** Novo formato de payload  
✅ **Testado:** Sistema enviando dados corretamente  
⚠️ **Pendente:** Ativação do workflow no n8n  
📋 **Próximo:** Configurar processamento no n8n  

O sistema está **pronto para uso** assim que o webhook for ativado! 🎯