<?php
/**
 * Layers plugin common classes
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 *
 * @copyright 2006 Office International de l'Eau, Camptocamp
 * @package Plugins
 * @version $Id$
 */

/**
 * Abstract serializable
 */
require_once(CARTOWEB_HOME . 'common/CwSerializable.php');

/**
 * OgcLayerLoaderRequest 
 * @package Plugins
 */
class OgcLayerLoaderRequest extends CwSerializable {

    /**
     * @var object
     */
    public $ogcLayers;

    /**
     * @var array of UserLayer
     */
     public $userLayers;
    
    /**
     * @see CwSerializable::unserialize()
     */
    public function unserialize($struct) {
        $this->ogcLayers = self::unserializeObjectMap($struct,
                                                   'ogcLayers', 'LayerOverlay');
       $this->userLayers = 
            self::unserializeObjectMap($struct, 'userLayers', 'UserLayer');
    }
}
?>
