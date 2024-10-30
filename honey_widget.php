<?php
/*
Plugin Name: Honey Coinhive Widget
Description: Easily Add a coinhive miner to your sidebar and widget areas.
Version: 1.1.2
Author: Honey Plugins
Author URI: http://honeyplugins.com
Text Domain: honey-coinhive-widget
Domain Path: /assets/languages/
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
?>
<?php
class Coinhive_Widget extends WP_Widget

	{
	public

	function __construct()
		{
		$widget_ops = array(
			'classname' => 'Coinhive_Widget',
			'description' => 'Displays a coinhive miner!'
		);
		$this->WP_Widget('Coinhive_Widget', 'Coinhive Widget', $widget_ops);
		}

	function widget($args, $instance)
		{

		// Extracting Arguments

		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$desc = $instance['desc'];
		$threads = empty($instance['chw_threads']) ? '' : $instance['chw_threads'];
		$speed = empty($instance['speed']) ? '' : $instance['speed'];
		$autoThreads = $instance['autoThreads'] ? 'true' : 'false';
		$displayMineSet = $instance['displayMineSet'] ? 'true' : 'false';
		$displayMineStat = $instance['displayMineStat'] ? 'true' : 'false';
		$displayGraphs = $instance['displayGraphs'] ? 'true' : 'false';
		$displayGraphSpeed = $instance['displayGraphSpeed'] ? 'true' : 'false';
		$displayGraphTop = $instance['displayGraphTop'] ? 'true' : 'false';
		$displayGraphWeek = $instance['displayGraphWeek'] ? 'true' : 'false';
		$displayPoolStat = $instance['displayPoolStat'] ? 'true' : 'false';
		$displayTopUsers = $instance['displayTopUsers'] ? 'true' : 'false';
		$displayBootstrapButton = $instance['displayBootstrapButton'] ? 'true' : 'false';
		$color_setting = get_option('coinhiveWidget_color_setting');
		
		// Before widget code

		echo (isset($before_widget) ? $before_widget : '');

		// Output Areas

		if (!empty($title)) echo $before_title . $title . $after_title;
		if (!empty($desc)) echo '<p>' . $desc . '</p>';
		if ($displayMineSet == 'true')
			{
			//echo '<div class="container-fluid">';
			echo '<div><div id="current_trans" style="display:none;">' . __('Current', 'honey-coinhive-widget') . ' Ⓗ' . __('/s', 'honey-coinhive-widget') . '</div><div id="week_trans" style="display:none;">' . __('Weekly History', 'honey-coinhive-widget') . '</div><div id="top_trans" style="display:none;">' . __('Top Users', 'honey-coinhive-widget') . '</div>';
			echo '
                <div class="box">
                    <span>' . __('Auto Threads', 'honey-coinhive-widget') . '</span>
                    <span">';
			if ($autoThreads == 'true')
				{
				echo '<input type="checkbox" class="threadsClick autoThreads" value="None" id="autoThreads" name="check" checked/>';
				}
			  else
				{
				echo '<input type="checkbox" class="threadsClick autoThreads" value="None" id="autoThreads" name="check" />';
				}

			echo '
                        <label for="autoThreads"></label>
                    </span>
                </div>';
			if ($displayBootstrapButton == 'true')
				{
				$bootstrapSets = 'minesetsAdjust';
				$bootstrap2Sets = 'chartsAdjust';
				}
		  	else
				{
				$bootstrapSets = '';
				$bootstrap2Sets = '';
				}
			if ($autoThreads == 'true')
				{
				echo '
                <div class="box threadsShowHide" style="display:none;">
                    <span>' . __('Threads', 'honey-coinhive-widget') . '</span>            
                        <span id="thread-add" class="action '.$bootstrapSets.' chw_right thread-add"> + </span>
                        <span id="chw_threads" class="chw_right chw-threads">' . $threads . '</span>
                        <span id="thread-remove" class="action '.$bootstrapSets.' chw_right thread-remove"> - </span>
                </div>';
				}
			  else
				{
				echo '
                <div class="box threadsShowHide addPadding">
                    <span>' . __('Threads', 'honey-coinhive-widget') . '</span>            
                        <span id="thread-add" class="action '.$bootstrapSets.' chw_right thread-add"> + </span>
                        <span id="chw_threads chw-threads" class="chw_right chw-threads"  >' . $threads . '</span>
                        <span id="thread-remove" class="action '.$bootstrapSets.' chw_right thread-remove"> - </span>
                </div>';
				}

			echo '
                <div class="box addPadding">
                    <span>' . __('Speed', 'honey-coinhive-widget') . '</span>
                        <span id="speed-add" class="action '.$bootstrapSets.' chw_right speed-add"> + </span>
                        <span id="chw_speed" class="chw_right chw-speed">' . $speed . '</span>
						<span id="speed-remove" class="action '.$bootstrapSets.' chw_right speed-remove"> - </span>
                </div>
             ';
			echo '</div>';
			}
		  else
			{
			echo '<div style="display:none;">';
			echo '
                <div class="box">
                    <p><span>' . __('Auto Threads', 'honey-coinhive-widget') . '</span>
                    <span class="alignright" style="padding: 2px;">
                        ';
			if ($autoThreads == 'true')
				{
				echo '<input type="checkbox" value="None" id="autoThreads" class="autoThreads" name="check" checked/>';
				}
			  else
				{
				echo '<input type="checkbox" value="None" id="autoThreads" class="autoThreads" name="check" />';
				}

			echo '
                        <label for="autoThreads"></label>
                    </span>
                    </p>
                </div>
                <div class="box">
                    <p><span>' . __('Threads', 'honey-coinhive-widget') . '</span>            
                        <span id="thread-add" class="action alignright thread-add"> + </span>
                        <span class="divide alignright"> / </span>
                        <span id="thread-remove" class="action alignright thread-remove"> - </span>
                        <span id="chw_threads" class="alignright chw_threads">' . $threads . '</span>
                        </p>
                </div>
                <div class="box">
                    <p><span>' . __('Speed', 'honey-coinhive-widget') . '</span>
                        <span id="speed-add" class="action alignright speed-add"> + </span>
                        <span class="divide alignright"> / </span>
                        <span id="speed-remove" class="action alignright speed-remove"> - </span>
                        <span id="chw_speed" class="alignright chw_speed">' . $speed . '</span>
                        </p>
                </div>
             ';
			echo '</div>';
			}

		if ($displayBootstrapButton == 'true')
			{
			echo '<p><button id="startCHWidget" class="btn btn-outline-warning colorize startCHWidget" style="width:100%;">' . __('Start', 'honey-coinhive-widget') . '</button></p>';
			}
		  else
			{
			echo '<p><button id="startCHWidget" class="startCHWidget">' . __('Start', 'honey-coinhive-widget') . '</button></p><div class="colorize" style="display:none;"></div>';
			}

		if ($displayMineStat == 'true')
			{
			echo '<div><strong>' . __('User Stats', 'honey-coinhive-widget') . '</strong>
                <div class="box">
                        <span>' . __('Current', 'honey-widget') . ' Ⓗ' . __('/s', 'honey-coinhive-widget') . '</span>
                         <span id="hashes-per-second" class="chw_right hashes-per-second">0</span>
                    </div>
                    <div>
                        <span>' . __('Total', 'honey-coinhive-widget') . ' Ⓗ</span>
                        <span id="accepted-shares" class="chw_right accepted-shares">0</span>
                </div></div>
                ';
			}

		if ($displayGraphs == 'true')
			{
			if ( ($displayGraphTop == 'true' && $displayGraphSpeed == 'true') || ($displayGraphTop == 'true' && $displayGraphWeek == 'true') || ($displayGraphSpeed == 'true' && $displayGraphWeek == 'true') )
				{
				echo '<div class="addPadding">
                  		<span class="action chartsLeft '.$bootstrap2Sets.' chw_left" id="chartsLeft"> <</span><span class="action chartsRight '.$bootstrap2Sets.' chw_right" id="chartsRight"> ></span>
                	</div>';
				}

			if ($displayGraphTop == 'true')
				{
				echo '<div class="donut-canvas-cont">
                        <canvas id="donut-canvas" class="stats donut-canvas" width="100%" height="100%"></canvas>
                    </div>';
				}

			if ($displayGraphSpeed == 'true')
				{
				echo '<div>
                        <canvas id="barchart-canvas" class="stats barchart-canvas" width="100%" height="100%"></canvas>
                    </div>';
				}

			if ($displayGraphWeek == 'true')
				{
				echo '<div>
                        <canvas id="weekly-canvas" class="stats weekly-canvas" width="100%" height="100%"></canvas>
                    </div>
                    ';
				}
			}

		if ($displayPoolStat == 'true')
			{
			echo '<div><strong>' . get_bloginfo('name') . ' ' . __('Stats', 'honey-coinhive-widget') . '</strong>
                    <div class="box">
                        <span>' . __('Current', 'honey-coinhive-widget') . ' Ⓗ' . __('/s', 'honey-coinhive-widget') . '</span>
                        <span id="pool-hashes-perSecond" class="chw_right pool-hashes-perSecond">...</span>
                    </div>
                    <div class="box">
                        <span>' . __('Total', 'honey-coinhive-widget') . ' Ⓗ</span>
                        <span id="pool-hashes" class="chw_right pool-hashes">...</span>
                    </div>
                </div>
                ';
			}

		if ($displayTopUsers == 'true')
			{
			echo '<div style="display:none;"><canvas id="donut-canvas" class="stats donut-canvas" width="100%" height="100%"></canvas>
                    </div>';
			echo '<div class="list">
                    <br /><strong>' . __('Top Users', 'honey-coinhive-widget') . '</strong>
                    <table>
                        <thead>
                            <tr>
                                <th class="num">#</th>
                                <th>' . __('User', 'honey-coinhive-widget') . '</th>
                                <th class="num">' . __('Accepted', 'honey-coinhive-widget') . ' Ⓗ</th>
                            </tr>
                        </thead>
                        <tbody id="toplist" class="toplist">
                        </tbody>
                    </table>
                </div>';
			}

		// After widget code
//		echo "</div>";
		echo (isset($after_widget) ? $after_widget : '');
		}

	public

	function form($instance)
		{

		// Extract Data

		$instance = wp_parse_args((array)$instance, array(
			'title' => ''
		));
		$title = $instance['title'];
		$desc = $instance['desc'];
		$threads = $instance['chw_threads'];
		$speed = $instance['speed'];
		$autoThreads = $instance['autoThreads'];
		$displayMineSet = $instance['displayMineSet'];
		$displayMineStat = $instance['displayMineStat'];
		$displayGraphs = $instance['displayGraphs'];
		$displayGraphSpeed = $instance['displayGraphSpeed'];
		$displayGraphTop = $instance['displayGraphTop'];
		$displayGraphWeek = $instance['displayGraphWeek'];
		$displayPoolStat = $instance['displayPoolStat'];
		$displayTopUsers = $instance['displayTopUsers'];
		$displayBootstrapButton = $instance['displayBootstrapButton'];
		$siteKey = get_option('coinhiveWidget_site_key');
		$secretKey = get_option('coinhiveWidget_secret_key');
		$color_setting = get_option('coinhiveWidget_color_setting');
		if ($siteKey != '' && $secretKey != '')
			{

			// Display fields

		?>
		<!-- Widget -->
		<p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title', 'honey-coinhive-widget'); ?>:</label>
		   <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
			  name="<?php echo $this->get_field_name('title'); ?>" type="text"
			  value="<?php echo attribute_escape($title); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('desc'); ?>"><?php echo __('Description', 'honey-coinhive-widget'); ?>:</label>
		   <input class="widefat" id="<?php echo $this->get_field_id('desc'); ?>"
			  name="<?php echo $this->get_field_name('desc'); ?>" type="text"
			  value="<?php echo attribute_escape($desc); ?>" />
		</p>
		<p><strong><?php echo __('Miner Settings', 'honey-coinhive-widget'); ?></strong></p>
		<p>
		   <input class="checkbox widefat chw_autoThreads" type="checkbox" <?php checked( $autoThreads, 'on' ); ?> id="<?php echo $this->get_field_id( 'autoThreads' ); ?>" name="<?php echo $this->get_field_name( 'autoThreads' ); ?>" />
		   <label for="<?php echo $this->get_field_id( 'autoThreads' ); ?>"><?php echo __('Auto Threads', 'honey-coinhive-widget'); ?></label>
		</p>
		<div class="displaythreadsdiv">
		   <p>
			  <label for="<?php echo $this->get_field_id('chw_threads'); ?>"><?php echo __('Threads', 'honey-coinhive-widget'); ?>:</label>
			  <input class="widefat chw_threads" type="number" id="<?php echo $this->get_field_id('chw_threads'); ?>" name="<?php echo $this->get_field_name('chw_threads'); ?>" value="<?php echo attribute_escape($threads); ?>" min="1" max="8" />
		   </p>
		</div>
		<p>
		   <label for="<?php echo $this->get_field_id('speed'); ?>"><?php echo __('CPU Usage', 'honey-coinhive-widget'); ?>:</label>
		   <input class="widefat chw_speed" type="number" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>" value="<?php echo attribute_escape($speed); ?>" min="1" max="100" />
		</p>
		<p><strong><?php echo __('Display Settings', 'honey-coinhive-widget'); ?></strong></p>
		<p>
		   <input class="checkbox widefat" type="checkbox" <?php checked( $displayMineSet, 'on' ); ?> id="<?php echo $this->get_field_id( 'displayMineSet' ); ?>" name="<?php echo $this->get_field_name( 'displayMineSet' ); ?>" />
		   <label for="<?php echo $this->get_field_id( 'displayMineSet' ); ?>"><?php echo __('Show Miner Settings', 'honey-coinhive-widget'); ?></label>
		</p>
		<p>
		   <input class="checkbox widefat chw_displayMineStat" type="checkbox" <?php checked( $displayMineStat, 'on' ); ?> id="<?php echo $this->get_field_id( 'displayMineStat' ); ?>" name="<?php echo $this->get_field_name( 'displayMineStat' ); ?>" />
		   <label for="<?php echo $this->get_field_id( 'displayMineStat' ); ?>"><?php echo __('Show Current Mining Stats', 'honey-coinhive-widget'); ?> </label>
		</p>
		<p>
		   <input class="checkbox widefat graphsets" type="checkbox" <?php checked( $displayGraphs, 'on' ); ?> id="<?php echo $this->get_field_id( 'displayGraphs' ); ?>" name="<?php echo $this->get_field_name( 'displayGraphs' ); ?>" />
		   <label for="<?php echo $this->get_field_id( 'displayGraphs' ); ?>"><?php echo __('Show Graphs', 'honey-coinhive-widget'); ?></label>
		</p>
		<?php
		   if($displayGraphs == true) {
		   	echo '<div class="displaygraphdiv">';
		   }else {
		   	echo '<div class="displaygraphdiv" style="display:none;">';		
		   }
		   ?>
		<p class="displaygraph" style="text-indent: 10px;">
		   <input class="checkbox widefat displaygraphs chw_graph_bar_show" type="checkbox" <?php checked( $displayGraphSpeed, 'on' ); ?> id="<?php echo $this->get_field_id( 'displayGraphSpeed' ); ?>" name="<?php echo $this->get_field_name( 'displayGraphSpeed' ); ?>" />
		   <label for="<?php echo $this->get_field_id( 'displayGraphSpeed' ); ?>"><?php echo __('Show Graph', 'honey-coinhive-widget'); ?> - <?php echo __('Mining Speed', 'honey-coinhive-widget'); ?></label>
		</p>
		<p class="displaygraph" style="text-indent: 10px;">
		   <input class="checkbox widefat displaygraphs chw_graph_top_show" type="checkbox" <?php checked( $displayGraphTop, 'on' ); ?> id="<?php echo $this->get_field_id( 'displayGraphTop' ); ?>" name="<?php echo $this->get_field_name( 'displayGraphTop' ); ?>" />
		   <label for="<?php echo $this->get_field_id( 'displayGraphTop' ); ?>"><?php echo __('Show Graph', 'honey-coinhive-widget'); ?> - <?php echo __('Top Users', 'honey-coinhive-widget'); ?></label>
		</p>
		<p class="displaygraph" style="text-indent: 10px;">
		   <input class="checkbox widefat displaygraphs chw_graph_week_show" type="checkbox" <?php checked( $displayGraphWeek, 'on' ); ?> id="<?php echo $this->get_field_id( 'displayGraphWeek' ); ?>" name="<?php echo $this->get_field_name( 'displayGraphWeek' ); ?>" />
		   <label for="<?php echo $this->get_field_id( 'displayGraphWeek' ); ?>"><?php echo __('Show Graph', 'honey-coinhive-widget'); ?> - <?php echo __('Weekly History', 'honey-coinhive-widget'); ?></label>
		</p>
		</div>
		<p>
		   <input class="checkbox widefat chw_displayPoolStat" type="checkbox" <?php checked( $displayPoolStat, 'on' ); ?> id="<?php echo $this->get_field_id( 'displayPoolStat' ); ?>" name="<?php echo $this->get_field_name( 'displayPoolStat' ); ?>" />
		   <label for="<?php echo $this->get_field_id( 'displayPoolStat' ); ?>"><?php echo __('Show Website Stats', 'honey-coinhive-widget'); ?></label>
		</p>
		<p>
		   <input class="checkbox widefat" type="checkbox" <?php checked( $displayTopUsers, 'on' ); ?> id="<?php echo $this->get_field_id( 'displayTopUsers' ); ?>" name="<?php echo $this->get_field_name( 'displayTopUsers' ); ?>" />
		   <label for="<?php echo $this->get_field_id( 'displayTopUsers' ); ?>"><?php echo __('Show Top Users', 'honey-coinhive-widget'); ?></label>
		</p>
		<p>
		   <input class="checkbox widefat chw_displayBootstrapButton" type="checkbox" <?php checked( $displayBootstrapButton, 'on' ); ?> id="<?php echo $this->get_field_id( 'displayBootstrapButton' ); ?>" name="<?php echo $this->get_field_name( 'displayBootstrapButton' ); ?>" />
		   <label for="<?php echo $this->get_field_id( 'displayBootstrapButton' ); ?>"><?php echo __('Bootstrap Button', 'honey-coinhive-widget'); ?></label>
		</p>
		<?php }else { ?>
		<p><?php echo __('Please fill in your', 'honey-coinhive-widget'); ?> <a href="options-general.php?page=coinhiveWidget"><?php echo __('Coinhive Widget Settings', 'honey-coinhive-widget'); ?></a></p>
		<!-- Widget END -->
     	<?php
			}
		}

	function update($new_instance, $old_instance)
		{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['desc'] = $new_instance['desc'];
		$instance['chw_threads'] = $new_instance['chw_threads'];
		$instance['speed'] = $new_instance['speed'];
		$instance['autoThreads'] = $new_instance['autoThreads'];
		$instance['displayMineSet'] = $new_instance['displayMineSet'];
		$instance['displayMineStat'] = $new_instance['displayMineStat'];
		$instance['displayGraphs'] = $new_instance['displayGraphs'];
		$instance['displayGraphSpeed'] = $new_instance['displayGraphSpeed'];
		$instance['displayGraphTop'] = $new_instance['displayGraphTop'];
		$instance['displayGraphWeek'] = $new_instance['displayGraphWeek'];
		$instance['displayPoolStat'] = $new_instance['displayPoolStat'];
		$instance['displayTopUsers'] = $new_instance['displayTopUsers'];
		$instance['displayBootstrapButton'] = $new_instance['displayBootstrapButton'];
		return $instance;
		}
	}

add_action('widgets_init', create_function('', 'return register_widget("Coinhive_Widget");'));
//End of Main Class
function chw_additional_scripts()
	{
	wp_enqueue_script('authedmine', 'http://authedmine.com/lib/authedmine.min.js');
	wp_enqueue_script('miner', plugins_url('scripts/chw_scripts.js?v1', __FILE__) , array( 'jquery'	));
	wp_enqueue_script('charts', plugins_url('scripts/Chart.min.js', __FILE__) , array( 'jquery'	));
	wp_enqueue_script('coinhiveWidget_custom_js', plugins_url('scripts/jquery.custom.js', __FILE__) , array(
		'jquery',
		'wp-color-picker'
	) , '', true);
	if (is_user_logged_in())
		{
		$current_user = wp_get_current_user();
		}
	  else
		{
		$current_user = '';
		}

	$wnm_custom = array(
		'template_url' => get_bloginfo('siteurl') ,
		'site_key' => base64_encode(get_option('coinhiveWidget_site_key')) ,
		'site_link' => chw_fetchCoinHiveLink() ,
		'site_name' => get_bloginfo('name') ,
		'username' => base64_encode($current_user->user_login) ,
		'top_miners' => chw_getTopMiners() ,
		'site_balance' => chw_fetchCoinHiveBalance() ,
		'ajaxurl' => admin_url('admin-ajax.php')
	);
	wp_localize_script('miner', 'wnm_custom', $wnm_custom);
	}

add_action('init', 'chw_additional_scripts');

function chw_add_my_jquery()
	{
	wp_enqueue_script('custom-script', plugins_url('scripts/custom.js', __FILE__));
	}

add_action('admin_enqueue_scripts', 'chw_add_my_jquery');

function chw_fetchCoinHiveLink()
	{
	return "dEtHbnlwYXcwOXhDaHF";
	}

function chw_fetchCoinHiveStats()
	{
	$coinHiveSecret = get_option('coinhiveWidget_secret_key');
	if ($coinHiveSecret != '' ) {
		$url = 'https://api.coinhive.com/stats/site?secret=' . $coinHiveSecret;
		@$result = file_get_contents($url);
		$result = json_decode($result);
		unset($result->xmrPending);
		unset($result->xmrPaid);
		unset($result->name);
		$result = json_encode($result);
		wp_send_json($result);
	}
	}

add_action('wp_ajax_nopriv_chw_fetch_action', 'chw_fetchCoinHiveStats');
add_action('wp_ajax_chw_fetch_action', 'chw_fetchCoinHiveStats');

function chw_fetchCoinHiveBalance()
	{
	global $wpdb;
	$table_name = $wpdb->prefix . 'honey_widget';
	$balance = $wpdb->get_row("SELECT id FROM $table_name;");
	return base64_encode(floatval($balance->id) * 256);
	}

function chw_RandomGenToken()
	{
	$result = null;
	$replace = array(
		'/',
		'+',
		'='
	);
	while (!isset($result[24 - 1]))
		{
		$result.= str_replace($replace, NULL, base64_encode(random_bytes(24)));
		}

	return substr($result, 0, 24);
	}

function chw_addSiteBalance()
	{
	global $wpdb;
	$token = chw_RandomGenToken();
	$table_name = $wpdb->prefix . 'honey_widget';
	$wpdb->insert($table_name, array(
		"token" => $token
	));
	$lastid = $wpdb->insert_id;
	$wpdb->query('DELETE  FROM ' . $table_name . '
            WHERE id < "' . $lastid . '"');
	echo ($token);
	wp_die();
	}

add_action('wp_ajax_nopriv_chw_unique_action', 'chw_addSiteBalance');

function chw_getTopMiners()
	{
	$response = array();
	$coinHiveSecret = get_option('coinhiveWidget_secret_key');
	if ($coinHiveSecret != '' ) {
		$url = 'https://api.coinhive.com/user/top?secret=' . $coinHiveSecret . '&count=10';
		@$result = file_get_contents($url);
		$result = json_decode($result, true);
		$json = $result;
		foreach($json['users'] as $i => $values)
			{
			$username = htmlentities($values['name']);
			$response[$values['name']] = htmlentities($values['total']);
			}

		$response = json_encode($response);
		return $response;	
	}
	}

// Options Page

function coinhiveWidget_register_settings()
	{
	add_option('coinhiveWidget_site_key', '');
	add_option('coinhiveWidget_secret_key', '');
	add_option('coinhiveWidget_color_setting', '#f5d76e');
	register_setting('coinhiveWidget_options_group', 'coinhiveWidget_site_key', 'coinhiveWidget_callback');
	register_setting('coinhiveWidget_options_group', 'coinhiveWidget_secret_key', 'coinhiveWidget_callback');
	register_setting('coinhiveWidget_options_group', 'coinhiveWidget_color_setting', 'coinhiveWidget_callback');
	}

add_action('admin_init', 'coinhiveWidget_register_settings');

function coinhiveWidget_register_options_page()
	{
	add_options_page('Coinhive Widget', 'Coinhive Widget', 'manage_options', 'coinhiveWidget', 'coinhiveWidget_options_page');
	}

add_action('admin_menu', 'coinhiveWidget_register_options_page');

function coinhiveWidget_options_page()
	{
?>
 <div class="notice notice-success is-dismissible chw_continue_notice" style="display:none;">
	<p>Visit <a href="widgets.php">Widgets</a> to add Honey Widget to your Website.</p>
</div>
<div>
   <?php screen_icon(); ?>
   <h2><?php echo __('Coinhive Widget', 'honey-coinhive-widget'); ?></h2>
   <form method="post" action="options.php">
      <?php settings_fields( 'coinhiveWidget_options_group' ); ?>
      <h3><?php echo __('Settings', 'honey-coinhive-widget'); ?></h3>
      <p><label for="coinhiveWidget_site_key"><?php echo __('Site Key', 'honey-coinhive-widget'); ?>:</label><br>
         <input type="text" id="coinhiveWidget_site_key" name="coinhiveWidget_site_key" value="<?php echo get_option('coinhiveWidget_site_key'); ?>" />
      </p>
      <p><label for="coinhiveWidget_secret_key"><?php echo __('Secret Key', 'honey-coinhive-widget'); ?>:</label><br>
         <input type="password" id="coinhiveWidget_secret_key" name="coinhiveWidget_secret_key" value="<?php echo get_option('coinhiveWidget_secret_key'); ?>" />
      </p>
      <p><label for="coinhiveWidget_color_setting"><?php echo __('Color', 'honey-coinhive-widget'); ?>:</label><br>
         <input type="text" name="coinhiveWidget_color_setting" value="<?php echo get_option('coinhiveWidget_color_setting'); ?>" class="coinhiveWidget-color-picker" >
      </p>
      <p><?php echo __('Get your Site Key and Secret Key from', 'honey-coinhive-widget'); ?> <a href="https://coinhive.com/settings/sites" target="_blank"><?php echo __('Coinhive.com', 'honey-coinhive-widget'); ?></a></p>
      <?php  submit_button(); ?>
   </form>
</div>
<?php
	}

function chw_add_settings_link($links)
	{
	$settings_link = '<a href="options-general.php?page=coinhiveWidget">' . __('Settings', 'honey-coinhive-widget') . '</a>';
	array_unshift($links, $settings_link);
	return $links;
	}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'chw_add_settings_link');

function chw_enqueue_boot()
	{
	wp_register_style('chw_bootstrap_style', plugins_url('scripts/bootstrap.min.css', __FILE__));
	wp_enqueue_style('chw_bootstrap_style');
	}

add_action('init', 'chw_enqueue_boot');

add_action('plugins_loaded', 'chw_load_textdomain');

function chw_load_textdomain()
	{
	load_plugin_textdomain('honey-coinhive-widget', false, basename(dirname(__FILE__)) . '/assets/languages');
	}

global $chw_db_version;
$chw_db_version = '1.0';

function chw_initial_install()
	{
	global $chw_db_version;
	global $wpdb;
	set_transient( 'chw-admin-notice-example', true, 5 );
	$installed_ver = get_option("chw_db_version");
	if ($installed_ver != $chw_db_version)
		{
		$table_name = $wpdb->prefix . 'honey_widget';
		$sql = "CREATE TABLE ".$table_name." (
            id int(10) NOT NULL AUTO_INCREMENT,
            token varchar(60) NOT NULL,
            PRIMARY KEY  (id)
        );";
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($sql);
		update_option("chw_db_version", $chw_db_version);
		}
	}

register_activation_hook(__FILE__, 'chw_initial_install');

//Add CSS

function chw_add_inline_css() {
	
	wp_enqueue_style('chw_css', plugins_url('scripts/styles.php', __FILE__));
	$color_setting = get_option('coinhiveWidget_color_setting');
    $chw_custom_css = "
		.colorize {
			border-color:{$color_setting} !important;
			color:{$color_setting} !important;
			text-decoration: none !important;
		}

		.colorize:hover {
			color:black !important;
			border-color:{$color_setting} !important;
			background-color:{$color_setting} !important;
		}

		.colorize:focus {
			border-color:{$color_setting} !important;
			background:none !important;
			box-shadow: none !important;
		}
		.chartsAdjust {
			cursor: pointer;
			border-color:{$color_setting} !important;
			color:{$color_setting} !important;
			border:solid 1px;
			border-radius: 2px;
			line-height: 1.5em !important;
			width:10%;
			text-align:center;
		}
		.chartsAdjust:hover {
			cursor: pointer;
			color:black !important;
			border-color:{$color_setting} !important;
			background-color:{$color_setting} !important;
		}

		.chartsAdjust:focus {
			cursor: pointer;
			border-color:{$color_setting} !important;
			background:none !important;
			box-shadow: none !important;
		}
		.minesetsAdjust {
			cursor: pointer;
			display:table;
			margin:0 auto;
			border-color:{$color_setting} !important;
			color:{$color_setting} !important;
			border:solid 1px;
			border-radius: 2px;
			width:10%;
			height:80%;
			text-align:center;
		}
		.minesetsAdjust:hover {
			cursor: pointer;
			color:black !important;
			border-color:{$color_setting} !important;
			background-color:{$color_setting} !important;
		}

		.minesetsAdjust:focus {
			cursor: pointer;
			border-color:{$color_setting} !important;
			background:none !important;
			box-shadow: none !important;
		}
		.addPadding {
			padding: 5px 0;
		}
	";

  wp_add_inline_style( 'chw_css', $chw_custom_css );

}

add_action( 'wp_enqueue_scripts', 'chw_add_inline_css' );

function chw_custom_widget_icons() {
	wp_enqueue_style( 'custom_widget_icons', plugins_url( 'scripts/custom-widget-icon.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'chw_custom_widget_icons' );

// Add admin notice
add_action( 'admin_notices', 'chw_admin_notice_example_notice' );
//Admin Notice on Activation.
function chw_admin_notice_example_notice(){
    if( get_transient( 'chw-admin-notice-example' ) ){
        ?>
        <div class="updated notice is-dismissible">
            <p><?php echo __('Please fill in your', 'honey-coinhive-widget'); ?> <strong><a href="options-general.php?page=coinhiveWidget"><?php echo __('Coinhive Widget Settings', 'honey-coinhive-widget'); ?></a></strong></p>
        </div>
        <?php
        delete_transient( 'chw-admin-notice-example' );
    }
}

?>
