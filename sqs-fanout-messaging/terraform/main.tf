terraform {
  required_version = ">= 1.0"
  
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.0"
    }
  }
}

provider "aws" {
  region = var.aws_region
}

# Email Queue
resource "aws_sqs_queue" "email_queue" {
  name                       = "${var.project_name}-email-queue"
  visibility_timeout_seconds = 30
  message_retention_seconds  = 345600  # 4 days
  receive_wait_time_seconds  = 20      # Long polling
  
  tags = {
    Name        = "Email Queue"
    Environment = var.environment
    Project     = var.project_name
  }
}

# Shipping Queue
resource "aws_sqs_queue" "shipping_queue" {
  name                       = "${var.project_name}-shipping-queue"
  visibility_timeout_seconds = 30
  message_retention_seconds  = 345600
  receive_wait_time_seconds  = 20
  
  tags = {
    Name        = "Shipping Queue"
    Environment = var.environment
    Project     = var.project_name
  }
}

# Inventory Queue
resource "aws_sqs_queue" "inventory_queue" {
  name                       = "${var.project_name}-inventory-queue"
  visibility_timeout_seconds = 30
  message_retention_seconds  = 345600
  receive_wait_time_seconds  = 20
  
  tags = {
    Name        = "Inventory Queue"
    Environment = var.environment
    Project     = var.project_name
  }
}
