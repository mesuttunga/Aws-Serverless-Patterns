output "source_bucket_name" {
  description = "Name of the source S3 bucket"
  value       = aws_s3_bucket.source.bucket
}

output "compressed_bucket_name" {
  description = "Name of the compressed S3 bucket"
  value       = aws_s3_bucket.compressed.bucket
}

output "lambda_function_name" {
  description = "Name of the Lambda function"
  value       = aws_lambda_function.image_processor.function_name
}

output "lambda_function_arn" {
  description = "ARN of the Lambda function"
  value       = aws_lambda_function.image_processor.arn
}

output "upload_command" {
  description = "AWS CLI command to test upload"
  value       = "aws s3 cp test-image.jpg s3://${aws_s3_bucket.source.bucket}/user-test.jpg"
}
