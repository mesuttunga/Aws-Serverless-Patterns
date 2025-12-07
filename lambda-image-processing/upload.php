<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$s3Client = new S3Client([
    'version' => 'latest',
    'region'  => 'eu-west-2'
]);

$bucketName = 'yourbucket-s3';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    
    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        $message = "<p style='color:red;'>Error: Only image files allowed (JPG, PNG, GIF)</p>";
    } else {
        try {
            // Generate unique filename with user- prefix
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = 'user-' . time() . '-' . uniqid() . '.' . $extension;
            
            // Upload to S3
            $result = $s3Client->putObject([
                'Bucket' => $bucketName,
                'Key'    => $fileName,
                'SourceFile' => $file['tmp_name'],
                'ContentType' => $file['type'],
                'ACL'    => 'private'
            ]);
            
            $message = "<p style='color:green;'>✅ Image uploaded successfully!</p>";
            $message .= "<p><strong>File:</strong> $fileName</p>";
            $message .= "<p><strong>Size:</strong> " . number_format($file['size'] / 1024, 2) . " KB</p>";
            $message .= "<p>🔄 Lambda function is processing the image...</p>";
            $message .= "<p>Check <strong>yourbucket-s3-compressed</strong> bucket for compressed version!</p>";
            
        } catch (AwsException $e) {
            $message = "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Image Upload - Lambda Compression Demo</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 50px auto; padding: 20px; }
        .upload-box { border: 2px dashed #ccc; padding: 30px; text-align: center; }
        input[type="file"] { margin: 20px 0; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>📸 Image Upload - Lambda Compression Demo</h1>
    
    <?php echo $message; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="upload-box">
            <h3>Upload an Image</h3>
            <p>Supported formats: JPG, PNG, GIF</p>
            <input type="file" name="image" accept="image/*" required>
            <br>
            <button type="submit">Upload & Compress</button>
        </div>
    </form>
    
    <hr>
    <h3>📋 How it works:</h3>
    <ol>
        <li>Upload image → S3 bucket (yourbucket-s3) with <code>user-</code> prefix</li>
        <li>S3 triggers Lambda function automatically</li>
        <li>Lambda compresses image</li>
        <li>Compressed image saved to yourbucket-s3-compressed bucket</li>
    </ol>
</body>
</html>
