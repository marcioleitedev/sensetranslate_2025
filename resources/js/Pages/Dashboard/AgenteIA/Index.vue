<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <div class="dashboard-layout">
    <!-- Botão Menu Mobile -->
    <button class="btn btn-primary d-md-none toggle-btn" @click="showMobileMenu = !showMobileMenu">
      <i class="bi bi-list"></i>
    </button>

    <!-- Menu Lateral -->
    <MenuLateral :showMobileMenu="showMobileMenu" @update:showMobileMenu="showMobileMenu = $event" />

    <!-- Conteúdo Principal -->
    <div class="dashboard-content">
      <!-- Header da Página -->
      <div class="page-header">
        <div class="header-content">
          <div class="header-info">
            <h1 class="page-title">
              <i class="bi bi-robot"></i>
              Agente de IA
            </h1>
            <p class="page-subtitle">Processamento inteligente de textos e arquivos em massa</p>
          </div>
          <div class="header-actions">
            <button class="btn-clear" @click="clearAll" :disabled="isProcessing">
              <i class="bi bi-trash"></i>
              Limpar Tudo
            </button>
          </div>
        </div>
      </div>

      <!-- Alert Messages -->
      <div v-if="alertMessage" class="alert-message" :class="alertType">
        <i class="bi" :class="getAlertIcon(alertType)"></i>
        {{ alertMessage }}
      </div>

      <!-- Área de Entrada -->
      <div class="input-section">
        <div class="input-header">
          <h3><i class="bi bi-file-text"></i> Entrada de Dados</h3>
          <div class="input-stats">
            <span class="stat">{{ characterCount }} caracteres</span>
            <span class="stat">{{ wordCount }} palavras</span>
            <span class="stat">{{ lineCount }} linhas</span>
          </div>
        </div>
        
        <div class="input-controls">
          <div class="file-upload">
            <input 
              type="file" 
              ref="fileInput" 
              @change="handleFileUpload" 
              accept=".txt,.csv,.json,.xml,.md,.pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp"
              multiple
              style="display: none"
            />
            <button class="btn-upload" @click="$refs.fileInput.click()" :disabled="isProcessing">
              <i class="bi bi-upload"></i>
              Carregar Arquivos
            </button>
            <small class="upload-info">Suporta: PDF, DOCX, TXT, CSV, JSON, XML, MD, Imagens</small>
          </div>
          
          <div class="format-controls">
            <label>
              <input type="checkbox" v-model="settings.preserveFormatting" />
              Preservar formatação
            </label>
            <label>
              <input type="checkbox" v-model="settings.removeEmptyLines" />
              Remover linhas vazias
            </label>
          </div>
        </div>

        <div class="textarea-container">
          <!-- Área de Drop Zone para arquivos -->
          <div 
            class="drop-zone"
            :class="{ 'drop-zone-active': isDragging }"
            @drop="handleFileDrop"
            @dragover.prevent
            @dragenter="isDragging = true"
            @dragleave="isDragging = false"
            v-show="!inputText && uploadedFiles.length === 0"
          >
            <div class="drop-zone-content">
              <i class="bi bi-cloud-upload"></i>
              <h4>Arraste arquivos aqui</h4>
              <p>ou clique no botão "Carregar Arquivos" acima</p>
              <div class="supported-formats">
                <span class="format-tag">PDF</span>
                <span class="format-tag">DOCX</span>
                <span class="format-tag">Imagens</span>
                <span class="format-tag">TXT</span>
              </div>
            </div>
          </div>

          <!-- Lista de arquivos enviados -->
          <div v-if="uploadedFiles.length > 0" class="uploaded-files">
            <div class="uploaded-files-header">
              <h4><i class="bi bi-files"></i> Arquivos Enviados ({{ uploadedFiles.length }})</h4>
              <button class="btn-clear-files" @click="clearFiles" :disabled="isProcessing">
                <i class="bi bi-trash"></i>
                Limpar Todos
              </button>
            </div>
            <div class="file-list">
              <div 
                v-for="(file, index) in uploadedFiles" 
                :key="index" 
                class="file-item"
                :class="{ 'file-processing': file.processing }"
              >
                <div class="file-icon">
                  <i class="bi" :class="getFileIcon(file.extension)"></i>
                </div>
                <div class="file-info">
                  <span class="file-name">{{ file.original_name }}</span>
                  <span class="file-details">{{ formatFileSize(file.size) }} • {{ file.extension.toUpperCase() }}</span>
                </div>
                <div class="file-status">
                  <span v-if="file.processing" class="status-processing">
                    <i class="bi bi-arrow-repeat spin"></i>
                    Processando...
                  </span>
                  <span v-else class="status-ready">
                    <i class="bi bi-check-circle"></i>
                    Pronto
                  </span>
                </div>
                <button 
                  class="btn-remove-file" 
                  @click="removeFile(index)"
                  :disabled="isProcessing"
                >
                  <i class="bi bi-x"></i>
                </button>
              </div>
            </div>
          </div>

          <textarea 
            v-model="inputText"
            class="input-textarea"
            :class="{ 'with-files': uploadedFiles.length > 0 }"
            placeholder="Cole seu texto aqui ou carregue arquivos usando o botão acima ou arrastando para a área de drop...

Exemplos do que você pode processar:
• Textos para tradução em massa
• Dados para análise de sentimento
• Conteúdo para resumos automáticos
• Listas para categorização
• Documentos para extração de informações
• PDFs e documentos Word
• Imagens com texto (OCR)"
            :disabled="isProcessing"
          ></textarea>
          
          <div class="textarea-actions">
            <button class="action-btn" @click="formatText" :disabled="isProcessing || !inputText">
              <i class="bi bi-text-paragraph"></i>
              Formatar
            </button>
            <button class="action-btn" @click="copyToClipboard" :disabled="!inputText">
              <i class="bi bi-clipboard"></i>
              Copiar
            </button>
          </div>
        </div>
      </div>

      <!-- Configurações de Processamento -->
      <div class="processing-section">
        <div class="processing-header">
          <h3><i class="bi bi-gear"></i> Configurações do Processamento</h3>
        </div>
        
        <div class="processing-options">
          <div class="option-group">
            <label class="option-label">
              <i class="bi bi-lightning"></i>
              Tipo de Processamento
            </label>
            <select v-model="processingType" class="form-select">
              <option value="translate">Tradução</option>
              <option value="summarize">Resumo</option>
              <option value="analyze">Análise de Sentimento</option>
              <option value="extract">Extração de Dados</option>
              <option value="categorize">Categorização</option>
              <option value="custom">Personalizado</option>
              <option value="genealogy">Gerar Arvore</option>
            </select>
          </div>

          <div class="option-group" v-if="processingType === 'translate'">
            <label class="option-label">
              <i class="bi bi-translate"></i>
              Idioma de Destino
            </label>
            <select v-model="targetLanguage" class="form-select">
              <option value="pt">Português</option>
              <option value="en">Inglês</option>
              <option value="es">Espanhol</option>
              <option value="fr">Francês</option>
              <option value="de">Alemão</option>
              <option value="it">Italiano</option>
            </select>
          </div>

          <div class="option-group" v-if="processingType === 'custom'">
            <label class="option-label">
              <i class="bi bi-code"></i>
              Instruções Personalizadas
            </label>
            <textarea 
              v-model="customInstructions" 
              class="form-textarea"
              placeholder="Descreva como deseja que o texto seja processado..."
              rows="3"
            ></textarea>
          </div>

          <div class="option-group">
            <label class="option-label">
              <i class="bi bi-speedometer"></i>
              Modo de Processamento
            </label>
            <div class="radio-group">
              <label class="radio-option">
                <input type="radio" v-model="processingMode" value="batch" />
                <span>Lote (Mais Rápido)</span>
              </label>
              <label class="radio-option">
                <input type="radio" v-model="processingMode" value="individual" />
                <span>Individual (Mais Preciso)</span>
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- Botão de Envio -->
      <div class="submit-section">
        <button 
          class="btn-process" 
          @click="processText" 
          :disabled="(!inputText && uploadedFiles.length === 0) || isProcessing"
          :class="{ processing: isProcessing }"
        >
          <i class="bi" :class="isProcessing ? 'bi-arrow-repeat spin' : 'bi-send'"></i>
          {{ isProcessing ? 'Processando...' : 'Processar com IA' }}
        </button>
        
        <div v-if="isProcessing" class="progress-info">
          <div class="progress-bar">
            <div class="progress-fill" :style="{ width: processingProgress + '%' }"></div>
          </div>
          <span class="progress-text">{{ processingProgress }}% concluído</span>
        </div>
      </div>

      <!-- Área de Resultado -->
      <div v-if="result" class="result-section">
        <div class="result-header">
          <h3>
            <i class="bi" :class="getResultIcon(resultStatus)"></i> 
            Resultado do Processamento
          </h3>
          <div class="result-actions">
            <button class="action-btn" @click="downloadResult">
              <i class="bi bi-download"></i>
              Download
            </button>
            <button class="action-btn" @click="copyResult">
              <i class="bi bi-clipboard"></i>
              Copiar
            </button>
            <button class="action-btn" @click="retryProcessing" v-if="resultStatus.includes('Erro')">
              <i class="bi bi-arrow-repeat"></i>
              Tentar Novamente
            </button>
          </div>
        </div>
        
        <div class="result-content">
          <div class="result-status-badge" :class="getStatusClass(resultStatus)">
            <i class="bi" :class="getResultIcon(resultStatus)"></i>
            {{ resultStatus }}
          </div>
          <pre class="result-text">{{ result }}</pre>
        </div>
        
        <div class="result-stats">
          <span class="stat">
            <i class="bi bi-clock"></i>
            Processado em: {{ processingTime }}s
          </span>
          <span class="stat">
            <i class="bi bi-activity"></i>
            Status: {{ resultStatus }}
          </span>
          <span class="stat">
            <i class="bi bi-cpu"></i>
            Tokens utilizados: {{ tokensUsed }}
          </span>
          <span class="stat" v-if="uploadedFiles.length > 0">
            <i class="bi bi-files"></i>
            Arquivos: {{ uploadedFiles.length }}
          </span>
        </div>
        
        <!-- Informações do Webhook -->
        <div class="webhook-info" v-if="resultStatus !== 'Erro'">
          <h4><i class="bi bi-link-45deg"></i> Informações do Webhook</h4>
          <div class="webhook-details">
            <span class="webhook-url">
              <i class="bi bi-globe"></i>
              https://sense-n8n.lbbcpb.easypanel.host/webhook/central
            </span>
            <span class="webhook-status" :class="getWebhookStatusClass()">
              <i class="bi" :class="getWebhookStatusIcon()"></i>
              {{ getWebhookStatusText() }}
            </span>
          </div>
        </div>
      </div>

      <!-- Histórico -->
      <div v-if="history.length > 0" class="history-section">
        <div class="history-header">
          <h3><i class="bi bi-clock-history"></i> Histórico de Processamentos</h3>
          <button class="btn-clear-small" @click="clearHistory">
            <i class="bi bi-trash"></i>
            Limpar Histórico
          </button>
        </div>
        
        <div class="history-list">
          <div 
            v-for="(item, index) in history" 
            :key="index" 
            class="history-item"
            @click="loadFromHistory(item)"
          >
            <div class="history-info">
              <span class="history-type">{{ getProcessingTypeName(item.type) }}</span>
              <span class="history-date">{{ formatDate(item.timestamp) }}</span>
            </div>
            <div class="history-preview">{{ item.preview }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import MenuLateral from '@/Components/MenuLateral.vue';

// Estado da aplicação
const showMobileMenu = ref(false);
const inputText = ref('');
const result = ref('');
const isProcessing = ref(false);
const processingProgress = ref(0);
const alertMessage = ref('');
const alertType = ref('');

// Novos estados para upload de arquivos
const uploadedFiles = ref([]);
const currentSessionId = ref('');
const isDragging = ref(false);

// Configurações
const processingType = ref('translate');
const targetLanguage = ref('pt');
const customInstructions = ref('');
const processingMode = ref('batch');
const settings = ref({
  preserveFormatting: true,
  removeEmptyLines: false
});

// Dados de resultado
const processingTime = ref(0);
const resultStatus = ref('');
const tokensUsed = ref(0);

// Histórico
const history = ref([]);

// Refs para elementos
const fileInput = ref(null);

// Computed properties
const characterCount = computed(() => inputText.value.length);
const wordCount = computed(() => inputText.value.trim().split(/\s+/).filter(word => word).length);
const lineCount = computed(() => inputText.value.split('\n').length);

// Webhook URL
const WEBHOOK_URL = 'https://sense-n8n.lbbcpb.easypanel.host/webhook/central';

// Funções utilitárias
const getAlertIcon = (type) => {
  if (type.includes('success')) return 'bi-check-circle';
  if (type.includes('error')) return 'bi-exclamation-triangle';
  if (type.includes('warning')) return 'bi-exclamation-circle';
  return 'bi-info-circle';
};

// Funções para status de resultado
const getResultIcon = (status) => {
  if (status.includes('Processado') || status === 'Sucesso') return 'bi-check-circle';
  if (status.includes('Erro')) return 'bi-exclamation-triangle';
  if (status.includes('Enviado')) return 'bi-arrow-up-circle';
  return 'bi-info-circle';
};

const getStatusClass = (status) => {
  if (status.includes('Processado') || status === 'Sucesso') return 'status-success';
  if (status.includes('Erro')) return 'status-error';
  if (status.includes('Enviado')) return 'status-warning';
  return 'status-info';
};

const getWebhookStatusClass = () => {
  if (resultStatus.value.includes('Processado')) return 'webhook-success';
  if (resultStatus.value.includes('Erro')) return 'webhook-error';
  if (resultStatus.value.includes('Enviado')) return 'webhook-warning';
  return 'webhook-info';
};

const getWebhookStatusIcon = () => {
  if (resultStatus.value.includes('Processado')) return 'bi-check-circle-fill';
  if (resultStatus.value.includes('Erro')) return 'bi-x-circle-fill';
  if (resultStatus.value.includes('Enviado')) return 'bi-clock-fill';
  return 'bi-info-circle-fill';
};

const getWebhookStatusText = () => {
  if (resultStatus.value.includes('Processado')) return 'Webhook respondeu com resultado';
  if (resultStatus.value.includes('Erro')) return 'Erro na comunicação com webhook';
  if (resultStatus.value.includes('Enviado')) return 'Aguardando resposta do webhook';
  return 'Status do webhook';
};

const retryProcessing = () => {
  processText();
};

const showAlert = (message, type = 'alert-info') => {
  alertMessage.value = message;
  alertType.value = type;
  setTimeout(() => {
    alertMessage.value = '';
  }, 5000);
};

const getProcessingTypeName = (type) => {
  const types = {
    translate: 'Tradução',
    summarize: 'Resumo',
    analyze: 'Análise',
    extract: 'Extração',
    categorize: 'Categorização',
    custom: 'Personalizado'
  };
  return types[type] || type;
};

const formatDate = (timestamp) => {
  return new Date(timestamp).toLocaleString('pt-BR');
};

// Funções de manipulação de arquivo
const handleFileUpload = async (event) => {
  const files = Array.from(event.target.files);
  await uploadFiles(files);
};

const handleFileDrop = async (event) => {
  event.preventDefault();
  isDragging.value = false;
  
  const files = Array.from(event.dataTransfer.files);
  await uploadFiles(files);
};

const uploadFiles = async (files) => {
  if (files.length === 0) return;
  
  const formData = new FormData();
  files.forEach(file => {
    formData.append('files[]', file);
  });
  
  try {
    const response = await axios.post('/api/agente-ia/upload', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      }
    });
    
    if (response.data.success) {
      uploadedFiles.value.push(...response.data.files);
      currentSessionId.value = response.data.session_id;
      showAlert(response.data.message, 'alert-success');
    } else {
      showAlert(response.data.message, 'alert-error');
    }
  } catch (error) {
    showAlert('Erro ao fazer upload dos arquivos', 'alert-error');
    console.error('Erro no upload:', error);
  }
};

const removeFile = (index) => {
  uploadedFiles.value.splice(index, 1);
};

const clearFiles = async () => {
  if (currentSessionId.value) {
    try {
      await axios.delete(`/api/agente-ia/session/${currentSessionId.value}/files`);
    } catch (error) {
      console.error('Erro ao limpar arquivos:', error);
    }
  }
  
  uploadedFiles.value = [];
  currentSessionId.value = '';
  showAlert('Arquivos removidos!', 'alert-success');
};

const getFileIcon = (extension) => {
  const icons = {
    pdf: 'bi-file-earmark-pdf',
    doc: 'bi-file-earmark-word',
    docx: 'bi-file-earmark-word',
    txt: 'bi-file-earmark-text',
    csv: 'bi-file-earmark-spreadsheet',
    json: 'bi-file-earmark-code',
    xml: 'bi-file-earmark-code',
    md: 'bi-file-earmark-text',
    jpg: 'bi-file-earmark-image',
    jpeg: 'bi-file-earmark-image',
    png: 'bi-file-earmark-image',
    gif: 'bi-file-earmark-image',
    webp: 'bi-file-earmark-image'
  };
  return icons[extension.toLowerCase()] || 'bi-file-earmark';
};

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

const readFileAsText = (file) => {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = (e) => resolve(e.target.result);
    reader.onerror = (e) => reject(e);
    reader.readAsText(file, 'UTF-8');
  });
};

// Funções de formatação
const formatText = () => {
  let text = inputText.value;
  
  if (settings.value.removeEmptyLines) {
    text = text.replace(/^\s*\n/gm, '');
  }
  
  if (!settings.value.preserveFormatting) {
    text = text.replace(/\s+/g, ' ').trim();
  }
  
  inputText.value = text;
  showAlert('Texto formatado!', 'alert-success');
};

const copyToClipboard = async () => {
  try {
    await navigator.clipboard.writeText(inputText.value);
    showAlert('Texto copiado para a área de transferência!', 'alert-success');
  } catch (error) {
    showAlert('Erro ao copiar texto', 'alert-error');
  }
};

// Função principal de processamento
const processText = async () => {
  if (!inputText.value.trim() && uploadedFiles.value.length === 0) {
    showAlert('Por favor, insira algum texto ou carregue arquivos para processar', 'alert-warning');
    return;
  }
  
  isProcessing.value = true;
  processingProgress.value = 0;
  const startTime = Date.now();
  
  try {
    // Simular progresso
    const progressInterval = setInterval(() => {
      if (processingProgress.value < 90) {
        processingProgress.value += Math.random() * 10;
      }
    }, 500);
    
    let response;
    
    // Se há arquivos enviados, usar API que envia tudo para o webhook
    if (uploadedFiles.value.length > 0) {
      const payload = {
        session_id: currentSessionId.value,
        processing_type: processingType.value,
        target_language: targetLanguage.value,
        custom_instructions: customInstructions.value,
        processing_mode: processingMode.value,
        text: inputText.value // Texto adicional se houver
      };
      
      response = await axios.post('/api/agente-ia/process', payload);
      
      if (response.data.success) {
        // Processar resposta do webhook
        const webhookResponse = response.data.webhook_response;
        
        if (webhookResponse) {
          // Se o webhook retornou dados, exibir resultado processado
          if (webhookResponse.result) {
            result.value = webhookResponse.result;
            resultStatus.value = webhookResponse.status || 'Processado pelo Webhook';
            tokensUsed.value = webhookResponse.tokens_used || webhookResponse.tokensUsed || 'N/A';
            
            showAlert('✅ Processamento concluído pelo webhook!', 'alert-success');
          } else {
            // Webhook respondeu mas sem resultado específico
            result.value = `✅ Dados processados pelo webhook!

📤 **Resposta do Webhook:**
${JSON.stringify(webhookResponse, null, 2)}

📊 **Informações do Envio:**
• Sessão: ${response.data.session_id}
• Tipo de processamento: ${getProcessingTypeName(response.data.processing_type)}
• Quantidade de arquivos: ${response.data.files_count}
• Status: ${response.data.status}
• Texto adicional: ${inputText.value ? 'Sim' : 'Não'}`;
            
            resultStatus.value = 'Processado';
            showAlert('✅ Dados enviados e processados pelo webhook!', 'alert-success');
          }
        } else {
          // Webhook não respondeu ou resposta vazia
          result.value = `⚠️ Dados enviados mas webhook não retornou resultado

📤 **Informações do Envio:**
• Sessão: ${response.data.session_id}
• Tipo de processamento: ${getProcessingTypeName(response.data.processing_type)}
• Quantidade de arquivos: ${response.data.files_count}
• Status: ${response.data.status}
• Texto adicional: ${inputText.value ? 'Sim' : 'Não'}

🎯 **Webhook:** https://sense-n8n.lbbcpb.easypanel.host/webhook-test/central

💡 Verifique se o webhook está configurado para retornar uma resposta.`;
          
          resultStatus.value = 'Enviado';
          showAlert('⚠️ Dados enviados mas sem resposta do webhook', 'alert-warning');
        }
      } else {
        // Tratar diferentes tipos de erro
        const isWebhookError = response.status === 422;
        
        if (isWebhookError) {
          result.value = `⚠️ Webhook retornou erro de configuração

**Erro do Webhook:** ${response.data.message}

**Status HTTP:** ${response.data.webhook_status}

**Detalhes:**
${JSON.stringify(response.data.webhook_error || {}, null, 2)}

💡 **Possíveis soluções:**
• Verifique se o workflow do n8n está ativo
• Confirme se há um nó "Respond to Webhook" configurado
• Teste o webhook diretamente no n8n

🎯 **Webhook:** https://sense-n8n.lbbcpb.easypanel.host/webhook/central`;
          resultStatus.value = 'Erro do Webhook';
          showAlert('⚠️ Webhook com erro de configuração', 'alert-warning');
        } else {
          result.value = `❌ Erro interno ao enviar para o webhook

**Erro:** ${response.data.message}

**Detalhes:** ${JSON.stringify(response.data, null, 2)}`;
          resultStatus.value = 'Erro Interno';
          showAlert('❌ Erro interno na aplicação', 'alert-error');
        }
      }
    } else {
      // Processamento apenas de texto - enviar através da API que redireciona para o webhook
      const payload = {
        text: inputText.value,
        processing_type: processingType.value,
        target_language: targetLanguage.value,
        custom_instructions: customInstructions.value,
        processing_mode: processingMode.value,
        settings: settings.value
      };
      
      response = await axios.post('/api/agente-ia/process-text', payload);
      
      if (response.data.success) {
        // Processar resposta do webhook
        const webhookResponse = response.data.webhook_response;
        
        if (webhookResponse) {
          // Se o webhook retornou dados, exibir resultado processado
          if (webhookResponse.result) {
            result.value = webhookResponse.result;
            resultStatus.value = webhookResponse.status || 'Processado pelo Webhook';
            tokensUsed.value = webhookResponse.tokens_used || webhookResponse.tokensUsed || 'N/A';
            
            showAlert('✅ Texto processado pelo webhook!', 'alert-success');
          } else {
            // Webhook respondeu mas sem resultado específico
            result.value = `✅ Texto processado pelo webhook!

📤 **Resposta do Webhook:**
${JSON.stringify(webhookResponse, null, 2)}

📊 **Informações do Envio:**
• Tipo de processamento: ${getProcessingTypeName(processingType.value)}
• Idioma de destino: ${targetLanguage.value || 'N/A'}
• Status: ${response.data.status}`;
            
            resultStatus.value = 'Processado';
            showAlert('✅ Texto enviado e processado pelo webhook!', 'alert-success');
          }
        } else {
          // Webhook não respondeu ou resposta vazia
          result.value = `⚠️ Texto enviado mas webhook não retornou resultado

📤 **Informações do Envio:**
• Tipo de processamento: ${getProcessingTypeName(processingType.value)}
• Idioma de destino: ${targetLanguage.value || 'N/A'}
• Status: ${response.data.status}

🎯 **Webhook:** https://sense-n8n.lbbcpb.easypanel.host/webhook/central

💡 Verifique se o webhook está configurado para retornar uma resposta.`;
          
          resultStatus.value = 'Enviado';
          showAlert('⚠️ Texto enviado mas sem resposta do webhook', 'alert-warning');
        }
      } else {
        // Tratar diferentes tipos de erro
        const isWebhookError = response.status === 422;
        
        if (isWebhookError) {
          result.value = `⚠️ Webhook retornou erro de configuração

**Erro do Webhook:** ${response.data.message}

**Status HTTP:** ${response.data.webhook_status}

**Detalhes:**
${JSON.stringify(response.data.webhook_error || {}, null, 2)}

💡 **Possíveis soluções:**
• Verifique se o workflow do n8n está ativo
• Confirme se há um nó "Respond to Webhook" configurado
• Teste o webhook diretamente no n8n

🎯 **Webhook:** https://sense-n8n.lbbcpb.easypanel.host/webhook/central`;
          resultStatus.value = 'Erro do Webhook';
          showAlert('⚠️ Webhook com erro de configuração', 'alert-warning');
        } else {
          result.value = `❌ Erro interno ao enviar texto para o webhook

**Erro:** ${response.data.message}

**Detalhes:** ${JSON.stringify(response.data, null, 2)}`;
          resultStatus.value = 'Erro Interno';
          showAlert('❌ Erro interno na aplicação', 'alert-error');
        }
      }
    }
    
    clearInterval(progressInterval);
    processingProgress.value = 100;
    processingTime.value = ((Date.now() - startTime) / 1000).toFixed(2);
    
    // Se não foi definido status ainda, usar 'Sucesso'
    if (!resultStatus.value) {
      resultStatus.value = 'Sucesso';
    }
    
    // Se não foi definido tokens ainda, usar dados da resposta
    if (tokensUsed.value === 'N/A' && response.data.webhook_response) {
      tokensUsed.value = response.data.webhook_response.tokens_used || 
                         response.data.webhook_response.tokensUsed || 
                         'N/A';
    }
    
    // Adicionar ao histórico
    addToHistory({
      type: processingType.value,
      input: inputText.value || `${uploadedFiles.value.length} arquivo(s)`,
      result: result.value,
      timestamp: Date.now(),
      preview: (inputText.value || `${uploadedFiles.value.length} arquivo(s) processado(s)`).substring(0, 100) + '...',
      webhook_status: resultStatus.value,
      processing_time: processingTime.value
    });
    
    showAlert('Processamento concluído com sucesso!', 'alert-success');
    
  } catch (error) {
    console.error('Erro no processamento:', error);
    
    // Simular resultado em caso de erro para demonstração
    result.value = `Erro ao processar: ${error.message}\n\nResultado simulado para demonstração:\n${generateMockResult()}`;
    processingTime.value = ((Date.now() - startTime) / 1000).toFixed(2);
    resultStatus.value = 'Erro (Simulado)';
    tokensUsed.value = 'N/A';
    
    showAlert('Erro no processamento, resultado simulado gerado', 'alert-warning');
  } finally {
    isProcessing.value = false;
  }
};

// Função para gerar resultado simulado
const generateMockResult = () => {
  const mockResults = {
    translate: `Tradução simulada do texto:\n\n${inputText.value.substring(0, 200)}...\n\n[TRADUZIDO PARA ${targetLanguage.value.toUpperCase()}]`,
    summarize: `Resumo do texto:\n\nEste texto contém ${wordCount.value} palavras e aborda os seguintes pontos principais:\n- Ponto 1\n- Ponto 2\n- Ponto 3`,
    analyze: `Análise de sentimento:\n\nSentimento geral: Neutro\nPolaridade: 0.1\nSubjetividade: 0.5\n\nDetalhes da análise...`,
    extract: `Dados extraídos:\n\n- Nomes: [Lista de nomes encontrados]\n- Datas: [Lista de datas]\n- Locais: [Lista de locais]`,
    categorize: `Categorização do texto:\n\nCategoria principal: Informativo\nSubcategorias: Técnico, Educacional\nConfiança: 85%`,
    custom: `Resultado personalizado baseado nas instruções:\n"${customInstructions.value}"\n\nProcessamento concluído.`
  };
  
  return mockResults[processingType.value] || 'Resultado processado com sucesso.';
};

// Funções de histórico
const addToHistory = (item) => {
  history.value.unshift(item);
  if (history.value.length > 10) {
    history.value.pop();
  }
  saveHistoryToStorage();
};

const loadFromHistory = (item) => {
  inputText.value = item.input;
  result.value = item.result;
};

const clearHistory = () => {
  history.value = [];
  saveHistoryToStorage();
  showAlert('Histórico limpo!', 'alert-success');
};

const saveHistoryToStorage = () => {
  localStorage.setItem('ai-agent-history', JSON.stringify(history.value));
};

const loadHistoryFromStorage = () => {
  const saved = localStorage.getItem('ai-agent-history');
  if (saved) {
    history.value = JSON.parse(saved);
  }
};

// Funções de resultado
const copyResult = async () => {
  try {
    await navigator.clipboard.writeText(result.value);
    showAlert('Resultado copiado!', 'alert-success');
  } catch (error) {
    showAlert('Erro ao copiar resultado', 'alert-error');
  }
};

const downloadResult = () => {
  const blob = new Blob([result.value], { type: 'text/plain' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = `ai-result-${Date.now()}.txt`;
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);
  showAlert('Download iniciado!', 'alert-success');
};

// Funções de limpeza
const clearAll = async () => {
  if (confirm('Tem certeza que deseja limpar todos os dados?')) {
    inputText.value = '';
    result.value = '';
    customInstructions.value = '';
    
    // Limpar arquivos também
    if (uploadedFiles.value.length > 0) {
      await clearFiles();
    }
    
    showAlert('Dados limpos!', 'alert-success');
  }
};

// Inicialização
onMounted(() => {
  loadHistoryFromStorage();
});
</script>

<style scoped>
/* Variáveis CSS */
:root {
  --primary-color: #e2b560;
  --secondary-color: #2c3e50;
  --accent-color: #3498db;
  --success-color: #27ae60;
  --warning-color: #f39c12;
  --danger-color: #e74c3c;
  --info-color: #3498db;
  --text-dark: #2c3e50;
  --text-light: #7f8c8d;
  --border-radius: 15px;
  --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.15);
}

/* Layout Principal */
.dashboard-layout {
  display: flex;
  min-height: 100vh;
  background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
}

.dashboard-content {
  flex: 1;
  margin-left: 250px;
  padding: 2rem;
  min-height: 100vh;
}

/* Header da Página */
.page-header {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border-radius: var(--border-radius);
  padding: 2rem;
  margin-bottom: 2rem;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 2rem;
}

.page-title {
  font-size: 2rem !important;
  font-weight: 700 !important;
  margin: 0 0 0.5rem 0 !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.75rem !important;
  color: black !important;
}

.page-title i {
  font-size: 1.8rem !important;
  color: black !important;
}

.page-subtitle {
  font-size: 1rem !important;
  margin: 0 !important;
  opacity: 0.9 !important;
  color: black !important;
}

.btn-clear {
  background: #dc3545 !important;
  color: white !important;
  border: 2px solid #dc3545 !important;
  padding: 0.75rem 1.5rem !important;
  border-radius: 25px !important;
  font-weight: 600 !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
  transition: all 0.3s ease !important;
  cursor: pointer !important;
}

.btn-clear:hover:not(:disabled) {
  background: #c82333 !important;
  transform: translateY(-2px) !important;
}

.btn-clear:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Alert Messages */
.alert-message {
  margin-bottom: 2rem;
  padding: 1rem 1.5rem;
  border-radius: var(--border-radius);
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-weight: 500;
  animation: slideDown 0.3s ease;
}

.alert-success {
  background: rgba(39, 174, 96, 0.1);
  color: var(--success-color);
  border: 1px solid rgba(39, 174, 96, 0.2);
}

.alert-error {
  background: rgba(231, 76, 60, 0.1);
  color: var(--danger-color);
  border: 1px solid rgba(231, 76, 60, 0.2);
}

.alert-warning {
  background: rgba(243, 156, 18, 0.1);
  color: var(--warning-color);
  border: 1px solid rgba(243, 156, 18, 0.2);
}

.alert-info {
  background: rgba(52, 152, 219, 0.1);
  color: var(--info-color);
  border: 1px solid rgba(52, 152, 219, 0.2);
}

/* Seções principais */
.input-section,
.processing-section,
.submit-section,
.result-section,
.history-section {
  background: white;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  margin-bottom: 2rem;
  padding: 2rem;
}

/* Área de Entrada */
.input-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.input-header h3 {
  margin: 0;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.input-stats {
  display: flex;
  gap: 1rem;
}

.stat {
  font-size: 0.9rem;
  color: var(--text-light);
  background: #f8f9fa;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
}

.input-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding: 1rem;
  background: #f8f9fa;
  border-radius: 10px;
}

.file-upload {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.btn-upload {
  background: var(--accent-color) !important;
  color: white !important;
  border: none !important;
  padding: 0.5rem 1rem !important;
  border-radius: 8px !important;
  font-weight: 600 !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
}

.btn-upload:hover:not(:disabled) {
  background: #2980b9 !important;
}

.upload-info {
  color: var(--text-light);
  font-size: 0.8rem;
}

.format-controls {
  display: flex;
  gap: 1rem;
}

.format-controls label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--text-dark);
  font-size: 0.9rem;
}

.textarea-container {
  position: relative;
}

.input-textarea {
  width: 100%;
  min-height: 300px;
  padding: 1rem;
  border: 2px solid #e9ecef;
  border-radius: 10px;
  font-family: 'Consolas', 'Monaco', monospace;
  font-size: 0.9rem;
  line-height: 1.5;
  resize: vertical;
  transition: all 0.3s ease;
}

.input-textarea:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(226, 181, 96, 0.1);
}

.textarea-actions {
  position: absolute;
  top: 1rem;
  right: 1rem;
  display: flex;
  gap: 0.5rem;
}

.action-btn {
  background: white;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 0.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.8rem;
}

.action-btn:hover:not(:disabled) {
  background: #f8f9fa;
  border-color: var(--primary-color);
}

.action-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Seção de Processamento */
.processing-header h3 {
  margin: 0 0 1.5rem 0;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.processing-options {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
}

.option-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.option-label {
  font-weight: 600;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
}

.form-select,
.form-textarea {
  padding: 0.75rem;
  border: 2px solid #e9ecef;
  border-radius: 8px;
  font-size: 0.9rem;
  transition: all 0.3s ease;
}

.form-select:focus,
.form-textarea:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(226, 181, 96, 0.1);
}

.radio-group {
  display: flex;
  gap: 1rem;
}

.radio-option {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
}

/* Botão de Processamento */
.btn-process {
  width: 100%;
  background: #28a745 !important;
  color: white !important;
  border: 2px solid #28a745 !important;
  padding: 1rem 2rem !important;
  border-radius: 12px !important;
  font-size: 1.1rem !important;
  font-weight: 600 !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 0.75rem !important;
  cursor: pointer !important;
  margin-bottom: 1rem;
  box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3) !important;
}

.btn-process:disabled {
  background: #28a745 !important;
  border-color: #28a745 !important;
  opacity: 0.7;
  cursor: not-allowed;
}

.btn-process.processing {
  background: #28a745 !important;
  border-color: #28a745 !important;
}

.progress-info {
  text-align: center;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background: #e9ecef;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.progress-fill {
  height: 100%;
  background: var(--success-color);
  transition: width 0.3s ease;
}

.progress-text {
  font-size: 0.9rem;
  color: var(--text-light);
}

/* Seção de Resultado */
.result-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.result-header h3 {
  margin: 0;
  color: var(--success-color);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.result-actions {
  display: flex;
  gap: 0.5rem;
}

.result-content {
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 1rem;
  margin-bottom: 1rem;
}

.result-text {
  margin: 0;
  font-family: 'Consolas', 'Monaco', monospace;
  font-size: 0.9rem;
  line-height: 1.5;
  white-space: pre-wrap;
  word-wrap: break-word;
}

.result-stats {
  display: flex;
  gap: 1rem;
  padding-top: 1rem;
  border-top: 1px solid #e9ecef;
}

/* Histórico */
.history-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.history-header h3 {
  margin: 0;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-clear-small {
  background: none;
  border: 1px solid #dc3545;
  color: #dc3545;
  padding: 0.5rem 1rem;
  border-radius: 6px;
  font-size: 0.8rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-clear-small:hover {
  background: #dc3545;
  color: white;
}

.history-list {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.history-item {
  padding: 1rem;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.history-item:hover {
  background: #f8f9fa;
  border-color: var(--primary-color);
}

.history-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.5rem;
}

.history-type {
  font-weight: 600;
  color: var(--text-dark);
}

.history-date {
  font-size: 0.8rem;
  color: var(--text-light);
}

.history-preview {
  font-size: 0.9rem;
  color: var(--text-light);
  line-height: 1.4;
}

/* Animações */
@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Toggle Button */
.toggle-btn {
  position: fixed;
  top: 15px;
  left: 15px;
  z-index: 1100;
  background: var(--primary-color) !important;
  border: none !important;
  border-radius: 10px !important;
  box-shadow: var(--shadow);
}

/* Responsividade */
@media (max-width: 992px) {
  .dashboard-content {
    margin-left: 0;
    padding: 1.5rem;
  }
  
  .header-content {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }
  
  .input-controls {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }
  
  .format-controls {
    justify-content: center;
  }
  
  .processing-options {
    grid-template-columns: 1fr;
  }
  
  .result-header {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }
  
  .history-header {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }
}

@media (max-width: 768px) {
  .page-title {
    font-size: 1.5rem !important;
  }
  
  .input-stats {
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .textarea-actions {
    position: static;
    margin-top: 1rem;
    justify-content: center;
  }
  
  .radio-group {
    flex-direction: column;
  }
  
  .result-stats {
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .history-info {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.25rem;
  }
}
</style>

<!-- Novos estilos para upload de arquivos -->
<style scoped>
/* Drop Zone */
.drop-zone {
  border: 2px dashed #ddd;
  border-radius: 12px;
  padding: 3rem 2rem;
  text-align: center;
  background: #f8f9fa;
  transition: all 0.3s ease;
  margin-bottom: 1rem;
  cursor: pointer;
}

.drop-zone-active {
  border-color: var(--primary-color);
  background: rgba(52, 152, 219, 0.05);
}

.drop-zone-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

.drop-zone-content i {
  font-size: 3rem;
  color: #ccc;
}

.drop-zone-active .drop-zone-content i {
  color: var(--primary-color);
}

.drop-zone h4 {
  margin: 0;
  color: var(--text-light);
  font-weight: 600;
}

.drop-zone p {
  margin: 0;
  color: var(--text-light);
}

.supported-formats {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
  justify-content: center;
}

.format-tag {
  background: var(--primary-color);
  color: white;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
}

/* Uploaded Files */
.uploaded-files {
  margin-bottom: 1rem;
  border: 1px solid #e9ecef;
  border-radius: 10px;
  overflow: hidden;
}

.uploaded-files-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background: #f8f9fa;
  border-bottom: 1px solid #e9ecef;
}

.uploaded-files-header h4 {
  margin: 0;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-clear-files {
  background: var(--danger-color);
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 6px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-clear-files:hover:not(:disabled) {
  background: #dc2626;
  transform: translateY(-2px);
}

.btn-clear-files:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.file-list {
  max-height: 300px;
  overflow-y: auto;
}

.file-item {
  display: flex;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid #f0f0f0;
  transition: background-color 0.3s ease;
}

.file-item:last-child {
  border-bottom: none;
}

.file-item:hover {
  background: #f8f9fa;
}

.file-processing {
  background: rgba(52, 152, 219, 0.05);
}

.file-icon {
  margin-right: 1rem;
  font-size: 1.5rem;
  color: var(--primary-color);
}

.file-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.file-name {
  font-weight: 600;
  color: var(--text-dark);
}

.file-details {
  font-size: 0.8rem;
  color: var(--text-light);
}

.file-status {
  margin-right: 1rem;
}

.status-processing {
  color: var(--primary-color);
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
}

.status-ready {
  color: var(--success-color);
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
}

.btn-remove-file {
  background: var(--danger-color);
  color: white;
  border: none;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-remove-file:hover:not(:disabled) {
  background: #dc2626;
  transform: scale(1.1);
}

.btn-remove-file:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Textarea com arquivos */
.input-textarea.with-files {
  min-height: 200px;
  margin-top: 1rem;
}

/* Responsividade para upload */
@media (max-width: 768px) {
  .drop-zone {
    padding: 2rem 1rem;
  }
  
  .drop-zone-content i {
    font-size: 2rem;
  }
  
  .uploaded-files-header {
    flex-direction: column;
    gap: 1rem;
    align-items: stretch;
  }
  
  .file-item {
    flex-wrap: wrap;
    gap: 0.5rem;
  }
  
  .file-icon {
    margin-right: 0.5rem;
  }
  
  .supported-formats {
    gap: 0.25rem;
  }
  
  .format-tag {
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
  }
}

/* Status badges */
.result-status-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-weight: 600;
  font-size: 0.9rem;
  margin-bottom: 1rem;
}

.status-success {
  background: rgba(39, 174, 96, 0.1);
  color: var(--success-color);
  border: 1px solid rgba(39, 174, 96, 0.3);
}

.status-error {
  background: rgba(231, 76, 60, 0.1);
  color: var(--danger-color);
  border: 1px solid rgba(231, 76, 60, 0.3);
}

.status-warning {
  background: rgba(243, 156, 18, 0.1);
  color: var(--warning-color);
  border: 1px solid rgba(243, 156, 18, 0.3);
}

.status-info {
  background: rgba(52, 152, 219, 0.1);
  color: var(--info-color);
  border: 1px solid rgba(52, 152, 219, 0.3);
}

/* Webhook information */
.webhook-info {
  margin-top: 1.5rem;
  padding: 1rem;
  background: #f8f9fa;
  border-radius: 8px;
  border-left: 4px solid var(--primary-color);
}

.webhook-info h4 {
  margin: 0 0 1rem 0;
  color: var(--text-dark);
  font-size: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.webhook-details {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.webhook-url {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-family: 'Courier New', monospace;
  font-size: 0.9rem;
  color: var(--text-light);
  background: white;
  padding: 0.5rem;
  border-radius: 4px;
  border: 1px solid #e9ecef;
}

.webhook-status {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  font-size: 0.9rem;
}

.webhook-success {
  color: var(--success-color);
}

.webhook-error {
  color: var(--danger-color);
}

.webhook-warning {
  color: var(--warning-color);
}

.webhook-info {
  color: var(--info-color);
}

/* Enhanced result stats */
.result-stats {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-top: 1rem;
  padding: 1rem;
  background: #f8f9fa;
  border-radius: 8px;
}

.result-stats .stat {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
  color: var(--text-light);
  background: white;
  padding: 0.5rem 0.75rem;
  border-radius: 6px;
  border: 1px solid #e9ecef;
  min-width: 0;
}

.result-stats .stat i {
  color: var(--primary-color);
  font-size: 1rem;
}
</style>