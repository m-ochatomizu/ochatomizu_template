<?php get_header(); ?>

<section id="wrapperLowContents">
	<!-- パンくず -->
	<?php custom_breadcrumb(); ?>
	<h2 class="titleContents">
        <span>
		<?php if(is_page('about')): ?>
		ABOUT
		<?php else: ?>
		DONATION
		<?php endif; ?>
        </span>
	</h2>
        
        <div id="wrapperSingle">
			<?php 
			if(is_page('about')){
				$page_data = get_page_by_path('about'); $page = get_post($page_data);
				$content = $page -> post_content;
			}else{
				$page_data = get_page_by_path('donation'); $page = get_post($page_data);
				$content = $page -> post_content;
			};
				 
			// 本文を表示する
			echo $content;
			 ?>
        </div>

    </section>


<?php get_footer(); ?>