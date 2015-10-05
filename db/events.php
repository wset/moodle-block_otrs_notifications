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
 * Add event handlers for the quiz
 *
 * @package    mod_quiz
 * @category   event
 * @copyright  2011 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

$handlers = array(

    // Handle group events, so that open quiz attempts with group overrides get updated check times.
    'quiz_attempt_submitted' => array(
        'handlerfile' => '/blocks/otrs_notifications/locallib.php',
        'handlerfunction' => 'block_otrs_notifications_quiz_attempt_submitted',
        'schedule' => 'instant',
        'internal' => 1,
    ),
    'course_completed' => array(
        'handlerfile' => '/blocks/otrs_notifications/locallib.php',
        'handlerfunction' => 'block_otrs_notifications_course_completed',
        'schedule' => 'instant',
        'internal' => 1,
    )
);
