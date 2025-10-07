# Funcionalidades de Upload do Agente IA

## Visão Geral

O dashboard do Agente IA agora suporta upload de múltiplos arquivos em massa para processamento. O agente pode processar diferentes tipos de arquivos sem necessidade de extrair os dados imediatamente - o processamento é feito pelo próprio agente.

## Tipos de Arquivos Suportados

- **PDFs** (.pdf)
- **Documentos Word** (.doc, .docx)
- **Imagens** (.jpg, .jpeg, .png, .gif, .webp)
- **Arquivos de Texto** (.txt, .csv, .json, .xml, .md)

## Funcionalidades Implementadas

### 1. Upload de Múltiplos Arquivos
- Suporte para upload de até 10 arquivos por vez
- Máximo de 10MB por arquivo
- Validação automática de tipos de arquivo

### 2. Drag & Drop
- Área de drop visual e interativa
- Feedback visual quando arquivos são arrastados
- Suporte para múltiplos arquivos simultaneamente

### 3. Gerenciamento de Arquivos
- Lista visual dos arquivos enviados
- Informações de cada arquivo (nome, tamanho, tipo)
- Botão para remover arquivos individuais
- Botão para limpar todos os arquivos

### 4. Integração com Processamento
- Os arquivos são agrupados em sessões
- O agente IA processa os arquivos em segundo plano
- Não há necessidade de extrair dados imediatamente

## Como Usar

### Upload via Botão
1. Acesse `/dashboard/agente-ia`
2. Clique no botão "Carregar Arquivos"
3. Selecione um ou múltiplos arquivos
4. Os arquivos aparecerão na lista

### Upload via Drag & Drop
1. Arraste arquivos da área de trabalho
2. Solte na área de drop indicada
3. Os arquivos serão automaticamente enviados

### Processamento
1. Com arquivos enviados ou texto digitado
2. Selecione o tipo de processamento desejado
3. Configure as opções se necessário
4. Clique em "Processar com IA"
5. O agente processará os arquivos em segundo plano

## Endpoints da API

### POST `/api/agente-ia/upload`
Upload de múltiplos arquivos
```javascript
// FormData com arquivos
const formData = new FormData();
files.forEach(file => formData.append('files[]', file));
```

### GET `/api/agente-ia/session/{sessionId}/files`
Lista arquivos de uma sessão

### DELETE `/api/agente-ia/session/{sessionId}/files`
Remove todos os arquivos de uma sessão

### POST `/api/agente-ia/process`
Processa arquivos e/ou texto
```javascript
{
  "session_id": "uuid",
  "processing_type": "translate|summarize|analyze|extract|categorize|custom|genealogy",
  "target_language": "pt",
  "custom_instructions": "...",
  "processing_mode": "batch|individual",
  "text": "texto adicional opcional"
}
```

## Estrutura de Armazenamento

Os arquivos são salvos em:
```
storage/app/agente-ia/uploads/
```

Cada arquivo é nomeado com:
```
{sessionId}_{timestamp}_{nome-arquivo-slug}.{extensão}
```

## Recursos de Interface

### Área de Drop
- Visual atrativo com ícones e instruções
- Feedback visual durante o drag & drop
- Lista de formatos suportados

### Lista de Arquivos
- Ícones específicos por tipo de arquivo
- Informações detalhadas (nome, tamanho, tipo)
- Status de processamento
- Ações individuais (remover)

### Responsividade
- Layout adaptável para dispositivos móveis
- Controles reorganizados em telas menores
- Área de drop otimizada para touch

## Próximos Passos

1. **Integração com IA**: Conectar o processamento real com serviços de IA
2. **OCR para Imagens**: Extrair texto de imagens automaticamente
3. **Processamento de PDFs**: Extrair texto e metadados de PDFs
4. **Análise de Documentos Word**: Processar conteúdo de documentos .docx
5. **Autenticação**: Adicionar middleware de autenticação às rotas da API
6. **Logs e Monitoramento**: Registrar atividades de upload e processamento

## Configurações de Segurança

- Validação rigorosa de tipos MIME
- Limite de tamanho de arquivo (10MB)
- Limite de quantidade de arquivos (10 por vez)
- Nomes de arquivos sanitizados
- Armazenamento seguro no storage local do Laravel