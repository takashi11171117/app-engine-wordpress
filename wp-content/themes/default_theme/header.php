<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="shortcut icon" href="<?php echo esc_url(content_url()); ?>/img/favicon/favicon.png" />
    <link rel="apple-touch-icon" href="<?php echo esc_url(content_url()); ?>/img/favicon/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url(content_url()); ?>/img/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url(content_url()); ?>/img/favicon/apple-touch-icon-114x114.png" />
    <link href="//fonts.googleapis.com/css?family=Quicksand:400,700" rel="stylesheet" type="text/css" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo esc_url(content_url()); ?>/themes/default_theme/build/css/style.css" rel="stylesheet" />
    <?php wp_enqueue_script('jquery'); ?>
    <?php wp_head(); ?>
</head>
<body>
    <header>
        <div class="header-inner wr">
            <div class="logo">
                <p class="hidden-xs">会社の経営・会計・税務と投資に関するブログ</p>
                <h1><a href="<?php echo esc_url(site_url()); ?>">仮想空間乞食</a></h1>
            </div>
            <div class="search header_search">
                <form role="search" method="get" id="searchform" action="<?php echo esc_url(site_url()); ?>" >
                    <input type="text" value="" name="s" class="s" placeholder="キーワードで検索"/>
                    <div class="submit">
                        <i class="fa fa-search"></i>
                        <input type="submit" class="searchsubmit" value="" />
                    </div>
                </form>
            </div>
            <div class="row-box visible-lg">
                <a href="<?php echo esc_url(site_url()); ?>/management"><span>Management</span><br />経営</a>
                <a href="<?php echo esc_url(site_url()); ?>/investment"><span>Investment</span><br />投資</a>
                <a href="<?php echo esc_url(site_url()); ?>/accounting"><span>Accounting</span><br />会計</a>
                <a href="<?php echo esc_url(site_url()); ?>/tax"><span>Tax Practice</span><br />税務</a>
                <a href="<?php echo esc_url(site_url()); ?>/it"><span>IT</span><br />IT関連</a>
            </div>
            <div class="hidden-lg">
                <div class="buttons">
                    <a class="button">
                        <label class="menu-btn" for="checked">
                            <div><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <div><span>MENU</span></div>
                        </label>
                    </a>
                    <input class="open" type="checkbox" id="checked" />
                    <div class="menu">
                        <div class="search">
                            <form role="search" method="get" id="searchform" action="<?php echo esc_url(site_url()); ?>" >
                               <input type="text" value="" name="s" class="s" placeholder="キーワードで検索"/>
                                <div class="submit">
                                    <i class="fa fa-search"></i>
                                    <input type="submit" class="searchsubmit" value="" />
                                </div>
                            </form>
                        </div>
                        <div>
                            <ul>
                                <li><a href="<?php echo esc_url(site_url()); ?>/management">経営<span>Management</span></a></li>
                                <li><a href="<?php echo esc_url(site_url()); ?>/investment">投資<span>Investment</span></a></li>
                                <li><a href="<?php echo esc_url(site_url()); ?>/accounting">会計<span>Accounting</span></a></li>
                                <li><a href="<?php echo esc_url(site_url()); ?>/tax">税務<span>Tax Practice</span></a></li>
                                <li><a href="<?php echo esc_url(site_url()); ?>/it">IT関連<span>IT</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
