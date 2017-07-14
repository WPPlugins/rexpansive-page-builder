<?php

/**
 * The class that register and render a block.
 *
 * @link       htto://www.neweb.info
 * @since      1.0.0
 *
 * @package    Rexpansive_Builder_Test
 * @subpackage Rexpansive_Builder_Test/includes
 */

/**
 * Defines the characteristics of the RexbuilderBlock
 *
 * @package    Rexpansive_Builder_Test
 * @subpackage Rexpansive_Builder_Test/includes
 * @author     http://rexpansive.neweb.info/ <info@neweb.info>
 *
 */
class Rexpansive_Builder_Test_Block {
	private $plugin_name;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct( ) {
		$this->plugin_name = 'rexpansive-builder-test';
	}

	/**
	 * Function that render the shortcode, merging the attributes and displaying the template.
	 *
	 * @since    1.0.0
	 * @param      string    $a       			The attributest passed.
	 * @param      string    $content    		The content passed.
	 */
	public function render_block( $atts, $content = null ) {
		extract( shortcode_atts( array(
			"id" => "",
			"type" => "text",
			"size_x" => 1,
			"size_y" => 1,
			"row"	=>	'',
			"col"	=>	'',
			"color_bg_block" => "#ffffff",
			"image_bg_block" => "",
			"id_image_bg_block" => "",
			'video_bg_id' => "",
			"video_bg_url"	=>	"",
			"type_bg_block" => "",
			'image_size'	=>	'full',
			"photoswipe" => '',
			"linkurl" => '',
			'block_custom_class' => '',
			'block_padding'	=>	'',
			'overlay_block_color' => '',
			"zak_background" => "",
			"zak_side" => "",
			"zak_title" => "",
			"zak_icon" => "",
			"zak_foreground" => "",
			"block_animation" => "fadeInUpBig",
		), $atts ) );

		global $post;
		$builder_active = get_post_meta( $post->ID, '_rexbuilder_active', true);

		if('true' == $builder_active) {

			$options = get_option( $this->plugin_name . '_options' );
			$animation = $options['animation'];

			$section = explode('_', $id);
			$section = $section[1];

			//$content = ltrim( $content, '<p></p>' );
			//$content = ltrim( $content, '</p>' );
			//$content = rtrim( $content, '<p></p>' );
			//$content = rtrim( $content, '</p>' );
			//$content = trim( $content );

			$pattern = '\[(\[?)(RexLastWorks)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
			preg_match_all( "/$pattern/", $content, $find_last_works );
			
			$content = preg_replace('/^<\/p>/', '', $content);
			$content = preg_replace('/<p>+$/', '', $content);

			// Construct the style property for the background
			$section_style = "";
			if( !empty( $image_bg_block ) && 'full' == $type_bg_block ) {
				$img_attrs = wp_get_attachment_image_src( $id_image_bg_block, $image_size );
				$section_style = ' style="background-image:url(\'' . $img_attrs[0] . '\');"';
			} else if( !empty( $color_bg_block ) && 'full' != $type_bg_block ) {
				$section_style = ' style="background-color:' . $color_bg_block . ';"';
			}

			$block_link_pre = '';
			$block_link_before = '';

			if($linkurl != '' && $photoswipe == 'true')
				$photoswipe = 'false';

			if($photoswipe == 'true' && '' == $video_bg_id && '' == $video_bg_url && '' != $img_attrs[0] ) :
				$img_attrs = wp_get_attachment_image_src( $id_image_bg_block, $image_size );

				$block_link_pre .= '<figure class="pswp-figure" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">';
				$block_link_pre .= '<a class="pswp-item" href="' . $img_attrs[0] . '" itemprop="contentUrl" data-size="' . $img_attrs[1] . 'x' . $img_attrs[2] . '">';
				$block_link_pre .= '<div class="pswp-item-thumb" data-thumburl="' . wp_get_attachment_thumb_url( $id_image_bg_block ) . '" itemprop="thumbnail"></div>';
				$block_link_before .= '</a>';
				//$block_link_before .= '<figcaption class="pswp-item-caption" itemprop="caption description">' . get_the_title( $id_image_bg_block ) . '</figcaption>';
				$block_link_before .= '<figcaption class="pswp-item-caption" itemprop="caption description"></figcaption>';
				$block_link_before .= '</figure>';
			endif;

			if($linkurl != '') :
				$block_link_pre .= '<a class="element-link hovered" href="' . $linkurl . '" title="' . trim(strip_tags($content)) . '">';
				//$block_link_pre .= '<div class="element-link-effect-before"></div>';
				//$block_link_before .= '<div class="element-link-effect-after"></div>';
				$block_link_before .= '</a>';
			endif;

			$block_custom_class = trim( $block_custom_class );

			$flex_positioned = false;

			if( preg_match_all( '/rex-flex-(top|middle|bottom|left|center|right)/', $block_custom_class ) != 0 ) :
				$flex_positioned = true;
			endif;

			$block_has_overlay = false;

			if( preg_match_all( '/active-(large|medium|small)-block-overlay/', $block_custom_class ) != 0 && $overlay_block_color != '' ) :
				$block_has_overlay = true;
			endif;

			echo '<div id="' . $id . '" class="perfect-grid-item';
			echo ( ( "" == $section_style && "" == $id_image_bg_block && "" == $content && "" == $video_bg_url && "" == $video_bg_id ) ? ' real-empty' : '' );
			echo ( ( 'full' == $type_bg_block && "" != $id_image_bg_block && "" == $content ) ? ' only-background' : '' );
			if($animation == 1) :
				echo ' ' . $block_animation . ' has-rs-animation rs-animation';
			endif;
			echo ' w' . $size_x;
			echo ( '' != $block_custom_class ? ' ' . $block_custom_class : '' );
			if( 'expand' == $type) : 
				echo ' wrapper-expand-effect'; 
				echo ' '; 
				echo 'effect-expand-' . $zak_side; 
			endif;
			if( isset($find_last_works[0][0]) && '' != $find_last_works[0][0] ) :
				echo ' horizontal-carousel';
			endif;
			
			echo '" data-height="'.  $size_y . '"';
			echo ' data-width="' . $size_x . '"';
			echo ' data-row="' . $row . '"';
			echo ' data-col="' . $col . '"';

			echo '>';

			$block_style_padding = '';
			if( '' != $block_padding ) :
				$block_padding_values = explode( ';', $block_padding );
				if( count( $block_padding_values ) > 1 ) :
					//$block_style_padding = ' style="padding:' . $block_padding . '"';
					$block_style_padding = ' style="padding-top:' . $block_padding_values[0] . ';';
					$block_style_padding .= 'padding-right:' . $block_padding_values[1] . ';';
					$block_style_padding .= 'padding-bottom:' . $block_padding_values[2] . ';';
					$block_style_padding .= 'padding-left:' . $block_padding_values[3] . ';"';
				else :
					$block_style_padding = ' style="padding:' . $block_padding . '"';
				endif;
			endif;

			$bg_video_markup = '';

			if( '' != $video_bg_id && 'undefined' != $video_bg_id ) :
				$bg_video_markup = '<div class="rex-video-wrap">';
				$bg_video_markup .= '<video class="rex-video-container" preload muted autoplay loop>';
				$bg_video_markup .= '<source type="video/mp4" src="' . wp_get_attachment_url ( $video_bg_id ) . '" />';
				$bg_video_markup .= '</video>';
				$bg_video_markup .= '</div>';
			endif;

			switch( $type ) :
				case 'image':
					echo $block_link_pre;
					echo '<div class="grid-item-content image-content' . ( ('' != $video_bg_url && 'undefined' != $video_bg_url) ? ' youtube-player' : '' ) . ( ($flex_positioned) ? ' rex-flexbox' : '' ) . '" ' . $section_style;
					//echo '<div class="rex-custom-position">';
					if( '' != $video_bg_url && 'undefined' != $video_bg_url ) :
						echo ' data-property="{videoURL:\'' . $video_bg_url . '\',containment:\'self\',startAt:0,mute:true,autoPlay:true,loop:true,opacity:1,showControls:false, showYTLogo:false}"';
					endif;
					echo '>';
					echo $bg_video_markup;
					echo ( ($block_has_overlay) ? '<div class="responsive-block-overlay" style="background-color:' . $overlay_block_color . ';">' : '' );
					echo '<div class="rex-custom-scrollbar' . ( ($flex_positioned) ? ' rex-custom-position' : '' ) . '">';
					if($type_bg_block == 'natural'){
						echo '<div class="natural-image-content">';
						echo wp_get_attachment_image( $id_image_bg_block, $image_size );
						echo '</div>';
					} else {
						if( "" != $content ) :
							echo '<div class="text-wrap"' . $block_style_padding . '>';
							//echo '<p>' . do_shortcode( $content ) . '</p>';
							echo do_shortcode( $content );
							echo '</div>';
						endif;
					}
					echo '</div>';
					echo ( ($block_has_overlay) ? '</div>' : '' );
					echo '</div>';
					//echo '</div>';
					echo $block_link_before;
					break;
				case 'text':
					echo $block_link_pre;
					echo '<div class="grid-item-content text-content' . ( ('' != $video_bg_url && 'undefined' != $video_bg_url) ? ' youtube-player' : '' ) . ( ($flex_positioned) ? ' rex-flexbox' : '' ) . '" ' . $section_style;
					if( '' != $video_bg_url && 'undefined' != $video_bg_url ) :
						echo ' data-property="{videoURL:\'' . $video_bg_url . '\',containment:\'self\',startAt:0,mute:true,autoPlay:true,loop:true,opacity:1,showControls:false, showYTLogo:false}"';
					endif;
					echo '>';
					/*if($type_bg_block == 'full') {
						if( "" != $content ) :
							echo '<div class="text-wrap">';
							echo '<p>' . do_shortcode( $content ) . '</p>';
							echo '</div>';
						endif;
					} else if($type_bg_block == 'natural') {
						echo wp_get_attachment_image( $id_image_bg_block, 'full' );
					} else {
						if( "" != $content ) :
							echo '<div class="text-wrap">';
							echo '<p>' . do_shortcode( $content ) . '</p>';
							echo '</div>';
						endif;
					}*/
					//echo '<div class="rex-custom-position">';
					echo $bg_video_markup;
					echo ( ($block_has_overlay) ? '<div class="responsive-block-overlay" style="background-color:' . $overlay_block_color . ';">' : '' );
					echo '<div class="rex-custom-scrollbar' . ( ($flex_positioned) ? ' rex-custom-position' : '' ) . '">';
					if($type_bg_block == 'natural'){
						echo '<div class="natural-image-content">';
						echo wp_get_attachment_image( $id_image_bg_block, $image_size );
						echo '</div>';
					} else {
						if( "" != $content ) :
							echo '<div class="text-wrap"' . $block_style_padding . '>';
							//echo wpautop(trim((do_shortcode( $content ))));
							//echo '<p>' . do_shortcode( $content ) . '</p>';
							echo do_shortcode( $content );
							echo '</div>';
						endif;
					} 
					echo '</div>';
					echo ( ($block_has_overlay) ? '</div>' : '' );
					echo '</div>';
					//echo '</div>';
					echo $block_link_before;
					break;
				case 'video':
					echo $block_link_pre;
					echo '<div class="grid-item-content text-content' . ( ('' != $video_bg_url && 'undefined' != $video_bg_url) ? ' youtube-player' : '' ) . ( ($flex_positioned) ? ' rex-flexbox' : '' ) . '" ' . $section_style;
					if( '' != $video_bg_url && 'undefined' != $video_bg_url ) :
						echo ' data-property="{videoURL:\'' . $video_bg_url . '\',containment:\'self\',startAt:0,mute:true,autoPlay:true,loop:true,opacity:1,showControls:false, showYTLogo:false}"';
					endif;
					echo '>';
					echo $bg_video_markup;
					echo ( ($block_has_overlay) ? '<div class="responsive-block-overlay" style="background-color:' . $overlay_block_color . ';">' : '' );
					echo '<div class="rex-custom-scrollbar' . ( ($flex_positioned) ? ' rex-custom-position' : '' ) . '">';
					if($type_bg_block == 'natural'){
						echo '<div class="natural-image-content">';
						echo wp_get_attachment_image( $id_image_bg_block, $image_size );
						echo '</div>';
					} else {
						if( "" != $content ) :
							echo '<div class="text-wrap"' . $block_style_padding . '>';
							//echo wpautop(trim((do_shortcode( $content ))));
							//echo '<p>' . do_shortcode( $content ) . '</p>';
							echo do_shortcode( $content );
							echo '</div>';
						endif;
					} 
					echo '</div>';
					echo ( ($block_has_overlay) ? '</div>' : '' );
					echo '</div>';
					//echo '</div>';
					echo $block_link_before;
					break;
				case 'empty':
					echo $block_link_pre;
					echo '<div class="grid-item-content empty-content';
					echo ( ( "" == $section_style && "" == $id_image_bg_block && "" == $content && "" == $video_bg_url && "" == $video_bg_id ) ? ' real-empty' : '' );
					echo ( ('' != $video_bg_url && 'undefined' != $video_bg_url) ? ' youtube-player' : '' );
					echo ( ($flex_positioned) ? ' rex-flexbox' : '' );
					echo '"';
					if( '' != $video_bg_url && 'undefined' != $video_bg_url ) :
						echo ' data-property="{videoURL:\'' . $video_bg_url . '\',containment:\'self\',startAt:0,mute:true,autoPlay:true,loop:true,opacity:1,showControls:false, showYTLogo:false}"';
					endif;
					echo $section_style . '>';

					//echo '<div class="empty-wrap">';
					//echo '<div class="rex-custom-position">';
					
					echo $bg_video_markup;
					echo ( ($block_has_overlay) ? '<div class="responsive-block-overlay" style="background-color:' . $overlay_block_color . ';">' : '' );
					echo '<div class="rex-custom-scrollbar' . ( ($flex_positioned) ? ' rex-custom-position' : '' ) . '">';
					if($type_bg_block == 'natural') {
						echo '<div class="natural-image-content">';
						echo wp_get_attachment_image( $id_image_bg_block, $image_size );
						echo '</div>';
					}
					if( "" != $content ) :
						echo '<div class="text-wrap"' . $block_style_padding . '>';
						//echo '<p>' . do_shortcode( $content ) . '</p>';
						echo do_shortcode( $content );
						echo '</div>';
					endif;
					echo '</div>';
					echo ( ($block_has_overlay) ? '</div>' : '' );
					//echo '</div>';
					//echo '</div>';

					echo '</div>';
					echo $block_link_before;
					break;
				case 'expand':
					echo '<div class="expand-effect-content" ' . $section_style . '>';
					echo '<article class="expanded-description"><div class="expanded-icon">';
					if( $zak_icon ) :
						//echo file_get_contents( get_template_directory() . "./assets/img/ico-circle.svg");
						//echo file_get_contents( wp_get_attachment_url( $zak_icon ) );
						echo wp_get_attachment_image( $zak_icon, 'full' );
					endif;
					echo '</div>';
					echo '<div class="expanded-title">';
					echo '<h2 class="underline">' . $zak_title . '</h2></div>';
					echo '<div class="expanded-text">';
					//echo '<p>' . do_shortcode( $content ) . '</p>';
					echo do_shortcode( $content );
					//echo wpautop(trim((do_shortcode( $content ))));
					echo '</div></article>';
					echo '<figure class="expanded-image">';
					echo '<div class="expanded-image-before" style="background-color:' . $color_bg_block . '"></div>';
					if( $zak_foreground ) :
						echo '<div class="zak-hovered-image">';
						echo '<span class="zak-foreground-responsive-wrap">';
						echo wp_get_attachment_image( $zak_foreground, 'full' );
						echo '</span>';
						//<img src="http://rexpansive.neweb.info/wp-content/uploads/2015/08/smartphone-flower.png">
						echo '</div>';
					endif;
					echo '<div class="expanded-image-overlay"><div class="exp-overlay-hover"><div class="ico-expansive">';
					echo file_get_contents( get_template_directory() . '/assets/img/ico-expansive.svg' );
					echo '</div>';
					echo '<div class="ico-more">';
					echo file_get_contents( get_template_directory() . '/assets/img/ico-more.svg' );
					echo '</div></div></div>';
					echo '<img src="' . wp_get_attachment_url( $zak_background, 'full' ) .'" alt="" />';
					echo '<div class="expanded-image-after" style="border-color:' . $color_bg_block . '"></div>';
					echo '</figure>';
					echo '</div>';
					break;
				default:
					break;
			endswitch;
			
			echo '</div>';

		} else {

			echo do_shortcode( $content );

		}
	}
}