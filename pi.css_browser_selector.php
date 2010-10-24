<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
	'pi_name'        => 'CSS Browser Selector',
	'pi_version'     => '1.0',
	'pi_author'      => 'Ronny-André Bendiksen',
	'pi_author_url'  => 'http://ronny-andre.no',
	'pi_description' => 'Returns the visitors operating system and browser as CSS browser selectors to use in your HTML.',
	'pi_usage'       => CSS_Browser_Selector::usage()
);

class CSS_Browser_Selector {
	
	var $return_data = '';
	
	function CSS_Browser_Selector() {
		$this->EE =& get_instance();
		
		$ua = ($this->EE->TMPL->fetch_param('agent') != '') ? strtolower($this->EE->TMPL->fetch_param('agent')) : strtolower($_SERVER['HTTP_USER_AGENT']);
		
		$g = 'gecko';
		$w = 'webkit';
		$s = 'safari';
		$b = array();
		
		// browser
		if (!preg_match('/opera|webtv/i', $ua) && preg_match('/msie\s(\d)/', $ua, $array)) {
			$b[] = 'ie ie'.$array[1];
		} else if (strstr($ua, 'firefox/2')) {
			$b[] = $g.' ff2';		
		} else if (strstr($ua, 'firefox/3.5')) {
			$b[] = $g.' ff3 ff3_5';
		} else if (strstr($ua, 'firefox/3')) {
			$b[] = $g.' ff3';
		} else if (strstr($ua, 'gecko/')) {
			$b[] = $g;
		} else if (preg_match('/opera(\s|\/)(\d+)/', $ua, $array)) {
			$b[] = 'opera opera'.$array[2];
		} else if (strstr($ua, 'konqueror')) {
			$b[] = 'konqueror';
		} else if (strstr($ua, 'chrome')) {
			$b[] = $w.' '.$s.' chrome';
		} else if (strstr($ua, 'iron')) {
			$b[] = $w.' '.$s.' iron';
		} else if (strstr($ua, 'applewebkit/')) {
			$b[] = (preg_match('/version\/(\d+)/i', $ua, $array)) ? $w.' '.$s.' '.$s.$array[1] : $w.' '.$s;
		} else if (strstr($ua, 'mozilla/')) {
			$b[] = $g;
		}

		// platform				
		if (strstr($ua, 'j2me')) {
			$b[] = 'mobile';
		} else if (strstr($ua, 'iphone')) {
			$b[] = 'iphone';		
		} else if (strstr($ua, 'ipod')) {
			$b[] = 'ipod';		
		} else if (strstr($ua, 'mac')) {
			$b[] = 'mac';		
		} else if (strstr($ua, 'darwin')) {
			$b[] = 'mac';		
		} else if (strstr($ua, 'webtv')) {
			$b[] = 'webtv';		
		} else if (strstr($ua, 'win')) {
			$b[] = 'win';		
		} else if (strstr($ua, 'freebsd')) {
			$b[] = 'freebsd';		
		} else if (strstr($ua, 'x11') || strstr($ua, 'linux')) {
			$b[] = 'linux';		
		}
		
		$this->return_data = join(' ', $b);
	}
	
	function usage() {
		ob_start() ?>
This plugin returns the visitors operating system and browser as CSS browser selectors to use in your HTML.

=====================================================
Basic Usage
=====================================================

The following code returns CSS selectors:
{exp:css_browser_selector}

Or you can provide the user agent as a string:
{exp:css_browser_selector agent="Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0)"}

Keep in mind that you can use ExpressionEngine's own Referrer module function {ref_agent}:
{exp:css_browser_selector agent="{ref_agent}"}


=====================================================
Parameters
=====================================================

agent
If empty, ExpressionEngine will use PHP's own $_SERVER['HTTP_USER_AGENT'] variable.


=====================================================
Credits
=====================================================

This is an ExpressionEngine port of Bastian Allgeier's PHP CSS Browser Selector. (Which is then a port of Rafael Lima's Javascript CSS Browser Selector.)

Bastian Allgeier
http://bastian-allgeier.de/css_browser_selector

Rafael Lima
http://rafael.adm.br/css_browser_selector
		<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
	
}

?>