# PHP Build on OSX

This has been tested successfully with PHP 5.6 on OSX El Capitan.

## Setup

We'll be building PHP from source, but let's use homebrew for the library dependencies.
```
brew tap homebrew/dupes
brew install openssl libxml2 mcrypt zlib libpng jpeg-8d
brew link openssl libxml2 --force
````

## Get the PHP Source

Download PHP source from http://php.net/downloads.php
```
mkdir /usr/local/src
cd /usr/local/src
curl -O ...php-x.x.x.tar.gz
tar -zxvf php-x.x.x.tar.gz
cd php-x.x.x/
```

## Configure the build
Copy the `configure.sh` file from the appropriate version directory of this repo, to the root of the php source directory.
```
./configure.sh
```

## Update Makefile
In the `Makefile`, on the line that starts with `EXTRA_LIBS`

- Remove `-lssl` and `-lcrypto`
- Add `/usr/local/opt/openssl/lib/libssl.dylib /usr/local/opt/openssl/lib/libcrypto.dylib`

Note: For my latest 5.6 configuration, `-libcrypto` was displayed twice on that line. In this case, remove both.

Here's some sed commands that will do the work for you.
```
sed -i '' '/^EXTRA_LIBS/s/ -lssl//g' Makefile
sed -i '' '/^EXTRA_LIBS/s/ -lcrypto//g' Makefile
sed -i '' '/^EXTRA_LIBS/s:$: /usr/local/opt/openssl/lib/libssl.dylib /usr/local/opt/openssl/lib/libcrypto.dylib:' Makefile
```

## Build
```
make
sudo make install
```

## Configure
The `php.ini` file for PHP 5.6 belongs at: `/etc/php56/php.ini`.

Addition ini configs can be placed in: `/etc/php56/conf.d`.

If it's your first time building, the directories may not be created yet.

```
sudo mkdir -p /etc/php56/conf.d
sudo cp php.ini-development /etc/php56/php.ini
```

# Command line path

Since we defined a custom prefix in configure, we need to add the `bin` path of our new php build for command line operations.

Do this by adding the following line to `~/.profile`.
```
export PATH="/usr/local/php56/bin"
```

Once complete, run `source ~/.profile` and then `which php`. The output should resolve to `/usr/local/php56/bin/php`.


## Install xdebug

You can now install xdebug (and other pecl extensions) like this:

```
pecl install xdebug
```

`/etc/php5/conf.d/xdebug.ini`
```
[Xdebug]
zend_extension=xdebug.so
xdebug.remote_enable=1
xdebug.remote_port=9000
xdebug.profiler_enable=0
xdebug.profiler_output_dir=/path/to/xdebug/data
xdebug.max_nesting_level=256
xdebug.remote_connect_back = On
```
