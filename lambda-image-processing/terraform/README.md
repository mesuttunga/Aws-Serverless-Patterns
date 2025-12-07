# Lambda Image Processing Terraform

Infrastructure as Code for event-driven image processing with Lambda and S3.

## Prerequisites

1. **Package Lambda function first:**
```bash
cd ../lambda
npm install
zip -r function.zip index.js node_modules/
```

## Quick Deploy

```bash
# Initialize Terraform
terraform init

# Review infrastructure plan
terraform plan

# Create infrastructure
terraform apply

# View outputs (bucket names, Lambda ARN)
terraform output
```

## What Gets Created

- **Source S3 Bucket** - For image uploads
- **Compressed S3 Bucket** - For processed images
- **Lambda Function** - Image processing (Node.js 24.x, 512MB, 60s timeout)
- **IAM Role & Policy** - S3 read/write permissions
- **S3 Event Trigger** - Automatic Lambda invocation on upload

## Testing

```bash
# Get bucket name from outputs
SOURCE_BUCKET=$(terraform output -raw source_bucket_name)

# Upload test image
aws s3 cp test-image.jpg s3://$SOURCE_BUCKET/user-test.jpg

# Check Lambda logs
aws logs tail /aws/lambda/image-processor-processor --follow

# Verify compressed output
COMPRESSED_BUCKET=$(terraform output -raw compressed_bucket_name)
aws s3 ls s3://$COMPRESSED_BUCKET/
```

## Clean Up

```bash
# Empty buckets first
aws s3 rm s3://$(terraform output -raw source_bucket_name) --recursive
aws s3 rm s3://$(terraform output -raw compressed_bucket_name) --recursive

# Destroy infrastructure
terraform destroy
```

## Estimated Cost

For 10,000 images/month (avg 2MB each):
- Lambda: ~$1.00/month
- S3 Storage: ~$0.50/month
- **Total: ~$1.50/month**

## Customization

Edit `variables.tf` to change:
- `project_name` - Bucket name prefix
- `aws_region` - AWS region
- `environment` - Environment tag