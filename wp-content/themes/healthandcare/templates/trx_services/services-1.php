<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'healthandcare_template_services_1_theme_setup' ) ) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_template_services_1_theme_setup', 1 );
	function healthandcare_template_services_1_theme_setup() {
		healthandcare_add_template(array(
			'layout' => 'services-1',
			'template' => 'services-1',
			'mode'   => 'services',
			'title'  => esc_html__('Services /Style 1/', 'healthandcare'),
			'thumb_title'  => esc_html__('Small image (crop)', 'healthandcare'),
			'w'		 => 50,
			'h'		 => 50
		));
	}
}

// Template output
if ( !function_exists( 'healthandcare_template_services_1_output' ) ) {
	function healthandcare_template_services_1_output($post_options, $post_data) {
		$show_title = true;
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(12, empty($parts[1]) ? (!empty($post_options['columns_count']) ? $post_options['columns_count'] : 1) : (int) $parts[1]));
		if (healthandcare_param_is_on($post_options['slider'])) {
			?><div class="swiper-slide" data-style="<?php echo esc_attr($post_options['tag_css_wh']); ?>" style="<?php echo esc_attr($post_options['tag_css_wh']); ?>"><div class="sc_services_item_wrap"><?php
		} else if ($columns > 1) {
			?><div class="column-1_<?php echo esc_attr($columns); ?> column_padding_bottom"><?php
		}
		?>
			<div<?php echo ($post_options['tag_id'] ? ' id="'.esc_attr($post_options['tag_id']).'"' : ''); ?>
				class="sc_services_item sc_services_item_<?php echo esc_attr($post_options['number']) . ($post_options['number'] % 2 == 1 ? ' odd' : ' even') . ($post_options['number'] == 1 ? ' first' : '') . (!empty($post_options['tag_class']) ? ' '.esc_attr($post_options['tag_class']) : ''); ?>"
				<?php echo ($post_options['tag_css']!='' ? ' style="'.esc_attr($post_options['tag_css']).'"' : '') 
					. (!healthandcare_param_is_off($post_options['tag_animation']) ? ' data-animation="'.esc_attr(healthandcare_get_animation_classes($post_options['tag_animation'])).'"' : ''); ?>>
				<?php 
				if ($post_data['post_icon'] && $post_options['tag_type']=='icons') {
					$html = healthandcare_do_shortcode('[trx_icon icon="'.esc_attr($post_data['post_icon']).'" shape="none"]');
					if ($show_title) {
                        if ((!isset($post_options['links']) || $post_options['links']) && !empty($post_data['post_link'])) {
                            ?><h4 class="sc_services_item_title">
                            <?php
                            if ((!isset($post_options['links']) || $post_options['links']) && !empty($post_data['post_link'])) {
                                ?><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php echo trim($html); echo ($post_data['post_title']); ?></a></h4><?php
                            } else
                                echo trim($html);
                        } else {
                            ?><h4 class="sc_services_item_title">
                            <?php
                            if ((!isset($post_options['links']) || $post_options['links']) && !empty($post_data['post_link'])) {
                                ?><a><?php echo trim($html); echo ($post_data['post_title']); ?></a></h4><?php
                            } else
                                echo trim($html); ?><?php
                        }
                    }
				} else {
					?>
					<div class="sc_services_item_featured post_featured">
						<?php require(healthandcare_get_file_dir('templates/_parts/post-featured.php')); ?>
					</div>
					<?php
				}
				?>
				<div class="sc_services_item_content">
					<div class="sc_services_item_description">
						<?php
							if ($post_data['post_excerpt']) {
								echo '<p>'.trim(healthandcare_strshort($post_data['post_excerpt'], isset($post_options['descr']) ? $post_options['descr'] : healthandcare_get_custom_option('post_excerpt_maxlength_masonry'))).'</p>';
							}
							if (!empty($post_data['post_link']) && !healthandcare_param_is_off($post_options['readmore'])) {
								?><a href="<?php echo esc_url($post_data['post_link']); ?>" class="sc_services_item_readmore"><?php echo trim($post_options['readmore']); ?><span class="icon-right-2"></span></a><?php
							}
						?>
					</div>
				</div>
			</div>
		<?php
		if (healthandcare_param_is_on($post_options['slider'])) {
			?></div></div><?php
		} else if ($columns > 1) {
			?></div><?php
		}
	}
}
?>