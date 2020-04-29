<?php
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'id' => 'sidebar-1',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2 class="widget_title">',
		'after_title' => '</h2>',
	));
}

// サムネイル投稿有効化
add_theme_support( 'post-thumbnails' );
// サムネイル投稿キャプション設定
add_shortcode('caption', 'my_img_caption_shortcode');

function my_img_caption_shortcode($attr, $content = null) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>s*)?<img [^>]+>(?:s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}

	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr, 'caption'));

	if ( 1 > (int) $width || empty($caption) )
		return $content;

	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '">' . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}

// 画像の相対パス
function imagepassshort($arg) {
$content = str_replace('" images/', '"' . get_bloginfo('template_directory') . '/images/', $arg);
return $content;
}
add_action('the_content', 'imagepassshort');

// カテゴリ_リンク先無し
function get_the_term_list_nolink( $id = 0, $taxonomy, $before = '', $sep = '', $after = '' ) {
 $terms = get_the_terms( $id, $taxonomy ); 
 
 if ( is_wp_error( $terms ) )
 return $terms;
 
 if ( empty( $terms ) )
 return false;
 
 foreach ( $terms as $term ) {
 $term_names[] = $term->name ;
 }
 
 return $before . join( $sep, $term_names ) . $after;
}

// カスタム投稿タイプ「WORK」を追加する
function create_post_type_work() {
  $Supports = [
	  'title',
	  'editor',
	  'author',
	  'thumbnail',
	  'revisions',
	  'excerpt',
	  'custom-fields',
  ];
  register_post_type( 'work',
    array(
      'label' => 'WORK',
      'labels' => array(
      'all_items' => 'WORK一覧'
      ),
      'public' => true,
      'has_archive' => true,
		'rewrite' => array('with_front' => false),
      'menu_position' => 5,
      'supports' => $Supports
    )
  );

// カスタム投稿カテゴリーを追加する
	register_taxonomy(
		'work_cat',
		array('work', 'comic'),
  array(
	  'label' => 'WORKカテゴリ',
	  'singular_label' => 'WORKカテゴリ',
	  'labels' => array(
		'all_items' => 'WORKカテゴリ一覧',
		'add_new_item' => 'WORKカテゴリを追加'
    ),
    'public' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'hierarchical' => true
    )
  );
	//タグを投稿と共通設定にする
	register_taxonomy_for_object_type('post_tag', 'work');
}
add_action( 'init', 'create_post_type_work' );

//タグアーカイブにカスタム投稿タイプを含める方法
function add_post_tag_archive( $wp_query ) {
if ($wp_query->is_main_query() && $wp_query->is_tag()) {
$wp_query->set( 'post_type', array('post','work','blog','info','shop','comic'));
}
}
add_action( 'pre_get_posts', 'add_post_tag_archive' , 10 , 1);

// カスタム投稿タイプ「BLOG」を追加する
function create_post_type_blog() {
  $Supports = [
	  'title',
	  'editor',
	  'author',
	  'thumbnail',
	  'revisions',
	  'excerpt',
	  'custom-fields',
  ];
  register_post_type( 'blog',
    array(
      'label' => 'BLOG',
      'labels' => array(
      'all_items' => 'BLOG一覧'
      ),
      'public' => true,
      'has_archive' => true,
		'rewrite' => array('with_front' => false),
      'menu_position' => 6,
      'supports' => $Supports
    )
  );
	
	// カスタム投稿カテゴリーを追加する
	register_taxonomy(
		'blog_cat',
		'blog',
		array(
	  'label' => 'BLOGカテゴリ',
	  'singular_label' => 'BLOGカテゴリ',
	  'labels' => array(
		'all_items' => 'BLOGカテゴリ一覧',
		'add_new_item' => 'BLOGカテゴリを追加'
    ),
    'public' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'hierarchical' => true
    )
  );
	//タグを投稿と共通設定にする
	register_taxonomy_for_object_type('post_tag', 'blog');
}
add_action( 'init', 'create_post_type_blog' );


// カスタム投稿タイプ「INFORMATION」を追加する
function create_post_type_info() {
  $Supports = [
	  'title',
	  'editor',
	  'author',
	  'thumbnail',
	  'revisions',
	  'excerpt',
	  'custom-fields',
  ];
  register_post_type( 'info',
    array(
      'label' => 'INFORMATION',
      'labels' => array(
      'all_items' => 'INFORMATION一覧'
      ),
      'public' => true,
      'has_archive' => true,
		'rewrite' => array('with_front' => false),
      'menu_position' => 7,
      'supports' => $Supports
    )
  );
	// カスタム投稿カテゴリーを追加する
	register_taxonomy(
		'info_cat',
		'info',
		array(
	  'label' => 'INFORMATIONカテゴリ',
	  'singular_label' => 'INFORMATIONカテゴリ',
	  'labels' => array(
		'all_items' => 'INFORMATIONカテゴリ一覧',
		'add_new_item' => 'INFORMATIONカテゴリを追加'
    ),
    'public' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'hierarchical' => true
    )
  );
	//タグを投稿と共通設定にする
	register_taxonomy_for_object_type('post_tag', 'info');
}
add_action( 'init', 'create_post_type_info' );

// カスタム投稿タイプ「SHOP」を追加する
function create_post_type_shop() {
  $Supports = [
	  'title',
	  'editor',
	  'thumbnail',
	  'author',
	  'revisions',
	  'excerpt',
	  'custom-fields',
  ];
  register_post_type( 'shop',
    array(
      'label' => 'SHOP',
      'labels' => array(
      'all_items' => 'SHOP一覧'
      ),
      'public' => true,
      'has_archive' => true,
		'rewrite' => array('with_front' => false),
      'menu_position' => 8,
      'supports' => $Supports
    )
  );
	// カスタム投稿カテゴリーを追加する
	register_taxonomy(
		'shop_cat',
		'shop',
		array(
	  'label' => 'SHOPカテゴリ',
	  'singular_label' => 'SHOPカテゴリ',
	  'labels' => array(
		'all_items' => 'SHOPカテゴリ一覧',
		'add_new_item' => 'SHOPカテゴリを追加'
    ),
    'public' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'hierarchical' => true
    )
  );
	//タグを投稿と共通設定にする
	register_taxonomy_for_object_type('post_tag', 'shop');
}
add_action( 'init', 'create_post_type_shop' );

// カスタム投稿タイプ「マンガ投稿」を追加する
function create_post_type_comic() {
  $Supports = [
	  'title',
	  'editor',
	  'thumbnail',
	  'author',
	  'revisions',
	  'excerpt',
	  'custom-fields',
  ];
  register_post_type( 'comic',
    array(
      'label' => 'マンガ投稿',
      'labels' => array(
      'all_items' => 'マンガ一覧'
      ),
      'public' => true,
      'has_archive' => true,
		'rewrite' => array('with_front' => false),
      'menu_position' => 9,
      'supports' => $Supports
    )
  );

	//タグを投稿と共通設定にする
	register_taxonomy_for_object_type('post_tag', 'comic');
}
add_action( 'init', 'create_post_type_comic' );

// 「マンガ投稿」カスタムフィールドボックス
function add_custom_fields_comic(){
    add_meta_box(
        'custom_setting_comic', //編集画面セクションのHTML ID
		'コピーライト・最終ページのカスタマイズ', //編集画面セクションのタイトル、画面上に表示される
        'insert_custom_fields_comic', //編集画面セクションにHTML出力する関数
		'comic', //投稿タイプ名
        'normal' //編集画面セクションが表示される部分
    );
}
add_action('admin_menu', 'add_custom_fields_comic');

// 「マンガ投稿」カスタムフィールドの入力エリア
function insert_custom_fields_comic() {
	global $post;
	
	//get_post_meta関数を使ってpostmeta情報を取得
    $comic_copy = get_post_meta($post->ID, 'comic_copy', true);
    $comic_adtxt = get_post_meta($post->ID, 'comic_adtxt', true);

	//下記に管理画面に表示される入力エリアを作ります。sns_ig「get_post_meta()」は現在入力されている値を表示するための記述です。
	echo '【コピーライト】 <input type="text" name="comic_copy" value="'.$comic_copy.'" size="50" /><br><br>';
    echo '【最終ページのカスタマイズ】最終ページにコンテンツを追加したい場合は記入してください。';
    wp_editor( $comic_adtxt, 'comic_adtxt', array('wpautop'=>true,'textarea_rows'=>10,'textarea_name' => 'comic_adtxt') );
}

// 「マンガ投稿」カスタムフィールドの値を保存
function save_custom_fields_comic( $post_id ) {
	
	if(isset($_POST['comic_copy'])){
        //comic_copyキーで、$_POST['comic_copy']を保存
        update_post_meta($post_id, 'comic_copy', $_POST['comic_copy']);
    }else{
        //comic_copyキーの情報を削除
        delete_post_meta($post_id, 'comic_copy');
    }
    
    if(isset($_POST['comic_adtxt'])){
        //comic_adtxtキーで、$_POST['comic_adtxt']を保存
        update_post_meta($post_id, 'comic_adtxt', $_POST['comic_adtxt']);
    }else{
        //sns_pixivキーの情報を削除
        delete_post_meta($post_id, 'comic_adtxt');
    }
}
add_action('save_post', 'save_custom_fields_comic');


// カスタム投稿タイプ「SNS」を追加する
function create_post_type_sns(){
  //カスタム投稿タイプがダッシュボードの編集画面で使用する項目を配列で用意
  $supports = array(
    'title',
    'revisions'
  );
  //カスタム投稿タイプを追加するための関数
  //第一引数は任意のカスタム投稿タイプ名
  register_post_type('sns',
    array(
      'label' => 'SNS',
      'public' => true, //フロントエンド上で公開する場合true
      'has_archive' => false, //アーカイブページを表示したい場合true
      'menu_position' => 10, //メニューを表示させる場所
      'supports' => $supports //ダッシュボードの編集画面で使用する項目
    )
  );
}
add_action('init','create_post_type_sns');

// 「SNS」カスタムフィールドボックス
function add_custom_fields_sns(){
    add_meta_box(
        'custom_setting_sns', //編集画面セクションのHTML ID
		'各種SNSのURLを設定してください', //編集画面セクションのタイトル、画面上に表示される
        'insert_custom_fields_sns', //編集画面セクションにHTML出力する関数
		'sns', //投稿タイプ名
        'normal' //編集画面セクションが表示される部分
    );
}
add_action('admin_menu', 'add_custom_fields_sns');

// 「SNS」カスタムフィールドの入力エリア
function insert_custom_fields_sns() {
	global $post;
	
	//get_post_meta関数を使ってpostmeta情報を取得
   $sns_pixiv = get_post_meta($post->ID, 'sns_pixiv', true);
	 $sns_tw = get_post_meta($post->ID, 'sns_tw', true);
	 $sns_ig = get_post_meta($post->ID, 'sns_ig', true);
	 $sns_fb = get_post_meta($post->ID, 'sns_fb', true);
 
	//下記に管理画面に表示される入力エリアを作ります。sns_ig「get_post_meta()」は現在入力されている値を表示するための記述です。
	echo 'Pixiv： <input type="text" name="sns_pixiv" value="'.$sns_pixiv.'" size="50" /><br>';
	echo 'Twitter： <input type="text" name="sns_tw" value="'.$sns_tw.'" size="50" /><br>';
	echo 'Instagram： <input type="text" name="sns_ig" value="'.$sns_ig.'" size="50" />　<br>';
	echo 'Facebook： <input type="text" name="sns_fb" value="'.$sns_fb.'" size="50" />　<br>';
}

// 「SNS」カスタムフィールドの値を保存
function save_custom_fields_sns( $post_id ) {
	
	if(isset($_POST['sns_pixiv'])){
        //sns_pixivキーで、$_POST['sns_pixiv']を保存
        update_post_meta($post_id, 'sns_pixiv', $_POST['sns_pixiv']);
    }else{
        //sns_pixivキーの情報を削除
        delete_post_meta($post_id, 'sns_pixiv');
    }
	
	if(isset($_POST['sns_tw'])){
        //sns_twキーで、$_POST['sns_tw']を保存
        update_post_meta($post_id, 'sns_tw', $_POST['sns_tw']);
    }else{
        //sns_twキーの情報を削除
        delete_post_meta($post_id, 'sns_tw');
    }
	
	if(isset($_POST['sns_ig'])){
        //sns_igキーで、$_POST['sns_ig']を保存
        update_post_meta($post_id, 'sns_ig', $_POST['sns_ig']);
    }else{
        //sns_igキーの情報を削除
        delete_post_meta($post_id, 'sns_ig');
    }
	
	if(isset($_POST['sns_fb'])){
        //sns_fbキーで、$_POST['sns_fb']を保存
        update_post_meta($post_id, 'sns_fb', $_POST['sns_fb']);
    }else{
        //sns_fbキーの情報を削除
        delete_post_meta($post_id, 'sns_fb');
    }
}
add_action('save_post', 'save_custom_fields_sns');

//記事内の画像をサムネイルに設定
function catch_that_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];
  
    if(empty($first_img)){
		// 記事内で画像がなかったときのためのデフォルト画像を指定
		$url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'] ;
		
		// 返り値が0のため含まれていないと判定される。
		// $first_img = get_theme_file_uri(). '/images/default.jpg';
        
        if(empty($first_img = get_the_default_image_url())){
            $first_img = get_theme_file_uri(). '/images/default.jpg';
        } else{
            $first_img = get_the_default_image_url();
        }
	}
	return $first_img;
}

// ABOUT用の固定カスタムフィールドボックス
function add_about_fields() {
	//add_meta_box(表示される入力ボックスのHTMLのID, ラベル, 表示する内容を作成する関数名, 投稿タイプ, 表示方法)
	//第4引数のpostをpageに変更すれば固定ページにオリジナルカスタムフィールドが表示されます(custom_post_typeのslugを指定することも可能)。
	//第5引数はnormalの他にsideとadvancedがあります。
	add_meta_box( 'about_setting', 'ABOUTトップ情報', 'insert_about_fields', 'page', 'normal');
}
add_action('admin_menu', 'add_about_fields');
 
 
// ABOUT用のカスタムフィールドの入力エリア
function insert_about_fields() {
	global $post;
 
	//下記に管理画面に表示される入力エリアを作ります。「get_post_meta()」は現在入力されている値を表示するための記述です。
	echo 'サークル名： <input type="text" name="about_name" value="'.get_post_meta($post->ID, 'about_name', true).'" size="50" /><br>';
	echo 'メンバー： <input type="text" name="about_member" value="'.get_post_meta($post->ID, 'about_member', true).'" size="50" /><br>';
	echo '活動拠点： <input type="text" name="about_erea" value="'.get_post_meta($post->ID, 'about_erea', true).'" size="50" />　<br>';
	echo '創作ジャンル： <input type="text" name="about_genre" value="'.get_post_meta($post->ID, 'about_genre', true).'" size="50" />　<br>';
	echo '作品名： <input type="text" name="about_worktitle" value="'.get_post_meta($post->ID, 'about_worktitle', true).'" size="50" />　<br>';
}
 
 
// ABOUT用のカスタムフィールドの値を保存
function save_about_fields( $post_id ) {
	if(!empty($_POST['about_name'])){ //題名が入力されている場合
		update_post_meta($post_id, 'about_name', $_POST['about_name'] ); //値を保存
	}else{ //題名未入力の場合
		delete_post_meta($post_id, 'about_name'); //値を削除
	}
	
	if(!empty($_POST['about_member'])){
		update_post_meta($post_id, 'about_member', $_POST['about_member'] );
	}else{
		delete_post_meta($post_id, 'about_member');
	}
	
	if(!empty($_POST['about_erea'])){
		update_post_meta($post_id, 'about_erea', $_POST['about_erea'] );
	}else{
		delete_post_meta($post_id, 'about_erea');
	}
	
	if(!empty($_POST['about_genre'])){
		update_post_meta($post_id, 'about_genre', $_POST['about_genre'] );
	}else{
		delete_post_meta($post_id, 'about_genre');
	}
	
	if(!empty($_POST['about_worktitle'])){
		update_post_meta($post_id, 'about_worktitle', $_POST['about_worktitle'] );
	}else{
		delete_post_meta($post_id, 'about_worktitle');
	}
}
add_action('save_post', 'save_about_fields');

// 前へ・次へのリンクにクラス付与
add_filter( 'previous_post_link', 'add_prev_post_link_class' );
function add_prev_post_link_class($output) {
  return str_replace('<a href=', '<a class="prev-link blink" href=', $output);
}
add_filter( 'next_post_link', 'add_next_post_link_class' );
function add_next_post_link_class($output) {
  return str_replace('<a href=', '<a class="next-link blink" href=', $output);
}

// パンくず自動生成
if ( ! function_exists( 'custom_breadcrumb' ) ) {
    function custom_breadcrumb( $wp_obj = null ) {

        // トップページでは何も出力しない
        if ( is_home() || is_front_page() ) return false;

        //そのページのWPオブジェクトを取得
        $wp_obj = $wp_obj ?: get_queried_object();

        echo '<div id="wrpperPankuzu">'.  //id名などは任意で
			'<a href="'. home_url() .'">HOME</a>';

        if ( is_attachment() ) {

            /**
             * 添付ファイルページ ( $wp_obj : WP_Post )
             * ※ 添付ファイルページでは is_single() も true になるので先に分岐
             */
            echo '<span>'. $wp_obj->post_title .'</span>';

        } elseif ( is_single() ) {

            /**
             * 投稿ページ ( $wp_obj : WP_Post )
             */
            $post_id    = $wp_obj->ID;
            $post_type  = $wp_obj->post_type;
            $post_title = $wp_obj->post_title;

            // カスタム投稿タイプかどうか
            if ( $post_type !== 'post' ) {

                $the_tax = "";  //そのサイトに合わせ、投稿タイプごとに分岐させて明示的に指定してもよい

				// 投稿タイプに紐づいたタクソノミーを取得 (投稿フォーマットは除く)
                $tax_array = get_object_taxonomies( $post_type, 'names');
                foreach ($tax_array as $tax_name) {
                    if ( $tax_name !== 'post_format' ) {
                       $the_tax = $tax_name;
                       break;
                    }
                }

                //カスタム投稿タイプ名の表示
                echo '<a href="'. get_post_type_archive_link( $post_type ) .'">'.
					'<span>'. get_post_type_object( $post_type )->label .'</span>'.
					'</a>';

            } else {
                $the_tax = 'category';  //通常の投稿の場合、カテゴリーを表示
            }

            // タクソノミーが紐づいていれば表示
            if ( $the_tax !== "" ) {

                $child_terms = array();   // 子を持たないタームだけを集める配列
                $parents_list = array();  // 子を持つタームだけを集める配列

                // 投稿に紐づくタームを全て取得
                $terms = get_the_terms( $post_id, $the_tax );

                if ( !empty( $terms ) ) {

                    //全タームの親IDを取得
                    foreach ( $terms as $term ) {
                        if ( $term->parent !== 0 ) $parents_list[] = $term->parent;
                    }

                    //親リストに含まれないタームのみ取得
                    foreach ( $terms as $term ) {
                        if ( ! in_array( $term->term_id, $parents_list ) ) $child_terms[] = $term;
                    }

                    // 最下層のターム配列から一つだけ取得
                    $term = $child_terms[0];

                    if ( $term->parent !== 0 ) {

                        // 親タームのIDリストを取得
                        $parent_array = array_reverse( get_ancestors( $term->term_id, $the_tax ) );

                        foreach ( $parent_array as $parent_id ) {
                            $parent_term = get_term( $parent_id, $the_tax );
                            echo '<a href="'. get_term_link( $parent_id, $the_tax ) .'">'.
                                      '<span>'. $parent_term->name .'</span>'.
                                    '</a>';
                        }
                    }

                    // 最下層のタームを表示
                    echo '<a href="'. get_term_link( $term->term_id, $the_tax ). '">'.
                              '<span>'. $term->name .'</span>'.
                            '</a>';
                }
            }

            // 投稿自身の表示
            echo '<span>'. $post_title .'</span>';

        } elseif ( is_page() ) {

            /**
             * 固定ページ ( $wp_obj : WP_Post )
             */
            $page_id    = $wp_obj->ID;
            $page_title = $wp_obj->post_title;

            // 親ページがあれば順番に表示
            if ( $wp_obj->post_parent !== 0 ) {
                $parent_array = array_reverse( get_post_ancestors( $page_id ) );
                foreach( $parent_array as $parent_id ) {
                    echo '<a href="'. get_permalink( $parent_id ).'">'.
                                '<span>'.get_the_title( $parent_id ).'</span>'.
                            '</a>';
                }
            }
            // 投稿自身の表示
            echo '<span>'. $page_title .'</span>';

        } elseif ( is_post_type_archive() ) {

            /**
             * 投稿タイプアーカイブページ ( $wp_obj : WP_Post_Type )
             */
            echo '<span>'. $wp_obj->label .'</span>';

        } elseif ( is_date() ) {

            /**
             * 日付アーカイブ ( $wp_obj : null )
             */
            $year  = get_query_var('year');
            $month = get_query_var('monthnum');
            $day   = get_query_var('day');

            if ( $day !== 0 ) {
                //日別アーカイブ
                echo '<a href="'. get_year_link( $year ).'"><span>'. $year .'年</span></a>'.
                     '<a href="'. get_month_link( $year, $month ). '"><span>'. $month .'月</span></a>'.
                     '<span>'. $day .'日</span>';

            } elseif ( $month !== 0 ) {
                //月別アーカイブ
                echo '<a href="'. get_year_link( $year ).'"><span>'.$year.'年</span></a>'.
                     '<span>'.$month . '月</span>';

            } else {
                //年別アーカイブ
                echo '<span>'.$year.'年</span>';

            }

        } elseif ( is_author() ) {

            /**
             * 投稿者アーカイブ ( $wp_obj : WP_User )
             */
            echo '<span>'. $wp_obj->display_name .' の執筆記事</span>';

        } elseif ( is_archive() ) {

            /**
             * タームアーカイブ ( $wp_obj : WP_Term )
             */
            $term_id   = $wp_obj->term_id;
            $term_name = $wp_obj->name;
            $tax_name  = $wp_obj->taxonomy;

            /* ここでタクソノミーに紐づくカスタム投稿タイプを出力しても良いでしょう。 */

            // 親ページがあれば順番に表示
            if ( $wp_obj->parent !== 0 ) {

                $parent_array = array_reverse( get_ancestors( $term_id, $tax_name ) );
                foreach( $parent_array as $parent_id ) {
                    $parent_term = get_term( $parent_id, $tax_name );
                    echo '<a href="'. get_term_link( $parent_id, $tax_name ) .'">'.
                                '<span>'. $parent_term->name .'</span>'.
                            '</a>';
                }
            }

            // ターム自身の表示
            echo '<span>'. $term_name .'</span>';

        } elseif ( is_search() ) {

            /**
             * 検索結果ページ
             */
            echo '<span>「'. get_search_query() .'」で検索した結果</span>';

        
        } elseif ( is_404() ) {

            /**
             * 404ページ
             */
            echo '<span>お探しの記事は見つかりませんでした。</span>';

        } else {

            /**
             * その他のページ（無いと思うが一応）
             */
            echo '<span>'. get_the_title() .'</span>';
        }

        echo '</div>';  // 冒頭に合わせて閉じタグ

    }
}

/*【出力カスタマイズ】固定ページで抜粋の機能を有効化 */
add_post_type_support( 'page', 'excerpt' );

//概要（抜粋）の文字数調整
 function my_excerpt_length($length) {
 return 200;
 }
 add_filter('excerpt_length', 'my_excerpt_length');

//投稿画面にタグ一覧を表示
function re_register_post_tag_taxonomy() {
	global $wp_rewrite;
	$rewrite = array(
		'slug' => get_option('tag_base') ? get_option('tag_base') : 'tag',
		'with_front' => ! get_option('tag_base') || $wp_rewrite->using_index_permalinks(),
		'ep_mask' => EP_TAGS,
	);
	$labels = array(
		'name' => _x( 'Tags', 'taxonomy general name' ),
		'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
		'search_items' => __( 'Search Tags' ),
		'popular_items' => __( 'Popular Tags' ),
		'all_items' => __( 'All Tags' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Tag' ),
		'view_item' => __( 'View Tag' ),
		'update_item' => __( 'Update Tag' ),
		'add_new_item' => __( 'Add New Tag' ),
		'new_item_name' => __( 'New Tag Name' ),
		'separate_items_with_commas' => __( 'Separate tags with commas' ),
		'add_or_remove_items' => __( 'Add or remove tags' ),
		'choose_from_most_used' => __( 'Choose from the most used tags' ),
		'not_found' => __( 'No tags found.' )
	);
	register_taxonomy( 'post_tag', 'post', array(
		'hierarchical' => true,
		'query_var' => 'tag',
		'rewrite' => $rewrite,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'_builtin' => true,
		'labels' => $labels
	));
}
add_action( 'init', 're_register_post_tag_taxonomy', 1 );

//ページャー
function the_pagination() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;
  echo '<nav class="pagination">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '<i class="fas fa-angle-double-left"></i>',
    'next_text'    => '<i class="fas fa-angle-double-right"></i>',
    'type'         => 'list',
    'end_size'     => 3,
    'mid_size'     => 3
  ) );
  echo '</nav>';
}

//---------------------------------------//
// 内部リンクのブログカード化（ショートコード）
// ここから
//---------------------------------------//

// 記事IDを指定して抜粋文を取得する
function ltl_get_the_excerpt($post_id){
  global $post;
  $post_bu = $post;
  $post = get_post($post_id);
  setup_postdata($post_id);
  $output = get_the_excerpt();
  $post = $post_bu;
  return $output;
}

//内部リンクをはてなカード風にするショートコード
function nlink_scode($atts) {
	extract(shortcode_atts(array(
		'url'=>"",
		'title'=>"",
		'excerpt'=>""
	),$atts));

	$id = url_to_postid($url);//URLから投稿IDを取得

	$img_width ="90";//画像サイズの幅指定
	$img_height = "90";//画像サイズの高さ指定
	$no_image = 'noimageに指定したい画像があればここにパス';//アイキャッチ画像がない場合の画像を指定

	//タイトルを取得
	if(empty($title)){
		$title = esc_html(get_the_title($id));
		$title = mb_strimwidth($title, 0, 30, "…", "UTF-8");
	}
	//本文を取得
	if(empty($excerpt)){
		$excerpt = esc_html(ltl_get_the_excerpt($id));
		$excerpt = mb_strimwidth($excerpt, 0, 90, "…", "UTF-8");
	}

    //アイキャッチ画像を取得
    if(has_post_thumbnail($id)) {
        $img = wp_get_attachment_image_src(get_post_thumbnail_id($id),array($img_width,$img_height));
        $img_tag = "<img src='" . $img[0] . "' alt='{$title}' width=" . $img[1] . " height=" . $img[2] . " />";
		
    }else{ 
		$img = catch_that_image();
		$img_tag ='<img src="'.$img.'" alt="" width="'.$img_width.'" height="'.$img_height.'" />';
    	//$img_tag ='<img src="'.$no_image.'" alt="" width="'.$img_width.'" height="'.$img_height.'" />';
    }

	$nlink .='
<div class="blog-card">
	<figure class="blog-card-thumbnail">'. $img_tag .'</figure>
	<div class="blog-card-content">
		<div class="blog-card-title">'. $title .' </div>
		<div class="blog-card-excerpt">'. $excerpt .'</div>
	</div>
	<a href="'. $url .'"></a>
</div>';

	return $nlink;
}

add_shortcode("nlink", "nlink_scode");
//---------------------------------------//
// ここまで
// 内部リンクのブログカード化（ショートコード）
//---------------------------------------//

// 固定カスタムフィールドボックス
function add_pickup_fields() {
	//add_meta_box(表示される入力ボックスのHTMLのID, ラベル, 表示する内容を作成する関数名, 投稿タイプ, 表示方法)
	//第4引数のpostをpageに変更すれば固定ページにオリジナルカスタムフィールドが表示されます(custom_post_typeのslugを指定することも可能)。
	//第5引数はnormalの他にsideとadvancedがあります。
	add_meta_box( 'book_setting', 'PickUpにこの記事を表示する', 'insert_pickup_fields', array( 'work', 'blog', 'info', 'shop', 'comic' ), 'normal');
}
add_action('admin_menu', 'add_pickup_fields');
 
// カスタム投稿カスタムフィールドの入力エリア
function insert_pickup_fields() {
	global $post;
 
	//下記に管理画面に表示される入力エリアを作ります。「get_post_meta()」は現在入力されている値を表示するための記述です。
	if( get_post_meta($post->ID,'pickup_label',true) == "is-on" ) {
		$pickup_label_check = "checked";
	}//チェックされていたらチェックボックスの$book_label_checkの場所にcheckedを挿入
	echo 'PickUpに固定したい場合はチェック： <input type="checkbox" name="pickup_label" value="is-on" '.$pickup_label_check.' ><br>';
}
 
 
// カスタムフィールドの値を保存
function save_pickup_fields( $post_id ) {
	
	if(!empty($_POST['pickup_label'])){
		update_post_meta($post_id, 'pickup_label', $_POST['pickup_label'] );
	}else{
		delete_post_meta($post_id, 'pickup_label');
	}
}
add_action('save_post', 'save_pickup_fields');

// 404エラートップリダイレクト
add_action( 'template_redirect', 'is404_redirect_home' );
function is404_redirect_home() {
  if( is_404() ){
    wp_safe_redirect( home_url( '/' ) );
    exit();
  }
}

///////////////////////////////////////
// テーマカスタマイザーにロゴアップロード設定機能追加
///////////////////////////////////////
define('LOGO_SECTION', 'logo_section'); //セクションIDの定数化
define('LOGO_IMAGE_URL', 'logo_image_url'); //セッティングIDの定数化
function themename_theme_customizer_logo( $wp_customize ) {
 $wp_customize->add_section( LOGO_SECTION , array(
 'title' => 'ロゴ画像', //セクション名
 'priority' => 30, //カスタマイザー項目の表示順
 'description' => 'サイトのロゴ設定。サイズ503*161', //セクションの説明
 ) );
 
 $wp_customize->add_setting( LOGO_IMAGE_URL );
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, LOGO_IMAGE_URL, array(
 'label' => 'ロゴ', //設定ラベル
 'section' => LOGO_SECTION, //セクションID
 'settings' => LOGO_IMAGE_URL, //セッティングID
 'description' => '画像をアップロードするとヘッダーにあるデフォルトのサイト名と入れ替わります。',
 ) ) );
 
}
add_action( 'customize_register', 'themename_theme_customizer_logo' );//カスタマイザーに登録
 
//ロゴイメージURLの取得
function get_the_logo_image_url(){
 return esc_url( get_theme_mod( LOGO_IMAGE_URL ) );
}

///////////////////////////////////////
// テーマカスタマイザーにメイン画像アップロード設定機能追加
///////////////////////////////////////
define('MAIN_SECTION', 'main_section'); //セクションIDの定数化
define('MAIN_IMAGE_URL', 'main_image_url'); //セッティングIDの定数化
function themename_theme_customizer_main( $wp_customize ) {
 $wp_customize->add_section( MAIN_SECTION , array(
 'title' => 'メイン画像', //セクション名
 'priority' => 31, //カスタマイザー項目の表示順
 'description' => 'サイトのメイン画像設定。サイズ1920*980', //セクションの説明
 ) );
 
 $wp_customize->add_setting( MAIN_IMAGE_URL );
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, MAIN_IMAGE_URL, array(
 'label' => 'メイン画像', //設定ラベル
 'section' => MAIN_SECTION, //セクションID
 'settings' => MAIN_IMAGE_URL, //セッティングID
 'description' => '画像をアップロードするとメイン画像に設定されます。',
 ) ) );
 
}
add_action( 'customize_register', 'themename_theme_customizer_main' );//カスタマイザーに登録
 
//メインイメージURLの取得
function get_the_main_image_url(){
 return esc_url( get_theme_mod( MAIN_IMAGE_URL ) );
}

///////////////////////////////////////
// テーマカスタマイザーにスマホ用メイン画像アップロード設定機能追加
///////////////////////////////////////
define('MAIN_SECTION_SP', 'main_section_sp'); //セクションIDの定数化
define('MAIN_IMAGE_URL_SP', 'main_image_url_sp'); //セッティングIDの定数化
function themename_theme_customizer_main_sp( $wp_customize ) {
 $wp_customize->add_section( MAIN_SECTION_SP , array(
 'title' => 'メイン画像（スマホ用） ', //セクション名
 'priority' => 31, //カスタマイザー項目の表示順
 'description' => 'サイトのメイン画像設定。サイズ640*980', //セクションの説明
 ) );
 
 $wp_customize->add_setting( MAIN_IMAGE_URL_SP );
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, MAIN_IMAGE_URL_SP, array(
 'label' => 'メイン画像（スマホ用）', //設定ラベル
 'section' => MAIN_SECTION_SP, //セクションID
 'settings' => MAIN_IMAGE_URL_SP, //セッティングID
 'description' => '画像をアップロードするとメイン画像に設定されます。',
 ) ) );
 
}
add_action( 'customize_register', 'themename_theme_customizer_main_sp' );//カスタマイザーに登録
 
//スマホ用メインイメージURLの取得
function get_the_main_image_url_sp(){
 return esc_url( get_theme_mod( MAIN_IMAGE_URL_SP ) );
}

///////////////////////////////////////
// テーマカスタマイザーにプロフィール画像アップロード設定機能追加
///////////////////////////////////////
define('PROFILE_SECTION', 'profile_section'); //セクションIDの定数化
define('PROFILE_IMAGE_URL', 'profile_image_url'); //セッティングIDの定数化
function themename_theme_customizer_profile( $wp_customize ) {
 $wp_customize->add_section( PROFILE_SECTION , array(
 'title' => 'プロフィール画像', //セクション名
 'priority' => 32, //カスタマイザー項目の表示順
 'description' => 'プロフィール画像設定。サイズ503*523', //セクションの説明
 ) );
 
 $wp_customize->add_setting( PROFILE_IMAGE_URL );
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, PROFILE_IMAGE_URL, array(
 'label' => 'メイン画像', //設定ラベル
 'section' => PROFILE_SECTION, //セクションID
 'settings' => PROFILE_IMAGE_URL, //セッティングID
 'description' => '画像をアップロードするとプロフィール画像に設定されます。',
 ) ) );
 
}
add_action( 'customize_register', 'themename_theme_customizer_profile' );//カスタマイザーに登録
 
//プロフィールメージURLの取得
function get_the_profile_image_url(){
 return esc_url( get_theme_mod( PROFILE_IMAGE_URL ) );
}

///////////////////////////////////////
// テーマカスタマイザーにデフォルト画像アップロード設定機能追加
///////////////////////////////////////
define('DEFAULT_SECTION', 'default_section'); //セクションIDの定数化
define('DEFAULT_IMAGE_URL', 'default_image_url'); //セッティングIDの定数化
function themename_theme_customizer_default( $wp_customize ) {
 $wp_customize->add_section( DEFAULT_SECTION , array(
 'title' => 'デフォルト画像', //セクション名
 'priority' => 33, //カスタマイザー項目の表示順
 'description' => 'デフォルト画像設定。サイズ1080*1080', //セクションの説明
 ) );
 
 $wp_customize->add_setting( DEFAULT_IMAGE_URL );
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, DEFAULT_IMAGE_URL, array(
 'label' => 'デフォルト画像', //設定ラベル
 'section' => DEFAULT_SECTION, //セクションID
 'settings' => DEFAULT_IMAGE_URL, //セッティングID
 'description' => '画像をアップロードするとサムネイルが何も設定されていない場合に表示されます',
 ) ) );
 
}
add_action( 'customize_register', 'themename_theme_customizer_default' );//カスタマイザーに登録
 
//プロフィールメージURLの取得
function get_the_default_image_url(){
 return esc_url( get_theme_mod( DEFAULT_IMAGE_URL ) );
}

/* デフォルトの gallery ショートコードを削除 */
remove_shortcode('gallery', 'gallery_shortcode');
 
/* gallery ショートコードをカスタム */
add_shortcode('gallery', 'custom_gallery_shortcode');
function custom_gallery_shortcode($attr) {
    $post = get_post();
 
    static $instance = 0;
    $instance++;
 
    if ( ! empty( $attr['ids'] ) ) {
        if ( empty( $attr['orderby'] ) )
            $attr['orderby'] = 'post__in';
        $attr['include'] = $attr['ids'];
    }
 
    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' )
        return $output;
 
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }
 
    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => 'div',
        'icontag'    => 'span', //画像のタグ
        'captiontag' => '', //キャプションのタグ
        'columns'    => 1,
        'size'       => 'full', //サムネイルサイズ
        'include'    => '',
        'exclude'    => '',
        'link'       => ''
    ), $attr, 'gallery'));
 
    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';
 
    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
 
        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }
 
    if ( empty($attachments) )
        return '';
 
    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }
 
    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $icontag = tag_escape($icontag);
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) )
        $itemtag = 'dl';
    if ( ! isset( $valid_tags[ $captiontag ] ) )
        $captiontag = 'dd';
    if ( ! isset( $valid_tags[ $icontag ] ) )
        $icontag = 'dt';
 
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';
 
    $selector = "gallery-{$instance}";
 
    $gallery_style = $gallery_div = '';
 
    $size_class = sanitize_html_class( $size );
    $gallery_div = "";
    $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
 
    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $image = wp_get_attachment_image_src($id, $size);
        $full = wp_get_attachment_image_src($id, 'large');
        $image_load = get_theme_file_uri(). '/js/slick_custom_ver1.3/load.gif';
        $image_output = '<img data-lazy="'.$image[0].'" alt="'.wptexturize($attachment->post_excerpt).'" src="'.$image_load.'" >';
 
        $image_meta  = wp_get_attachment_metadata( $id );
 
        $orientation = '';
        if ( isset( $image_meta['height'], $image_meta['width'] ) )
            $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
 
        $output .= "<{$itemtag} class='gallery-item'>\n";
        $output .= "<{$icontag} class='{$orientation}'>
                $image_output\n";
                
        $output .= "</{$icontag}>";
        $output .= "</{$itemtag}>\n";
    }
    $output .= "\n";
 
    return $output;
}
//WORKとCOMICを同じ投稿分類とする
function pre_get_posts_custom( $query ) {
	if ( is_admin() || !$query->is_main_query() ) { return; }
	if ( $query->is_post_type_archive( 'work' ) && !$query->is_search() ){
	   $query->set( 'post_type', array('work', 'comic') );
   }
}
add_action( 'pre_get_posts', 'pre_get_posts_custom' );