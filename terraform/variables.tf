variable "region" {
  default = "ap-northeast-1"
}

variable "az" {
  default = "ap-northeast-1a"
}

variable "vpc_id" {
  default = "vpc-06cd001e1d56ec520"
}

variable "subnet_id" {
  default = "subnet-039db752f7485eb24"
}

variable "ec2_ami" {
  description = "EC2のAMI ID（Amazon Linux 2023等）"
  type        = string
}

variable "ec2_key_name" {
  description = "EC2のSSHキーペア名"
  type        = string
}

variable "db_username" {
  description = "RDSのマスターユーザー名"
  type        = string
  sensitive   = true
}

variable "db_password" {
  description = "RDSのマスターパスワード"
  type        = string
  sensitive   = true
}
