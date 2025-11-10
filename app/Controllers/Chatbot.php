<?php

namespace App\Controllers;

use App\Models\ChatModel;

class Chatbot extends BaseController
{
    public function index()
    {
        $chatModel = new ChatModel();
        $data = [
            'title' => 'AI Chatbot',
            'user'  => session()->get('user'),   // assuming you store user in session
            'chats' => $chatModel->orderBy('id', 'DESC')->findAll(),
        ];

       return view('admin/chatboat', $data);

    }

    public function send()
    {
        $chatModel = new ChatModel();
        $message   = trim($this->request->getPost('message'));

        if (!$message) {
            return redirect()->back();
        }

        // Get AI reply
        $response = $this->getAIResponse($message);

        // Store in database
        $chatModel->insert([
            'user_id'  => session()->get('user')['id'] ?? null,
            'message'  => $message,
            'response' => $response,
        ]);

        return redirect()->to('/chatbot');
    }

    private function getAIResponse(string $message): string
    {
        // === REAL OPENAI API INTEGRATION ===
        $apiKey = getenv('sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxx'); // set in .env file

        $payload = json_encode([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are EcoBot, a helpful recycling assistant.'],
                ['role' => 'user', 'content' => $message],
            ],
            'max_tokens' => 100,
            'temperature' => 0.7,
        ]);

        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);
        return $data['choices'][0]['message']['content'] ?? 'Sorry, I could not process that.';
    }
}
