<?php
global $wp_query;
get_header(); ?> 
 
<div class="container">
  <div class="content single">
  
  <?php 
  if (have_posts()):
  
    while ( have_posts() ) : the_post(); ?>
      <h1 class="single__title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>

      <div class="single__excerpt">
        <?php echo get_post_meta($post->ID, 'singleExcerpt', true); ?>
      </div>

      
      <?php if(has_post_thumbnail()): ?>
        <div class="single__thumbnail">
            <?php the_post_thumbnail('gg-post-thumbnail'); ?>
        </div>    
      <?php 
      endif;
      the_content(); 

    endwhile; 
 
  if (  $wp_query->max_num_pages > 1 ): ?>
	  <a href="#" class="more">More posts</a>
  <?php
  endif;

  else: ?>
  <p>Sorry, no posts matched your criteria.</p>
  
  
  <?php endif; ?>
  </div>
</div>
 
<?php get_footer(); ?>