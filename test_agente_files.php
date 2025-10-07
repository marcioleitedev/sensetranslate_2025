<?php
/**
 * Teste para verificar a funcionalidade de envio de arquivos ao agente IA
 */

require_once 'vendor/autoload.php';

// Simular dados de arquivo
$testFileData = [
    'name' => 'test-file.pdf',
    'original_name' => 'Documento de Teste.pdf',
    'size' => 1024000, // 1MB
    'size_formatted' => '1.00 MB',
    'type' => 'pdf',
    'mime_type' => 'application/pdf',
    'content' => null, // PDF não tem conteúdo de texto
    'last_modified' => '2025-01-08 10:30:00',
    'can_read_content' => false,
    'file_url' => '/storage/agente-ia/uploads/test-file.pdf'
];

$testTextFileData = [
    'name' => 'notes.txt',
    'original_name' => 'Anotações Importantes.txt',
    'size' => 512,
    'size_formatted' => '512 B',
    'type' => 'txt',
    'mime_type' => 'text/plain',
    'content' => 'Esta é uma anotação importante sobre o projeto.',
    'last_modified' => '2025-01-08 10:25:00',
    'can_read_content' => true,
    'file_url' => '/storage/agente-ia/uploads/notes.txt'
];

// Simular payload que seria enviado ao webhook
$webhookPayload = [
    'message' => 'Analise estes documentos e me dê um resumo',
    'sessionId' => 'user-123',
    'processing_type' => 'analyze', // Tipo de processamento em nível principal
    'files' => [$testFileData, $testTextFileData],
    'metadata' => [
        'processing_type' => 'analyze',
        'target_language' => 'pt-BR',
        'custom_instructions' => null,
        'processing_mode' => 'batch',
        'total_files' => 2,
        'files_with_content' => 1,
        'total_size' => 1024512,
        'total_size_formatted' => '1.00 MB',
        'has_files' => true,
        'has_text' => true,
        'timestamp' => date('Y-m-d H:i:s'),
        'supported_types' => ['pdf', 'docx', 'txt', 'jpg', 'jpeg', 'png', 'gif']
    ]
];

echo "=== TESTE DO PAYLOAD DO AGENTE IA ===\n\n";
echo "Payload JSON que seria enviado ao webhook:\n";
echo json_encode($webhookPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

echo "\n\n=== INFORMAÇÕES DOS ARQUIVOS ===\n";
foreach ($webhookPayload['files'] as $file) {
    echo "\nArquivo: {$file['original_name']}\n";
    echo "- Tamanho: {$file['size_formatted']}\n";
    echo "- Tipo: {$file['type']}\n";
    echo "- MIME: {$file['mime_type']}\n";
    echo "- Pode ler conteúdo: " . ($file['can_read_content'] ? 'Sim' : 'Não') . "\n";
    if ($file['content']) {
        echo "- Conteúdo: {$file['content']}\n";
    }
}

echo "\n\n=== METADADOS ===\n";
foreach ($webhookPayload['metadata'] as $key => $value) {
    if (is_array($value)) {
        echo "- {$key}: " . implode(', ', $value) . "\n";
    } else {
        echo "- {$key}: {$value}\n";
    }
}

echo "\n✅ Teste concluído! O sistema está preparado para enviar dados completos dos arquivos para o agente.\n";