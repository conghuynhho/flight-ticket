<?php
add_action( 'init', 'create_danh_muc_taxonomies', 10 );
function create_danh_muc_taxonomies()
{
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

/*FILTER PAGE BY PAGE-CAT*/
####################################
#FILTER CUSTOM POST TYPE BY TAXONOMY
####################################
add_action( 'restrict_manage_posts', 'my_filter_list' );
add_filter( 'parse_query','perform_filtering' );

function my_filter_list() {
    $screen = get_current_screen();
    $arrtax=array(
        array('slug'=>'page-cat','name'=>'Phân Loại'),

    );
    global $wp_query;

    if ( $screen->post_type == 'page' ) {

        foreach($arrtax as $tax){
            wp_dropdown_categories( array(
                'show_option_all' => 'Tất cả '.$tax['name'],
                'taxonomy' => $tax['slug'],
                'name' => $tax['slug'],
                'orderby' => 'name',
                'selected' => ( isset( $wp_query->query[$tax['slug']] ) ? $wp_query->query[$tax['slug']] : '' ),
                'hierarchical' => true,
                'depth' => 1,
                'show_count' => false,
                'hide_empty' => false,
            ) );
        }


    }
}


function perform_filtering( $query ) {
    global $pagenow;
    $arrtax=array('page','page-cat');

    if($pagenow=='edit.php'){
        foreach($arrtax as $tax){
            $qv = &$query->query_vars;
            if ( ( $qv[$tax] )  ) {
                $term = get_term_by( 'id', $qv[$tax], $tax );
                $qv[$tax] = $term->slug;
            }
        }
    }
}
/*END FILTER PAGE BY PAGE-CAT*/
?>