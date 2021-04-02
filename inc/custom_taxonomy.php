<?php
/**
 * Created by Notepad.
 * User: Mr.Lak
 * Date: 3/8/13
 * Time: 2:24 PM
 */




add_action( 'init', 'create_dia_diem_taxonomies', 10 );
function create_dia_diem_taxonomies()
{
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                         => __('địa điểm'),
        'singular_name'                => __( 'Địa điểm' ),
        'search_items'                 => __( 'Tìm địa điểm' ),
        'popular_items'                => __( 'Địa điểm phổ biến' ),
        'all_items'                    => __( 'Danh sách địa điểm' ),
        'parent_item'                  => null,
        'parent_item_colon'            => null,
        'edit_item'                    => __( 'Sửa' ),
        'update_item'                  => __( 'Cập nhật' ),
        'add_new_item'                 => __( 'Thêm địa điểm' ),
        'new_item_name'                => __( 'New place Name' ),
        'separate_items_with_commas'   => __( 'Ngăn cách bởi dấu phẩy' ),
        'add_or_remove_items'          => __( 'Thêm hoặc xóa địa điểm' ),
        'choose_from_most_used'        => __( 'Choose from the most used writers' ),
        'not_found'                    => __( 'Không tìm thấy địa điểm.' ),
        'menu_name'                    => __( 'Địa điểm' )
    );

    $args = array(
        'hierarchical'            => true,
        'labels'                  => $labels,
        'show_ui'                 => true,
        'show_admin_column'       => true,
       // 'update_count_callback'   => '_update_post_term_count',
        'query_var'               => true,
        'rewrite'                 => array( 'slug' => 'dia-diem','with_front'=>false ),
        'sort'                    => true
    );

    register_taxonomy( 'dia-diem', array('post','page'), $args );
}


add_action( 'init', 'create_danh_muc_taxonomies', 10 );
function create_danh_muc_taxonomies()
{
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                         => __('Page category'),
        'singular_name'                => __( 'Page category' ),
        'search_items'                 => __( 'Tìm Page category' ),
        'popular_items'                => __( 'Page category phổ biến' ),
        'all_items'                    => __( 'Danh sách Page category' ),
        'parent_item'                  => null,
        'parent_item_colon'            => null,
        'edit_item'                    => __( 'Sửa' ),
        'update_item'                  => __( 'Cập nhật' ),
        'add_new_item'                 => __( 'Thêm Page category' ),
        'new_item_name'                => __( 'Page category mới' ),
        'separate_items_with_commas'   => __( 'Ngăn cách bởi dấu phẩy' ),
        'add_or_remove_items'          => __( 'Thêm hoặc xóa Page category' ),
        'choose_from_most_used'        => __( 'Choose from the most used writers' ),
        'not_found'                    => __( 'Không tìm thấy danh mục.' ),
        'menu_name'                    => __( 'Page category' )
    );

    $args = array(
        'hierarchical'            => true,
        'labels'                  => $labels,
        'show_ui'                 => true,
        'show_admin_column'       => true,
        // 'update_count_callback'   => '_update_post_term_count',
        'query_var'               => true,
        'rewrite'                 => array( 'slug' => 'page-cat','with_front'=>false ),
        'sort'                    => true
    );

    register_taxonomy( 'page-cat', array('page'), $args );
}


add_action( 'init', 'create_tax_trade', 10 );
function create_tax_trade()
{
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                         => __('Trade cat'),
        'singular_name'                => __( 'Trade cat' ),
        'search_items'                 => __( 'Tìm Trade cat' ),
        'popular_items'                => __( 'Trade cat phổ biến' ),
        'all_items'                    => __( 'Danh sách Trade categories' ),
        'parent_item'                  => null,
        'parent_item_colon'            => null,
        'edit_item'                    => __( 'Sửa' ),
        'update_item'                  => __( 'Cập nhật' ),
        'add_new_item'                 => __( 'Thêm danh mục' ),
        'new_item_name'                => __( 'Danh mục mới' ),
        'separate_items_with_commas'   => __( 'Ngăn cách bởi dấu phẩy' ),
        'add_or_remove_items'          => __( 'Thêm hoặc xóa Danh mục' ),
        'choose_from_most_used'        => __( 'Choose from the most used writers' ),
        'not_found'                    => __( 'Không tìm thấy danh mục.' ),
        'menu_name'                    => __( 'Phân loại' )
    );

    $args = array(
        'hierarchical'            => true,
        'labels'                  => $labels,
        'show_ui'                 => true,
        'show_admin_column'       => true,
        'query_var'               => true,
        'rewrite'                 => array( 'slug' => 'trade-cat','with_front'=>false ),
        'sort'                    => true
    );

    register_taxonomy( 'trade-cat', array('trade'), $args );
}

?>