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
              accept=".txt,.csv,.json,.xml,.md"
              multiple
              style="display: none"
            />
            <button class="btn-upload" @click="$refs.fileInput.click()" :disabled="isProcessing">
              <i class="bi bi-upload"></i>
              Carregar Arquivos
            </button>
            <small class="upload-info">Suporta: TXT, CSV, JSON, XML, MD</small>
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
          <textarea 
            v-model="inputText"
            class="input-textarea"
            placeholder="Cole seu texto aqui ou carregue arquivos usando o botão acima...

Exemplos do que você pode processar:
• Textos para tradução em massa
• Dados para análise de sentimento
• Conteúdo para resumos automáticos
• Listas para categorização
• Documentos para extração de informações"
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
          :disabled="!inputText || isProcessing"
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
          <h3><i class="bi bi-check-circle"></i> Resultado do Processamento</h3>
          <div class="result-actions">
            <button class="action-btn" @click="downloadResult">
              <i class="bi bi-download"></i>
              Download
            </button>
            <button class="action-btn" @click="copyResult">
              <i class="bi bi-clipboard"></i>
              Copiar
            </button>
          </div>
        </div>
        
        <div class="result-content">
          <pre class="result-text">{{ result }}</pre>
        </div>
        
        <div class="result-stats">
          <span class="stat">Processado em: {{ processingTime }}s</span>
          <span class="stat">Status: {{ resultStatus }}</span>
          <span class="stat">Tokens utilizados: {{ tokensUsed }}</span>
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
  
  if (files.length === 0) return;
  
  try {
    let combinedText = inputText.value;
    
    for (const file of files) {
      const text = await readFileAsText(file);
      combinedText += (combinedText ? '\n\n' : '') + `--- ${file.name} ---\n${text}`;
    }
    
    inputText.value = combinedText;
    showAlert(`${files.length} arquivo(s) carregado(s) com sucesso!`, 'alert-success');
  } catch (error) {
    showAlert('Erro ao carregar arquivo(s)', 'alert-error');
    console.error('Erro ao carregar arquivo:', error);
  }
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
  if (!inputText.value.trim()) {
    showAlert('Por favor, insira algum texto para processar', 'alert-warning');
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
    
    // Preparar payload para o webhook
    const payload = {
      text: inputText.value,
      type: processingType.value,
      language: targetLanguage.value,
      customInstructions: customInstructions.value,
      mode: processingMode.value,
      settings: settings.value,
      timestamp: new Date().toISOString()
    };
    
    // Enviar para o webhook
    const response = await axios.post(WEBHOOK_URL, payload, {
      headers: {
        'Content-Type': 'application/json',
      }
    });
    
    clearInterval(progressInterval);
    processingProgress.value = 100;
    
    // Processar resposta
    result.value = response.data.result || JSON.stringify(response.data, null, 2);
    processingTime.value = ((Date.now() - startTime) / 1000).toFixed(2);
    resultStatus.value = 'Sucesso';
    tokensUsed.value = response.data.tokensUsed || 'N/A';
    
    // Adicionar ao histórico
    addToHistory({
      type: processingType.value,
      input: inputText.value,
      result: result.value,
      timestamp: Date.now(),
      preview: inputText.value.substring(0, 100) + '...'
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
const clearAll = () => {
  if (confirm('Tem certeza que deseja limpar todos os dados?')) {
    inputText.value = '';
    result.value = '';
    customInstructions.value = '';
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