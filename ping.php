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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package mod_vimeo
 * @author Bruno Magalhães <brunomagalhaes@blackbean.com.br>
 * @copyright 2018 by BlackBean Inc, all rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html
 */
define('AJAX_SCRIPT', true);

/**
 * Loading all libraries, classes
 * and functions required by this
 * class execution.
 */
require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');
require_once(__DIR__.'/locallib.php');
require_once(__DIR__.'/../../lib/completionlib.php');

/**
 * This user needs to be
 * authenticated before
 * viewing this video.
 */
require_login();

/**
 * Capturing the supplied identifier
 * to load this Vimeo video instance.
 */
$courseid = required_param('courseid', PARAM_INT);
$videoid = required_param('videoid', PARAM_INT);
$userid = required_param('userid', PARAM_INT);
$value = required_param('value', PARAM_INT);

if ($video = vimeo_fetch_video($videoid)) {

    vimeo_save_progress($userid, $videoid, $value);

    if ($video->completionenable == true and
        $video->completionprogress <= $value) {
        $module = get_coursemodule_from_instance('vimeo', $videoid, 0, false, MUST_EXIST);
        $course = $DB->get_record('course', ['id' => $module->course], '*', MUST_EXIST);
        $completion = new completion_info($course);
        $completion->update_state($module, COMPLETION_COMPLETE);
    }

    header('HTTP/1.0 200 OK');
    header('Content-Type: application/json; charset=UTF-8');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    header('Pragma: no-cache');
    header('Expires: 0');
    print('{"result":true}');
    exit(0);
}

header('HTTP/1.0 404 Not Found');
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');
header('Expires: 0');
print('{"result":false}');
exit(0);
