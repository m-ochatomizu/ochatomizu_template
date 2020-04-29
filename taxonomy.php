<?php get_header(); ?>

<section id="wrapperArchiveContents">
	<!-- パンくず -->
	<div id="wrpperPankuzu">
		<a href="<?php echo home_url(); ?>">HOME</a>
		<?php
			$parents = getRootTaxonomies( get_the_terms( $post->ID,'work'), "0" );
			foreach($parents as $pv){
				echo "<ul>\n";
				echo '<li><a href="/work/'.$pv->slug.'">'.$pv->name.'</a></li>'."\n";
				echo "<li><ul>\n";
				foreach($pv->children as $ck=>$cv){
					echo '<li><a
					href="/work/'.$cv->slug.'">'.$cv->name.'</a></li>'."\n";
				}
			echo "</ul></li>\n";
			echo "</ul>\n";
			}
		?>
	</div>
	
	
	<h2 class="titleContents_txt"><?php single_term_title(); ?></h2>

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

                <a href="<?php the_permalink();?>"></a>
            </article>
			<?php endwhile; ?>
			<?php endif; ?>       
            
            <?php if( function_exists("the_pagination") ) the_pagination(); ?>
        </div>
	
    </section>

<?php get_footer(); ?>