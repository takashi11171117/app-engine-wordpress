docker exec -it dockerappengine_php_1 \
vendor/bin/wp plugin install \
wp-multibyte-patch \
all-in-one-seo-pack \
imsanity \
markdown-editor \
no-category-base-wpml \
table-of-contents-plus \
wp-pagenavi \
wp-stateless \
--activate --allow-root

docker exec -it dockerappengine_php_1 \
vendor/bin/wp theme activate default_theme \
--allow-root
