<?php
/**
 * @package Common
 * @version $Id$
 */

/**
 * Abstract serializable
 */
require_once(CARTOCOMMON_HOME . 'common/Serializable.php');
require_once(CARTOCOMMON_HOME . 'common/basic_types.php');

/**
 * @package Common
 */
class CartocommonException extends Exception {

}

/**
 * @package Common
 */
class LayerBase extends Serializable {
    
    public $id;
    public $label;
    public $minScale = 0;
    public $maxScale = 0;
    public $icon = 'none';
    public $link;
    
    function unserialize($struct) {
        $this->id    = self::unserializeValue($struct, 'id'); 
        $this->label = self::unserializeValue($struct, 'label');
        $this->link  = self::unserializeValue($struct, 'link');

        // Not implemented
        //$this->minScale = $struct->minscale;
        //$this->maxScale = $struct->maxscale;
        //$this->icon     = $struct->icon;
    }
}

/**
 * @package Common
 */
class LayerContainer extends LayerBase {
    public $children = array();
    
    function unserialize($struct) {
        parent::unserialize($struct);   
        $this->children = self::unserializeArray($struct, 'children');
        // FIXME: do it in unserializeArray ?
        if (is_null($this->children))
            $this->children = array();
    }    
}

/**
 * @package Common
 */
class LayerGroup extends LayerContainer {
    public $aggregate = false;

    function unserialize($struct) {
        parent::unserialize($struct);
        $this->aggregate = self::unserializeValue($struct, 'aggregate',
                                                  'boolean');
    }
}

/**
 * @package Common
 */
class Layer extends LayerContainer {

    public $msLayer;
    public $idAttributeString;

    function unserialize($struct) {
        parent::unserialize($struct);
        $this->msLayer = self::unserializeValue($struct, 'msLayer'); 
        $this->idAttributeString = self::unserializeValue($struct, 'idAttributeString'); 
    }
}

/**
 * @package Common
 */
class LayerClass extends LayerBase {

}

/**
 * @package Common
 */
class Location extends Serializable {
    public $bbox;
    
    function unserialize($struct) {
        $this->bbox = self::unserializeObject($struct, 'bbox', 'Bbox');
    }
}

/**
 * @package Common
 */
class InitialLocation extends Location {

}

/**
 * @package Common
 */
class LayerState extends Serializable {
    public $id;
    public $hidden;
    public $frozen;
    public $selected;
    public $unfolded;

    function unserialize($struct) {
        $this->id       = self::unserializeValue($struct, 'id');
        $this->hidden   = self::unserializeValue($struct, 'hidden', 'boolean');
        $this->frozen   = self::unserializeValue($struct, 'frozen', 'boolean');
        $this->selected = self::unserializeValue($struct, 'selected', 
                                                     'boolean');
        $this->unfolded = self::unserializeValue($struct, 'unfolded', 
                                                     'boolean');        
    }
}

/**
 * @package Common
 */
class InitialMapState extends Serializable {

    public $id;
    public $location;
    public $layers;

    function unserialize($struct) {
        $this->id       = self::unserializeValue($struct, 'id');
        $this->location = self::unserializeObject($struct, 'location', 'InitialLocation');
        $this->layers   = self::unserializeObjectMap($struct, 'layers', 'LayerState'); 
    }
}

/**
 * @package Common
 */
class MapInfo extends Serializable {
    public $timeStamp;
    public $mapId;
    public $mapLabel;
    public $outlineLayer;
    public $loadPlugins;
    public $layers;
    public $initialMapStates;
    public $extent;
    public $location;
    public $keymapGeoDimension; 

    function unserialize($struct) {
        $this->timeStamp        = self::unserializeValue($struct, 'timeStamp');
        $this->mapId            = self::unserializeValue($struct, 'mapId');
        $this->mapLabel         = self::unserializeValue($struct, 'mapLabel');
        $this->outlineLayer     = self::unserializeValue($struct, 'outlineLayer');
  
        $this->loadPlugins      = self::unserializeArray($struct, 'loadPlugins');
  
        // Layers class names are specicified in className attribute
        $this->layers           = self::unserializeObjectMap($struct, 'layers');
        $this->initialMapStates = self::unserializeObjectMap($struct, 'initialMapStates', 'InitialMapState');
        $this->extent           = self::unserializeObject($struct, 'extent', 'Bbox');
        $this->location         = self::unserializeObject($struct, 'location', 'Location');
        $this->keymapGeoDimension = self::unserializeObject($struct, 'keymapGeoDimension', 'GeoDimension');
        
        foreach (get_object_vars($struct) as $attr => $value) {
            if (substr($attr, -4) == 'Init') {
                $this->$attr = self::unserializeObject($struct, $attr, ucfirst($attr));
            }
        }
    }
    
    function getLayerById($layerId) {

        foreach ($this->layers as $layer) {
            if ($layer->id == $layerId)
                return $layer;
        }
        return NULL;
    }

    function getInitialMapStateById($mapStateId) {

        foreach ($this->initialMapStates as $mapState) {
            if ($mapState->id == $mapStateId)
                return $mapState;
        }
        return NULL;
    }

    function getLayers() {

        return $this->layers;
    }

    function addChildLayerBase($parentLayer, $childLayer) {
        
        $childLayerId = $childLayer->id;

        if (in_array($childLayerId, array_keys($this->layers)))
            throw new CartocommonException("Trying to replace layer $childLayerId");

        if (!in_array($childLayerId, $parentLayer->children))
            $parentLayer->children[] = $childLayerId;

        $this->layers[$childLayerId] = $childLayer;
    }
}

?>
