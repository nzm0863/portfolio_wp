<?php
function mytheme_scripts() {
  // スタイルの登録
  wp_enqueue_style('sanitize', get_stylesheet_directory_uri() . '/styles/sanitize.css');
  wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/styles/style.css');
  // wp_enqueue_style('comfirm-style', get_stylesheet_directory_uri() . '/styles/comfirm.css');
  
  // スクリプトの登録
  // wp_enqueue_script('vue', get_stylesheet_directory_uri() . '/js/vue.global.prod.js', array(), false, true);
  // wp_enqueue_script('particles', get_stylesheet_directory_uri() . '/js/particles.js', array(), false, true);
  wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/js/app.js', array('vue', 'particles'), false, true);
  // wp_enqueue_script('jquery-validate', get_stylesheet_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), false, true);
  // wp_enqueue_script('messages_ja', get_stylesheet_directory_uri() . '/js/messages_ja.js', array('jquery', 'jquery-validate'), false, true);
  // wp_enqueue_script('form-validate', get_stylesheet_directory_uri() . '/js/form-validate.js', array('jquery', 'jquery-validate', 'messages_ja'), false, true);
  //themeUrlをJavaScriptに渡す
  wp_localize_script('main-js', 'themeUrl', array(
    'themeUrl' => get_stylesheet_directory_uri()
  ));
}
add_action('wp_enqueue_scripts', 'mytheme_scripts');

// カスタムフィールドをREST APIに含める
function add_custom_fields_to_rest_api() {
  // Works投稿タイプのカスタムフィールド
  register_rest_field('works', 'work_link', array(
    'get_callback' => function($post) {
      return get_field('work_link', $post['id']);
    },
    'schema' => null,
  ));
  
  // Skill投稿タイプのカスタムフィールド
  register_rest_field('skill', 'skill_link', array(
    'get_callback' => function($post) {
      return get_field('skill_link', $post['id']);
    },
    'schema' => null,
  ));
}
add_action('rest_api_init', 'add_custom_fields_to_rest_api');

function create_skill_post_type() {
  register_post_type('skill',
    array(
      'labels' => array(
        'name' => 'Skills',
        'singular_name' => 'Skill'
      ),
      'public' => true,
      'show_in_rest' => true, // REST API有効化
      'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
      'rest_base' => 'skill', 
      'rest_controller_class' => 'WP_REST_Posts_Controller',
    )
  );
}
add_action('init', 'create_skill_post_type');

function create_post_type_works() {
  register_post_type('works',
    array(
      'labels' => array(
        'name' => __('Works'),
        'singular_name' => __('Work')
      ),
      'public' => true,
      'has_archive' => true,
      'show_in_rest' => true, // ←これでREST API有効
      'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
    )
  );
}
add_action('init', 'create_post_type_works');