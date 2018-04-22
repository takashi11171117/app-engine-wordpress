<?php
    include('header.php');
    View::breadcrumb( $post, Util::which_temp(), Util::get_query() );
?>
<div id="main" class="archive">
        <div class="wr">
            <div class="content">
                <div class="row">
                    <div class="left col-lg-9 col">
                        <div class="row row-eq-height">
                            <?php if (have_posts()) : ?>
                                <?php while (have_posts()) : the_post(); ?>
                                    <article class="col-sm-6 col">
                                        <a href="<?php the_permalink();?>" class="link">
                                            <?php Controller::get_thumbnail(); ?>
                                            <h2><?php echo Controller::get_archive_title( $post ); ?></h2>
                                            <p class="time"><span><i class="fa fa-clock-o"></i> <?php the_time("Y/m/d"); ?></span></p>
                                            <div class="con post_content">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        </a>
                                    </article>
                                <?php endwhile; ?><?php else : ?>
                                コンテンツがない時の表示
                            <?php endif; ?>
                        </div>
                        <?php
                            if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
                            wp_reset_query();
                        ?>
                    </div>
                    <?php include('sidebar.php'); ?>
                </div>
            </div>
        </div>
    </div>
<?php include('footer.php'); ?>
