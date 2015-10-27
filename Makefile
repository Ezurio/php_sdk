#
# Copyright (c) 2015, Laird
#
# Permission to use, copy, modify, and/or distribute this software for any
# purpose with or without fee is hereby granted, provided that the above
# copyright notice and this permission notice appear in all copies
# THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
# WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
# MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
# ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
# WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
# ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
# OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
#--------------------------------------------------------------------------
$(info Building Laird PHP SDK wrapper)

ifndef INCLUDES
$(warning INCLUDES variable should contain PHPs includes and Lairds SDK header files)
endif

CPPFLAGS += $(INCLUDES)
CFLAGS += -fpic
LIB = lrd_php_sdk
OBJS = php_sdk_wrap.o
LIBS = -lsdc_sdk
FIND_REV = $(shell sed -n '/LRD_PHP_SDK_VERSION_MAJOR/s/.* //p' php_sdk.i). \
		$(shell sed -n '/LRD_PHP_SDK_VERSION_MINOR/s/.* //p' php_sdk.i). \
		$(shell sed -n '/LRD_PHP_SDK_VERSION_REVISION/s/.* //p' php_sdk.i)
PHP_SDK_REV = $(subst . ,.,$(FIND_REV))

ifdef HOST_DIR
BUILD_PATH = $(HOST_DIR)/usr/bin/
endif

all: $(LIB)

php_sdk_wrap.c: php_sdk.i
	$(BUILD_PATH)swig -php5 php_sdk.i

$(LIB): $(OBJS)
	$(CC) -shared $(OBJS) -o $(LIB).so.$(PHP_SDK_REV) $(LIBS)

install-php_sdk:
	php-config --extension-dir | xargs install -m 644 $(LIB).so.$(PHP_SDK_REV)
	cd `php-config --extension-dir` && ln -s $(LIB).so.$(PHP_SDK_REV) $(LIB).so

test-php_sdk: $(LIB)
	cd unit/ && phpunit unit_sdk_GetVersion.php

clean:
	-rm -f *.h *.o *.so* *_wrap.c

.PHONY: clean
