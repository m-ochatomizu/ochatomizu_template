<?php get_header(); ?>

<section id="wrapperArchiveContents">
	<!-- パンくず -->
	<div id="wrpperPankuzu">
		<a href="<?php echo home_url(); ?>">HOME</a>
		<a href="<?php echo get_post_type_archive_link( 'info' ); ?>"><?php echo get_post_type_object('info')->label; ?></a>
		<?php // 表示しているタームアーカイブの親・先祖タームの情報を取得して表示
		  $term_id = get_queried_object_id(); // タームのIDを取得
		  $ancestors = get_ancestors($term_id, 'info_cat'); // タクソノミースラッグを指定してタームの配列を取得
		  $ancestors = array_reverse($ancestors); // 子親の順番で表示されるので、親子の順番に変更
		  foreach( $ancestors as $ancestor ) { // 配列から個々の値を取り出す
			$parent_term = get_term($ancestor, 'info_cat'); // タームIDとタクソノミースラッグを指定してターム情報を取得
			echo '<a href="'.site_url().'/info/info_cat/'.$slug = $parent_term->slug.'">'.$name = $parent_term->name.'</a>'; // タームスラッグを取得
		  }
		?>
		<?php echo single_term_title() ?>
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
				<p class="category_name" id="taxonomy_category_name">
					<?php // 表示しているタームアーカイブの親・先祖タームの情報を取得して表示
						foreach( $ancestors as $ancestor ) { // 配列から個々の値を取り出す
							$parent_term = get_term($ancestor, 'info_cat'); // タームIDとタクソノミースラッグを指定してターム情報を取得
							echo '<span>'.$name = $parent_term->name.'</span>'; // タームスラッグを取得
						}
					?>
					<span><?php echo single_term_title() ?></span>
				</p>
                <a href="<?php the_permalink();?>"></a>
            </article>
			<?php endwhile; ?>
			<?php endif; ?>       
            
            
        </div>
	<?php if( function_exists("the_pagination") ) the_pagination(); ?>
    </section>

<?php get_footer(); ?>