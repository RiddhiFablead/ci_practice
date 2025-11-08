<?php

namespace App\Controllers;
use App\Models\ChatModel;

class Chatbot extends BaseController
{
    public function index()
    {
        $chatModel = new ChatModel();
        $data['chats'] = $chatModel->orderBy('id', 'DESC')->findAll();

        echo view('layouts/header');
        echo view('layouts/sidebar');
        echo view('chatbot/chat', $data);
        echo view('layouts/footer');
    }

    public function send()
    {
        $message = $this->request->getPost('message');
        $chatModel = new ChatModel();

        // Call AI API (You can replace with OpenAI or custom model)
        $response = $this->callAI($message);

        // Save in DB
        $chatModel->insert([
            'user_id' => session()->get('id') ?? null,
            'message' => $message,
            'response' => $response
        ]);

        return redirect()->to('/chatbot');
    }

    private function callAI($message)
    {
        // Dummy AI Response (you can replace with real API call)
        if (stripos($message, 'hello') !== false) {
            return "👋 Hello! How can I help you recycle today?";
        } elseif (stripos($message, 'reward') !== false) {
            return "💰 You can earn coins by recycling items through our system.";
        } else {
            return "🌱 I’m here to help! Please ask me about recycling, rewards, or orders.";
        }
    }
}
