#!/usr/bin/make -f
#
#

# Detect OS
OS = $(shell uname -s)

# Defaults
ECHO = echo

# Make adjustments based on OS
# http://stackoverflow.com/questions/3466166/how-to-check-if-running-in-cygwin-mac-or-linux/27776822#27776822
ifneq (, $(findstring CYGWIN, $(OS)))
	ECHO = /bin/echo -e
endif

# Colors and helptext
NO_COLOR	= \033[0m
ACTION		= \033[32;01m
OK_COLOR	= \033[32;01m
ERROR_COLOR	= \033[31;01m
WARN_COLOR	= \033[33;01m

# Which makefile am I in?
WHERE-AM-I = $(CURDIR)/$(word $(words $(MAKEFILE_LIST)),$(MAKEFILE_LIST))
THIS_MAKEFILE := $(call WHERE-AM-I)

# Echo some nice helptext based on the target comment
HELPTEXT = $(ECHO) "$(ACTION)--->" `egrep "^\# target: $(1) " "$(THIS_MAKEFILE)" | sed "s/\# target: $(1)[ ]*-[ ]* / /g"` "$(NO_COLOR)"

# Check version  and path to command and display on one line
CHECK_VERSION = printf "%-15s %-10s %s\n" "`basename $(1)`" "`$(1) --version $(2)`" "`which $(1)`"



# Add local bin path for test tools
BIN 		= bin
VENDORBIN 	= vendor/bin
NPMBIN		= /usr/bin
NPMBINR		= /usr/lib/node_modules
NPMBINM		= /usr/lib/node_modules/.bin

# SASS and CSS
SASS 		 	= style.scss #style1.scss #style2.scss
SASS_MODULES	= modules/
SASS_OPTIONS 	= --strict-imports --include-path=$(SASS_MODULES)
CSSLINT_OPTIONS = --quiet
FONT_AWESOME 	= modules/font-awesome/fonts/

CSSLINT   := $(NPMBIN)/csslint
STYLELINT := $(NPMBIN)/stylelint
SASSC     := $(NPMBIN)/sass-lint


# Get current working directory, it may not exist as environment variable.
PWD = $(shell pwd)

# target: help                    - Displays help.
.PHONY:  help
help:
	@$(call HELPTEXT,$@)
	@$(ECHO) "Usage:"
	@$(ECHO) " make [target] ..."
	@$(ECHO) "target:"
	@egrep "^# target:" $(THIS_MAKEFILE) | sed 's/# target: / /g'



# target: prepare-build      - Clear and recreate the build directory.
.PHONY: prepare-build
prepare-build:
	@$(call HELPTEXT,$@)
	install -d build/css build/lint



# target: clean              - Remove all generated files.
.PHONY:  clean
clean:
	@$(call HELPTEXT,$@)
	rm -rf build
	rm -f npm-debug.log



# target: clean-all          - Remove all installed files.
.PHONY:  clean-all
clean-all: clean
	@$(call HELPTEXT,$@)
	rm -rf node_modules



# target: check              - Check installed tools.
.PHONY:  check
check: npm-version
	@$(call HELPTEXT,$@)



# target: install            - Install tools neded (including dev).
.PHONY: install
install: npm-install
	@$(call HELPTEXT,$@)



# target: update             - Update codebase including submodules.
.PHONY: update
update:
	@$(call HELPTEXT,$@)
	git pull
	git pull --recurse-submodules && git submodule foreach git pull origin master



# target: test               - Execute all tests.
.PHONY: test
test: less-lint
	@$(call HELPTEXT,$@)



# target: sass               - Compile and minify the stylesheet(s).
.PHONY: sass sass-install sass-lint
sass: prepare-build
	@$(call HELPTEXT,$@)
	
	$(foreach file, $(SASS), $(SASSC) $(SASS_OPTIONS) $(file) build/css/$(basename $(file)).css; )
	$(foreach file, $(SASS), $(SASSC) --clean-css $(SASS_OPTIONS) $(file) build/css/$(basename $(file)).min.css; )

	cp build/css/*.min.css htdocs/css/



# target: sass-install       - Installing the stylesheet(s).
sass-install: sass
	@$(call HELPTEXT,$@)
	if [ -d ../htdocs/css/ ]; then cp build/css/*.min.css ../htdocs/css/; fi
	if [ -d ../htdocs/js/ ]; then rsync -a js/ ../htdocs/js/; fi



# target: sass-lint          - Lint the sass stylesheet(s).
sass-lint: sass
	@$(call HELPTEXT,$@)

	$(foreach file, $(SASS), $(SASSC) --lint $(SASS_OPTIONS) $(file) > build/lint/$(file); )
	@#- $(foreach file, $(SASS), $(CSSLINT) $(CSSLINT_OPTIONS) build/css/$(basename $(file)).css > build/lint/$(basename $(file)).csslint.css; )
	@#- $(foreach file, $(SASS), $(STYLELINT) build/css/$(basename $(file)).css > build/lint/$(basename $(file)).stylelint.css; )
	@#ls -l build/lint/



# target: npm-install        - Install npm development npm packages.
# target: npm-update         - Update npm development npm packages.
# target: npm-version        - Display version for each npm package.
.PHONY: npm-install npm-update npm-version
npm-install: 
	@$(call HELPTEXT,$@)
	npm install

npm-update: 
	@$(call HELPTEXT,$@)
	npm update

npm-version:
	@$(call HELPTEXT,$@)
	@$(call CHECK_VERSION, node)
	@$(call CHECK_VERSION, npm)
	@$(call CHECK_VERSION, $(CSSLINT))
	@$(call CHECK_VERSION, $(STYLELINT))
	@$(call CHECK_VERSION, $(SASSC), | cut -d ' ' -f 2)
