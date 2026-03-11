# SESメール送信用ドメイン認証
resource "aws_ses_domain_identity" "main" {
  domain = "pinposiplus.com"
}
