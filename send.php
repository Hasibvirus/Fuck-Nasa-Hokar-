<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $botToken = $_POST['bot_token'];
    $chatId = $_POST['chat_id'];
    $limit = intval($_POST['limit']);
    $message = $_POST['message'];

    // Limit ভ্যালিড কিনা চেক করি
    if ($limit < 10 || $limit > 30) {
        echo "Message limit must be between 10 and 30.";
        exit;
    }

    $url = "https://api.telegram.org/bot$botToken/sendMessage";

    for ($i = 0; $i < $limit; $i++) {
        $postFields = array(
            'chat_id' => $chatId,
            'text' => $message
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode != 200) {
            echo "Failed to send message. Telegram API returned HTTP code $httpCode.<br>";
            echo "Response: $response";
            exit;
        }
    }

    echo "✅ Message sent $limit times successfully.";
} else {
    echo "❌ Invalid request method.";
}
?>
