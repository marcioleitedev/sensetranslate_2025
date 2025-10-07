# Atualização do Formato de Payload - Webhook Agente IA

## ✅ **Formato Atualizado Implementado!**

O sistema foi atualizado para enviar dados para o webhook no formato simplificado solicitado:

### 🎯 **Novo Formato do Payload**

```json
{
  "message": "Conteúdo do prompt + arquivos",
  "sessionId": "sense-website"
}
```

### 📋 **Comparação dos Formatos**

#### **❌ Formato Antigo (Complexo):**
```json
{
  "text": "Texto do usuário",
  "type": "translate",
  "language": "pt",
  "customInstructions": "Instruções",
  "mode": "batch",
  "settings": {...},
  "timestamp": "2025-10-07T...",
  "has_files": false,
  "has_text": true,
  "files": [...],
  "files_count": 0
}
```

#### **✅ Formato Novo (Simplificado):**
```json
{
  "message": "Me explique o que é inteligência artificial",
  "sessionId": "sense-website"
}
```

### 📄 **Como o Sistema Monta a Mensagem**

#### **1. Apenas Texto:**
```json
{
  "message": "Texto digitado pelo usuário",
  "sessionId": "sense-website"
}
```

#### **2. Texto + Arquivos:**
```json
{
  "message": "Texto digitado pelo usuário

Arquivos anexados:
- documento.pdf (pdf, 1024 bytes)
- texto.txt (txt, 512 bytes)

Conteúdo do arquivo texto.txt:
Este é o conteúdo extraído do arquivo de texto...",
  "sessionId": "sense-website"
}
```

### 🔧 **Implementação Técnica**

#### **Controller Laravel Atualizado:**
- `AgenteIAController::processFiles()` - Para arquivos + texto
- `AgenteIAController::processText()` - Para apenas texto

#### **Lógica de Montagem da Mensagem:**
1. **Base**: Texto digitado pelo usuário
2. **+ Lista de arquivos**: Nome, tipo e tamanho
3. **+ Conteúdo**: Texto extraído de arquivos TXT/CSV/JSON/XML/MD
4. **SessionId**: Sempre "sense-website"

### 📊 **Tipos de Arquivo Processados**

#### **Arquivos com Conteúdo Extraído:**
- **.txt, .csv, .json, .xml, .md**: Conteúdo é lido e incluído na mensagem

#### **Arquivos Referenciados:**
- **.pdf, .doc, .docx**: Apenas informações (nome, tipo, tamanho)
- **Imagens**: Apenas informações (nome, tipo, tamanho)

### 🧪 **Testando o Novo Formato**

#### **1. Via Interface Web:**
1. Acesse `/dashboard/agente-ia`
2. Digite: "Me explique o que é inteligência artificial"
3. Clique "Processar com IA"
4. Payload enviado: `{ "message": "Me explique...", "sessionId": "sense-website" }`

#### **2. Via Script de Teste:**
```bash
php test_webhook.php
```

#### **3. Via API Direta:**
```bash
curl -X POST http://localhost/api/agente-ia/process-text \
  -H "Content-Type: application/json" \
  -d '{
    "text": "Me explique o que é inteligência artificial",
    "processing_type": "custom",
    "processing_mode": "batch"
  }'
```

### 📋 **Status do Webhook**

**Situação Atual:** 
- ✅ Formato implementado corretamente
- ❌ Webhook retornando 404 (workflow não ativo)

**Mensagem do n8n:**
```
"The requested webhook 'POST central' is not registered."
"The workflow must be active for a production URL to run successfully."
```

### 🔧 **Para Ativar o Webhook no n8n:**

1. **Acesse**: https://sense-n8n.lbbcpb.easypanel.host
2. **Verifique**: Se o workflow com webhook "central" existe
3. **Ative**: Toggle no canto superior direito do editor
4. **Configure**: Nó "Respond to Webhook" para retornar resposta

### 📄 **Exemplo de Workflow n8n Atualizado**

```
[Webhook: /central] → [Processar message] → [Respond to Webhook]
        ↓                      ↓                     ↓
   Recebe dados           Processa a              Retorna
   simplificados         mensagem única           resultado
```

#### **Configuração do Webhook Trigger:**
- **Path**: `central`
- **Method**: `POST`
- **Response Mode**: `Respond to Webhook`

#### **Dados Recebidos:**
```javascript
// No n8n, acessar dados com:
const message = $json.message;        // "Me explique o que é IA"
const sessionId = $json.sessionId;    // "sense-website"
```

#### **Resposta Esperada:**
```json
{
  "result": "Resposta da IA aqui...",
  "status": "success"
}
```

### ✅ **Vantagens do Novo Formato**

1. **Simplicidade**: Apenas 2 campos obrigatórios
2. **Flexibilidade**: Toda informação em um campo de mensagem
3. **Compatibilidade**: Funciona com qualquer sistema de IA
4. **Manutenibilidade**: Menos complexidade de parsing

### 🎯 **Próximos Passos**

1. **Ativar o workflow no n8n**
2. **Configurar processamento da mensagem**
3. **Testar resposta do webhook**
4. **Ajustar se necessário**

O sistema está **pronto** e aguardando apenas a ativação do workflow no n8n! 🚀