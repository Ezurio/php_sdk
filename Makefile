$(info php_sdk makefile)

all:
example.so: example.i example.c
	swig -php example.i
	gcc -c -fpic example.c example_wrap.c -I/usr/include -I/usr/include/php5 -I/usr/include/php5/Zend -I/usr/include/php5/main -I/usr/include/php5/TSRM
	gcc -shared example.o example_wrap.o -o example.so

test: test-example

install-example:
	php-config --extension-dir | xargs install -m 644 example.so

test-example: example.so
	phpunit unit_example.php

clean:
	-rm -f php_sdk.stamp
	-rm -f example.php php_example.h
	-rm -f php_sdk.php php_php_sdk.h
	-rm -f *.o *.so *_wrap.c

.PHONY: all clean test install-example
.DEFAULT: all
