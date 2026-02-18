<?php
/**
 * Helper functions
 *
 * @package Happy_Addons Pro
 */
defined('ABSPATH') || die();

/**
 * Short Number Format
 * @param $n
 * @param int $precision
 * @return string
 */
function hapro_short_number_format($n, $precision = 1) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }
    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }
    return $n_format . $suffix;
}

/**
 * Instagram Feed Ajax
 */
function hapro_instagram_feed_ajax() {

    $security = check_ajax_referer('happy_addons_pro_nonce', 'security');

    if (true == $security && isset($_POST['query_settings'])) :

        $settings = $_POST['query_settings'];
        $loaded_item = $_POST['loaded_item'];
        $item_tag = 'yes' == $settings['show_link'] ? 'a' : 'div';
        $href_target = '';
        $access_token = base64_decode($settings['access_token']);
        $transient_key = 'happy_insta_feed_data' . str_replace('.', '_', $access_token);
        $instagram_data = get_transient($transient_key);
        if (false === $instagram_data) {
            $instagram_data = wp_remote_retrieve_body(wp_remote_get('https://api.instagram.com/v1/users/self/media/recent/?access_token=' . $access_token));
        }
        $instagram_data = json_decode($instagram_data, true);
        switch ($settings['sort_by']) {
            case 'old-posts':
                usort($instagram_data['data'], function ($a, $b) {
                    if ($a['created_time'] == $b['created_time']) return 0;
                    return ($a['created_time'] < $b['created_time']) ? -1 : 1;
                });
                break;
            case 'most-liked':
                usort($instagram_data['data'], function ($a, $b) {
                    if ($a['likes']['count'] == $b['likes']['count']) return 0;
                    return ($a['likes']['count'] > $b['likes']['count']) ? -1 : 1;
                });
                break;
            case 'less-liked':
                usort($instagram_data['data'], function ($a, $b) {
                    if ($a['likes']['count'] == $b['likes']['count']) return 0;
                    return ($a['likes']['count'] < $b['likes']['count']) ? -1 : 1;
                });
                break;
            case 'most-commented':
                usort($instagram_data['data'], function ($a, $b) {
                    if ($a['comments']['count'] == $b['comments']['count']) return 0;
                    return ($a['comments']['count'] > $b['comments']['count']) ? -1 : 1;
                });
                break;
            case 'less-commented':
                usort($instagram_data['data'], function ($a, $b) {
                    if ($a['comments']['count'] == $b['comments']['count']) return 0;
                    return ($a['comments']['count'] < $b['comments']['count']) ? -1 : 1;
                });
                break;
            default:
                $instagram_data['data'];
        }
        $instagram_data = array_splice($instagram_data['data'], $loaded_item, $settings['instagram_item']);
        ?>
        <?php if ('ha-hover-info' == $settings['view_style']): ?>
	        <?php foreach ($instagram_data as $key => $single): ?>
	            <?php if ('yes' == $settings['show_link']) {
	                $href_target = 'href="'.esc_url($single['link']).'" '.'target="'.esc_attr($settings['link_target']).'"';
	            }?>
	            <<?php echo tag_escape($item_tag) . ' class="ha-insta-item loaded" '.$href_target;?>>
	            <img src="<?php echo $single['images'][$settings['image_size']]['url'] ?>" alt="">
	            <div class="ha-insta-content">
		            <?php if('yes' == $settings['show_likes'] || 'yes' == $settings['show_comments'] ):?>
		                <div class="ha-insta-likes-comments">
		                    <?php if ('yes' == $settings['show_likes']): ?>
		                        <div class="ha-insta-likes">
			                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><path d="M16,30.4c-0.8,0-1.5-0.3-2.1-0.9L2.8,18.4c0,0-0.1-0.1-0.1-0.1c-3.6-3.8-3.5-10,0.2-13.7c1.9-1.9,4.3-2.9,7-2.9  c2.3,0,4.4,0.8,6.2,2.2c1.7-1.4,3.9-2.2,6.2-2.2c2.6,0,5.1,1,7,2.9c3.7,3.7,3.8,9.9,0.2,13.7c0,0-0.1,0.1-0.1,0.1L18.1,29.5  C17.5,30,16.8,30.4,16,30.4z M4.3,17L4.3,17l11,11c0.4,0.4,1,0.4,1.3,0l11-11c0,0,0-0.1,0.1-0.1c3-3.1,2.9-8-0.1-11  c-1.5-1.5-3.5-2.3-5.5-2.3c-2.1,0-4,0.8-5.5,2.2c-0.4,0.4-1,0.4-1.4,0c-1.5-1.4-3.4-2.2-5.5-2.2c-2.1,0-4.1,0.8-5.5,2.3  C1.3,8.9,1.2,13.9,4.3,17C4.2,17,4.3,17,4.3,17z"></path></svg>
		                            <label><?php echo esc_html(hapro_short_number_format($single['likes']['count'])); ?></label>
		                        </div>
		                    <?php endif; ?>
		                    <?php if ('yes' == $settings['show_comments']): ?>
		                        <div class="ha-insta-comments">
			                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><path d="M16,32C7.2,32,0,24.8,0,16S7.2,0,16,0s16,7.2,16,16c0,2.4-0.5,4.8-1.6,7l1.6,6.7c0.1,0.3,0,0.7-0.3,0.9  c-0.2,0.2-0.6,0.3-0.9,0.3l-6.3-1.4C22,31.2,19,32,16,32z M16,2C8.3,2,2,8.3,2,16s6.3,14,14,14c2.8,0,5.5-0.8,7.8-2.4  c0.2-0.2,0.5-0.2,0.8-0.1l5.1,1.1l-1.3-5.5c-0.1-0.2,0-0.5,0.1-0.7c1-2,1.5-4.1,1.5-6.4C30,8.3,23.7,2,16,2z"></path></svg>
			                        <label><?php echo esc_html(hapro_short_number_format($single['comments']['count']));?></label>
		                        </div>
		                    <?php endif; ?>
		                </div>
	                <?php endif; ?>
	                <?php if (null != $single['caption'] && 'yes' == $settings['show_caption']): ?>
	                    <div class="ha-insta-caption">
	                        <p><?php echo esc_html($single['caption']['text']); ?></p>
	                    </div>
	                <?php endif; ?>
	            </div>
	            </<?php echo tag_escape($item_tag); ?>><!-- Item wrap End-->
	        <?php endforeach; ?>
	    <?php endif; ?>
	    <?php if ('ha-hover-push' == $settings['view_style']): ?>
	        <?php foreach ($instagram_data as $key => $single):?>
	            <?php if ('yes' == $settings['show_link']) {
	                $href_target = 'href="'.esc_url($single['link']).'" '.'target="'.esc_attr($settings['link_target']).'"';
	            }?>
	            <<?php echo tag_escape($item_tag) . ' class="ha-insta-item loaded" '.$href_target;?>>
	            <img src="<?php echo $single['images'][$settings['image_size']]['url'] ?>" alt="">
	            <div class="ha-insta-likes-comments">
	                <?php if ('yes' == $settings['show_likes']): ?>
	                    <div class="ha-insta-likes">
		                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><path d="M16,30.4c-0.8,0-1.5-0.3-2.1-0.9L2.8,18.4c0,0-0.1-0.1-0.1-0.1c-3.6-3.8-3.5-10,0.2-13.7c1.9-1.9,4.3-2.9,7-2.9  c2.3,0,4.4,0.8,6.2,2.2c1.7-1.4,3.9-2.2,6.2-2.2c2.6,0,5.1,1,7,2.9c3.7,3.7,3.8,9.9,0.2,13.7c0,0-0.1,0.1-0.1,0.1L18.1,29.5  C17.5,30,16.8,30.4,16,30.4z M4.3,17L4.3,17l11,11c0.4,0.4,1,0.4,1.3,0l11-11c0,0,0-0.1,0.1-0.1c3-3.1,2.9-8-0.1-11  c-1.5-1.5-3.5-2.3-5.5-2.3c-2.1,0-4,0.8-5.5,2.2c-0.4,0.4-1,0.4-1.4,0c-1.5-1.4-3.4-2.2-5.5-2.2c-2.1,0-4.1,0.8-5.5,2.3  C1.3,8.9,1.2,13.9,4.3,17C4.2,17,4.3,17,4.3,17z"></path></svg>
	                        <label><?php echo esc_html(hapro_short_number_format($single['likes']['count'])); ?></label>
	                    </div>
	                <?php endif; ?>
	                <?php if ('yes' == $settings['show_comments']): ?>
	                    <div class="ha-insta-comments">
		                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><path d="M16,32C7.2,32,0,24.8,0,16S7.2,0,16,0s16,7.2,16,16c0,2.4-0.5,4.8-1.6,7l1.6,6.7c0.1,0.3,0,0.7-0.3,0.9  c-0.2,0.2-0.6,0.3-0.9,0.3l-6.3-1.4C22,31.2,19,32,16,32z M16,2C8.3,2,2,8.3,2,16s6.3,14,14,14c2.8,0,5.5-0.8,7.8-2.4  c0.2-0.2,0.5-0.2,0.8-0.1l5.1,1.1l-1.3-5.5c-0.1-0.2,0-0.5,0.1-0.7c1-2,1.5-4.1,1.5-6.4C30,8.3,23.7,2,16,2z"></path></svg>
		                    <label><?php echo esc_html(hapro_short_number_format($single['comments']['count']));?></label>
	                    </div>
	                <?php endif; ?>
	            </div>
	            </<?php echo tag_escape($item_tag); ?>>
	        <?php endforeach; ?>
	    <?php endif; ?>
	    <?php if ('ha-feed-view' == $settings['view_style']): ?>
		    <?php foreach ($instagram_data as $key => $single):?>
			    <div class="ha-insta-item loaded">
				    <?php if('yes' == $settings['show_user_picture'] || 'yes' == $settings['show_username'] || 'yes' == $settings['show_user_postdate'] || 'yes' == $settings['show_user_insta_icon']):?>
					    <div class="ha-insta-user-info">
						    <?php if('yes' == $settings['show_user_picture'] || 'yes' == $settings['show_username'] || 'yes' == $settings['show_user_postdate']):?>
							    <a class="ha-insta-user" href="<?php echo esc_url('https://www.instagram.com/'.$single['user']['username']);?>" target="_blank">
								    <?php if('yes' == $settings['show_user_picture']):?>
									    <div class="ha-insta-user-profile-picture">
										    <img src="<?php echo esc_url($single['user']['profile_picture']);?>" alt="<?php echo esc_attr($single['user']['full_name']);?>">
									    </div>
								    <?php endif;?>
								    <div class="ha-insta-username-and-postdate">
									    <?php if('yes' == $settings['show_username']):?>
										    <span class="ha-insta-user-name"><?php echo esc_html($single['user']['full_name'])?></span>
									    <?php endif;?>
									    <?php if('yes' == $settings['show_user_postdate']):?>
										    <span class="ha-insta-postdate"><?php echo esc_html(date("M d Y", strtotime($single['created_time'])));?></span>
									    <?php endif;?>
								    </div>
							    </a>
						    <?php endif;?>
						    <?php if('yes' == $settings['show_user_insta_icon']):?>
							    <a class="ha-insta-feed-icon" href="<?php echo esc_url($single['link']);?>" target="_blank">
								    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><path d="M23,32H9c-5,0-9-4-9-9V9c0-5,4-9,9-9h14c5,0,9,4,9,9v14C32,28,28,32,23,32z M9,2C5.1,2,2,5.1,2,9v14c0,3.9,3.1,7,7,7h14  c3.9,0,7-3.1,7-7V9c0-3.9-3.1-7-7-7H9z"></path><path d="M16,24.2c-4.5,0-8.2-3.7-8.2-8.2c0-4.5,3.7-8.2,8.2-8.2c4.5,0,8.2,3.7,8.2,8.2C24.2,20.5,20.5,24.2,16,24.2z M16,9.8  c-3.4,0-6.2,2.8-6.2,6.2s2.8,6.2,6.2,6.2s6.2-2.8,6.2-6.2S19.4,9.8,16,9.8z"></path><circle cx="16" cy="16" r="1.9"></circle></svg>
							    </a>
						    <?php endif;?>
					    </div>
				    <?php endif;?>
				    <a class="ha-insta-image" href="<?php echo esc_url($single['link']);?>" target="_blank">
					    <img src="<?php echo $single['images'][$settings['image_size']]['url'] ?>" alt="">
				    </a>
				    <?php if('yes' == $settings['show_likes'] || 'yes' == $settings['show_comments'] || (null != $single['caption'] && 'yes' == $settings['show_caption']) ):?>
					    <div class="ha-insta-content">
						    <?php if('yes' == $settings['show_likes'] || 'yes' == $settings['show_comments'] ):?>
						        <div class="ha-insta-likes-comments">
							    <?php if ('yes' == $settings['show_likes']): ?>
								    <a class="ha-insta-likes" href="<?php echo esc_url($single['link']);?>" target="_blank">
									    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><path d="M16,30.4c-0.8,0-1.5-0.3-2.1-0.9L2.8,18.4c0,0-0.1-0.1-0.1-0.1c-3.6-3.8-3.5-10,0.2-13.7c1.9-1.9,4.3-2.9,7-2.9  c2.3,0,4.4,0.8,6.2,2.2c1.7-1.4,3.9-2.2,6.2-2.2c2.6,0,5.1,1,7,2.9c3.7,3.7,3.8,9.9,0.2,13.7c0,0-0.1,0.1-0.1,0.1L18.1,29.5  C17.5,30,16.8,30.4,16,30.4z M4.3,17L4.3,17l11,11c0.4,0.4,1,0.4,1.3,0l11-11c0,0,0-0.1,0.1-0.1c3-3.1,2.9-8-0.1-11  c-1.5-1.5-3.5-2.3-5.5-2.3c-2.1,0-4,0.8-5.5,2.2c-0.4,0.4-1,0.4-1.4,0c-1.5-1.4-3.4-2.2-5.5-2.2c-2.1,0-4.1,0.8-5.5,2.3  C1.3,8.9,1.2,13.9,4.3,17C4.2,17,4.3,17,4.3,17z"></path></svg>
									    <label><?php echo esc_html(hapro_short_number_format($single['likes']['count'])); ?></label>
								    </a>
							    <?php endif; ?>
							    <?php if ('yes' == $settings['show_comments']): ?>
								    <a class="ha-insta-comments" href="<?php echo esc_url($single['link']);?>" target="_blank">
									    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><path d="M16,32C7.2,32,0,24.8,0,16S7.2,0,16,0s16,7.2,16,16c0,2.4-0.5,4.8-1.6,7l1.6,6.7c0.1,0.3,0,0.7-0.3,0.9  c-0.2,0.2-0.6,0.3-0.9,0.3l-6.3-1.4C22,31.2,19,32,16,32z M16,2C8.3,2,2,8.3,2,16s6.3,14,14,14c2.8,0,5.5-0.8,7.8-2.4  c0.2-0.2,0.5-0.2,0.8-0.1l5.1,1.1l-1.3-5.5c-0.1-0.2,0-0.5,0.1-0.7c1-2,1.5-4.1,1.5-6.4C30,8.3,23.7,2,16,2z"></path></svg>
									    <label><?php echo esc_html(hapro_short_number_format($single['comments']['count']));?></label>
								    </a>
							    <?php endif; ?>
						    </div>
						    <?php endif; ?>
						    <?php if (null != $single['caption'] && 'yes' == $settings['show_caption']): ?>
							    <div class="ha-insta-caption">
								    <p><?php echo esc_html($single['caption']['text']); ?></p>
							    </div>
						    <?php endif; ?>
					    </div>
				    <?php endif;?>
			    </div>
		    <?php endforeach; ?>
	    <?php endif; ?>
    <?php
    endif;
    wp_die();
}

add_action( 'wp_ajax_ha_instagram_feed_action', 'hapro_instagram_feed_ajax' );
add_action( 'wp_ajax_nopriv_ha_instagram_feed_action', 'hapro_instagram_feed_ajax' );

/**
 * Check license validity
 *
 * @return bool
 */
function hapro_has_valid_license() {
    return \Happy_Addons_Pro\Base::$appsero->license()->is_valid();
}

/**
 * Contain masking shape list
 * @param $element
 * @return array
 */
function hapro_masking_shape_list( $element ) {
	$dir = HAPPY_ADDONS_PRO_ASSETS . 'imgs/masking-shape/';
	$shape_name = 'shape';
	$extension = '.svg';
	$list = [];
	if ( 'list' == $element ) {
		for ($i = 1; $i <= 39; $i++) {
			$list[$shape_name.$i] = [
				'title' => ucwords($shape_name.' '.$i),
				'url' => $dir . $shape_name . $i . $extension,
			];
		}
	} elseif ( 'url' == $element ) {
		for ($i = 1; $i <= 39; $i++) {
			$list[$shape_name.$i] = $dir . $shape_name . $i . $extension;
		}
	}
	return $list;
}


/**
 * Compare value.
 *
 * Compare two values based on Comparison operator
 *
 * @param mixed $left_value  First value to compare.
 * @param mixed $right_value  Second value to compare.
 * @param string $operator  Comparison operator.
 * @return bool
 */
function hapro_compare( $left_value, $right_value, $operator ) {
	switch ( $operator ) {
		case 'is':
			return $left_value == $right_value;
		case 'not':
			return $left_value != $right_value;
		default:
			return $left_value === $right_value;
	}
}

/**
 * Get User Browser name
 *
 * @param $user_agent
 * @return string
 */
function hapro_get_browser_name ( $user_agent ) {

	if ( strpos( $user_agent, 'Opera' ) || strpos( $user_agent, 'OPR/' ) ) return 'opera';
	elseif ( strpos( $user_agent, 'Edge' ) ) return 'edge';
	elseif ( strpos( $user_agent, 'Chrome' ) ) return 'chrome';
	elseif ( strpos( $user_agent, 'Safari' ) ) return 'safari';
	elseif ( strpos( $user_agent, 'Firefox' ) ) return 'firefox';
	elseif ( strpos( $user_agent, 'MSIE' ) || strpos( $user_agent, 'Trident/7' ) ) return 'ie';
	return 'other';
}

/**
 * Get Client Site Time
 * @param string $format
 * @return string
 */
function hapro_get_local_time ( $format = 'Y-m-d h:i:s A' ) {
	$local_time_zone = isset($_COOKIE['HappyLocalTimeZone']) && !empty($_COOKIE['HappyLocalTimeZone'])? str_replace('GMT ','GMT+',$_COOKIE['HappyLocalTimeZone']): date_default_timezone_get();
	$now_date = new \DateTime('now',new \DateTimeZone( $local_time_zone ) );
	$today = $now_date->format($format);
	return $today;
}

/**
 * Get Server Time
 * @param string $format
 * @return string
 */
function hapro_get_server_time ( $format = 'Y-m-d h:i:s A' ) {
	$today 	= date( $format , strtotime("now") + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
	return $today;
}

/**
 * Check elementor version
 *
 * @param string $version
 * @param string $operator
 * @return bool
 */
function hapro_is_elementor_version( $operator = '>=', $version = '2.8.0' ) {
    return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
}

/**
 * Get the list of all section templates
 *
 * @return array
 */
function hapro_get_section_templates() {
    $items = ha_elementor()->templates_manager->get_source( 'local' )->get_items();
    if ( ! empty( $items ) ) {
        $items = wp_list_filter( $items, ['type' => 'section'] );
        $items = wp_list_pluck( $items, 'title', 'template_id' );
        return $items;
    }
    return [];
}
