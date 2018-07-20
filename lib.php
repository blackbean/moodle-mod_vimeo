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
 * @param string $feature
 * @return boolean
 */
function vimeo_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_INTRO: return true;
        case FEATURE_SHOW_DESCRIPTION: return true;
        case FEATURE_COMPLETION_HAS_RULES: return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return true;
        default: return false;
    }
}

/**
 * Given a course_module object, this function returns any
 * extra information that may be needed when printing this
 * activity in a course listing.
 * 
 * @param integer $coursemodule
 * @return cached_cm_info
 */
function vimeo_get_coursemodule_info(stdclass $coursemodule) {

    /**
     * Loading all libraries, classes
     * and functions required by this
     * function execution.
     */
    require_once(__DIR__.'/locallib.php');

    /**
     * 
     */
    if ($video = vimeo_fetch_video($coursemodule->instance)) {
        /**
         * 
         */
        $info = new cached_cm_info();
        $info->name = $video->name;

        /**
         * 
         */
        if ($video->popupopen) {
            $video->popupwidth = ($video->popupwidth > 0) ? $video->popupwidth : 640;
            $video->popupheight = ($video->popupheight > 0) ? $video->popupheight : 360;
            $info->onclick = "window.open('/mod/vimeo/view.php?id=".$coursemodule->id."&popup=1','_blank',".
                             "'top=' + (window.top.outerHeight / 2 + window.top.screenY - ( ".$video->popupheight." / 2)) + ',".
                             "left=' + (window.top.outerWidth / 2 + window.top.screenX - ( ".$video->popupwidth." / 2)) + ',".
                             "width=".$video->popupwidth.",height=".$video->popupheight.",toolbar=no,location=no,menubar=no,".
                             "copyhistory=no,status=no,directories=no,scrollbars=yes,resizable=yes'); return false;";
        }

        /**
         * 
         */
        if ($coursemodule->showdescription) {
            $info->content = format_module_intro('vimeo', $video, $coursemodule->id, false);
        }

        /**
         * 
         */
        if ($coursemodule->completion == COMPLETION_TRACKING_AUTOMATIC) {
            $info->customdata['customcompletionrules']['completionprogress'] = $video->completionprogress;
        }

        /**
         * 
         */
        return($info);
    }

    /**
     * 
     */
    return(null);
}

/**
 * Saves a new instance of the
 * Vimeo video into the database.
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param stdclass $video
 * @param mod_vimeo_mod_form $form
 * @return integer
 */
function vimeo_add_instance(stdclass $video, mod_vimeo_mod_form $form = null) {
    /**
     * Loading all libraries, classes
     * and functions required by this
     * function execution.
     */
    require_once(__DIR__.'/locallib.php');

    /**
     * Trying to insert the supplied object
     * into the database and, if successful,
     * returning the generated identifier.
     */
    if (vimeo_insert_video($video)) {
        /**
         * Rebuilding this course cache.
         */
        rebuild_course_cache($video->course, true);

        /**
         * Returning the generated
         * object identifier value
         * as this function result.
         */
        return($video->id);
    }

    /**
     * Because we were unable to execute this
     * operation successfully, returning a zero
     * integer value as this function result.
     */
    return(0);
}

/**
 * Updates an instance of the
 * Vimeo video into the database.
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param stdclass $video
 * @param mod_vimeo_mod_form $form
 * @return boolean
 */
function vimeo_update_instance(stdclass $video, mod_vimeo_mod_form $form = null) {
    /**
     * Loading all libraries, classes
     * and functions required by this
     * function execution.
     */
    require_once(__DIR__.'/locallib.php');

    /**
     * Trying to update the supplied object
     * into the database and, if successful,
     * returning a true boolean as result.
     */
    if (vimeo_update_video($video)) {
        /**
         * Rebuilding this course cache.
         */
        rebuild_course_cache($video->course, true);

        /**
         * Returning a true boolean
         * as this function result.
         */
        return(true);
    }

    /**
     * Because we were unable to execute this
     * operation successfully, returning a false
     * boolean value as this function result.
     */
    return(false);
}

/**
 * Removes an instance of the
 * Vimeo video from the database.
 *
 * Given an id of an instance of this module,
 * this function will permanently delete the
 * instance and any data that depends on it.
 *
 * @param integer $id
 * @return boolean
 */
function vimeo_delete_instance($id) {
    /**
     * Loading all libraries, classes
     * and functions required by this
     * function execution.
     */
    require_once(__DIR__.'/locallib.php');

    /**
     * Trying to load the requested object
     * from the database and, if successful,
     * trying to delete it from the database.
     */
    if ($video = vimeo_fetch_video($id)) {
        /**
         * Trying to delete the requested object
         * from the database and, if successful,
         * returning a true boolean as result.
         */
        if (vimeo_delete_video($video)) {
            /**
             * Rebuilding this course cache.
             */
            rebuild_course_cache($video->course, true);

            /**
             * Returning a true boolean
             * as this function result.
             */
            return(true);
        }
    }

    /**
     * Because we were unable to execute this
     * operation successfully, returning a false
     * boolean value as this function result.
     */
    return(false);
}

/**
 * This standard function will check all instances of this
 * module and make sure there are up-to-date events created
 * for each of them. If courseid equals to zero, then every
 * Vimeo event in the site is checked, else only Vimeo events
 * belonging to the course specified are checked. This is only
 * required if the module is generating calendar events.
 *
 * @param integer $courseid
 * @return boolean
 */
function vimeo_refresh_events($courseid) {
    /**
     * Because we don't have any related
     * events returning a true boolean
     * value as this function result.
     */
    return(true);
}

/**
 * Obtains the automatic completion state
 * for this video based on any conditions
 * in Vimeo settings.
 *
 * @param object $course
 * @param object $module
 * @param integer $userid
 * @param boolean $type
 * @return boolean
 */
function vimeo_get_completion_state($course, $module, $userid, $type) {
    /**
     * Loading all libraries, classes
     * and functions required by this
     * function execution.
     */
    require_once(__DIR__.'/locallib.php');

    /**
     * Loading the required video to
     * check for the completion rule.
     */
    if ($video = vimeo_fetch_video($module->instance)) {
        /**
         * If the completion rule is enabled, loading
         * this user's watch progress to compare the
         * completion threshold with the user's.
         */
        if ($video->completionenable == true) {
            /**
             * 
             */
            if ($progress = vimeo_fetch_progress($userid, $video->id)) {
                /**
                 * 
                 */
                if ($progress->progress >= $video->completionprogress) {
                    return(true);
                } else {
                    return(false);
                }
            }
        }
    }

    /**
     * 
     */
    return($type);
 }

/**
 * Returns a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 *
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @param stdclass $course The course record
 * @param stdclass $user The user record
 * @param cm_info|stdclass $mod The course module info object or record
 * @param stdclass $video The Vimeo instance record
 * @return stdclass|null
 */
function vimeo_user_outline($course, $user, $mod, $video) {
    $return = new stdclass();
    $return->time = 0;
    $return->info = '';
    return $return;
}

/**
 * Prints a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * It is supposed to echo directly without returning a value.
 *
 * @param stdclass $course the current course record
 * @param stdclass $user the record of the user we are generating report for
 * @param cm_info $mod course module info
 * @param stdclass $video the module instance record
 */
function vimeo_user_complete($course, $user, $mod, $video) {
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in Vimeo activities and print it out.
 *
 * @param stdclass $course The course record
 * @param boolean $viewfullnames Should we disautoplay full names
 * @param integer $timestart Print activity since this timestamp
 * @return boolean True if anything was printed, otherwise false
 */
function vimeo_print_recent_activity($course, $viewfullnames, $timestart) {
    return false;
}

/**
 * Prepares the recent activity data
 *
 * This callback function is supposed to populate the passed array with
 * custom activity records. These records are then rendered into HTML via
 * {@link vimeo_print_recent_mod_activity()}.
 *
 * Returns void, it adds items into $activities and increases $index.
 *
 * @param array $activities sequentially indexed array of objects with added 'cmid' property
 * @param integer $index the index in the $activities to use for the next record
 * @param integer $timestart append activity since this time
 * @param integer $courseid the id of the course we produce the report for
 * @param integer $moduleid course module id
 * @param integer $userid check for a particular user's activity only, defaults to 0 (all users)
 * @param integer $groupid check for a particular group's activity only, defaults to 0 (all groups)
 */
function vimeo_get_recent_mod_activity(&$activities, &$index, $timestart, $courseid, $moduleid, $userid = 0, $groupid = 0) {
}

/**
 * Prints single activity item prepared by {@link vimeo_get_recent_mod_activity()}
 *
 * @param stdclass $activity activity record with added 'cmid' property
 * @param integer $courseid the id of the course we produce the report for
 * @param boolean $detail print detailed report
 * @param array $modnames as returned by {@link get_module_types_names()}
 * @param boolean $viewfullnames disautoplay users' full names
 */
function vimeo_print_recent_mod_activity($activity, $courseid, $detail, $modnames, $viewfullnames) {
}

/**
 * Returns all other caps used in this
 * Vimeo module. In our case, we don't
 * use any aditional capabilities.
 *
 * @return array
 */
function vimeo_get_extra_capabilities() {
    /**
     * Because we don't use any aditional
     * capabilities, returning an empty
     * array as this function result.
     */
    return([]);
}

/**
 * Function to be run periodically according
 * to the moodle cron, and searches for things
 * that need to be done, if any, such as sending
 * out emails, toggling flags, etc...
 *
 * @return boolean
 */
function vimeo_cron() {
    /**
     * Because we don't have any related
     * tasks, returning a false boolean
     * value as this function result.
     */
    return(false);
}

/**
 * Is a given scale used by the instance
 * of Vimeo video? This function returns
 * a boolean true of false if this plugin
 * has support for grading and scales.
 *
 * @param integer $videoid
 * @param integer $scaleid
 * @return boolean
 */
function vimeo_scale_used($videoid, $scaleid) {
    /**
     * Because we don't have any related
     * scales, returning a false boolean
     * value as this function result.
     */
    return(false);
}

/**
 * Checks if scale is being used by any
 * instance of Vimeo video. This is used
 * to find out if scale used anywhere.
 *
 * @param integer $scaleid
 * @return boolean
 */
function vimeo_scale_used_anywhere($scaleid) {
    /**
     * Because we don't have any related
     * scales, returning a false boolean
     * value as this function result.
     */
    return(false);
}

/**
 * Updates grade item for given vimeo
 * video instance within the database.
 *
 * @param stdclass $video
 * @param integer $userid
 */
function vimeo_update_grades(stdclass $video, $userid = 0) {
    /**
     * Because we don't have any related
     * grades, returning a false boolean
     * value as this function result.
     */
    return(false);
}

/**
 * Creates or updates grade item
 * for given Vimeo video instance
 * within the database.
 *
 * @param stdclass $video
 * @param boolean $reset
 * @return boolean
 */
function vimeo_grade_item_update(stdclass $video, $reset = false) {
    /**
     * Because we don't have any related
     * grades, returning a false boolean
     * value as this function result.
     */
    return(false);
}

/**
 * Deletes grade item for given vimeo
 * video instance from the database.
 *
 * @param stdclass $video
 * @return boolean
 */
function vimeo_grade_item_delete(stdclass $video) {
    /**
     * Because we don't have any related
     * grades, returning a false boolean
     * value as this function result.
     */
    return(false);
}