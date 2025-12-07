# AWS Serverless Patterns

Production-ready reference implementations for AWS serverless architecture patterns. Each pattern demonstrates event-driven design, decoupled components, and infrastructure as code principles.

![AWS](https://img.shields.io/badge/AWS-Serverless-orange)
![Lambda](https://img.shields.io/badge/Lambda-Node.js_|_Python-blue)
![Terraform](https://img.shields.io/badge/IaC-Terraform-purple)

## 📋 Available Patterns

### 🔄 SQS Fanout Messaging Pattern
**Path:** [`/sqs-fanout-messaging`](./sqs-fanout-messaging)

Multi-queue processing system demonstrating SQS fanout pattern with independent queue readers for email notifications, shipping fulfillment, and inventory management.

**Technologies:** Amazon SQS, PHP, CloudWatch  
**Use Case:** Decoupled order processing workflow  
**Key Features:**
- Independent queue consumers
- Error handling and message visibility
- Scalable message processing

---

### 🖼️ S3 Event-Driven Image Processing
**Path:** [`/lambda-image-processing`](./lambda-image-processing)

Automated image compression pipeline triggered by S3 upload events. Lambda function processes images and stores compressed versions in a separate bucket.

**Technologies:** AWS Lambda (Node.js), S3, CloudWatch Events  
**Use Case:** Automatic image optimization for web applications  
**Key Features:**
- Event-driven architecture
- Automatic scaling
- Cost-effective processing

---

## 🏗️ Architecture Principles

These patterns follow cloud-native best practices:

- **Event-Driven Design** - Components react to events rather than polling
- **Loose Coupling** - Services communicate through managed queues and events
- **Scalability** - Automatic scaling based on demand
- **Cost Optimization** - Pay only for actual usage
- **Infrastructure as Code** - Repeatable deployments with Terraform

## 🛠️ Tech Stack

- **AWS Services:** Lambda, SQS, S3, CloudWatch
- **Languages:** Node.js, Python, PHP
- **Infrastructure:** Terraform
- **Monitoring:** CloudWatch Logs & Metrics

## 🚀 Getting Started

Each pattern directory contains:
- **README.md** - Pattern-specific documentation
- **Architecture diagram** - Visual representation
- **Source code** - Implementation files
- **Terraform configs** - Infrastructure definitions (where applicable)

Navigate to individual pattern directories for detailed setup instructions.

## 📁 Repository Structure

```
aws-serverless-patterns/
├── sqs-fanout-messaging/
│   ├── README.md
│   ├── email-reader.php
│   ├── shipping-reader.php
│   ├── inventory-reader.php
│   └── architecture.md
├── lambda-image-processing/
│   ├── README.md
│   ├── lambda/
│   │   └── index.js
│   ├── terraform/
│   └── architecture.md
└── README.md
```

## 🎯 Use Cases

**E-commerce Order Processing** - SQS fanout pattern  
**Media Asset Management** - Image processing pipeline  
**Microservices Communication** - Event-driven messaging  
**Automated Workflows** - S3 event triggers

## 📚 Related AWS Services

- **Amazon SQS** - Fully managed message queuing
- **AWS Lambda** - Serverless compute
- **Amazon S3** - Object storage with event notifications
- **CloudWatch** - Monitoring and logging

## 🔗 Additional Resources

- [AWS Serverless Application Lens](https://docs.aws.amazon.com/wellarchitected/latest/serverless-applications-lens/)
- [AWS Lambda Best Practices](https://docs.aws.amazon.com/lambda/latest/dg/best-practices.html)
- [Amazon SQS Developer Guide](https://docs.aws.amazon.com/AWSSimpleQueueService/latest/SQSDeveloperGuide/)

## 📝 License

MIT License - see [LICENSE](LICENSE) file for details

---

**Built with ❤️ for production serverless architectures on AWS**