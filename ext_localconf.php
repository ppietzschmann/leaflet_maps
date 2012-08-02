<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_leafletmaps_markers=1
');
t3lib_extMgm::addPageTSConfig('

	# ***************************************************************************************
	# CONFIGURATION of RTE in table "tx_leafletmaps_markers", field "popuptext"
	# ***************************************************************************************
RTE.config.tx_leafletmaps_markers.popuptext {
  hidePStyleItems = H1, H4, H5, H6
  proc.exitHTMLparser_db=1
  proc.exitHTMLparser_db {
    keepNonMatchedTags=1
    tags.font.allowedAttribs= color
    tags.font.rmTagIfNoAttrib = 1
    tags.font.nesting = global
  }
}
');

t3lib_extMgm::addUserTSConfig('
    options.saveDocNew.tx_leafletmaps_layergroups=1
');

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_leafletmaps_pi1.php', '_pi1', 'list_type', 1);
?>