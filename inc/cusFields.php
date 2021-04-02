<?php
class RW_Meta_Box_Taxonomy extends RW_Meta_Box {
	
	function add_missed_values() {
		parent::add_missed_values();
		
		// add 'multiple' option to taxonomy field with checkbox_list type
		foreach ($this->_meta_box['fields'] as $key => $field) {
			if ('taxonomy' == $field['type'] && 'checkbox_list' == $field['options']['type']) {
				$this->_meta_box['fields'][$key]['multiple'] = true;
			}
		}
	}
	
	// show taxonomy list
	function show_field_taxonomy($field, $meta) {
		global $post;
		
		if (!is_array($meta)) $meta = (array) $meta;
		
		$this->show_field_begin($field, $meta);
		
		$options = $field['options'];
		$terms = get_terms($options['taxonomy'], $options['args']);
		
		// checkbox_list
		if ('checkbox_list' == $options['type']) {
			foreach ($terms as $term) {
				echo "<input type='checkbox' name='{$field['id']}[]' value='$term->slug'" . checked(in_array($term->slug, $meta), true, false) . " /> $term->name<br/>";
			}
		}
		// select
		else {
			echo "<select name='{$field['id']}" . ($field['multiple'] ? "[]' multiple='multiple' style='height:auto'" : "'") . ">";
		
			foreach ($terms as $term) {
				echo "<option value='$term->slug'" . selected(in_array($term->slug, $meta), true, false) . ">$term->name</option>";
			}
			echo "</select>";
		}
		
		$this->show_field_end($field, $meta);
	}
}

/********************* END EXTENDING CLASS ***********************/
$prefix = 'fl_';
$meta_boxes = array();
$meta_boxes[] = array(
	'id' => 'seo_meta',
	'title' => 'Cấu hình bài viết',
	'priority' => 'low',
	'pages' => array('post','page'),
	'fields' => array(
        array(
            'name' => 'Homepage',
            'desc' => 'Cho phép bài viết hiển thị lên trang chủ',
            'id' => $prefix.'homestick',
            'type' => 'checkbox'

        ),
		array(
            'name' => 'Footer',
            'desc' => 'Cho phép bài viết hiển thị dưới Footer',
            'id' => $prefix.'footerstick',
            'type' => 'checkbox'

        ),
		array(
            'name' => 'Sắp xếp',
            'desc' => 'Thứ tự bài viết khi hiển thị',
            'id' => $prefix.'mysortby',
            'type' => 'text',
			'std' => 999999,

        ),
		array(
            'name' => 'Nơi đi',
            'desc' => 'Mã nơi đi (vd: SGN)',
            'id' => $prefix.'dep_code',
            'type' => 'text'

        ),
		array(
            'name' => 'Nơi đến',
            'desc' => 'Mã nơi đến (vd: HAN)',
            'id' => $prefix.'arv_code',
            'type' => 'text'

        ),
	),
);

foreach ($meta_boxes as $meta_box) {
	$my_box = new RW_Meta_Box_Taxonomy($meta_box);
}
?>