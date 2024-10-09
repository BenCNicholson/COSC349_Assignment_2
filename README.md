Steps to deploy!

<h1>COSC349 A2</h1>

<h2>About</h2>
<p>In this assignment we created a deployable piece of cloud software. The software in question is a simple Room-Booker app. Utilising two EC2 instances with a MYSQL RDS back end</p>
<h2>Developers</h2>
<p>James Liu & Ben Nicholson</p>

<h2>Access link</h2>

ADMIN EMAIL = admin@example.com 
ADMIN PW = root

http://54.224.121.104/


<h2>How to deploy manually</h2>

clone the repo: https://github.com/BenCNicholson/COSC349\_Assignment\_2
  
cd \~/../COSC349\_Assignment2
   
run: vagrant up

run vagrant ssh
    
copy your AWS CLI into \~/.aws/credentials
     
run: aws configure (set region to "us-east-1"
    
Gather a keypair from AWS
    
Set the setup-webservers.tf keypair names to your designated keypair
   
run: terraform init
   
run terraform plan
     
run terraform apply
    
gather the printed addresses.
    
ssh into both the Admin-Server and Web-Server
  
Configure /var/www/main/dbconnect.php by passing in the addresses
  
run: sudo chmod +x /var/www/main/database/setupDatabase.sh
    
run: /var/www/main/database/setupDatabase.sh
    
Use the WebServer address in the browser, explore the webpage.
