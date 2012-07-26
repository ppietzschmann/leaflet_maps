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
	
	var $js = '';
	
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
		
		$this->conf['map']['uid'] = $this->cObj->data['uid'];
		$this->conf['map']['div_id'] = 'map';
		$this->conf['map']['center'] = '39.73, -104.99';
		$this->conf['map']['zoom'] = '10';
		$this->conf['map']['layers'] = null;
		

		
		// http://leaflet.cloudmade.com/reference.html
	
		
		$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] = '
			<link rel="stylesheet" href="'.$GLOBALS["TSFE"]->absRefPrefix.'typo3conf/ext/leaflet_maps/dist/leaflet.css" />
			<!--[if lte IE 8]>
			<link rel="stylesheet" href="'.$GLOBALS["TSFE"]->absRefPrefix.'typo3conf/ext/leaflet_maps/dist/leaflet.ie.css" />
			<![endif]-->
		';
		
		
		$content = sprintf('<div id="%s%d" %s></div>',
				$this->conf['map']['div_id'],
				$this->conf['map']['uid'],
				$this->pi_classParam('map'));
		
		
		$content .= '<script src="'.$GLOBALS["TSFE"]->absRefPrefix.'typo3conf/ext/leaflet_maps/dist/leaflet.js"></script>';
	
		
		$content .= "<script>";
		
		
		
		$content .= $this->buildLayerGroup();
		
		$content .= $this->buildLayersControl();
		
		$content .= $this->buildMap();
		
		
		
		
		$content .= $this->js;
		
		
		$content .= 'var overlayMaps = {
							"Motorways": motorways,
							"Cities": citiesLayer
						};';
		
		// 
		$content .= 'layersControl = new L.Control.Layers(baseMaps, overlayMaps);';
		$content .= 'map.addControl(layersControl);';
		
		$content .= "</script>";
		
		#$GLOBALS['TSFE']->additionalJavaScript[$this->extKey] = $js;
	
		return $this->pi_wrapInBaseClass($content);
	}
	
	
	
		/**
	 * create a map
	 * initialize the map on the "map" div with a given center and zoom
	 * 
	 * 
	 * @see http://leaflet.cloudmade.com/reference.html#map-usage
	 * 
	 */
	function buildMap() {
		
		
		$this->js .= sprintf("var map = new L.Map('%s%d', {
							center: new L.LatLng(%s),
							zoom: %d, 
							layers: [minimal, citiesLayer]
						});",
				
				$this->conf['map']['div_id'],
				$this->conf['map']['uid'],
				$this->conf['map']['center'],
				$this->conf['map']['zoom'],
				''
				);
		
		
		
	}
	
	
	/**
	 * create a CloudMade tile layer
	 * 
	 * 
	 */
	function buildLayersControl() {
		
			// Cloudmade Layer		
		$this->js .= "var cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade',
						cloudmadeOptions = {maxZoom: 18, attribution: cloudmadeAttribution},
						cloudmadeUrl = 'http://{s}.tile.cloudmade.com/".$this->extConf['api_key']."/{styleId}/256/{z}/{x}/{y}.png';";
		
		$this->js .= "var minimal = new L.TileLayer(cloudmadeUrl, cloudmadeOptions, {styleId: 22677}),
						midnightCommander = new L.TileLayer(cloudmadeUrl, cloudmadeOptions, {styleId: 999}),
						motorways = new L.TileLayer(cloudmadeUrl, cloudmadeOptions, {styleId: 46561});";
		
		$this->js .= 'var baseMaps = {
							"Minimal": minimal,
							"Night View": midnightCommander
						};';
		
		
		// @todo: more layers
		
		
	}
	
	
	
	function buildLayerGroup() {
		
		$markers=$GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*','tx_leafletmaps_markers','1=1 '.$this->cObj->enableFields('tx_leafletmaps_markers'));
		
		foreach ($markers as $key => $value) {
			fb($value,__LINE__.': $value');
			
			
			
		}
		
		$this->js .= 'var littletonMarker = new L.Marker(new L.LatLng(39.61, -105.02)).bindPopup("This is Littleton, CO."),
							denverMarker = new L.Marker(new L.LatLng(39.74, -104.99)).bindPopup("This is Denver, CO."),
							auroraMarker = new L.Marker(new L.LatLng(39.73, -104.8)).bindPopup("This is Aurora, CO."),
							goldenMarker = new L.Marker(new L.LatLng(39.77, -105.23)).bindPopup("This is Golden, CO.");

						var citiesLayer = new L.LayerGroup();

						citiesLayer.addLayer(littletonMarker);
						citiesLayer.addLayer(denverMarker);
						citiesLayer.addLayer(auroraMarker);
						citiesLayer.addLayer(goldenMarker);';
		
		
	}
	
	

}






if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/leaflet_maps/pi1/class.tx_leafletmaps_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/leaflet_maps/pi1/class.tx_leafletmaps_pi1.php']);
}

?>