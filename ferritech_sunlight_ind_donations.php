<?php
/**
 * @package Independent Donations
 */
/*
Plugin Name: Independent Donations
Plugin URI: http://www.ferritech.com/designs/wordpress/plugins/ind_dontations
Description: With the use of the <a href='http://sunlightfoundation.com/api/accounts/register/' target='_blank'>Sunlight API</a>, this widget will show the most recently updated information regarding spending by Political Action Committees (PACs).
Version: 1.0
Author: Ferritech
Author URI: http://www.ferritech.com/designs/wordpress
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

class ft_ind_don extends WP_Widget
{
	function __construct()
	{
		parent::__construct(false, $name=__('Independent Donations'));
	}
	function widget($args, $instance)
	{
		$apikey = format_to_edit($instance['text']);
		
		wp_enqueue_style('independent_donationscss');
		include "independent_donations.php";
	}
	function update($new_instance, $old_instance)
	{
        $instance = $old_instance;
        if (current_user_can('unfiltered_html'))
		{
            $instance['text'] =  $new_instance['text'];
		}
        else
		{
            $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		}
        return $instance;
    }
    function form($instance)
	{
        $instance = wp_parse_args((array) $instance, array('text' => ''));
        $text = format_to_edit($instance['text']);
		?>
        <label><a href="http://sunlightfoundation.com/api/accounts/register/" target="_blank">Sunlight API Key</a></label><hr />
	    <input id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" value="<?php echo $text; ?>" style="width:100%;" /><br /><br />
		<?php
    }
}
add_action('widgets_init',function()
{
	register_widget('ft_ind_don');
});
add_action('wp_enqueue_scripts',function()
{
	wp_enqueue_style('independent_donationscss', plugins_url('css/independent_donations.css',__FILE__));
	wp_enqueue_script('jquery');
});
?>