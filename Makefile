$(info php_sdk makefile)

PHP_INCLUDES ?= $(shell php-config --includes)
#PHP_INCLUDES="-I/usr/include -I/usr/include/php5 -I/usr/include/php5/Zend -I/usr/include/php5/main -I/usr/include/php5/TSRM"
$(info using includes $(PHP_INCLUDES))

all: lrd_php_sdk.so

lrd_php_sdk.so: php_sdk.i sdc_sdk.h
	swig -php php_sdk.i
	gcc -c -fpic example.c php_sdk_wrap.c $(PHP_INCLUDES)
	gcc -shared example.o php_sdk_wrap.o -o lrd_php_sdk.so

install-php_sdk:
	php-config --extension-dir | xargs install -m 644 lrd_php_sdk.so

test-php_sdk: lrd_php_sdk.so
	phpunit unit_php_sdk.php

example.so: example.i example.c
	swig -php example.i
	gcc -c -fpic example.c example_wrap.c $(PHP_INCLUDES)
	gcc -shared example.o example_wrap.o -o example.so

install-example:
	php-config --extension-dir | xargs install -m 644 example.so

test-example: example.so
	phpunit unit_example.php


test: test-example

clean:
	-rm -f php_sdk.stamp
	-rm -f example.php php_example.h
	-rm -f php_sdk.php php_php_sdk.h
	-rm -f *.o *.so *_wrap.c

.PHONY: all clean test install-example
.DEFAULT: all
