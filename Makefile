LIBS_URL="http://www.camptocamp.com/~sypasche/cartoweb3/cartoweb3_includes.tgz"

all:
	:

fetch_libs:
	-rm -r include
	wget -O- $(LIBS_URL) | tar xzf -

clean:
	find -name "*~" -type f -exec  rm {} \;
	find www-data -type f|xargs -r rm
	rm -f templates_c/*
	find -type l -exec rm {} \;

dirs:
	-mkdir -p www-data/mapinfo_cache
	-mkdir -p www-data/images
	-mkdir -p www-data/saved_posts
	-mkdir -p templates_c

links:
	ln -snf ../www-data/images htdocs/images

perms:
	chmod +x scripts/*sh scripts/*py
	chmod 777 log
	chmod -R 777 www-data
	chmod 777 templates_c
	
perms_sudo:
	sudo chown www-data log
	sudo chown -R www-data www-data
	sudo chown www-data templates_c

create_config:
	for i in `find -name "*.dist"`; do \
	 cp -i $$i $${i%%.dist} ;  \
	done

htlinks:
	(cd scripts; chmod a+x htlinks.sh; ./htlinks.sh)

init: fetch_libs dirs perms links create_config htlinks
	:

init_sudo: fetch_libs dirs perms_sudo links create_config htlinks
	:
