<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_leafletmaps_markers'] = array (
	'ctrl' => $TCA['tx_leafletmaps_markers']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,longitude,latitude,popuptext'
	),
	'feInterface' => $TCA['tx_leafletmaps_markers']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'longitude' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:leaflet_maps/locallang_db.xml:tx_leafletmaps_markers.longitude',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'latitude' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:leaflet_maps/locallang_db.xml:tx_leafletmaps_markers.latitude',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'popuptext' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:leaflet_maps/locallang_db.xml:tx_leafletmaps_markers.popuptext',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, longitude, latitude, popuptext;;;richtext[]:rte_transform[mode=ts_css|imgpath=uploads/tx_leafletmaps/rte/]')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>