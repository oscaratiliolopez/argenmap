<?php
/**
 * CartoWeb3 main page.
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
 * @copyright 2005 Camptocamp SA
 * @package Htdocs
 * @version $Id$
 */

define('CARTOWEB_HOME', realpath(dirname(__FILE__) . '/..') . '/');

require_once(CARTOWEB_HOME . 'common/Common.php');
Common::preInitializeCartoweb(array('client' => true, 'apd' => false));

require_once(CARTOWEB_HOME . 'client/Cartoclient.php');

$cartoclient = new Cartoclient();

print $cartoclient->main();

?>
