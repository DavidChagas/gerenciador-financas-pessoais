<h2>Configurações de Ambiente</h2>

<p>
-Instalar XAMPP
<br>
-Instalar Composer
</p>

<p>
No arquivo php.ini remover ; das linhas:<br>
;extension=fileinfo<br>
;extension=pdo_mysql
</p>

<h2>Configuração de Projeto</h2>
    
<p>
-Criar um arquivo chamado .env na raiz do projeto utilizando como base o arquivo .env.example alterando apenas as variáveis DB_USERNAME e DB_PASSWORD conforme as configurações do seu banco de dados.<br>
-Uma base deverá ser criada no mysql, e o nome dado para essa base deverá ser informada na variável DB_DATABASE no arquivo .env<br>
-Na pasta do projeto pelo prompt de comando rodar os seguintes comandos:<br>
>'composer install' para instalar as dependências, caso der erro rodar 'composer install --ignore-platform-reqs'.<br>
>'php artisan migrate' para criar as tabelas no banco de dados.<br>
>'php artisan serve' para levantar o servidor.
</p>
