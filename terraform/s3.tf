# PDF保存用S3バケット
resource "aws_s3_bucket" "pdf" {
  bucket = "pinposiplus-pdfs"

  tags = {
    Name = "pinposiplus-pdfs"
  }
}

# パブリックアクセス設定（PDF公開URLのため）
resource "aws_s3_bucket_public_access_block" "pdf" {
  bucket = aws_s3_bucket.pdf.id

  block_public_acls       = false
  block_public_policy     = false
  ignore_public_acls      = false
  restrict_public_buckets = false
}
