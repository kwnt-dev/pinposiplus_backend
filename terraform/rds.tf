# RDS用セキュリティグループ（EC2からのMySQL接続のみ許可）
resource "aws_security_group" "rds" {
  name        = "pinposiplus-db-sg"
  description = "PinPosiPlus RDS"
  vpc_id      = var.vpc_id

  ingress {
    description     = "MySQL from EC2"
    from_port       = 3306
    to_port         = 3306
    protocol        = "tcp"
    security_groups = [aws_security_group.ec2.id]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "pinposiplus-db-sg"
  }
}

# RDSインスタンス（MySQL 8.0）
resource "aws_db_instance" "mysql" {
  identifier     = "pinposiplus-db"
  engine         = "mysql"
  engine_version = "8.0"
  instance_class = "db.t3.micro"

  allocated_storage = 20
  storage_type      = "gp2"

  username = var.db_username
  password = var.db_password

  vpc_security_group_ids = [aws_security_group.rds.id]
  publicly_accessible    = false
  skip_final_snapshot    = true

  tags = {
    Name = "pinposiplus-db"
  }
}
