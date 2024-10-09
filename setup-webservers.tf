provider "aws" {
  region = "us-east-1"
}

resource "aws_security_group" "allow_ssh" {
  name        = "allow_ssh"
  description = "Allow inbound SSH traffic"

  ingress {
    description = "SSH from anywhere"
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

resource "aws_security_group" "allow_web" {
  name        = "allow_web"
  description = "Allow inbound HTTP(S) traffic"

  ingress {
    description = "HTTP from anywhere"
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    description = "HTTPS from anywhere"
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
}

resource "aws_security_group" "rds" {
  name        = "allow_rds"
  description = "Allow inbound MySQL traffic"

  ingress {
    description = "MySQL from web server"
    from_port   = 3306
    to_port     = 3306
    protocol    = "tcp"
    security_groups = [aws_security_group.allow_web.id]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}


resource "aws_db_instance" "mysql_server" {
  identifier             = "sql-server"
  instance_class         = "db.t3.micro"
  allocated_storage      = 5
  engine                 = "mysql"
  engine_version         = "8.0.35"
  username               = "root"
  password               = "insecurePW"
  vpc_security_group_ids = [aws_security_group.rds.id]
  publicly_accessible    = false
  skip_final_snapshot    = true
}


resource "aws_instance" "admin_server" {
  ami           = "ami-010e83f579f15bba0"
  instance_type = "t2.micro"
  key_name      = "COSC349-2024"
  vpc_security_group_ids = [aws_security_group.allow_ssh.id,
              aws_security_group.allow_web.id]

  user_data = templatefile("${path.module}/build-adminserver-vm.tpl", { mysql_server_ip = aws_db_instance.mysql_server.address})
  disable_api_termination = true
  tags = {
    Name = "AdminServer"
  }
}

resource "aws_eip" "admin_server_ip" {
  instance = aws_instance.admin_server.id
}

resource "aws_instance" "web_server" {
  ami           = "ami-010e83f579f15bba0"
  instance_type = "t2.micro"
  key_name      = "COSC349-2024"
  disable_api_termination = true
  vpc_security_group_ids = [aws_security_group.allow_ssh.id,
              aws_security_group.allow_web.id]

  user_data = templatefile("${path.module}/build-webserver-vm.tpl", { mysql_server_ip = aws_db_instance.mysql_server.address, admin_server_ip = = aws_eip.admin_server_ip.public_ip })

  tags = {
    Name = "WebServer"
  }
}

resource "aws_eip" "web_server_ip"{
  instance = aws_instance.web_server.id
}

output "admin_server_elastic_ip" {
  value = aws_eip.admin_server_ip.public_ip
}

output "web_server_elastic_ip" {
  value = aws_eip.web_server_ip.public_ip
}

output "rds_hostname" {
  description = "RDS instance hostname"
  value       = aws_db_instance.mysql_server.address
}

output "rds_port" {
  description = "RDS instance port"
  value       = aws_db_instance.mysql_server.port
}

output "rds_username" {
  description = "RDS instance root username"
  value       = aws_db_instance.mysql_server.username
}
