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
		'latitude' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:leaflet_maps/locallang_db.xml:tx_leafletmaps_markers.latitude',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
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
		'0' => array('showitem' => 'hidden;;1;;1-1-1, latitude, longitude, popuptext;;;richtext[]:rte_transform[mode=ts_css|imgpath=uploads/tx_leafletmaps/rte/]')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_leafletmaps_layergroups'] = array (
	'ctrl' => $TCA['tx_leafletmaps_layergroups']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,starttime,endtime,title,marker,maplayer'
	),
	'feInterface' => $TCA['tx_leafletmaps_layergroups']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(3, 14, 7, 1, 19, 2038),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'title' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:leaflet_maps/locallang_db.xml:tx_leafletmaps_layergroups.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'marker' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:leaflet_maps/locallang_db.xml:tx_leafletmaps_layergroups.marker',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tx_leafletmaps_markers',	
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 100,
			)
		),
        'maplayer' => array (        
            'exclude' => 1,        
            'label' => 'LLL:EXT:leaflet_maps/locallang_db.xml:tx_leafletmaps_layergroups.maplayer',        
            'config' => array (
                'type' => 'check',
                'default' => 1,
            )
        ),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, marker;;;;3-3-3, maplayer')
	),
	'palettes' => array (
		'1' => array('showitem' => 'starttime, endtime')
	)
);
?>