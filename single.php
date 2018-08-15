<?php get_header(); ?>

    <div class="container">
        <div class="content single">
            <?php
            while ( have_posts() ) : the_post();?>

                <h1 class="single__title"><?php the_title();?></h1>

                <div class="single__excerpt">
                    <?php echo get_post_meta($post->ID, 'singleExcerpt', true); ?>
                </div>

                <?php
                if(has_post_thumbnail()): ?>
                    <div class="single__thumbnail">
                        <?php the_post_thumbnail('gg-post-thumbnail'); ?>

                        <div class="share">
                            <span class="share__heading">share</span>
                            <a href="#" class="share__icon"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" class="share__icon"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            <a href="#" class="share__icon"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        </div>
                    </div>                
                <?php
                endif;


                the_content(); 

                the_terms( get_the_ID(), 'tag', '<div class="tag">', '', '</div>');

                if(is_active_sidebar('bb-single-widget-1')): 
                    dynamic_sidebar('bb-single-widget-1');
                endif; 
    
            endwhile;
            ?>
        </div>
    </div>

<?php get_footer() ?>