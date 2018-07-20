<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * @package mod_vimeo
 * @author Bruno Magalhães <brunomagalhaes@blackbean.com.br>
 * @copyright 2018 by BlackBean Inc, all rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html
 */
defined('MOODLE_INTERNAL') || die();

/**
 * This function is responsible for executing the
 * required routines when upgrading this plug-in.
 *
 * @param integer $oldversion
 * @return boolean
 */
function xmldb_vimeo_upgrade($oldversion) {
    if ($oldversion) {
        return(true);
    } else {
        return(true);
    }
}