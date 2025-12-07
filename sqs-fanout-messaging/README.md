# SQS Fanout Messaging Pattern

Demonstrates a decoupled order processing system using Amazon SQS with independent queue consumers for email notifications, shipping fulfillment, and inventory management.

## 🏗️ Architecture

```
Order Event (SNS/EventBridge)
         |
         ├──> Email Queue (SQS) ──> Email Reader
         |
         ├──> Shipping Queue (SQS) ──> Shipping Reader
         |
         └──> Inventory Queue (SQS) ──> Inventory Reader
```

### Flow
1. Order event published to SNS topic or EventBridge
2. SNS fans out message to multiple SQS queues
3. Independent consumers process messages from their respective queues
4. Each consumer handles failures independently
5. Processed messages deleted from queue

## 💡 Key Concepts

**Fanout Pattern Benefits:**
- **Decoupling** - Services don't need to know about each other
- **Independent Scaling** - Each consumer scales based on queue depth
- **Fault Isolation** - One consumer failure doesn't affect others
- **Retry Logic** - Built-in message retry with visibility timeout

## 📂 Files

- `email-reader.php` - Processes email notification queue
- `shipping-reader.php` - Handles shipping fulfillment queue  
- `inventory-reader.php` - Manages inventory update queue
- `architecture.md` - Detailed architecture documentation

## 🚀 Running Locally

### Prerequisites
- AWS CLI configured with credentials
- PHP 7.4+ with AWS SDK
- Access to SQS queues

### Setup

1. **Install dependencies:**
```bash
composer require aws/aws-sdk-php
```

2. **Configure AWS credentials:**
```bash
aws configure
```

3. **Update queue URLs in each reader:**
```php
$queueUrl = 'https://sqs.eu-west-2.amazonaws.com/YOUR_ACCOUNT/EmailQueue';
```

4. **Run queue readers:**
```bash
# Terminal 1
php email-reader.php

# Terminal 2  
php shipping-reader.php

# Terminal 3
php inventory-reader.php
```

## 🧪 Testing

### Send test message to queue:
```bash
aws sqs send-message \
  --queue-url https://sqs.eu-west-2.amazonaws.com/YOUR_ACCOUNT/EmailQueue \
  --message-body '{
    "orderId": "12345",
    "email": "customer@example.com",
    "items": ["Product A", "Product B"],
    "total": 99.99
  }'
```

### Monitor queue depth:
```bash
aws sqs get-queue-attributes \
  --queue-url https://sqs.eu-west-2.amazonaws.com/YOUR_ACCOUNT/EmailQueue \
  --attribute-names ApproximateNumberOfMessages
```

## ⚙️ Configuration

### Queue Settings (Recommended)
- **Visibility Timeout:** 30 seconds
- **Message Retention:** 4 days
- **Receive Wait Time:** 20 seconds (long polling)
- **Dead Letter Queue:** Enabled after 3 retries

### Environment Variables
```bash
export AWS_REGION=eu-west-2
export EMAIL_QUEUE_URL=https://sqs.eu-west-2.amazonaws.com/.../EmailQueue
export SHIPPING_QUEUE_URL=https://sqs.eu-west-2.amazonaws.com/.../ShippingQueue
export INVENTORY_QUEUE_URL=https://sqs.eu-west-2.amazonaws.com/.../InventoryQueue
```

## 📊 Monitoring

Track these CloudWatch metrics:
- `ApproximateNumberOfMessagesVisible` - Queue backlog
- `ApproximateAgeOfOldestMessage` - Processing lag
- `NumberOfMessagesSent` - Throughput
- `NumberOfMessagesDeleted` - Successful processing

## 🔧 Error Handling

Each reader implements:
1. **Message validation** - Check required fields
2. **Visibility timeout** - Extend for long-running tasks
3. **Exponential backoff** - Retry failed operations
4. **Dead letter queue** - Move failed messages after max retries
5. **Logging** - CloudWatch integration for debugging

## 💰 Cost Estimation (September 2025)

Assuming 1M messages/month:
- **SQS Requests:** ~$0.40 (1M requests)
- **Data Transfer:** Included in free tier
- **CloudWatch Logs:** ~$0.50
- **Total:** ~$1/month for processing layer

## 🎯 Production Considerations

- Deploy consumers as Lambda functions for automatic scaling
- Use SQS FIFO queues for ordered processing
- Implement idempotency for duplicate message handling
- Set up CloudWatch alarms for queue depth
- Enable encryption at rest with KMS

## 📚 Learn More

- [Amazon SQS Fanout Pattern](https://docs.aws.amazon.com/sns/latest/dg/sns-sqs-as-subscriber.html)
- [SQS Message Visibility](https://docs.aws.amazon.com/AWSSimpleQueueService/latest/SQSDeveloperGuide/sqs-visibility-timeout.html)
- [Dead Letter Queues](https://docs.aws.amazon.com/AWSSimpleQueueService/latest/SQSDeveloperGuide/sqs-dead-letter-queues.html)

---

**Pattern Status:** Production-tested ✅  
**Last Updated:** September 2025