<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
	<?php get_template_part( 'meta' ); ?>
	
<title>
<?php
	global $page, $paged;
	if(is_front_page()) : //トップページ
		bloginfo('name');
	elseif(is_home()) : //ブログページ（ブログサイトの場合はトップページ）
		wp_title('|', true, 'right');
		bloginfo('name');
	elseif(is_single()) : //記事ページ
		wp_title('');
	elseif(is_page()) : //固定ページ
		wp_title('|', true, 'right');
		bloginfo('name');
	elseif(is_author()): //著者ページ
		wp_title('|', true, 'right');
		bloginfo('name');
	elseif(is_archive()) : //アーカイブページ（カテゴリーページなど）
		wp_title('|', true, 'right');
		bloginfo('name');
	elseif(is_search()) : //検索結果ページ
		wp_title('');
	elseif(is_404()): //404ページ
		echo '404|';
		bloginfo('name');
	endif;
	if($paged >= 2 || $page >= 2) : //２ページ目以降の場合
		echo '-' . sprintf('%sページ',
		max($paged,$page));
	endif;
?>
	
</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
	
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/iscroll-master/build/iscroll.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/drawer-master/dist/css/drawer.css">
<script src="<?php echo get_template_directory_uri(); ?>/js/drawer-master/dist/js/drawer.min.js"></script>
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
<script src="<?php echo get_template_directory_uri(); ?>/js/pagescroll.js"></script>

<!--object-sit（IE対策）-->
<script src="<?php echo get_template_directory_uri(); ?>/js/object-fit-images-master/dist/ofi.min.js"></script>
<script>
  objectFitImages();
</script>
    
<script>
$(document).ready(function() {
    $('.drawer').drawer();
    $('.drawer-menu li a').on('click', function() {
        $('.drawer').drawer('close');
    });
});
</script>
    <script>
    window.onload = function() {
      scroll_effect();

      $(window).scroll(function(){
       scroll_effect();
      });

      function scroll_effect(){
       $('.effect-fade').each(function(){
        var elemPos = $(this).offset().top;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if (scroll > elemPos - windowHeight+ 200){
            $(this).addClass('effect-scroll');
        }
       });
      }
    };
    </script>

<?php wp_head(); ?>
</head>
    
<body  class="drawer drawer--left">
	
	<header>
        <h1>
            <?php
///////////////////////////////////////
// ロゴ表示部分
///////////////////////////////////////
if ( get_the_logo_image_url() ) : ?>
  <div class='site-logo'>
      <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo get_the_logo_image_url(); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
  </div>
<?php else : ?>
  <div class='site-logo'><a href="<?php echo home_url(); ?>" class="blink"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"></a></div>
<?php endif; ?>
        </h1>
        
        <div id="wrapperSNS">
			<?php
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$args = array(
				'post_type' => 'sns', //カスタム投稿タイプの名称を入れる
			  'post_status' => 'publish', //取得するステータス。publishなら一般公開のもののみ
			  'paged' => $paged,
			  'posts_per_page' => 1,
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post(); 
		?>
			<?php if (get_post_meta($post->ID, 'sns_pixiv', true)) : ?>
			<a href="<?php echo get_post_meta($post->ID, 'sns_pixiv', true); ?>" class="blink btnPixiv" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/iconPixiv.svg"></a>
			<?php endif ; ?>
			<?php if (get_post_meta($post->ID, 'sns_tw', true)) : ?>
            <a href="<?php echo get_post_meta($post->ID, 'sns_tw', true); ?>" target="_blank" class="blink btnTw"><img src="<?php echo get_template_directory_uri(); ?>/images/iconTW.svg"></a>
			<?php endif ; ?>
			<?php if (get_post_meta($post->ID, 'sns_ig', true)) : ?>
            <a href="<?php echo get_post_meta($post->ID, 'sns_ig', true); ?>" target="_blank" class="blink btnIg"><img src="<?php echo get_template_directory_uri(); ?>/images/iconIG.svg"></a>
			<?php endif ; ?>
			<?php if (get_post_meta($post->ID, 'sns_fb', true)) : ?>
			<a href="<?php echo get_post_meta($post->ID, 'sns_fb', true); ?>" target="_blank" class="blink btnIg"><img src="<?php echo get_template_directory_uri(); ?>/images/iconFB.png"></a>
			<?php endif ; ?>
			<?php endwhile; ?>
			<?php endif; ?>
        </div>
    
        <div id="wrapperButton">
            <button type="button" class="drawer-toggle drawer-hamburger">
            <p>MENU</p>
              <span class="sr-only">toggle navigation</span>
              <span class="drawer-hamburger-icon"></span>
            </button>
        </div>
        
        <nav id="wrapperNav" class="drawer-nav">
          <ul class="drawer-menu">
            <!-- ドロワーメニューの中身 -->
			  <li id="gMenu01"><a href="<?php echo home_url(); ?>" ontouchend="">HOME</a></li>
			  <?php if (get_page_by_path('about')) : ?><li id="gMenu01"><a href="<?php echo home_url( '/about' ); ?>" ontouchend="">ABOUT</a></li><?php endif ; ?>
			  <?php
			  $args = array(
				  'post_type' => array( 'work', 'blog', 'info', 'shop' ),
				  'meta_key' => 'pickup_label', //カスタムフィールドのキー
				  'meta_value' => 'is-on', //カスタムフィールドの値
				  'meta_compare' => 'LIKE' //'meta_value'のテスト演算子
			  );
			  $myposts = get_posts($args);
			  ?>
			  <?php if (empty($myposts))  : ?><?php else : ?>
			  <li id="gMenu02"><a href="<?php echo home_url( '/#wrapperPickup' ); ?>" ontouchend="">PICK UP</a></li><?php endif ; ?>
			  
			  <?php
			  $args = array( 'post_type' => 'work',);
			  $myposts = get_posts($args);
			  ?>
			  <?php if (empty($myposts)) : ?><?php else : ?>
			  <?php $post = get_post_type_object( 'work' ); ?>
			<li id="gMenu03"><a href="<?php echo get_post_type_archive_link( 'work' ); ?>" ontouchend=""><?php echo $post->label; ?></a></li><?php endif ; ?>
			  <?php
			  $args = array( 'post_type' => 'blog',);
			  $myposts = get_posts($args);
			  ?>
			  <?php if (empty($myposts)) : ?><?php else : ?>
			  <?php $post = get_post_type_object( 'blog' ); ?>
            <li id="gMenu04"><a href="<?php echo get_post_type_archive_link( 'blog' ); ?>" ontouchend=""><?php echo $post->label; ?></a></li><?php endif ; ?>
			  <?php
			  $args = array( 'post_type' => 'info',);
			  $myposts = get_posts($args);
			  ?>
			  <?php if (empty($myposts)) : ?><?php else : ?>
			  <?php $post = get_post_type_object( 'info' ); ?>
            <li id="gMenu05"><a href="<?php echo get_post_type_archive_link( 'info' ); ?>" ontouchend=""><?php echo $post->label; ?></a></li><?php endif ; ?>
			  <?php
			  $args = array( 'post_type' => 'shop',);
			  $myposts = get_posts($args);
			  ?>
			  <?php if (empty($myposts)) : ?><?php else : ?>
			  <?php $post = get_post_type_object( 'shop' ); ?>
			  <li id="gMenu06"><a href="<?php echo get_post_type_archive_link( 'shop' ); ?>" ontouchend=""><?php echo $post->label; ?></a></li><?php endif ; ?>
			  <?php if (get_page_by_path('donation')) : ?><li id="gMenu07"><a href="<?php echo home_url( '/donation' ); ?>" ontouchend="">DONATION</a></li><?php endif ; ?>
          </ul>
        
        <div id="wrapperNavSNS">
			<?php
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$args = array(
				'post_type' => 'sns', //カスタム投稿タイプの名称を入れる
			  'post_status' => 'publish', //取得するステータス。publishなら一般公開のもののみ
			  'paged' => $paged,
			  'posts_per_page' => 1,
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post(); 
		?>
			<?php if (get_post_meta($post->ID, 'sns_pixiv', true)) : ?>
			<a href="<?php echo get_post_meta($post->ID, 'sns_pixiv', true); ?>" class="blink btnPixiv" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/iconPixiv.svg"></a>
			<?php endif ; ?>
			
			<?php if (get_post_meta($post->ID, 'sns_tw', true)) : ?>
            <a href="<?php echo get_post_meta($post->ID, 'sns_tw', true); ?>" target="_blank" class="blink btnTw"><img src="<?php echo get_template_directory_uri(); ?>/images/iconTW.svg"></a>
			<?php endif ; ?>
			
			<?php if (get_post_meta($post->ID, 'sns_ig', true)) : ?>
            <a href="<?php echo get_post_meta($post->ID, 'sns_ig', true); ?>" target="_blank" class="blink btnIg"><img src="<?php echo get_template_directory_uri(); ?>/images/iconIG.svg"></a>
			<?php endif ; ?>
			
			<?php if (get_post_meta($post->ID, 'sns_fb', true)) : ?>
            <a href="<?php echo get_post_meta($post->ID, 'sns_fb', true); ?>" target="_blank" class="blink btnFb"><img src="<?php echo get_template_directory_uri(); ?>/images/iconFB.png"></a>
			<?php endif ; ?>
			<?php endwhile; ?>
			<?php endif; ?>
        </div>
        </nav>
    </header>