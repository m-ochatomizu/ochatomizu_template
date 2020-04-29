<?php get_header(); ?>
<section id="wrapperMainimg">
    <figure>
<?php
///////////////////////////////////////
// メイン画像表示部分
///////////////////////////////////////
if ( get_the_main_image_url() ) : ?>
<img src='<?php echo get_the_main_image_url(); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' id="mainPC">
<?php else : ?>
<img src="<?php echo get_template_directory_uri(); ?>/images/imgMain.jpg" id="mainPC">
<?php endif; ?>
        
<?php
///////////////////////////////////////
// メイン画像（スマホ）表示部分
///////////////////////////////////////
if ( get_the_main_image_url_sp() ) : ?>
<img src='<?php echo get_the_main_image_url_sp(); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' class="spOnly" id="mainSP">
<?php elseif ( get_the_main_image_url() ): ?>
		<img src='<?php echo get_the_main_image_url(); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' class="spOnly" id="mainSP">
<?php else : ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/imgMain.jpg" id="mainSP">
<?php endif; ?>
        
    </figure>
</section>

<?php if (get_page_by_path('about')) : ?>
<section id="wrapperAbout">
    <h2 class="titleContents"><span>ABOUT</span></h2>
    <div id="wrapperAbout_left" class="effect-fade">
        <div class="imgAbout">
            <?php
///////////////////////////////////////
// プロフィール画像表示部分
///////////////////////////////////////
if ( get_the_profile_image_url() ) : ?>
<img src='<?php echo get_the_profile_image_url(); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
<?php else : ?>
<img src="<?php echo get_template_directory_uri(); ?>/images/imgAbout.png">
<?php endif; ?>
        </div>
    </div>
        <div id="wrapperAbout_right" class="effect-fade">
			<?php
			$page_data = get_page_by_path('about');
			$page_id = $page_data->ID;
			?>
			<?php if (get_post_meta($page_id, 'about_name', true)) : ?>
            <dl>
                <dt>サークル名</dt>
                <div>					
					<dd><?php echo get_post_meta($page_id, 'about_name', true); ?></dd>
                </div>
            </dl>
			<?php endif ; ?>
			<?php if (get_post_meta($page_id, 'about_member', true)) : ?>
            <dl>
                <dt>メンバー</dt>
                <div>
					<dd><?php echo get_post_meta($page_id, 'about_member', true); ?></dd>
                </div>
            </dl>
			<?php endif ; ?>
			<?php if (get_post_meta($page_id, 'about_erea', true)) : ?>
            <dl>
                <dt>活動拠点</dt>
                <div>
					<dd><?php echo get_post_meta($page_id, 'about_erea', true); ?></dd>
                </div>
            </dl>
			<?php endif ; ?>
			<?php if (get_post_meta($page_id, 'about_genre', true)) : ?>
            <dl>
                <dt>創作ジャンル</dt>
                <div>
					<dd><?php echo get_post_meta($page_id, 'about_genre', true); ?></dd>
                </div>
            </dl>
			<?php endif ; ?>
			<?php if (get_post_meta($page_id, 'about_worktitle', true)) : ?>
            <dl>
                <dt>作品名</dt>
                <div>
					<dd><?php echo get_post_meta($page_id, 'about_worktitle', true); ?></dd>
                </div>
            </dl>
			<?php endif ; ?>
        </div>
		<a href="<?php echo home_url( '/about' ); ?>" class="btn_more effect-fade blink">MORE</a>
    </section>
    <?php endif ; ?>

<?php
$args = array(
  'post_type' => array( 'work', 'blog', 'info', 'shop', 'comic' ),
	'meta_key' => 'pickup_label', //カスタムフィールドのキー
	'meta_value' => 'is-on', //カスタムフィールドの値
	'meta_compare' => 'LIKE' //'meta_value'のテスト演算子
);
$myposts = get_posts($args);
?>

<?php if (empty($myposts))  : ?>
<?php else : ?>

    <section id="wrapperPickup" class="wrapperBgcolor wrapperTopPage">
        <h2 class="titleContents"><span>PICK UP</span></h2>
        <div class="wrapperGlid">
			
		<?php $args = array(
	'posts_per_page' => 4,//取得したい件数を指定する
	'post_type' => array( 'work', 'blog', 'info', 'shop', 'comic' ),
	'orderby' => 'date',  //日付順
	'order' => 'DESC', //降順
	'meta_key' => 'pickup_label', //カスタムフィールドのキー
	'meta_value' => 'is-on', //カスタムフィールドの値
	'meta_compare' => 'LIKE' //'meta_value'のテスト演算子
);
			$my_query = new WP_Query($args);
			if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();
		?>
			
			<div class="squareBox effect-fade" ontouchend=""><figure class="hoverEffect">
				<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('thumbnail'); ?>
				<?php else : ?>
				<img src="<?php echo catch_that_image(); ?>" alt="<?php the_title(); ?>" />
				<?php endif ; ?>
              <figcaption>
				  <p class="category"><?php echo get_the_term_list_nolink( $post->ID, array( 'work_cat', 'blog_cat', 'info_cat', 'shop_cat' ) , '<span>', ' ／ ', '</span>'); ?></p>
				  <h2><?php
					  if(mb_strlen($post->post_title, 'UTF-8')>20){
						  $title= mb_substr($post->post_title, 0, 20, 'UTF-8');
						  echo $title.'……';
					  }else{
						  echo $post->post_title;
					  }
					  ?>
				  </h2>
				  <p class="overview"><?php echo wp_trim_words( get_the_excerpt(), 50, '...' ); ?></p>
				  <p class="date"><?php the_time('Y・m・d'); ?></p>
				</figcaption>
				<a href="<?php the_permalink();?>"></a>
				</figure></div>
		<?php endwhile; ?>
		<?php endif; ?>
        </div>
    </section>
<?php endif ; ?>

<?php
$args = array(
  'post_type' => array('work', 'comic'),
);
$myposts = get_posts($args);
?>

<?php if (empty($myposts))  : ?>
<?php else : ?>
<?php $post = get_post_type_object( 'work' ); ?>
     <section id="wrapperWork" class="wrapperBgcolor wrapperTopPage">
        <h2 class="titleContents"><span><?php echo $post->label; ?></span></h2>
        
        <div class="wrapperGlid">
			
	    <?php
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$args = array(
			  //'category_name' => 'restriction',
			  'post_type' => array('work', 'comic'), //カスタム投稿タイプの名称を入れる
			  'post_status' => 'publish', //取得するステータス。publishなら一般公開のもののみ
			  'paged' => $paged,
			  'posts_per_page' => 8,
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post(); 
		?>
			
			<div class="squareBox effect-fade" ontouchend=""><figure class="hoverEffect">
				<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('thumbnail'); ?>
				<?php else : ?>
				<img src="<?php echo catch_that_image(); ?>" alt="<?php the_title(); ?>" />
				<?php endif ; ?>
              <figcaption>
				  <?php if ($terms = get_the_terms($post->ID, 'work_cat')) : ?>
				  <p class="category"><?php echo get_the_term_list_nolink( $post->ID, 'work_cat' , '<span>', ' ／ ', '</span>'); ?></p>
				  <?php endif; ?>
				  <h2><?php
					  if(mb_strlen($post->post_title, 'UTF-8')>20){
						  $title= mb_substr($post->post_title, 0, 20, 'UTF-8');
						  echo $title.'……';
					  }else{
						  echo $post->post_title;
					  }
					  ?>
				  </h2>
				  <p class="overview"><?php echo wp_trim_words( get_the_excerpt(), 50, '...' ); ?></p>
				  <p class="date"><?php the_time('Y・m・d'); ?></p>
				</figcaption>
				<a href="<?php the_permalink();?>"></a>
				</figure></div>
	            
		<?php endwhile; ?>
		<?php endif; ?>
			
        </div>
        
        <a href="<?php echo get_post_type_archive_link( 'work' ); ?>" class="btn_more effect-fade blink">MORE</a>
    </section>
<?php endif ; ?>
 

<?php
$args = array(
  'post_type' => 'blog',
);
$myposts = get_posts($args);
?>

<?php if (empty($myposts))  : ?>
<?php else : ?>
<?php $post = get_post_type_object( 'blog' ); ?>
    <section id="wrapperBlog" class="wrapperBgcolor wrapperTopPage">
        <h2 class="titleContents"><span><?php echo $post->label; ?></span></h2>
        <div class="wrapperGlid_blog">
            
		<?php
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$args = array(
			  //'category_name' => 'restriction',
			  'post_type' => 'blog', //カスタム投稿タイプの名称を入れる
			  'post_status' => 'publish', //取得するステータス。publishなら一般公開のもののみ
			  'paged' => $paged,
			  'posts_per_page' => 4,
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post(); 
		?>
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
					?>
				</h3>
                <a href="<?php the_permalink();?>"></a>
            </article>
		<?php endwhile; ?>
		<?php endif; ?>
            
        </div>
        <a href="<?php echo get_post_type_archive_link( 'blog' ); ?>" class="btn_more effect-fade blink">MORE</a>
    </section>
<?php endif ; ?>
   

<?php
$args = array(
  'post_type' => 'info',
);
$myposts = get_posts($args);
?>

<?php if (empty($myposts))  : ?>
<?php else : ?>
<?php $post = get_post_type_object( 'info' ); ?>
    <section id="wrapperInfomation" class="wrapperBgcolor wrapperTopPage">
        <h2 class="titleContents"><span><?php echo $post->label; ?></span></h2>
        <div class="wrapperGlid_blog">
			<?php
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$args = array(
				//'category_name' => 'restriction',
				'post_type' => 'info', //カスタム投稿タイプの名称を入れる
			  'post_status' => 'publish', //取得するステータス。publishなら一般公開のもののみ
			  'paged' => $paged,
			  'posts_per_page' => 4,
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post(); 
		?>
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
					?>
				</h3>
                <a href="<?php the_permalink();?>"></a>
            </article>
		<?php endwhile; ?>
		<?php endif; ?>
			
        </div>
        <a href="<?php echo get_post_type_archive_link( 'info' ); ?>" class="btn_more effect-fade blink">MORE</a>
    </section>
<?php endif ; ?>

<?php
$args = array(
  'post_type' => 'shop',
);
$myposts = get_posts($args);
?>

<?php if (empty($myposts))  : ?>
<?php else : ?>
<?php $post = get_post_type_object( 'shop' ); ?>
    <section id="wrapperShop" class="wrapperBgcolor wrapperTopPage">
        <h2 class="titleContents"><span><?php echo $post->label; ?></span></h2>
        <div class="wrapperGlid_blog">
		<?php
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$args = array(
			  //'category_name' => 'restriction',
			  'post_type' => 'shop', //カスタム投稿タイプの名称を入れる
			  'post_status' => 'publish', //取得するステータス。publishなら一般公開のもののみ
			  'paged' => $paged,
			  'posts_per_page' => 4,
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post(); 
		?>
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
					?>
				</h3>
                <a href="<?php the_permalink();?>"></a>
            </article>
		<?php endwhile; ?>
		<?php endif; ?>
        </div>
        <a href="<?php echo get_post_type_archive_link( 'shop' ); ?>" class="btn_more effect-fade blink">MORE</a>
    </section>
<?php endif ; ?>

<?php if (get_page_by_path('donation')) : ?>
    <section id="wrapperDonation" class="wrapperBgcolor">
        <h2 class="titleContents"><span>DONATION</span></h2>
		<?php
		//$argsのプロパティを変えていく
		$args = array(
			'post_type' => 'page',
			'posts_per_page' => -1,
			'no_found_rows' => true,  //ページャーを使う時はfalseに。
			'name' => 'donation',
		);
		$the_query = new WP_Query($args);
		if ($the_query->have_posts()) :
		while ($the_query->have_posts()) :
		$the_query->the_post();
		?>
		
		<div class="caption"><?php the_excerpt(); ?></div>

		<?php endwhile; ?>
		<?php endif; ?>

		<a href="<?php echo home_url( '/donation' ); ?>" class="btn_more effect-fade blink">MORE</a>
    </section>
<?php endif ; ?>

<?php get_footer(); ?>