# SQS Fanout Terraform

Infrastructure as Code for SQS fanout messaging pattern.

## Quick Deploy

```bash
# Initialize Terraform
terraform init

# Review what will be created
terraform plan

# Create infrastructure
terraform apply

# Get queue URLs
terraform output
```

## What Gets Created

- 3 SQS Queues (Email, Shipping, Inventory)
- Long polling enabled (20s)
- 4-day message retention
- 30s visibility timeout

## Clean Up

```bash
terraform destroy
```

## Estimated Cost

~$0.40/month for 1M messages (within free tier)