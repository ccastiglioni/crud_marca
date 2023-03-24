# Crud_marca
Teste Desenvolvedor Fullstack (PHP)

- O processo necessário para que seja possível testar o código  
docker build -t image_mysql .
docker run --name  container_mysql -p 3050:3306 -d image_mysql
 
php artisan migrate
php artisan serve (deixe na porta 8000)

- Descreva exemplos das requisições para utilização da API (rota, dados de entrada e retorno).  
depois de se logar é só clicar em cadastro. 
As entradas da API estão na própria interface do CRUD.

usei jwt como gestor do Token