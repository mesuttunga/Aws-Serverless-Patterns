<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

require 'vendor/autoload.php';

use Aws\Sqs\SqsClient;

// Create SQS Client (v3 syntax - uses IAM Role)
$client = SqsClient::factory([
    'region'  => 'eu-west-2',
    'version' => 'latest'
]);

// Queue URL
$queueUrl = 'https://sqs.eu-west-2.amazonaws.com/YOUR_ACCOUNT/InventoryQueue';

echo "<h1>📦 Inventory Queue Reader</h1>";
echo "<p><strong>Queue:</strong> $queueUrl</p>";

try {
    // Read messages
    $result = $client->receiveMessage([
        'QueueUrl' => $queueUrl,
        'MaxNumberOfMessages' => 10,
        'WaitTimeSeconds' => 5,
    ]);
    
    $messages = $result->get('Messages');
    
    if ($messages) {
        echo "<h2>✅ " . count($messages) . " messages found:</h2>";
        
        foreach ($messages as $message) {
            echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0; background:#f9f9f9;'>";
            echo "<strong>📨 Message Body:</strong><br>";
            
            $body = json_decode($message['Body'], true);
            if ($body) {
                echo "<pre>" . json_encode($body, JSON_PRETTY_PRINT) . "</pre>";
            } else {
                echo "<pre>" . htmlspecialchars($message['Body']) . "</pre>";
            }
            
            echo "</div>";
            
            // Delete the message
            $client->deleteMessage([
                'QueueUrl' => $queueUrl,
                'ReceiptHandle' => $message['ReceiptHandle']
            ]);
            echo "<p style='color:green;'>✅ Message processed and deleted</p>";
        }
    } else {
        echo "<p style='color:orange;'>⚠️ No messages in the queue</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
