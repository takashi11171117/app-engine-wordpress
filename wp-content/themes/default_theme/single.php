<?php
    include('header.php');
    View::breadcrumb( $post, Util::which_temp(), Util::get_query() );
?>
<div id="main" class="single">
        <div class="wr">
            <div class="content">
                <div class="row">
                    <article class="left col-lg-9 col">
                            <?php if (have_posts()) : ?>
                                <?php while (have_posts()) : the_post(); ?>
                                    <h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                                    <?php View::cat_tag_list( $post ); ?>
                                    <p class="time"><span><i class="fa fa-clock-o"></i> <?php the_time("Y/m/d"); ?></span></p>
                                    <div class="share">
                                        <svg class="defs" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <symbol id="icon-facebook" viewBox="0 0 100 100">
                                                    <path d="M74.93,43.62a6.07,6.07,0,0,1,4.38,1.8,6,6,0,0,1,1.85,4.43v6.23a5.94,5.94,0,0,1-1.85,4.43,6.07,6.07,0,0,1-4.38,1.8H56.23V93.48A6.32,6.32,0,0,1,50,99.71H43.77a5.94,5.94,0,0,1-4.43-1.85,6.06,6.06,0,0,1-1.8-4.38V62.32H31.3a6.15,6.15,0,0,1-6.23-6.23V49.85a6.15,6.15,0,0,1,6.23-6.23h6.23V24.93A24,24,0,0,1,44.84,7.3,24,24,0,0,1,62.46,0H74.93a6,6,0,0,1,4.43,1.8,6,6,0,0,1,1.8,4.43v6.23a6.15,6.15,0,0,1-6.23,6.23H62.46a6.15,6.15,0,0,0-6.23,6.23v18.7h18.7Z"/>
                                                </symbol>
                                                <symbol id="icon-twitter" viewBox="0 0 100 100">
                                                    <path d="M97.08,29.11a13.14,13.14,0,0,1-3.31,2.58A21.6,21.6,0,0,1,90.7,33q-1.46.49-2.39,0.73a1.06,1.06,0,0,0-.92.54,65.86,65.86,0,0,1-2.14,16.55,61,61,0,0,1-6.72,16A60.05,60.05,0,0,1,67.48,80.43,48.82,48.82,0,0,1,51.7,89.92a56.12,56.12,0,0,1-20.2,3.55q-12.47,0-20.59-3.6T0.15,81.21a24.8,24.8,0,0,0,3.41,0Q6,81,6.38,81q4,0,6.43-.1t6.33-.63A25,25,0,0,0,26,78.38a17.61,17.61,0,0,0,5.26-3.6,23.48,23.48,0,0,1-12.51-3.65,17,17,0,0,1-7.45-9.49,18.33,18.33,0,0,0,3.8.39,19.07,19.07,0,0,0,5.45-.78Q6.38,58.42,6.38,43.62q3.11,0,7-.1a14.47,14.47,0,0,1-5.45-6.28A23.55,23.55,0,0,1,6.38,28q0-4,3.12-9.35A47.2,47.2,0,0,0,26.92,32.23,64.44,64.44,0,0,0,50,37.39a11.06,11.06,0,0,1-.19-2.58q0-1.9.1-4.14T50,28Q50,20,55.11,16.21t14.07-3.75a19.63,19.63,0,0,1,14.9,6.43,16.41,16.41,0,0,0,3.51-1.07,24.67,24.67,0,0,0,3.07-1.51q1.22-.73,3.21-2t2.87-1.85q-3,9.45-8.67,12.85a111.68,111.68,0,0,1,11.78-.39A14.1,14.1,0,0,1,97.08,29.11Z"/>
                                                </symbol>
                                                <symbol id="icon-line" viewBox="0 0 100 100">
                                                    <path d="M49.85,2.37q20.91,0,35.53,11.92T100,43q0,15.79-13.89,28.22A140.72,140.72,0,0,1,62.5,89.51q-14.11,8.92-16.3,8Q44.44,96.81,45,94a33.68,33.68,0,0,1,1.68-5.63,5.11,5.11,0,0,0-.37-5,43,43,0,0,0-5-.88Q23.1,80,11.55,69T0,42.87Q0,26.06,14.55,14.22T49.85,2.37ZM21.35,56.47h8.48q2.34,0,2.34-2.63,0-2.34-2.63-2.34H22.66q-0.59,0-.58-2.63V34.1q0-2.63-2.49-2.63T17.11,34.1V51.93q0,2.78,1.1,3.65A4.92,4.92,0,0,0,21.35,56.47Zm19.15-2V34.1a2.65,2.65,0,0,0-.73-1.83,2.46,2.46,0,0,0-1.9-.8,2.29,2.29,0,0,0-1.75.8,2.64,2.64,0,0,0-.73,1.83V54.42q0,2.34,2.63,2.34a2.54,2.54,0,0,0,1.75-.66A2.16,2.16,0,0,0,40.5,54.42Zm24-2.78V33.81q0-2.34-2.63-2.34t-2.49,2.34V46.67L50.88,34.83q-1.9-3.36-4.39-3.36t-2.34,4.24V54.42q0,2.34,2.49,2.34t2.49-2.34V41.12L57.6,53q0.29,0.44,1,1.32l0.88,1.17a3.26,3.26,0,0,0,.73.66,3.59,3.59,0,0,0,1,.51,3.77,3.77,0,0,0,1.17.15Q64.47,56.76,64.47,51.64ZM80.85,41.55H73.39V37.31a0.85,0.85,0,0,1,.88-1h6.58q2.63,0,2.63-2.49T80.7,31.32H72.22q-3.95,0-3.95,4.09V51.93q0,4.53,3.95,4.53h8.63a2.33,2.33,0,0,0,2.63-2.63q0-2.48-2.63-2.49H74.42a0.85,0.85,0,0,1-1-.88V46.38h7.75q2.19,0,2.19-2.49T80.85,41.55Z"/>
                                                </symbol>
                                            </defs>
                                        </svg>
                                        <div id="fb-root"></div>
                                        <script>(function(d, s, id) {
                                            var js, fjs = d.getElementsByTagName(s)[0];
                                            if (d.getElementById(id)) return;
                                            js = d.createElement(s); js.id = id;
                                            js.src = 'https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.11';
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));</script>
                                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                                        <ul>
                                            <li class="fb-share-button sns-button facebook"><a href="http://www.facebook.com/share.php?u=<?php echo esc_url( get_permalink() ); ?>" onclick="window.open(this.href, \'window\', \'width=550, height=450,personalbar=0,toolbar=0,scrollbars=1,resizable=1\'); return false;"><svg class="icon_white" width="14" height="14"><use xlink:href="#icon-facebook"></use></svg> <span>シェア</span></a></li>
                                            <li class="tweet-button sns-button twitter"><a class="button-twitter" href="http://twitter.com/share?original_referer=<?php echo esc_url( get_permalink() ); ?>&ref_src=twsrc%5Etfw&text=<?php echo trim( wp_title( '', false ) ); ?>&tw_p=tweetbutton&url=<?php echo esc_url( get_permalink() ); ?>" onclick="window.open(encodeURI(decodeURI(this.href)), \'tweetwindow\', \'width=550, height=450, personalbar=0, toolbar=0, scrollbars=1, resizable=1\' ); return false;" target="_blank"><svg class="icon_white" width="14" height="14"><use xlink:href="#icon-twitter"></use></svg> <span>ツイート</span></a></li>
                                            <li class="line"><a href="http://line.me/R/msg/text/?<?php echo esc_url( get_permalink() ); ?>" target="_blank"><svg class="icon_white" width="14" height="14"><use xlink:href="#icon-line"></use></svg> <span>LINE</span></a></li>
                                        </ul>
                                    </div>
                                    <?php Controller::get_thumbnail(); ?>
                                    <div class="con post_content">
                                        <?php the_content(); ?>
                                    </div>
                                <?php endwhile; ?><?php else : ?>
                                コンテンツがない時の表示
                            <?php endif; ?>
                        </article>
                    <?php include('sidebar.php'); ?>
                </div>
            </div>
        </div>
    </div>
<?php include('footer.php'); ?>
