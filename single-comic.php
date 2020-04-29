<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    
    <title><?php
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
?></title>
    <?php get_template_part( 'meta' ); ?>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/js/slick_custom_ver1.3/comi_style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <?php wp_head(); ?>
</head>
<body>
    <?php if(have_posts()): while(have_posts()):the_post(); ?>
    <div class="slider" dir="rtl">
        <div id="first_page"></div>
        <?php the_content(); ?>
        
        <div id="last_page">
            <div class="last_page_in">
                <section id="comic_adtxt" dir="ltr">
                    <?php if (get_post_meta($post->ID, 'comic_adtxt', true)) : ?>
                    <?php $comic_adtxt = get_post_meta($post->ID, 'comic_adtxt', true); ?>
                    <?php echo wp_kses_post( $comic_adtxt ); ?>
                    <?php endif ; ?>
                
                <h1><?php the_title(); ?></h1>
                <small>Copyright &copy; 
                    <span class="copy">
                   
                    <?php if (get_post_meta($post->ID, 'comic_copy', true)) : ?>
                    <?php echo post_custom('comic_copy'); ?>
                    <?php endif ; ?>
                        </span>
                    All Rights Reserved</small>
                <input type="button" value="最初から読む" class="button b_button"><br><br>
                <input type="button" value="サイトへ戻る" class="button o_button" onclick="location.href='<?php echo esc_url( home_url( '/work' ) ); ?>'">
                    </section>
            </div>
        </div>
    </div>
    
    <div class="menu_box">
        <div class="menu_button">menu</div>
        <div class="menu_show">    
            <h1><?php the_title(); ?></h1>
            <small>Copyright &copy; 
                    <span class="copy">
                    <?php if (get_post_meta($post->ID, 'comic_copy', true)) : ?>
						<?php echo post_custom('comic_copy'); ?>
                    <?php endif ; ?>

                        </span>
                    All Rights Reserved</small>
            <input type="button" value="操作ヘルプ" class="button p_button">
            <input type="button" value="全画面表示" class="button g_button sp_none">
            <input type="button" value="最初から読む" class="button b_button">
            <input type="button" value="サイトへ戻る" class="button o_button" onclick="location.href='<?php echo esc_url( home_url( '/work' ) ); ?>'">
            <div class="slick-counter"><span class="current"></span> / <span class="total"></span></div>
            <div class="dots" dir="rtl"></div>
            <div class="menu_button close">close</div>
        </div>
    </div>
    <?php endwhile; endif; ?>
	
    <div class="help">
        <div class="help_in">
            <div class="help_img"></div>
            <p>【画面操作】</p>
            <ul>
                <li>&#9312;画面スライド<span>……次のページ・前のページ</span></li>
                <li>&#9313;両端クリック<span>……次のページ・前のページ</span></li>
                <li>&#9314;ページャークリック<span>……ページ移動</span></li>
            </ul>
            <!--class="sp_none"でPC以外だと非表示-->
            <p class="sp_none">【キーボード操作】</p>
            <ul class="sp_none">
                <li>←キー……次のページ</li>
                <li>→キー……前のページ</li>
                <li>↓キー……メニュー表示</li>
                <li>F11キー……全画面表示</li>
            </ul>
        </div>
    </div>
    
    <div class="guide">
        <div class="slide-arrow prev-arrow"><span></span></div>
        <div class="guide_yazirusi"><div class="icon"></div><div class="text"></div></div>
        <div class="guide_yubi"><div class="icon"></div><div class="text"></div></div>
        <div class="slide-arrow next-arrow"><span></span></div>
    </div>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/slick_custom_ver1.3/comic.js"></script>
</body>
</html>