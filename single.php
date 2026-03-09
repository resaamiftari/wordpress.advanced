<? get_header();?>

<div class= "container">

<?php
if(have_posts()) : 
    while (have_posts()): the_post();
?>

   <article class="single-post">

   <!-- titulli i postimit -->

   <h1 style="color:blue"> <?php the_title(); ?></h1>

   <?php if(has_post_thumbnail()) : ?>
      <div class="post-image">
        <?php the_post_thumbnail('large'); ?>
      </div>
    <?php endif;?>


    <!-- Kategorite -->

    <div class="post-categories">
        <strong>Kategorite</strong>
        <?php the_category(', ');?>
   </div>


     <!-- Permbajtja e postimit -->

    <div class="post-content">
        
        <?php the_content();?>
   </div>


     <!-- Tags -->

    <div class="post-tags">
        <strong>Tags</strong>
        <?php the_tags(', ');?>
   </div>


     <!-- Kategorite -->

    <div class="edit-link">
        
        <?php edit_post_link('edito kete postim');?>
   </div>

    </article>

    <?php 
      if(comments_open() || get_comments_number()):
          comments_template();
      endif;
    ?>

<?php
endwhile;
endif;
?>
    </div>

<?php get_footer();?>