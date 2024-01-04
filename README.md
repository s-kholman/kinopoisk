НАСТРОЙКА XAMPP
httpd-vhosts.conf

NameVirtualHost *:80

<VirtualHost test.ru:80>
    
    DocumentRoot "C:\project\test"
    ServerName test.ru
    ServerAlias www.test.ru

    <Directory "C:\project\test">
        Require all granted
		AllowOverride All
    </Directory>
</VirtualHost>