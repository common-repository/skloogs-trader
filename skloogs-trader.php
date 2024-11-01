<?php
/*
Plugin Name: Skloogs Trader
Plugin URI: http://tec.skloogs.com/dev/plugins/skloogs-trader
Description: This plugin shows shares from the Brazilian Stock Exchange.
Version: 1.1.1
Author: Philippe Hilger
Author URI: http://tec.skloogs.com

  Copyright 2009  Philippe Hilger  (hilgerph@yahoo.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$SkTRDomain = "skloogs-trader";
$SkTRVersion = "1.1.1";
$SkTRStTmpl='<div class="SkTrader">';
$SkTRMiTmpl='<a target=_blank href="http://www.bovespa.com.br" alt="Bovespa"><applet code=GeradorGrafico.class codebase="http://www.bovespa.com.br/Cotacoes2000/Graficos/WWW" height={HEIGHT} name=GeradorGrafico width={WIDTH} VIEWASTEXT id=apl{SHARECODE}>
    <param name="width" value="{WIDTH}">
    <param name="height" value="{HEIGHT}">
    <param name="codigo" value="{SHARECODE}">
    <param name="titulo" value="{SHARECODE}">
    <param name="arqurl" value="http://www.bovespa.com.br/Cotacoes2000/Graficos/Arquivos/">
    <param name="xmin" value="10:00:00">
    <param name="xmax" value="18:30:00">
    <param name="marginf" value="32">
    <param name="margsup" value="28">
    <param name="delay" VALUE="9999999">
    <param name="arqend" value="2">
    <param name="margdir" value="12">
    <param name="margesq" value="52">
    <param name="arqinit" value="1">
    <param name="bgco" value="{BGCOLOR}">
    <param name="txtco" value="{TXTCOLOR}">
    <param name="borderco" value="{BDCOLOR}">
    <param name="fillco" value="{FILLCOLOR}">
    <param name="UrlAsp" value="http://www.bovespa.com.br/Cotacoes2000/SolicitaGrafico.Asp?CodigoPapelIndice={SHARECODE}">
</applet></a>';
$SkTRAdTmpl='<a target=_blank href="http://br.advfn.com/p.php?pid=qkchart&symbol={MARKET}^{SHARECODE}" alt="ADVFN"><img width="{WIDTH}" height="{HEIGHT}" src="http://br.advfn.com/p.php?pid=staticchart&s={MARKET}%3A{SHARECODE}&p={PERIOD}&t={CHTYPE}&vol={VOLUME}" alt="{SHARECODE}" /></a>';
$SkTREnTmpl='<br/>
<small>&copy; 2009 Plugin <i><a target=_blank href="http://tec.skloogs.com/dev/plugins/skloogs-trader" alt="Skloogs Trader v.'.$SkTRVersion.'">Skloogs Trader</a></i> by Philippe Hilger. Charts by Bovespa/ADVFN.</small></div>';

function SkTR_get($codes) {
	global $SkTRStTmpl,$SkTRMiTmpl,$SkTREnTmpl,$SkTRAdTmpl;
	$applets = $SkTRStTmpl;
	if (preg_match_all("/\[sktrades?\s+(([a-zA-Z0-9=:|]+[, ;]*)+)\]/",$codes,$ncodes)) {
		foreach ($ncodes[1] as $ucode) {
			$ecode = preg_split("/[, ;]+/",$ucode);
			foreach ($ecode as $code) {
				$width = 400;
				$height = 180;
				$bgco = '242,244,247';
				$txtco = '51,102,153';
				$bdco = '255,255,255';
				$filco = '247,197,102';
				$vol=1;
				$chtype=1;
				$period=5;
				$market="BOV";
				$static=0;
				$attr = split('=',$code);
				if (count($attr)>1) {
					$tattr = split('\|',$attr[1]);
					foreach ($tattr as $vattr) {
						$xat=split(':',$vattr);
						switch ($xat[0]) {
							case 's':
								$width = 200;
								$height = 100;
								break;
							case 'w':
								$width = $xat[1];
								break;
							case 'h':
								$height = $xat[1];
								break;
							case 'bg':
								$bgco = $xat[1].','.$xat[2].','.$xat[3];
								break;
							case 'tx':
								$txtco = $xat[1].','.$xat[2].','.$xat[3];
								break;
							case 'bd':
								$bdco = $xat[1].','.$xat[2].','.$xat[3];
								break;
							case 'fi':
								$filco = $xat[1].','.$xat[2].','.$xat[3];
								break;
							case 'p':
								switch ($xat[1]) {
									case 'i': // intraday
										$period = 0;
										break;
									case 'm': // month
										$period = 1;
										break;
									case '2m': // 2 months
										$period = 2;
										break;
									case '3m': // 3 months
										$period = 3;
										break;
									case '6m': // 6 months
										$period = 4;
										break;
									case 'y': // 1 year
										$period = 5;
										break;
									case '2y': // 2 years
										$period = 6;
										break;
									case '3y': // 3 years
										$period = 7;
										break;
									case '5y': // 5 years
										$period = 8;
										break;
								}
								break;
							case 'ty':
								$chtype = $xat[1];
								break;
							case 'mk':
								$market = strtoupper($xat[1]);
								break;
							case 'nv':
								$vol = 0;
								break;
							case 'v':
								$vol = 1;
								break;
							case 'q':
								$static=1;
						}
					}
				}
				$applet = str_replace('{SHARECODE}',strtoupper($attr[0]),$SkTRMiTmpl);
				$applet = str_replace('{HEIGHT}',$height,$applet);
				$applet = str_replace('{WIDTH}',$width,$applet);
				$applet = str_replace('{BGCOLOR}',$bgco,$applet);
				$applet = str_replace('{TXTCOLOR}',$txtco,$applet);
				$applet = str_replace('{BDCOLOR}',$bdco,$applet);
				$applet = str_replace('{FILLCOLOR}',$filco,$applet);
				$chart = str_replace('{SHARECODE}',strtoupper($attr[0]),$SkTRAdTmpl);
				$chart = str_replace('{VOLUME}',$vol,$chart);
				$chart = str_replace('{CHTYPE}',$chtype,$chart);
				$chart = str_replace('{PERIOD}',$period,$chart);
				$chart = str_replace('{MARKET}',$market,$chart);
				$chart = str_replace('{HEIGHT}',$height,$chart);
				$chart = str_replace('{WIDTH}',$width,$chart);
				if ($static) $applets .= $chart;
				else $applets .= $applet;
			}
		}
	}
	return $applets.$SkTREnTmpl;
}

function SkTR_filter($content) {
	if (preg_match_all('/(\[sktrades?\s+[^\]]+\])/',$content,$sktrcodes)) {
		foreach ($sktrcodes[0] as $kk => $code) {
			$scode=SkTR_get($code);
    		$content = str_replace($code,$scode,$content);
		}
	}
    return $content;
}

function SkTR_style() {
	global $SkTRDomain;
	echo "<link rel='stylesheet' href='".plugins_url($SkTRDomain)."/style.css' type='text/css' />";
}

/*
 * Plugin desinstallation
 */
function SkTR_uninstall() {
}

/*
 * Plugin installation
 */
function SkTR_install() {
}

function SkTR_menu() {
	global $SkTRDomain;
	$SkMenuMode=get_option('SkMenuMode');
	switch($SkMenuMode) {
		case 'Skloogs':
			if (!function_exists('SkOptions')) {
				function SkOptions() {
				  echo '<div class="wrap">';
				  echo '<p>'.__('This section provides access to all options for the Skloogs plugins '
				  . 'you have installed.',$SkTRDomain).'</p>';
				  echo '</div>';
				}
				function SkOptionsFile() {
					return __FILE__;
				}
				add_menu_page('Skloogs Plugins', 'Skloogs', 8, __FILE__, 'SkOptions');
			}
			$SkMenuMode='Skloogs';
			$SkMenu=SkOptionsFile();
			break;
		case 'Settings':
		default:
			$SkMenuMode='Settings';
			$SkMenu='options-general.php';
			break;
	}
	update_option('SkMenuMode',$SkMenuMode);
	add_submenu_page($SkMenu, 'Skloogs Trader', 'Trader', 8, __FILE__, 'SkTROptions');	
}

function SkTROptions() {
	global $SkTRDomain;

	if ($_POST['updated'] == 'true') SkMS_loader();
?>
	<div class="wrap">
	<h2>Skloogs Trader</h2>
	
	<form method="post" action="options.php">
	<?php wp_nonce_field('update-options'); ?>
	
	<table class="form-table">
	
	<tr valign="top">
	<th scope="row"><?php echo __('Configuration Menu',$SkTRDomain); ?></th>
	<td><input type="radio" name="SkMenuMode" value="Settings"<?php if (get_option('SkMenuMode')=='Settings') echo ' checked'; ?> /><?php echo __('Settings',$SkTRDomain); ?><br />
	<input type="radio" name="SkMenuMode" value="Skloogs"<?php if (get_option('SkMenuMode')=='Skloogs') echo ' checked'; ?> /><?php echo __('Top Level',$SkTRDomain); ?>
	</td>
	</tr>
	 
	<tr valign="top">
	<th scope="row"><?php echo __('Default Width',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRDefWidth" value="<?php echo get_option('SkTRDefWidth'); ?>" />
	<?php echo __('Default Graphic Width in pixels',$SkTRDomain).'(400)'; ?></td>
	</tr>
	 
	<tr valign="top">
	<th scope="row"><?php echo __('Default Height',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRDefHeight" value="<?php echo get_option('SkTRDefHeight'); ?>" />
	<?php echo __('Default Graphic Height in pixels',$SkTRDomain).'(180)'; ?></td>
	</tr>

	<tr valign="top">
	<th scope="row"><?php echo __('Background Color',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRBgColor" value="<?php echo get_option('SkTRBgColor'); ?>" />
	<?php echo __('RGB Decimal Values',$SkTRDomain). '(242,244,247)'; ?></td>
	</tr>

	<tr valign="top">
	<th scope="row"><?php echo __('Text Color',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRTxtColor" value="<?php echo get_option('SkTRTxtColor'); ?>" />
	<?php echo __('RGB Decimal Values',$SkTRDomain). '(51,102,153)'; ?></td>
	</tr>

	<tr valign="top">
	<th scope="row"><?php echo __('Border Color',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRBdColor" value="<?php echo get_option('SkTRBdColor'); ?>" />
	<?php echo __('RGB Decimal Values',$SkTRDomain). '(255,255,255)'; ?></td>
	</tr>

	<tr valign="top">
	<th scope="row"><?php echo __('Fill Color',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRFilColor" value="<?php echo get_option('SkTRFilColor'); ?>" />
	<?php echo __('RGB Decimal Values',$SkTRDomain). '(247,197,102)'; ?></td>
	</tr>

	<tr valign="top">
	<th scope="row"><?php echo __('Show Volume',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRShVolume" value="<?php echo get_option('SkTRShVolume'); ?>" />
	<?php echo __('Show Trade volumes (Yes)',$SkTRDomain); ?></td>
	</tr>

	<tr valign="top">
	<th scope="row"><?php echo __('Chart Type',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRChType" value="<?php echo get_option('SkTRChType'); ?>" />
	<?php echo __('ADVFN Chart Type',$SkTRDomain). '(1)'; ?></td>
	</tr>

	<tr valign="top">
	<th scope="row"><?php echo __('Default Period',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRDefPeriod" value="<?php echo get_option('SkTRDefPeriod'); ?>" />
	<?php echo __('Graph Period (Intraday)',$SkTRDomain); ?></td>
	</tr>

	<tr valign="top">
	<th scope="row"><?php echo __('Default Market',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRDefMarket" value="<?php echo get_option('SkTRDefMarket'); ?>" />
	<?php echo __('ADVFN Market Code (BOV)',$SkTRDomain); ?></td>
	</tr>

	<tr valign="top">
	<th scope="row"><?php echo __('Default Graph Mode',$SkTRDomain); ?></th>
	<td><input type="text" name="SkTRStatic" value="<?php echo get_option('SkTRStatic'); ?>" />
	<?php echo __('Static/Dynamic (Dynamic)',$SkTRDomain); ?></td>
	</tr>

	</table>
	
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options"
	 value="SkTRDefWidth,SkTRDefHeight,SkTRBgColor,SkTRTxtColor,SkTRBdColor,SkTRFilColor,SkTRShVolume,SkTRChType,SkTRDefPeriod,SkTRDefMarket,SkTRStatic,SkMenuMode" />
	
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	
	</form>
	</div>
<?php

}


//add_action('plugins_loaded', 'SkTR_loader');
add_filter('the_content', 'SkTR_filter');
add_action('wp_head','SkTR_style');
add_action('admin_head','SkTR_style');
//register_activation_hook(__FILE__,'SkTR_install');
//register_deactivation_hook(__FILE__,'SkTR_uninstall');
add_action('admin_menu', 'SkTR_menu');

?>
