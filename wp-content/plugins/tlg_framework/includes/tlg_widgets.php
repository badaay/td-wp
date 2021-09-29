<?php
/**
 * Theme widgets
 *
 * @package TLG Framework
 *
 */

/**
    FLICKR WIDGET
**/
if( ! class_exists('tlg_framework_Flickr_Widget') ) {
	class tlg_framework_Flickr_Widget extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct(){
			parent::__construct(
				'tlg-flickr-widget', // Base ID
				wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Flickr Widget', 'tlg_framework'), // Name
				array( 'description' => esc_html__( 'Add a simple Flickr feed widget', 'tlg_framework' ), ) // Args
			);
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			if ( isset( $instance['flickr_id'] ) ) {
				echo '<ul class="flickr-feed" data-user-id="'. esc_attr($instance['flickr_id']) .'" data-number="'. esc_attr($instance['number']) .'"></ul>';
			}
			echo $args['after_widget'];
		}

		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) {
			return $new_instance;
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			$defaults = array(
				'title' => esc_html__( 'Flickr Feed', 'tlg_framework' ), 
				'flickr_id' => '',
				'number' => ''
			);
			$instance = wp_parse_args((array) $instance, $defaults);
			extract($instance);
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'tlg_framework' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of images:', 'tlg_framework' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'flickr_id' ) ); ?>"><?php esc_html_e( 'Flickr ID:', 'tlg_framework' ); ?><code><?php esc_html_e( 'eg: 138253421@N04', 'tlg_framework' ); ?></code></label>
				<p class="description"><?php echo wp_kses( __( 'You can get the Flickr ID at: <a href="http://www.idgettr.com" target="_blank">idGettr</a>', 'tlg_framework' ), tlg_framework_allowed_tags() ) ?></p>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'flickr_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr_id' ) ); ?>" type="text" value="<?php echo esc_attr( $flickr_id ); ?>">
			</p>
		<?php 
		}
	}
	function tlg_framework_register_flickr() {
	     register_widget( 'tlg_framework_Flickr_Widget' );
	}
	add_action( 'widgets_init', 'tlg_framework_register_flickr');
}

/**
    INSTAGRAM WIDGET
**/
if( ! class_exists('tlg_framework_Instagram_Widget') ) {
	class tlg_framework_Instagram_Widget extends WP_Widget {
	
		/**
		 * Sets up the widgets name etc
		 */
		public function __construct(){
			parent::__construct(
				'tlg-instagram-widget', // Base ID
				wp_get_theme()->get( 'Name' ) . ' ' . esc_html__('Instagram Widget', 'tlg_framework'), // Name
				array( 'description' => esc_html__( 'Add a simple Instagram feed widget', 'tlg_framework' ), ) // Args
			);
		}
	
		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			$access_token = get_option( 'tlg_framework_instagram_token', '' );
			if (!empty($access_token)) {
				$media_array = tlg_framework_get_instagram($access_token, $transient = 'widget');
				if ( is_wp_error( $media_array ) ) {
					echo wp_kses_post( $media_array->get_error_message() );
				} else {
					$media_array = array_slice( $media_array, 0, $instance['number'] );
					?><div class="instagram-feed"><ul><?php
					foreach ( $media_array as $item ) {
						echo '<li class="p0 m0">
								<div class="image-box hover-meta text-center mb0">
									<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $instance['target'] ) .'">
										<img src="'. esc_url( $item['thumbnail'] ) .'"  alt="'. esc_html__( 'instagram-image', 'tlg_framework' ) .'" />
										<div class="meta-caption fadebg">
											<h5 class="color-white to-top mb8 text-center-force s-text"><span class="block mb8"><i class="ti-instagram"></i></span></h5>
										</div></a></div></li>';
					}
					?></ul><div class="clearfix"></div></div><?php
				}
			} else {
				echo '<p class="fade-color"><i>'.esc_html__( 'Instagram Access Token is missing, please add the access token in your Dashboard > Appearances > Customize > System > Instagram Access Token.', 'tlg_framework' ).'</i></p>';
			}
			echo $args['after_widget'];
		}
	
		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			$defaults = array(
				'title' => esc_html__( 'Instagram Feed', 'tlg_framework' ), 
				'target' => '_blank',
				'number' => '6'
			);
			$instance = wp_parse_args((array) $instance, $defaults);
			extract($instance);
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'tlg_framework' ); ?></label> 
				<p class="description"><?php echo esc_html__( '* In order to use Instagram widget, please make sure you\'ve added an Access Token in your Dashboard > Appearances > Customize > System > Instagram Access Token.', 'tlg_framework' ) ?></p>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo  esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of photos:', 'tlg_framework' ); ?></label>
				<input type="number" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" min="1" name="<?php echo  esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">
			</p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Open images in', 'tlg_framework' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">
					<option value="_blank" <?php selected( '_blank', $target ) ?>><?php esc_html_e( 'New window', 'tlg_framework' ); ?></option>
					<option value="_self" <?php selected( '_self', $target ) ?>><?php esc_html_e( 'Current window', 'tlg_framework' ); ?></option>
				</select>
			</p>
		<?php 
		}
	
		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) {
			return $new_instance;
		}
	}
	function tlg_framework_register_instagram() {
	     register_widget( 'tlg_framework_Instagram_Widget' );
	}
	add_action( 'widgets_init', 'tlg_framework_register_instagram');
}

/**
    TWITTER WIDGET
**/
if( ! class_exists('tlg_framework_Twitter_Widget') ) {
	class tlg_framework_Twitter_Widget extends WP_Widget {
	
		/**
		 * Sets up the widgets name etc
		 */
		public function __construct(){
			parent::__construct(
				'tlg-twitter-widget', // Base ID
				wp_get_theme()->get( 'Name' ) . ' ' . esc_html__('Twitter Widget', 'tlg_framework'), // Name
				array( 'description' => esc_html__( 'Add a simple Twitter feed widget', 'tlg_framework' ), ) // Args
			);
		}
	
		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			$this->tlg_framework_get_tweets_token( $instance['consumer_key'], $instance['consumer_secret'] );
		    echo $args['before_widget'];
		    if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
		    echo '<div class="twitter-feed">'.$this->tlg_framework_tweets($instance).'</div>';
		    echo $args['after_widget'];
		}
	
		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			$defaults = array(
				'title'             => esc_html__( 'Twitter Feed', 'tlg_framework' ), 
				'query'             => 'from:themelogi',
				'number'            =>  1,
				'show_time'       	=> false,
				'show_quote'       	=> false,
				'show_follow'       => false,
				'show_avatar'       => false,
				'show_account'      => true,
				'exclude_replies'   => false,
				'consumer_key'      => '',
				'consumer_secret'   => ''
			);
			$instance = wp_parse_args((array) $instance, $defaults);
			extract($instance);
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>"><?php esc_html_e( 'Title', 'tlg_framework' ); ?></label><br />
				<input type="text" name="<?php echo esc_attr( $this->get_field_name('title') ) ?>" id="<?php echo esc_attr( $this->get_field_id('title') ) ?>" class="widefat" value="<?php echo esc_attr( $instance['title'] ) ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('consumer_key') ); ?>"><?php esc_html_e( 'Consumer Key', 'tlg_framework' ); ?></label>
				<p class="description"><?php echo wp_kses( __( 'To get Consumer Key & Consumer Secret, you have to <a href="https://apps.twitter.com/app/new" target="_blank">create an app</a> in Twitter', 'tlg_framework' ), tlg_framework_allowed_tags() ) ?></p>
			  	<input type="text" name="<?php echo esc_attr( $this->get_field_name('consumer_key') ) ?>" id="<?php echo esc_attr( $this->get_field_id('consumer_key') ) ?>" class="widefat" value="<?php echo esc_attr( $instance['consumer_key'] ) ?>">
			</p>
			<p>
			  	<label for="<?php echo esc_attr( $this->get_field_id('consumer_secret') ) ?>"><?php esc_html_e( 'Consumer Secret', 'tlg_framework' ); ?></label>
			  	<input type="text" name="<?php echo esc_attr( $this->get_field_name('consumer_secret') ) ?>"  class="widefat" id="<?php echo esc_attr($this->get_field_id('consumer_secret')) ?>" value="<?php echo esc_attr($instance['consumer_secret']) ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('query') ) ?>"><?php echo wp_kses( __( 'Search Query (<a href="https://dev.twitter.com/docs/using-search" target="_blank" title="Read more about Twitter Search query">?</a>)', 'tlg_framework' ), tlg_framework_allowed_tags() ) ?></label><br />
			  	<input type="text" name="<?php echo esc_attr( $this->get_field_name('query') ); ?>" id="<?php echo esc_attr( $this->get_field_id('query') ); ?>" class="widefat" value="<?php echo esc_attr( $instance['query'] ) ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('number') ) ?>"><?php esc_html_e( 'Number of Tweets', 'tlg_framework' ) ?></label>&nbsp;
				<input type="text" name="<?php echo esc_attr( $this->get_field_name('number') ) ?>" id="<?php echo esc_attr( $this->get_field_id('number') ) ?>" size="3" value="<?php echo esc_attr( $instance['number'] ) ?>" >
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('show_follow') ) ?>">
			  		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('show_follow') ); ?>" id="<?php echo esc_attr( $this->get_field_id('show_follow') ); ?>" <?php checked( 'true', $instance['show_follow'] ) ?> value="true" >
			  		<?php esc_html_e( 'Show Follow Button?', 'tlg_framework' ) ?>
			  	</label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('show_account') ) ?>">
			  	<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('show_account') ); ?>" id="<?php echo esc_attr( $this->get_field_id('show_account') ); ?>" <?php checked( 'true', $instance['show_account'] ) ?> value="true"  >
			  		<?php esc_html_e( 'Show Account Info?', 'tlg_framework' ) ?>
			  	</label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('show_avatar') ) ?>">
			  	<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('show_avatar') ); ?>" id="<?php echo esc_attr( $this->get_field_id('show_avatar') ); ?>" <?php checked( 'true', $instance['show_avatar'] ) ?> value="true" >
			  		<?php esc_html_e( 'Show User Avatar?', 'tlg_framework' ) ?>
			  	</label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('show_time') ) ?>">
			  	<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('show_time') ); ?>" id="<?php echo esc_attr( $this->get_field_id('show_time') ); ?>" <?php checked( 'true', $instance['show_time'] ) ?> value="true" >
			  		<?php esc_html_e( 'Show Post Time?', 'tlg_framework' ) ?>
			  	</label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('show_quote') ) ?>">
			  	<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('show_quote') ); ?>" id="<?php echo esc_attr( $this->get_field_id('show_quote') ); ?>" <?php checked( 'true', $instance['show_quote'] ) ?> value="true" >
			  		<?php esc_html_e( 'Enable Quote Style?', 'tlg_framework' ) ?>
			  	</label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('exclude_replies') ) ?>">
			  	<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('exclude_replies') ); ?>" id="<?php echo esc_attr( $this->get_field_id('exclude_replies') ); ?>" <?php checked( 'true', $instance['exclude_replies'] ) ?> value="true" >
			  		<?php esc_html_e( 'Exclude replies for UserTimeline', 'tlg_framework' ) ?>
			  	</label>
			</p>
		<?php 
		}
	
		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) {
			if( !isset($new_instance['show_quote']) ) {
		      $new_instance['show_quote'] = false;
		    }
			if( !isset($new_instance['show_time']) ) {
		      $new_instance['show_time'] = false;
		    }
			if( !isset($new_instance['show_follow']) ) {
		      $new_instance['show_follow'] = false;
		    }
		    if( !isset($new_instance['show_avatar']) ) {
		      $new_instance['show_avatar'] = false;
		    }
		    if( !isset($new_instance['show_account']) ) {
		      $new_instance['show_account'] = false;
		    }
		    if( !isset($new_instance['exclude_replies']) ) {
		      $new_instance['exclude_replies'] = false;
		    }
		    return $new_instance;
		}

		/**
		 * Update Tweet URL
		 **/
		function tlg_framework_update_tweets( $content ) {
			$maxLen = 16;
			$pattern = '/[^\s\t]{'.$maxLen.'}[^\s\.\,\+\-\_]+/';
			$content = preg_replace( $pattern, '$0 ', $content );
			$pattern = '/\w{2,5}\:\/\/[^\s\"]+/';
			$content = preg_replace( $pattern, '<a href="$0" title="" target="_blank">$0</a>', $content );
			$pattern = '/\#([a-zA-Z0-9_-]+)/';
			$content = preg_replace( $pattern, '<a href="https://twitter.com/search?q=%23$1&src=hash" title="" target="_blank">$0</a>', $content );
			$pattern = '/\@([a-zA-Z0-9_-]+)/';
			$content = preg_replace( $pattern, '<a href="https://twitter.com/#!/$1" title="" target="_blank">$0</a>', $content );
			return $content;
		}

		/**
		* Get Tweet Token
		**/
		function tlg_framework_get_tweets_token( $consumer_key, $consumer_secret ){
			$consumer_key = rawurlencode( $consumer_key );
			$consumer_secret = rawurlencode( $consumer_secret );
			if( !$consumer_secret || !$consumer_key ) return false;
			$token = maybe_unserialize( get_option( 'tlg_twitter_widget' ) );
			if( ! is_array($token) || empty($token) || $token['consumer_key'] != $consumer_key || empty($token['access_token']) ) {
				$authorization = base64_encode( $consumer_key . ':' . $consumer_secret );
				$args = array(
					'httpversion' => '1.1',
					'headers' => array( 
				  		'Authorization' => 'Basic ' . $authorization,
				  		'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
					),
					'body' => array( 'grant_type' => 'client_credentials' )
				);
				add_filter('https_ssl_verify', '__return_false');
				$remote_get_tweets = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );
				$result = json_decode( wp_remote_retrieve_body(  $remote_get_tweets ) );
				if( !isset($result->access_token) ) return false;
				$token = serialize( array(
					'consumer_key'      => $consumer_key,
					'access_token'      => $result->access_token
				) );
				update_option( 'tlg_twitter_widget', $token );
				return $token;
			}
		}

		/**
		* Get Tweet
		**/
		function tlg_framework_tweets( $instance ) {
			extract( $instance );
			$output = '';
			$token = maybe_unserialize( get_option( 'tlg_twitter_widget' ) );
			if( empty($token) || !isset($token['access_token']) ) {
		  		$token = $this->tlg_framework_get_tweets_token( $consumer_key, $consumer_secret );
		  		if( !$token ) return false;
			}
			if( strpos($query, 'from:') === 0  ) {
		  		$query_type = 'user_timeline';
		  		$query = substr($query, 5);
		  		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.rawurlencode($query).'&count='.$number;
		  		if( $exclude_replies ) $url .= '&exclude_replies=true';
			} else {
		  		$query_type = 'search';
		  		$url =  'https://api.twitter.com/1.1/search/tweets.json?q='.rawurlencode($query).'&count='.$number;
		  		if( $exclude_replies ) $url .= '&exclude_replies=true';
			}
			$remote_get_tweets = wp_remote_get( $url, array(
		    	'headers' => array( 'Authorization' => 'Bearer '. (is_array($token) && isset($token['access_token']) ? $token['access_token'] : '')),              
		    	'sslverify'=>false
			) );
			$result = json_decode( wp_remote_retrieve_body( $remote_get_tweets ) );
			if( empty($result) || (isset( $result->errors ) && ( $result->errors[0]->code == 89 || $result->errors[0]->code == 215 ) ) ) {
		    	delete_option( 'tlg_twitter_widget' );
		    	$this->tlg_framework_get_tweets_token($consumer_key,$consumer_secret);
		    	return $this->tlg_framework_tweets($instance);
			} 
			$tweets = array();
			if( 'user_timeline' == $query_type ) {
		  		if( !empty($result) ) {
		    		$tweets = $result;
		  		}
			} else {
		  		if( !empty($result->statuses) ) {
		    		$tweets = $result->statuses;
		  		}
			}
			$follow_button = '<a href="https://twitter.com/__name__" class="twitter-follow-button" data-show-count="false" data-lang="en">'.__( 'Follow', 'tlg_framework' ).' @__name__</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			if( !empty($tweets) ) {
				$output = '<ul class="twitter-content '.(!empty($show_quote) ? 'twitter-quote' : '').'">';
		  		foreach ($tweets as $tweet ) {
			    	$text = $this->tlg_framework_update_tweets( $tweet->text );
				    $time = human_time_diff( strtotime($tweet->created_at), time() );
				    $url = '//twitter.com/'.$tweet->user->id.'/status/'.$tweet->id_str;
				    $screen_name = $tweet->user->screen_name;
				    $name = $tweet->user->name;
				    $profile_image_url = $tweet->user->profile_image_url;
				    $output .= '<li class="mb24 '.$query_type.'">';
				    if( 'search' == $query_type ) {
				      	$output .= '<div class="twitter-user">';
				      	if( $show_account ) {
				        	$output .= '<a href="https://twitter.com/'.$screen_name.'">';
				        	if( $show_avatar && $profile_image_url ) {
				        		$profile_image_url = str_replace("http:", "", $profile_image_url);
				          		$output .= '<img src="'.esc_url( $profile_image_url ).'" width="16px" height="16px" >';
				        	}
				        	$output .= '&nbsp;<strong class="name">'.$name.'</strong>&nbsp;<span class="screen_name">@'.$screen_name.'</span></a>';
				      	}
				      	$output .= '</div>';
				    }
				    $output .= '<div class="tweet">'.$text;
				    if( $show_time ) {
				    	$output .= '<span class="timePosted"><a target="_blank" title="" href="'.esc_url( $url ).'"> '.esc_html__( 'about', 'tlg_framework' ).' '.$time.' '.esc_html__( 'ago', 'tlg_framework' ).'</a></span>';
					}
				    $output .= '</div>';
				    if( 'search' == $query_type ) {
				      	if( $show_follow ) {
				        	$output .= str_replace('__name__', $screen_name, $follow_button);
				      	}
				    }
				    $output .= '</li>';
			  	}
			  	$output .= '</ul>';
		  		if( 'user_timeline' == $query_type ) {
		    		$output .= '<div class="twitter-user">';
		    		if( $show_account ) {
		      			$output .= '<a href="https://twitter.com/'.$screen_name.'">';
		      			if( $show_avatar && $profile_image_url ) {
		      				$profile_image_url = str_replace("http:", "", $profile_image_url);
		        			$output .= '<img src="'.$profile_image_url.'" width="16px" height="16px" >';
		      			}
		      			$output .= '&nbsp;'.$name.'&nbsp;<span class="screen_name">@'.$screen_name.'</span></a>';
		    		}
		    		if( $show_follow ) {
		      			$output .= str_replace('__name__', $screen_name, $follow_button);
		    		}
		    		$output .= '</div>';
		  		} 
			}
			return $output;
		}
	}

	function tlg_framework_register_twitter() {
	     register_widget( 'tlg_framework_Twitter_Widget' );
	}
	add_action( 'widgets_init', 'tlg_framework_register_twitter');
}

/**
    POSTS WIDGET
**/
if( ! class_exists('tlg_framework_Posts_Widget') ) {
	class tlg_framework_Posts_Widget extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct(){
			parent::__construct(
				'tlg-posts-widget', // Base ID
				wp_get_theme()->get( 'Name' ) . ' ' . esc_html__('Posts Widget', 'tlg_framework'), // Name
				array( 'description' => esc_html__( 'Add a Posts feed widget', 'tlg_framework' ), ) // Args
			);
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			extract($args);
		    $title          = !empty( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
		    $title          = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		    $limit          = !empty( $instance['number'] ) ? absint( $instance['number'] ) : 10;
		    $show_date      = !empty( $instance['show_date'] ) ? $instance['show_date'] : 0;
		    $show_comment   = !empty( $instance['show_comment'] ) ? $instance['show_comment'] : 0;
		    $show_thumb     = !empty( $instance['show_thumb'] ) ? $instance['show_thumb'] : 0;
		    $cat_id         = !empty( $instance['cat_id'] ) ? absint( $instance['cat_id'] ) : 0;
		    $orderby        = !empty( $instance['orderby'] ) ? $instance['orderby'] : 'date';
		    $tags           = !empty( $instance['tags'] ) ? $instance['tags'] : '';
		    $posts 			= new WP_Query( apply_filters( 'widget_posts_args', array( 'orderby' => $orderby, 'order'   => 'DESC', 'no_found_rows' => true, 'post_status' => 'publish', 'cat' => $cat_id, 'tag' => $tags, 'ignore_sticky_posts' => true, 'posts_per_page' => $limit ) ) );
		    if ( $posts->have_posts() ) {
				echo $before_widget;
				if ( $title ) echo $before_title.$title.$after_title; ?>
			    <ul class="tlg-posts-widget">
					<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
			        <li class="tlg-posts-item">
			        	<?php if ( $show_thumb && has_post_thumbnail() ) :  ?>
			            <div class="tlg-posts-thumbnail">
			             	 <a href="<?php esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
			              	</a>
			            </div>
			        	<?php endif; ?>
			            <div class="tlg-posts-content">
			            	<div class="tlg-posts-meta">
								<?php if ( $show_date ) : ?>
				                	<span class="tlg-posts-date"><?php echo get_the_date(); ?></span>
				                <?php endif; ?>
								<?php if ( $show_comment && !post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
									<span class="tlg-posts-comment"><?php comments_popup_link( '<i class="ti-comment"></i>'.esc_html__( '0', 'tlg_framework' ), '<i class="ti-comment"></i>'.esc_html__( '1', 'tlg_framework' ), '<i class="ti-comment"></i>'.esc_html__( '%', 'tlg_framework' ) ); ?></span>
								<?php endif; ?>
			              	</div>
			              	<a href="<?php esc_url( the_permalink() ) ?>" class="tlg-posts-title" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
			            </div>
			        </li>
				<?php endwhile; ?>
			    </ul>
				<?php echo $after_widget; ?>
				<?php wp_reset_query();
			}
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
	  	function form( $instance ) {
		    $title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		    $number         = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		    $show_date      = isset( $instance['show_date'] ) ? esc_attr( $instance['show_date'] ) : 1;
		    $show_comment   = isset( $instance['show_comment'] ) ? esc_attr( $instance['show_comment'] ) : 1;
		    $show_thumb     = isset( $instance['show_thumb'] ) ? esc_attr( $instance['show_thumb'] ) : 1;
		    $cat_id         = isset( $instance['cat_id'] ) ? esc_attr( $instance['cat_id'] ) : 0;
		    $orderby        = isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : 'date';
		    $tags           = isset( $instance['tags'] ) ? esc_attr( $instance['tags'] ) : '';
		    ?>
		    <p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'tlg_framework' ); ?></label>
		    <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		    <p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of posts to show:', 'tlg_framework' ); ?></label>
		    <input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>
		    <p>
		      <label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php esc_html_e( 'Show post date ?', 'tlg_framework') ?></label><br>
		      <select name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" id="<?php echo esc_attr($this->get_field_id('show_date')); ?>">
		        <option value="1" <?php selected($show_date, 1, $echo = true) ?>><?php esc_html_e( 'Yes', 'tlg_framework' ) ?></option>
		        <option value="0" <?php selected($show_date, 0, $echo = true) ?>><?php esc_html_e( 'No', 'tlg_framework' ) ?></option>
		      </select>
		    </p>
		    <p>
		      <label for="<?php echo esc_attr($this->get_field_id( 'show_comment' )); ?>"><?php esc_html_e( 'Show comment ?', 'tlg_framework') ?></label><br>
		      <select name="<?php echo esc_attr($this->get_field_name('show_comment')); ?>" id="<?php echo esc_attr($this->get_field_id('show_comment')); ?>">
		        <option value="1" <?php selected($show_comment, 1, $echo = true) ?>><?php esc_html_e( 'Yes', 'tlg_framework' ) ?></option>
		        <option value="0" <?php selected($show_comment, 0, $echo = true) ?>><?php esc_html_e( 'No', 'tlg_framework' ) ?></option>
		      </select>
		    </p>
		    <p>
		      <label for="<?php echo esc_attr($this->get_field_id( 'show_thumb' )); ?>"><?php esc_html_e( 'Show post thumbnail ?', 'tlg_framework') ?></label><br>
		      <select name="<?php echo esc_attr($this->get_field_name('show_thumb')); ?>" id="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>">
		        <option value="1" <?php selected($show_thumb, 1, $echo = true) ?>><?php esc_html_e( 'Yes', 'tlg_framework' ) ?></option>
		        <option value="0" <?php selected($show_thumb, 0, $echo = true) ?>><?php esc_html_e( 'No', 'tlg_framework' ) ?></option>
		      </select>
		    </p>
		    <p><label for="<?php echo esc_attr($this->get_field_id( 'cat_id' )); ?>"><?php esc_html_e( 'Category:', 'tlg_framework' ); ?></label>
		    <?php wp_dropdown_categories('name='.$this->get_field_name( 'cat_id' ).'&class=widefat&show_option_all=All&selected='.$cat_id); ?></p>
		    <p>
		      <label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><?php esc_html_e( 'Order by', 'tlg_framework') ?></label><br>
		      <select name="<?php echo esc_attr($this->get_field_name('orderby')); ?>" id="<?php echo esc_attr($this->get_field_id('orderby')); ?>">
		        <option value="date" <?php selected($orderby, 'date', $echo = true) ?>><?php esc_html_e('Date', 'tlg_framework') ?></option>
		        <option value="ID" <?php selected($orderby, 'ID', $echo = true) ?>><?php esc_html_e('ID', 'tlg_framework') ?></option>
		        <option value="comment_count" <?php selected($orderby, 'comment_count', $echo = true) ?>><?php esc_html_e('Most Commented', 'tlg_framework') ?></option>
		      </select>
		    </p>
		    <p>
		    	<label for="<?php echo esc_attr($this->get_field_id( 'tags' )); ?>"><?php esc_html_e( 'Tags:', 'tlg_framework' ); ?></label>
		    	<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tags' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tags' )); ?>" placeholder="<?php esc_html_e( 'tag 1, tag 2, tag 3','tlg_framework' )?>" type="text" value="<?php echo esc_attr($tags); ?>" />
		    </p>
			<?php
	  	}

	  	/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title']          = strip_tags($new_instance['title']);
		    $instance['number']         = (int) $new_instance['number'];
		    $instance['show_date']      = $new_instance['show_date'];
		    $instance['show_comment']   = $new_instance['show_comment'];
		    $instance['show_thumb']     = $new_instance['show_thumb'];
		    $instance['cat_id']         = (int) $new_instance['cat_id'];
		    $instance['orderby']        = $new_instance['orderby'];
		    $instance['tags']           = strip_tags($new_instance['tags']);
			return $instance;
		}
	}
	function tlg_framework_register_posts() {
	     register_widget( 'tlg_framework_Posts_Widget' );
	}
	add_action( 'widgets_init', 'tlg_framework_register_posts');
}