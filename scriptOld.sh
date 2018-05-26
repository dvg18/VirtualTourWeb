
#!/bin/bash
sudo apt update
echo "######### Установка LAMP...#########"
package=$(dpkg -l | grep apache2)
if [ -n "$package" ]
then
	echo "######### Apache already installed #########"
else
	echo "#########Installing Apache2...#########"
	sudo apt install apache2
	sudo chmod -R 777 /var/www
fi
package=$(dpkg -l | grep mysql-server)
if [ -n "$package" ]
then
echo "######### MySQL already installed #########"
else
        echo "######### Installing MySQL Server...#########"
        sudo apt install mysql-server
fi
package=$(dpkg -l | grep php7.0*)
if [ -n "$package" ]
then
echo "######### PHP7 already installed #########"
else
        echo "#########Installing PHP7...#########"
        sudo apt install php7.0-mysql php7.0-curl php7.0-json php7.0-cgi php7.0 libapache2-mod-php7.0 php7.0
fi
package=$(dpkg -l | grep phpmyadmin)
if [ -n "$package" ]
then
echo "######### phpmyadmin already installed #########"
else
        echo "######### Installing phpmyadmin...#########"
        sudo apt install phpmyadmin php-mbstring php-gettext
	#ссылки для работы phpmyadmin
	sudo ln -s /etc/phpmyadmin /var/www
	sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-enabled/phpmyadmin.conf
fi
echo "У вас есть готовый проект в Apache? Do you have the existing project in Apache?"
echo -n "Введите Y/N: "
read q
if [[ "$q" = "N" || "$q" = "n" ]]
then
flag=false
echo "Setting project for Apache..."
echo "Введите название проекта для Apache, например - ofteamchat. Type a project name for Apache, for example - ofteamchat"
read project_name
cd ~
sudo mv ofteamchat.conf $project_name.conf
sudo cp $project_name.conf /etc/apache2/sites-available/$project_name.conf
# Активируем сайт:
sudo a2ensite $project_name
# Активируем модуль mod-rewrite (в будущем, думаю, понадобиться):
sudo a2enmod rewrite
# создаём директории для проекта
sudo mkdir -p /var/www/$project_name/public_html
chmod 777 /var/www/$project_name/public_html
# И перезапускаем сервер:
sudo service apache2 restart
else
echo "Введите абсолютный путь до проекта, например - /var/www/ofteamchat/public_html. Type a full path to project, for example - /var/www/ofteamchat/public_html "
read project_path
flag=true
fi
echo "У вас установлен Composer? Do you have an installed Composer?"
echo -n "Введите Y/N: "
read q
if [[ "$q" = "N" || "$q" = "n" ]]
then
cd  ~
sudo apt install curl php-cli php-mbstring unzip
curl -sS https://getcomposer.org/installer -o composer-setup.php
# в той же директории
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
fi
# установка Phinx перейти в папку проекта
if [[ $flag = false ]]
then
cd /var/www/$project_name/public_html
else
cd $project_path
fi
#команды дальше, возможно, будут работать и без sudo (по крайней мере Composer'у не нравится работать из под root)
composer require robmorgan/phinx
#прописать на всякий случай, но может и не понадобиться:
composer install --no-dev
#директории для Phinx
sudo mkdir -p db/migrations db/seeds
sudo chmod 777 db/migrations
sudo chmod 777 db/seeds
sudo vendor/bin/phinx init
# отредактировать файл phinx.yml в корне проекта - задать пароль "pass" и имя БД в разделе development
#echo "Введите пароль для MySQL, который Вы вводили ранее. Type the password for MySQL, which you typed before: "
#read -s p
#if [[ $flag = false ]]
#then
#sudo sed -i '22s/pwd/$p/' /var/www/$project_name/public_html/phinx.yml
#else
#sudo sed -i '22s/pwd/$p/' $project_path/phinx.yml
#fi
