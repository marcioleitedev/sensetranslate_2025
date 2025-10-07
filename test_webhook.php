<?php

// Script de teste para verificar integração com webhook
// Execute: php test_webhook.php

$webhookUrl = 'https://sense-n8n.lbbcpb.easypanel.host/webhook/central';

// Teste 1: Envio de texto simples (NOVO FORMATO)
echo "=== TESTE 1: Enviando texto simples (NOVO FORMATO) ===\n";

$textPayload = [
    'message' => 'Me explique o que é inteligência artificial',
    'sessionId' => 'sense-website'
];

$response1 = sendToWebhook($webhookUrl, $textPayload);
echo "Resposta: " . json_encode($response1, JSON_PRETTY_PRINT) . "\n\n";

// Teste 2: Simulação de envio com arquivos (NOVO FORMATO)
echo "=== TESTE 2: Simulando envio com arquivos (NOVO FORMATO) ===\n";

$filesPayload = [
    'message' => 'Analise o conteúdo dos seguintes arquivos:

Arquivos anexados:
- documento.pdf (pdf, 1024 bytes)
- texto.txt (txt, 512 bytes)

Conteúdo do arquivo texto.txt:
Este é um exemplo de conteúdo de um arquivo de texto que será analisado pela inteligência artificial.',
    'sessionId' => 'sense-website'
];

$response2 = sendToWebhook($webhookUrl, $filesPayload);
echo "Resposta: " . json_encode($response2, JSON_PRETTY_PRINT) . "\n\n";

// Teste 3: Comparação com formato antigo
echo "=== TESTE 3: Formato antigo (para comparação) ===\n";

$oldFormatPayload = [
    'text' => 'Este é um teste de envio de texto para o webhook do agente IA.',
    'type' => 'translate',
    'language' => 'en',
    'customInstructions' => 'Traduza este texto para inglês',
    'mode' => 'batch',
    'settings' => [
        'preserveFormatting' => true,
        'removeEmptyLines' => false
    ],
    'timestamp' => date('c'),
    'has_files' => false,
    'has_text' => true,
    'files' => [],
    'files_count' => 0
];

$response3 = sendToWebhook($webhookUrl, $oldFormatPayload);
echo "Resposta: " . json_encode($response3, JSON_PRETTY_PRINT) . "\n\n";

function sendToWebhook($url, $payload) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    if ($error) {
        return [
            'error' => $error,
            'http_code' => $httpCode
        ];
    }
    
    return [
        'http_code' => $httpCode,
        'response' => json_decode($response, true) ?: $response
    ];
}

echo "=== TESTES CONCLUÍDOS ===\n";
echo "Webhook URL: $webhookUrl\n";
echo "NOVO FORMATO: { message: '...', sessionId: 'sense-website' }\n";
echo "Verifique no n8n se os dados chegaram no formato correto.\n";