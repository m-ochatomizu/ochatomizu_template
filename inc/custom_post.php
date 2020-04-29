// カスタム投稿タイプ「WORK」を追加する
function create_post_type_work() {
  $Supports = [
	  'title',
	  'editor',
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
      'menu_position' => 5,
      'supports' => $Supports
    )
  );

// カスタム投稿カテゴリーを追加する
	register_taxonomy(
		'work_cat',
		'work',
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

// カスタム投稿タイプ「BLOG」を追加する
function create_post_type_blog() {
  $Supports = [
	  'title',
	  'editor',
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