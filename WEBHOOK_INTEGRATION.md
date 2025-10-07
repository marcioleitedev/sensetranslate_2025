# Integração com Webhook - Agente IA

## Configuração Atual

O sistema do Agente IA foi configurado para enviar **TODAS** as requisições (texto e arquivos) para o webhook:

🔗 **URL do Webhook:** `https://sense-n8n.lbbcpb.easypanel.host/webhook/central`

## Fluxo de Dados

### 1. **Apenas Texto**
```
Usuário digita texto → Frontend → API Laravel (/api/agente-ia/process-text) → Webhook
```

### 2. **Arquivos + Texto (Opcional)**
```
Usuário faz upload → Storage Laravel → Frontend → API Laravel (/api/agente-ia/process) → Webhook
```

## Estrutura dos Dados Enviados ao Webhook

### Para Texto Simples:
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
  "timestamp": "2025-10-07T20:17:00.000Z",
  "has_files": false,
  "has_text": true,
  "files": [],
  "files_count": 0
}
```

### Para Arquivos + Texto:
```json
{
  "session_id": "uuid-da-sessao",
  "text": "Texto adicional opcional",
  "type": "translate|summarize|analyze|extract|categorize|custom|genealogy",
  "language": "pt|en|es|fr|de|it",
  "customInstructions": "Instruções personalizadas",
  "mode": "batch|individual",
  "files": [
    {
      "name": "arquivo.pdf",
      "size": 1024,
      "type": "pdf",
      "content": "conteúdo extraído (apenas para txt, csv, json, xml, md)"
    }
  ],
  "files_count": 1,
  "timestamp": "2025-10-07T20:17:00.000Z",
  "has_files": true,
  "has_text": true
}
```

## Endpoints da API

### 1. `/api/agente-ia/process-text` (POST)
- **Uso:** Processar apenas texto
- **Ação:** Envia dados formatados para o webhook
- **Resposta:** Retorna resposta do webhook

### 2. `/api/agente-ia/process` (POST)
- **Uso:** Processar arquivos + texto opcional
- **Ação:** Lê arquivos do storage, prepara dados e envia para webhook
- **Resposta:** Retorna resposta do webhook

### 3. `/api/agente-ia/upload` (POST)
- **Uso:** Upload de múltiplos arquivos
- **Ação:** Salva arquivos no storage do Laravel
- **Resposta:** Confirma upload e retorna session_id

## Tipos de Arquivo Suportados

### Arquivos com Conteúdo Extraído:
- **TXT, CSV, JSON, XML, MD**: Conteúdo é lido e enviado no campo `content`

### Arquivos Binários (Referência):
- **PDF, DOC, DOCX**: Informações do arquivo são enviadas (nome, tamanho, tipo)
- **Imagens (JPG, PNG, GIF, WEBP)**: Informações do arquivo são enviadas

## Fluxo Completo de Processamento

1. **Upload de Arquivos** (opcional):
   - Usuário faz upload via drag & drop ou botão
   - Arquivos são salvos em `storage/app/agente-ia/uploads/`
   - Session ID é gerado

2. **Configuração de Processamento**:
   - Usuário escolhe tipo de processamento
   - Define configurações adicionais
   - Adiciona texto opcional

3. **Envio para Webhook**:
   - Sistema prepara payload unificado
   - Envia TUDO para o webhook via HTTP POST
   - Aguarda resposta do webhook

4. **Exibição de Resultado**:
   - Mostra resposta do webhook
   - Ou confirma envio bem-sucedido

## Monitoramento

### Logs no Laravel:
- Logs de upload em `storage/logs/laravel.log`
- Erros de HTTP para o webhook

### Verificação de Envio:
```php
// No controller, a resposta do webhook é capturada
$response = Http::timeout(30)->post($webhookUrl, $webhookPayload);

if ($response->successful()) {
    // Webhook recebeu e processou
    return $response->json();
} else {
    // Erro na comunicação
    return ['error' => $response->body()];
}
```

## Configurações de Segurança

- **Timeout:** 30 segundos para requisições ao webhook
- **Validação:** Tipos de arquivo e tamanhos são validados
- **Storage:** Arquivos ficam seguros no storage do Laravel
- **Session:** Cada upload gera um UUID único

## Testando a Integração

### 1. Teste com Texto:
1. Acesse `/dashboard/agente-ia`
2. Digite qualquer texto
3. Selecione tipo de processamento
4. Clique "Processar com IA"
5. Verifique se os dados chegam no webhook

### 2. Teste com Arquivos:
1. Faça upload de um ou mais arquivos
2. Adicione texto opcional
3. Configure processamento
4. Clique "Processar com IA"
5. Verifique se arquivos + texto chegam no webhook

## Estrutura de Resposta Esperada do Webhook

O webhook deve retornar:
```json
{
  "result": "Resultado do processamento...",
  "status": "success|error",
  "message": "Mensagem opcional",
  "processing_time": "2.5s",
  "tokens_used": 150
}
```

Esta estrutura garante que **todos os dados** (texto, arquivos, configurações) sejam enviados de forma unificada para o webhook especificado.