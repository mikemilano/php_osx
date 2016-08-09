# PHP on OSX

## Setup
```
brew tap homebrew/dupes
brew install openssl libxml2 mcrypt zlib libpng jpeg-8d
brew link openssl libxml2 --force
````

## Get Source

Download PHP source from http://php.net/downloads.php
```
mkdir /usr/local/src
cd /usr/local/src
curl -O ...php-x.x.x.tar.gz
tar -zxvf php-x.x.x.tar.gz
cd php-x.x.x/
```

## Configure
Copy the `configure.sh` file from the appropriate version directory of this repo, to the root of the php source directory.
```
./configure.sh
```

## Update Makefile
In the `Makefile`, on the line that starts with `EXTRA_LIBS`, replace `-lssl` with `/usr/local/opt/openssl/lib/libssl.dylib` and `-lcrypto` with `/usr/local/opt/openssl/lib/libcrypto.dylib`

## Build
```
make
make install
```

## Configure
The `php.ini` file for PHP 5.6 belongs at: `/etc/php5/php.ini`.

Addition ini configs can be placed in: `/etc/php5/conf.d`.
