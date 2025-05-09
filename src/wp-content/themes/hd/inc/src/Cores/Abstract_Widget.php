<?php

namespace Cores;

use ReflectionClass;
use WP_Widget;

\defined( 'ABSPATH' ) || die;

abstract class Abstract_Widget extends WP_Widget {

	protected string $prefix = 'w-';
	protected string $widget_id;
	protected string $widget_classname;
	protected string $widget_name = 'Unknown Widget';
	protected string $widget_description = '';
	protected string $widget_mime_type = '';

	protected array $settings;

	/**
	 * Whether the widget hasn't been registered yet.
	 *
	 * @var bool
	 */
	protected bool $registered = false;

	// --------------------------------------------------

	/**
	 * Constructor.
	 */
	public function __construct() {
		$className              = ( new ReflectionClass( $this ) )->getShortName();
		$this->widget_classname = str_replace( [
			'_widget',
			'-widget'
		], '', Helper::dashCase( strtolower( $className ) ) );
		$this->widget_id        = $this->prefix . $this->widget_classname;

		parent::__construct( $this->widget_id, $this->widget_name, $this->widget_options(), $this->control_options() );

		add_action( 'save_post', [ &$this, 'flush_widget_cache' ] );
		add_action( 'deleted_post', [ &$this, 'flush_widget_cache' ] );
		add_action( 'switch_theme', [ &$this, 'flush_widget_cache' ] );
	}

	// --------------------------------------------------

	/**
	 * @return array
	 */
	protected function widget_options() {
		return [
			'classname'                   => $this->widget_classname,
			'description'                 => $this->widget_description,
			'customize_selective_refresh' => true,
			'show_instance_in_rest'       => true,
			'mime_type'                   => $this->widget_mime_type,
		];
	}

	// --------------------------------------------------

	/**
	 * @return array
	 */
	protected function control_options() {
		return [];
	}

	// --------------------------------------------------

	/**
	 * Flush the cache
	 *
	 * @return void
	 */
	public function flush_widget_cache() {
		foreach ( [ 'https', 'http' ] as $scheme ) {
			wp_cache_delete( $this->get_widget_id_for_cache( $this->widget_id, $scheme ), 'widget' );
		}
	}

	// --------------------------------------------------

	/**
	 * @param        $widget_id
	 * @param string $scheme
	 *
	 * @return mixed|void
	 */
	protected function get_widget_id_for_cache( $widget_id, $scheme = '' ) {
		if ( $scheme ) {
			$widget_id_for_cache = $widget_id . '-' . $scheme;
		} else {
			$widget_id_for_cache = $widget_id . '-' . ( is_ssl() ? 'https' : 'http' );
		}

		return apply_filters( 'hd_cached_widget_id', $widget_id_for_cache );
	}

	// --------------------------------------------------

	/**
	 * Cache the widget
	 *
	 * @param array $args Arguments
	 * @param string $content Content
	 *
	 * @return string the content that was cached
	 */
	public function cache_widget( $args, $content ) {

		// Don't set any cache if widget_id doesn't exist
		if ( empty( $args['widget_id'] ) ) {
			return $content;
		}

		$cache = wp_cache_get( $this->get_widget_id_for_cache( $this->widget_id ), 'widget' );
		if ( ! is_array( $cache ) ) {
			$cache = [];
		}

		$cache[ $this->get_widget_id_for_cache( $args['widget_id'] ) ] = $content;
		wp_cache_set( $this->get_widget_id_for_cache( $this->widget_id ), $cache, 'widget' );

		return $content;
	}

	// --------------------------------------------------

	/**
	 * Get cached widget
	 *
	 * @param array $args Arguments
	 *
	 * @return bool true if the widget is cached otherwise false
	 */
	public function get_cached_widget( $args ) {
		// Don't get cache if widget_id doesn't exists
		if ( empty( $args['widget_id'] ) ) {
			return false;
		}

		$cache = wp_cache_get( $this->get_widget_id_for_cache( $this->widget_id ), 'widget' );
		if ( ! is_array( $cache ) ) {
			$cache = [];
		}

		if ( isset( $cache[ $this->get_widget_id_for_cache( $args['widget_id'] ) ] ) ) {
			echo $cache[ $this->get_widget_id_for_cache( $args['widget_id'] ) ]; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

			return true;
		}

		return false;
	}

	// --------------------------------------------------

	/**
	 * @param array $instance Array of instance options.
	 *
	 * @return string
	 */
	protected function get_instance_title( $instance ) {
		if ( isset( $instance['title'] ) ) {
			return $instance['title'];
		}

		if ( isset( $this->settings['title']['std'] ) ) {
			return $this->settings['title']['std'];
		}

		return '';
	}

	// --------------------------------------------------

	/**
	 * @param $new_instance
	 * @param $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		if ( empty( $this->settings ) ) {
			return $instance;
		}

		// Loop settings and get values to save
		foreach ( $this->settings as $key => $setting ) {

			$setting_type = $setting['type'] ?? '';
			if ( ! $setting_type ) {
				continue;
			}

			// Format the value based on a settings type.
			switch ( $setting_type ) {
				case 'number':
					$instance[ $key ] = absint( $new_instance[ $key ] );

					if ( isset( $setting['min'] ) && '' !== $setting['min'] ) {
						$instance[ $key ] = max( $instance[ $key ], $setting['min'] );
					}

					if ( isset( $setting['max'] ) && '' !== $setting['max'] ) {
						$instance[ $key ] = min( $instance[ $key ], $setting['max'] );
					}
					break;
				case 'textarea':
					$instance[ $key ] = wp_kses( trim( wp_unslash( $new_instance[ $key ] ) ), wp_kses_allowed_html( 'post' ) );
					break;
				case 'checkbox':
					$instance[ $key ] = empty( $new_instance[ $key ] ) ? 0 : 1;
					break;
				default:
					$instance[ $key ] = isset( $new_instance[ $key ] ) ? sanitize_text_field( $new_instance[ $key ] ) : $setting['std'];
					break;
			}

			// Sanitize the value of a setting.
			$instance[ $key ] = apply_filters( 'hd_widget_settings_sanitize_option', $instance[ $key ], $new_instance, $key, $setting );
		}

		$this->flush_widget_cache();

		return $instance;
	}

	// --------------------------------------------------

	/**
	 * @param $instance
	 *
	 * @return void
	 */
	public function form( $instance ) {
		if ( empty( $this->settings ) ) {
			return;
		}

		foreach ( $this->settings as $key => $setting ) {

			$class = $setting['class'] ?? '';
			$value = $instance[ $key ] ?? $setting['std'];

			switch ( $setting['type'] ) {
				case 'text':
					?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo wp_kses_post( $setting['label'] ); ?></label><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
						?>
                        <input class="widefat <?php echo esc_attr( $class ); ?>"
                               id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                               name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="text"
                               value="<?php echo esc_attr( $value ); ?>" />
						<?php if ( isset( $setting['desc'] ) ) : ?>
                            <small class="help-text"><?php echo $setting['desc']; ?></small>
						<?php endif; ?>
                    </p>
					<?php
					break;

				case 'number':
					?>
                    <p class="<?php echo esc_attr( $class ); ?>">
                        <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                        <input class="widefat"
                               id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                               name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="number"
                               min="<?php echo esc_attr( $setting['min'] ); ?>"
                               max="<?php echo esc_attr( $setting['max'] ); ?>"
                               value="<?php echo esc_attr( $value ); ?>" />
						<?php if ( isset( $setting['desc'] ) ) : ?>
                            <small class="help-text"><?php echo $setting['desc']; ?></small>
						<?php endif; ?>
                    </p>
					<?php
					break;

				case 'select':
					?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                        <select class="widefat <?php echo esc_attr( $class ); ?>"
                                id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                                name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>">
							<?php foreach ( $setting['options'] as $option_key => $option_value ) : ?>
                                <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $value ); ?>><?php echo esc_html( $option_value ); ?></option>
							<?php endforeach; ?>
                        </select>
						<?php if ( isset( $setting['desc'] ) ) : ?>
                            <small class="help-text"><?php echo $setting['desc']; ?></small>
						<?php endif; ?>
                    </p>
					<?php
					break;

				case 'textarea':
					$rows = ! empty( $setting['rows'] ) ? (int) $setting['rows'] : 3;
					?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                        <textarea class="widefat <?php echo esc_attr( $class ); ?>"
                                  id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                                  name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" cols="20"
                                  rows="<?= $rows ?>"><?php echo esc_textarea( $value ); ?></textarea>
						<?php if ( isset( $setting['desc'] ) ) : ?>
                            <small class="help-text"><?php echo $setting['desc']; ?></small>
						<?php endif; ?>
                    </p>
					<?php
					break;

				case 'checkbox':
					?>
                    <p>
                        <label>
                            <input class="hd-checkbox checkbox <?php echo esc_attr( $class ); ?>"
                                   id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                                   name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="checkbox"
                                   value="1" <?php checked( $value, 1 ); ?> />
                            <span class="message"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></span>
                        </label>
                    </p>
					<?php
					break;

				// Default: run an action.
				default:
					do_action( 'widget_field_' . $setting['type'], $key, $value, $setting, $instance );
					break;
			}
		}
	}

	// --------------------------------------------------

	/**
	 * @param int $number
	 */
	public function _register_one( $number = - 1 ) {
		parent::_register_one( $number );

		if ( $this->registered ) {
			return;
		}

		$this->registered = true;

		if ( is_active_widget( false, false, $this->id_base, true ) ) {
			add_action( 'wp_enqueue_scripts', [ &$this, 'styles_and_scripts' ], 99 );
		}
	}

	// --------------------------------------------------

	/**
	 * styles_and_scripts
	 */
	public function styles_and_scripts() {}

	// --------------------------------------------------

	/**
	 * @param $instance
	 * @param $ACF
	 *
	 * @return array
	 * @throws \JsonException
	 */
	protected function swiper_acf_options( $instance, $ACF ) {
		$m_rows           = $ACF->m_rows ?? 1;
		$m_spacebetween   = $ACF->m_spacebetween ?? 0;
		$m_slidesperview  = $ACF->m_slidesperview ?? 0;
		$m_slidespergroup = $ACF->m_slidespergroup ?? 1;

		$t_rows           = $ACF->t_rows ?? 1;
		$t_spacebetween   = $ACF->t_spacebetween ?? 0;
		$t_slidesperview  = $ACF->t_slidesperview ?? 0;
		$t_slidespergroup = $ACF->t_slidespergroup ?? 1;

		$d_rows           = $ACF->d_rows ?? 1;
		$d_spacebetween   = $ACF->d_spacebetween ?? 0;
		$d_slidesperview  = $ACF->d_slidesperview ?? 0;
		$d_slidespergroup = $ACF->d_slidespergroup ?? 1;

		$gap                         = $ACF->gap ?? false;
		$show_responsive_breakpoints = $ACF->show_responsive_breakpoints ?? false;

		$swiper_class = '';
		$_data        = [];

		//---------------------------------------

		$navigation   = $ACF->navigation ?? false;
		$pagination   = $ACF->pagination ?? 'none';
		$autoplay     = $ACF->autoplay ?? false;
		$loop         = $ACF->loop ?? false;
		$marquee      = $ACF->marquee ?? false;
		$scrollbar    = $ACF->scrollbar ?? false;
		$direction    = $ACF->direction ?? 'default';
		$effect_slide = $ACF->effect_slide ?? 'default';
		$delay        = $ACF->delay ?? 1;
		$speed        = $ACF->speed ?? 1;

		//---------------------------------------

		if ( $navigation ) {
			$_data['navigation'] = Helper::toBool( $navigation );
		}

		if ( 'none' !== $pagination && $pagination ) {
			$_data['pagination'] = Helper::toString( $pagination );
			$swiper_class        .= ' pagination-' . $pagination;
		}

		if ( $autoplay ) {
			$_data['autoplay'] = Helper::toBool( $autoplay );
		}

		if ( $loop ) {
			$_data['loop'] = Helper::toBool( $loop );
		}

		if ( $marquee ) {
			$_data['marquee'] = Helper::toBool( $marquee );
			$swiper_class     .= ' marquee';
		}

		if ( $scrollbar ) {
			$_data['scrollbar'] = Helper::toBool( $scrollbar );
			$swiper_class       .= ' scrollbar';
		}

		if ( 'default' !== $direction && $direction ) {
			$_data['direction'] = Helper::toString( $direction );
			$swiper_class       .= ' direction-' . $direction;
		}

		if ( 'default' !== $effect_slide && $effect_slide ) {
			$_data['effect_slide'] = Helper::toString( $effect_slide );
			$swiper_class          .= ' effect-' . $effect_slide;
		}

		if ( $delay > 0 ) {
			$_data['delay'] = absint( $delay );
		}

		if ( $speed > 0 ) {
			$_data['speed'] = absint( $speed );
		}

		if ( $gap ) {
			$_data['gap'] = true;
		}

		//---------------------------------------

		if ( ! $show_responsive_breakpoints ) {
			$_data['autoview'] = true;
			$swiper_class      .= ' auto-view';
		} else {

			// mobile
			if ( $m_slidesperview > 0 ) {
				$_data['mobile'] = [
					'spaceBetween'   => absint( $m_spacebetween ),
					'slidesPerView'  => absint( $m_slidesperview ),
					'slidesPerGroup' => absint( $m_slidespergroup ),
				];

				$m_rows = absint( $m_rows );
				if ( $m_rows > 1 ) {
					$_data['mobile']['grid'] = [
						'rows' => $m_rows,
						'fill' => 'row',
					];

					unset( $_data['loop'] );
				}
			}

			// tablet
			if ( $t_slidesperview > 0 ) {
				$_data['tablet'] = [
					'spaceBetween'   => absint( $t_spacebetween ),
					'slidesPerView'  => absint( $t_slidesperview ),
					'slidesPerGroup' => absint( $t_slidespergroup ),
				];

				$t_rows = absint( $t_rows );
				if ( $t_rows > 1 ) {
					$_data['tablet']['grid'] = [
						'rows' => $t_rows,
						'fill' => 'row',
					];

					unset( $_data['loop'] );
				}
			}

			// desktop
			if ( $d_slidesperview > 0 ) {
				$_data['desktop'] = [
					'spaceBetween'   => absint( $d_spacebetween ),
					'slidesPerView'  => absint( $d_slidesperview ),
					'slidesPerGroup' => absint( $d_slidespergroup ),
				];

				$d_rows = absint( $d_rows );
				if ( $d_rows > 1 ) {
					$_data['desktop']['grid'] = [
						'rows' => $d_rows,
						'fill' => 'row',
					];

					unset( $_data['loop'] );
				}
			}
		}

		return [
			'class' => $swiper_class,
			'data'  => json_encode( $_data, JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE ),
		];
	}

	// --------------------------------------------------

	/**
	 * @param $id
	 *
	 * @return object|mixed|null
	 * @throws \JsonException
	 */
	protected function acfFields( $id ) {
		return Helper::acfFields( $id );
	}
}
