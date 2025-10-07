<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AgenteIAController extends Controller
{
    /**
     * Faz upload de múltiplos arquivos para processamento pelo agente IA
     */
    public function uploadFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array|max:10', // Máximo 10 arquivos por vez
            'files.*' => 'file|max:10240|mimes:pdf,doc,docx,txt,jpg,jpeg,png,gif,webp', // 10MB por arquivo
        ], [
            'files.required' => 'É necessário enviar pelo menos um arquivo.',
            'files.max' => 'Máximo de 10 arquivos por vez.',
            'files.*.max' => 'Cada arquivo deve ter no máximo 10MB.',
            'files.*.mimes' => 'Tipos de arquivo permitidos: PDF, DOC, DOCX, TXT, JPG, JPEG, PNG, GIF, WEBP.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro na validação dos arquivos.',
                'errors' => $validator->errors()
            ], 422);
        }

        $uploadedFiles = [];
        $sessionId = Str::uuid();

        try {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $mimeType = $file->getMimeType();
                $size = $file->getSize();
                
                // Gerar nome único para o arquivo
                $filename = $sessionId . '_' . time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
                
                // Salvar no storage
                $path = $file->storeAs('agente-ia/uploads', $filename, 'local');
                
                $uploadedFiles[] = [
                    'original_name' => $originalName,
                    'stored_name' => $filename,
                    'path' => $path,
                    'size' => $size,
                    'mime_type' => $mimeType,
                    'extension' => $extension,
                    'url' => Storage::url($path)
                ];
            }

            return response()->json([
                'success' => true,
                'message' => count($uploadedFiles) . ' arquivo(s) enviado(s) com sucesso!',
                'session_id' => $sessionId,
                'files' => $uploadedFiles
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao fazer upload dos arquivos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lista arquivos de uma sessão específica
     */
    public function getSessionFiles(Request $request, $sessionId)
    {
        try {
            $files = Storage::files('agente-ia/uploads');
            $sessionFiles = [];

            foreach ($files as $file) {
                if (Str::startsWith(basename($file), $sessionId . '_')) {
                    $sessionFiles[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'size' => Storage::size($file),
                        'modified' => Storage::lastModified($file),
                        'url' => Storage::url($file)
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'files' => $sessionFiles
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar arquivos da sessão: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove arquivos de uma sessão
     */
    public function deleteSessionFiles(Request $request, $sessionId)
    {
        try {
            $files = Storage::files('agente-ia/uploads');
            $deletedCount = 0;

            foreach ($files as $file) {
                if (Str::startsWith(basename($file), $sessionId . '_')) {
                    Storage::delete($file);
                    $deletedCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => $deletedCount . ' arquivo(s) removido(s) com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover arquivos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Processa os arquivos com o agente IA
     */
    public function processFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required|string',
            'processing_type' => 'required|string|in:translate,summarize,analyze,extract,categorize,custom,genealogy',
            'target_language' => 'nullable|string',
            'custom_instructions' => 'nullable|string',
            'processing_mode' => 'required|string|in:batch,individual',
            'text' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos para processamento.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $sessionId = $request->session_id;
            $files = Storage::files('agente-ia/uploads');
            $sessionFiles = [];
            $filesData = [];

            // Buscar arquivos da sessão e preparar dados
            foreach ($files as $file) {
                if (Str::startsWith(basename($file), $sessionId . '_')) {
                    $filePath = Storage::path($file);
                    $fileContent = null;
                    $fileName = basename($file);
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    
                    // Para arquivos de texto, ler o conteúdo
                    if (in_array(strtolower($extension), ['txt', 'csv', 'json', 'xml', 'md'])) {
                        $fileContent = Storage::get($file);
                    }
                    
                    $fileSize = Storage::size($file);
                    $mimeType = Storage::mimeType($file);
                    $lastModified = Storage::lastModified($file);
                    $originalName = str_replace($sessionId . '_' . explode('_', $fileName)[1] . '_', '', $fileName);
                    
                    $sessionFiles[] = [
                        'name' => $fileName,
                        'original_name' => $originalName,
                        'path' => $file,
                        'size' => $fileSize,
                        'extension' => $extension,
                        'content' => $fileContent,
                        'processed' => false
                    ];
                    
                    $filesData[] = [
                        'name' => $fileName,
                        'original_name' => $originalName,
                        'size' => $fileSize,
                        'size_formatted' => $this->formatBytes($fileSize),
                        'type' => $extension,
                        'mime_type' => $mimeType,
                        'content' => $fileContent,
                        'last_modified' => date('Y-m-d H:i:s', $lastModified),
                        'can_read_content' => in_array(strtolower($extension), ['txt', 'csv', 'json', 'xml', 'md']),
                        'file_url' => Storage::url($file)
                    ];
                }
            }

            // Preparar payload para o webhook no formato solicitado
            $message = $request->text;
            
            // Se há arquivos, incluir informações na mensagem
            if (!empty($filesData)) {
                $filesList = [];
                foreach ($filesData as $file) {
                    $filesList[] = "- {$file['name']} ({$file['type']}, {$file['size']} bytes)";
                }
                
                $message = $request->text . "\n\nArquivos anexados:\n" . implode("\n", $filesList);
                
                // Se há conteúdo de texto dos arquivos, incluir
                foreach ($filesData as $file) {
                    if ($file['content']) {
                        $message .= "\n\nConteúdo do arquivo {$file['name']}:\n" . $file['content'];
                    }
                }
            }

            $webhookPayload = [
                'message' => $message,
                'sessionId' => 'sense-website',
                'processing_type' => $request->processing_type, // Tipo de processamento em nível principal
                'files' => $filesData, // Dados completos dos arquivos para o agente processar
                'metadata' => [
                    'session_id' => $sessionId,
                    'processing_type' => $request->processing_type,
                    'target_language' => $request->target_language,
                    'custom_instructions' => $request->custom_instructions,
                    'processing_mode' => $request->processing_mode,
                    'files_count' => count($filesData),
                    'has_files' => !empty($filesData),
                    'has_text' => !empty($request->text),
                    'timestamp' => now()->toISOString()
                ]
            ];

            // Enviar para o webhook
            $webhookUrl = 'https://sense-n8n.lbbcpb.easypanel.host/webhook/central';
            
            $response = Http::timeout(30)->post($webhookUrl, $webhookPayload);

            if ($response->successful()) {
                $responseData = $response->json();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Dados enviados para processamento no webhook com sucesso!',
                    'session_id' => $sessionId,
                    'processing_type' => $request->processing_type,
                    'files_count' => count($sessionFiles),
                    'webhook_response' => $responseData,
                    'webhook_status' => $response->status(),
                    'status' => 'sent_to_webhook'
                ]);
            } else {
                // Capturar erro específico do webhook
                $errorBody = $response->body();
                $errorData = $response->json();
                
                return response()->json([
                    'success' => false,
                    'message' => 'Webhook retornou erro: ' . ($errorData['message'] ?? $errorBody),
                    'webhook_error' => $errorData,
                    'webhook_status' => $response->status(),
                    'webhook_body' => $errorBody
                ], 422); // Mudando para 422 em vez de 500 para diferencar de erros internos
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar arquivos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Processa apenas texto via webhook
     */
    public function processText(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string',
            'processing_type' => 'required|string|in:translate,summarize,analyze,extract,categorize,custom,genealogy',
            'target_language' => 'nullable|string',
            'custom_instructions' => 'nullable|string',
            'processing_mode' => 'required|string|in:batch,individual',
            'settings' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos para processamento.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Preparar payload para o webhook no formato solicitado
            $webhookPayload = [
                'message' => $request->text,
                'sessionId' => 'sense-website',
                'processing_type' => $request->processing_type, // Tipo de processamento em nível principal
                'files' => [], // Array vazio para texto simples
                'metadata' => [
                    'processing_type' => $request->processing_type,
                    'target_language' => $request->target_language,
                    'custom_instructions' => $request->custom_instructions,
                    'processing_mode' => $request->processing_mode,
                    'settings' => $request->settings ?? [],
                    'files_count' => 0,
                    'has_files' => false,
                    'has_text' => true,
                    'timestamp' => now()->toISOString()
                ]
            ];

            // Enviar para o webhook
            $webhookUrl = 'https://sense-n8n.lbbcpb.easypanel.host/webhook/central';
            
            $response = Http::timeout(30)->post($webhookUrl, $webhookPayload);

            if ($response->successful()) {
                $responseData = $response->json();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Texto enviado para processamento no webhook com sucesso!',
                    'webhook_response' => $responseData,
                    'webhook_status' => $response->status(),
                    'status' => 'sent_to_webhook'
                ]);
            } else {
                // Capturar erro específico do webhook
                $errorBody = $response->body();
                $errorData = $response->json();
                
                return response()->json([
                    'success' => false,
                    'message' => 'Webhook retornou erro: ' . ($errorData['message'] ?? $errorBody),
                    'webhook_error' => $errorData,
                    'webhook_status' => $response->status(),
                    'webhook_body' => $errorBody
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Erro ao processar texto no webhook: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro interno ao processar texto no webhook.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Formata bytes em formato legível
     */
    private function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}