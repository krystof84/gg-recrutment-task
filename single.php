<?php get_header(); ?>

    <div class="container">
        <div class="content content--single">
            <?php
            while ( have_posts() ) : the_post();?>

                <h1><?php the_title();?></h1>

                <?php
                echo get_post_meta($post->ID, 'singleExcerpt', true);

                if(has_post_thumbnail()) {
                    the_post_thumbnail();
                }


                the_content();

            endwhile;
            ?>
        </div>
    </div>

<?php get_footer() ?>