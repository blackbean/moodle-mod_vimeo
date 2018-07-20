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

// Defining this plug-in metadata.
$plugin->component = 'mod_vimeo';
$plugin->release = '1.0.0';
$plugin->version = 2018050100;
$plugin->maturity = MATURITY_BETA;
$plugin->requires = 2016052311;
$plugin->dependencies = [];
$plugin->cron = 0;