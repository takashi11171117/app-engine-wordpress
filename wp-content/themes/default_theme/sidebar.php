<div class="side col-lg-3 col">
    <div class="title"><i class="fa fa-tags"></i><span class="font">Category</span>カテゴリー</div>
    <?php $terms = get_terms('category'); ?>
    <ul>
        <?php foreach ((array)$terms as $term ) { ?>
            <li><a href="<?php echo esc_url( site_url() ); ?>/category/<?php echo esc_html($term->slug); ?>"><?php echo esc_html($term->name); ?><span><?php echo esc_html($term->count); ?></span></a></li>
        <?php } ?>
    </ul>
    <div class="title"><i class="fa fa-tags"></i><span class="font">Archive</span>アーカイブ</div>
    <?php $archives = View::get_archives_array(); ?>
    <ul>
        <?php foreach ((array)$archives as $archive ) {?>
            <li><a href="<?php echo esc_url( site_url() ); ?>/date/<?php echo $archive->year; ?>/<?php echo $archive->month;?>"><?php echo $archive->year; ?>年<?php echo $archive->month; ?>月<span><?php echo esc_html($archive->posts); ?></span></a></li>
        <?php } ?>
    </ul>
</div>
