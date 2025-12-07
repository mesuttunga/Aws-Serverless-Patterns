output "email_queue_url" {
  description = "URL of the email queue"
  value       = aws_sqs_queue.email_queue.url
}

output "shipping_queue_url" {
  description = "URL of the shipping queue"
  value       = aws_sqs_queue.shipping_queue.url
}

output "inventory_queue_url" {
  description = "URL of the inventory queue"
  value       = aws_sqs_queue.inventory_queue.url
}

output "all_queue_urls" {
  description = "Map of all queue URLs"
  value = {
    email     = aws_sqs_queue.email_queue.url
    shipping  = aws_sqs_queue.shipping_queue.url
    inventory = aws_sqs_queue.inventory_queue.url
  }
}
