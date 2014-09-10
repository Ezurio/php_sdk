$(info php_sdk makefile)

all:
	swig -php example.i
	gcc -c -fpic example.c example_wrap.c -I/usr/include -I/usr/include/php5 -I/usr/include/php5/Zend -I/usr/include/php5/main -I/usr/include/php5/TSRM
	gcc -shared example.o example_wrap.o -o example.so

clean:
	-rm php_sdk.stamp

.PHONY: all clean
.DEFAULT: all
