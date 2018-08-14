<?php
/* Template Name: Home Page Template */
?>

<?php get_header(); ?>

<div class="container">

    <?php if(has_post_thumbnail()): ?>
        <div class="baner">
            <?php the_post_thumbnail(); ?>
      
            <div class="baner__caption">
                <?php the_post_thumbnail_caption(); ?>
            </div>
      
        </div>     
    <?php endif; ?>

    <?php
    if (have_posts()): 
        while (have_posts()) : the_post(); ?>
            
            <div class="content content--home">
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>

        <?php    
        endwhile;
    endif;
    ?>

</div>

<?php get_footer(); ?>