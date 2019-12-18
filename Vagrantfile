# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = '2'

@script = <<SCRIPT
# Fix for https://bugs.launchpad.net/ubuntu/+source/livecd-rootfs/+bug/1561250
if ! grep -q "ubuntu-xenial" /etc/hosts; then
    echo "127.1.0.1 ubuntu-xenial" >> /etc/hosts
fi

# Install dependencies
add-apt-repository ppa:ondrej/php
apt-get update
apt-get install -y git curl php7.3-bcmath php7.3-bz2 php7.3-cli php7.3-curl php7.3-intl php7.3-json php7.3-mbstring php7.3-opcache php7.3-soap php7.3-sqlite3 php7.3-xml php7.3-xsl php7.3-zip php-mongodb

if [ -e /usr/local/bin/composer ]; then
    /usr/local/bin/composer self-update
else
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

# Reset home directory of vagrant user
if ! grep -q "cd /var/www" /home/ubuntu/.profile; then
    echo "cd /var/www" >> /home/ubuntu/.profile
fi

echo "** Run the following command to install dependencies, if you have not already:"
echo "    vagrant ssh -c 'composer install'"
SCRIPT

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = 'ubuntu/bionic64'
  config.vm.synced_folder '.', '/var/www'
  config.vm.provision 'shell', inline: @script

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--memory", "1024"]
    vb.customize ["modifyvm", :id, "--name", "PSR11 Monolog"]
  end
end
