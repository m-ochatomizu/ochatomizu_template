<?php get_header(); ?>

<section id="wrapperArchiveContents">
	<!-- パンくず -->
	<?php custom_breadcrumb(); ?>
    <?php
    $args = array(
        'post_type' => 'blog',
    );
    $myposts = get_posts($args);
    ?>
    <?php $post = get_post_type_object( 'blog' ); ?>
		<h2 class="titleContents"><span><?php echo $post->label; ?></span></h2>

        <div class="wrapperGlid_blog">
		<!-- ループで一覧を表示 -->
			<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
            <article class="effect-fade">
                <div class="thumnail"><?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('thumbnail'); ?>
				<?php else : ?>
				<img src="<?php echo catch_that_image(); ?>" alt="<?php the_title(); ?>" />
				<?php endif ; ?></div>
                <p class="date"><?php the_time('Y・m・d'); ?></p>
                <h3><?php
					if(mb_strlen($post->post_title, 'UTF-8')>34){
						$title= mb_substr($post->post_title, 0, 34, 'UTF-8');
						echo $title.'……';
					}else{
						echo $post->post_title;
					}
					?></h3>
				<?php if ($terms = get_the_terms($post->ID, array('work_cat','blog_cat','info_cat','shop_cat'))) : ?>
                <p class="category_name"><?php echo get_the_term_list_nolink( $post->ID, 'blog_cat' , '<span>', ' ／ ', '</span>'); ?></p>
				<?php endif; ?>  
                <a href="<?php the_permalink();?>"></a>
            </article>
			<?php endwhile; ?>
			<?php endif; ?>       
        </div>
<?php if( function_exists("the_pagination") ) the_pagination(); ?>
    </section>

<?php get_footer(); ?>