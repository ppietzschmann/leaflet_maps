<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Peter Pietzschmann <peter@pietzschmann.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Show leaflet map' for the 'leaflet_maps' extension.
 *
 * @author	Peter Pietzschmann <peter@pietzschmann.de>
 * @package	TYPO3
 * @subpackage	tx_leafletmaps
 */
class tx_leafletmaps_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_leafletmaps_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_leafletmaps_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'leaflet_maps';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		
		//$this->pi_initPIflexForm();
		
		$this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
	/*
		$content='
			<strong>This is a few paragraphs:</strong><br />
			<p>This is line 1</p>
			<p>This is line 2</p>
	
			<h3>This is a form:</h3>
			<form action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id).'" method="POST">
				<input type="text" name="'.$this->prefixId.'[input_field]" value="'.htmlspecialchars($this->piVars['input_field']).'">
				<input type="submit" name="'.$this->prefixId.'[submit_button]" value="'.htmlspecialchars($this->pi_getLL('submit_button_label')).'">
			</form>
			<br />
			<p>You can click here to '.$this->pi_linkToPage('get to this page again',$GLOBALS['TSFE']->id).'</p>
		';
		*/
		
		// http://leaflet.cloudmade.com/reference.html
	
		
		$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] = '
			<link rel="stylesheet" href="typo3conf/ext/leaflet_maps/dist/leaflet.css" />
			<!--[if lte IE 8]>
			<link rel="stylesheet" href="typo3conf/ext/leaflet_maps/dist/leaflet.ie.css" />
			<![endif]-->
		';
		
		
		$content = "
		<div id=\"map\" style=\"height: 400px\"></div>

	<script src=\"typo3conf/ext/leaflet_maps/dist/leaflet.js\"></script>
	<script>
		var map = new L.Map('map');

		var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/".$this->extConf['api_key']."/997/256/{z}/{x}/{y}.png',
			cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade',
			cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution});

		map.setView(new L.LatLng(51.505, -0.09), 13).addLayer(cloudmade);


		// http://leaflet.cloudmade.com/examples/custom-icons.html
		var markerLocation = new L.LatLng(51.5, -0.09),
			marker = new L.Marker(markerLocation);

		map.addLayer(marker);
		marker.bindPopup('<b>Hello world!</b><br />I am a popup.').openPopup();


		// 
		var circleLocation = new L.LatLng(51.508, -0.11),
			circleOptions = {color: '#f03', opacity: 0.7},
			circle = new L.Circle(circleLocation, 500, circleOptions);

		circle.bindPopup('I am a circle.');
		map.addLayer(circle);


		var p1 = new L.LatLng(51.509, -0.08),
			p2 = new L.LatLng(51.503, -0.06),
			p3 = new L.LatLng(51.51, -0.047),
			polygonPoints = [p1, p2, p3],
			polygon = new L.Polygon(polygonPoints);

		polygon.bindPopup('I am a polygon.');
		map.addLayer(polygon);

		// http://leaflet.cloudmade.com/examples/layers-control.html
		var baseLayers = {
			'CloudMade': cloudmade,
			//'OpenStreetMap': osm
		};

		var overlays = {
			'Marker': marker,
			//'Roads': roadsLayer
		};

		layersControl = new L.Control.Layers(baseLayers, overlays);

		map.addControl(layersControl);
		


		map.on('click', onMapClick);

		var popup = new L.Popup();

		function onMapClick(e) {
			var latlngStr = '(' + e.latlng.lat.toFixed(3) + ', ' + e.latlng.lng.toFixed(3) + ')';

			popup.setLatLng(e.latlng);
			popup.setContent('You clicked the map at ' + latlngStr);
			map.openPopup(popup);
		}
	</script>	

		";
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/leaflet_maps/pi1/class.tx_leafletmaps_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/leaflet_maps/pi1/class.tx_leafletmaps_pi1.php']);
}

?>