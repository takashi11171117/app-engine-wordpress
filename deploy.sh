rm -rf $PWD/wordpress-project/wordpress/wp-content
cp -r $PWD/wp-content $PWD/wordpress-project/wordpress/wp-content
cd $PWD/wordpress-project
gcloud app deploy
