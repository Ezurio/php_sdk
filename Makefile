$(info php_sdk makefile)

all:
	@echo "made all"
	touch php_sdk.stamp

clean:
	-rm php_sdk.stamp

.PHONY: all clean
.DEFAULT: all
