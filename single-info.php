<?php get_header(); ?>

<section id="wrapperLowContents">

	<?php if(have_posts()): while(have_posts()):the_post(); ?>
	<!-- パンくず -->
	<div id="wrpperPankuzu">
		<a href="<?php echo home_url(); ?>">HOME</a>
		<a href="<?php echo get_post_type_archive_link( 'info' ); ?>"><?php echo get_post_type_object('info')->label; ?></a>
		<?php echo get_the_term_list( $post->ID, 'info_cat'); ?>
		<?php the_title(); ?>
	</div>
	
        <h1 class="titleContents_single"><?php the_title(); ?></h1>
        <div class="date_single">
			<span class="date_time"><i class="far fa-clock"></i> <?php the_time('Y.m.d'); ?></span>
			<?php
			$before = '<i class="fas fa-tag"></i> '; 
			the_tags( $before, ' / ' ); 
			?>
	</div>
        
        <div id="wrapperSingle">
			
            <?php the_content(); ?>
	
        <div id="navPrevNext">
		<?php if (get_previous_post()):?>
			<div class="btnNextpost"><?php previous_post_link('%link', '<i class="fas fa-angle-double-left"></i> 前の記事へ'); ?></div>
			<?php endif; ?>
			<?php if (get_next_post()):?>
			<div class="btnNextpost"><?php next_post_link('%link', '次の記事へ <i class="fas fa-angle-double-right"></i>'); ?></div>
			<?php endif; ?>
            </div>
        </div>
	<?php endwhile; endif; ?>

	<?php // 現在表示されている投稿と同じタームに分類された投稿を取得
  $taxonomy_slug = 'info_cat'; // タクソノミーのスラッグを指定
  $post_type_slug = 'info'; // 投稿タイプのスラッグを指定
  $post_terms = wp_get_object_terms($post->ID, $taxonomy_slug); // タクソノミーの指定
  if( $post_terms && !is_wp_error($post_terms)) { // 値があるときに作動
    $terms_slug = array(); // 配列のセット
    foreach( $post_terms as $value ){ // 配列の作成
      $terms_slug[] = $value->slug; // タームのスラッグを配列に追加
    }
  }
  $args = array(
    'post_type' => $post_type_slug, // 投稿タイプを指定
    'posts_per_page' => 4, // 表示件数を指定
    'orderby' =>  'rand', // ランダムに投稿を取得
    'post__not_in' => array($post->ID), // 現在の投稿を除外
    'tax_query' => array( // タクソノミーパラメーターを使用
      array(
        'taxonomy' => $taxonomy_slug, // タームを取得タクソノミーを指定
        'field' => 'slug', // スラッグに一致するタームを返す
        'terms' => $terms_slug // タームの配列を指定
      )
    )
  );
  $the_query = new WP_Query($args); if($the_query->have_posts()):
?>

	<div id="wrapperRelation">
	<h3 class="titleContents_single"><i class="fas fa-link"></i> 関連記事</h3>
		<div class="wrapperGlid_relation">
			<?php while ($the_query->have_posts()): $the_query->the_post(); ?>
		<article>
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
					?>
				</h3>
                <a href="<?php the_permalink();?>"></a>
            </article>
			<?php endwhile; ?>
			</div>
	</div>
<?php wp_reset_postdata(); ?>
<?php endif; ?>
    </section>

<?php get_footer(); ?>