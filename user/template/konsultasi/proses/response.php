<?php
// API key dari OpenAI
$api_key = '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';  // Isi dengan API key Anda

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);
    
    // Sanitasi input dari user
    $message = htmlspecialchars($input['message']);

    // Data yang akan dikirim ke API OpenAI
    $data = [
        'model' => 'gpt-4-turbo',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => $message]
        ]
    ];

    // Menggunakan cURL untuk mengirim permintaan ke OpenAI
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Mendapatkan hasil dari API
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        echo json_encode(['reply' => 'Terjadi kesalahan: ' . $error_msg]);
    } else {
        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            $bot_message = $result['choices'][0]['message']['content'];
            echo json_encode(['reply' => $bot_message]);
        } else {
            echo json_encode(['reply' => 'Maaf, tidak ada respons yang diterima dari API.']);
        }
    }

    curl_close($ch);
}
