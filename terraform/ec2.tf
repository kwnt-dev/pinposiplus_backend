# EC2用セキュリティグループ（HTTP/HTTPS/SSH）
resource "aws_security_group" "ec2" {
  name        = "pinposiplus-ec2-sg"
  description = "PinPosiPlus EC2"
  vpc_id      = var.vpc_id

  ingress {
    description = "SSH"
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    description = "HTTP"
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    description = "HTTPS"
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "pinposiplus-ec2-sg"
  }
}

# EC2インスタンス（Docker + Laravel）
resource "aws_instance" "app" {
  ami                    = var.ec2_ami
  instance_type          = "t3.micro"
  key_name               = var.ec2_key_name
  subnet_id              = var.subnet_id
  vpc_security_group_ids = [aws_security_group.ec2.id]

  # GitHub Actionsからのデプロイ先
  tags = {
    Name = "pinposiplus-server"
  }
}
