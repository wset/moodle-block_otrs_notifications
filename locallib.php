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

defined('MOODLE_INTERNAL') || die();

function block_otrs_notifications_get_block_info($courseid) {
    global $DB;

    // get the course context.
    $coursecontext = context_course::instance($courseid);
    if (!$notifications = $DB->get_record('block_instances', array('blockname' => 'otrs_notifications', 'parentcontextid' => $coursecontext->id))) {
        return false;
    } else {
        $notifications->config = unserialize(base64_decode($notifications->configdata));
        return $notifications;
    }
}

/**
 * A course reset has ended.
 *
 * @param \core\event\base $event The event.
 * @return void
 */
function block_otrs_notifications_course_completed($event) {
    global $DB, $CFG;
    // Does this block exist in this course?
    if ($block = block_otrs_notifications_get_block_info($event->course)) {
        if (!empty($block->config->coursenotify)) {
            require_once( $CFG->dirroot.'/blocks/otrs/otrsgenericinterface.class.php' );
            require_once( $CFG->dirroot.'/blocks/otrs/otrslib.class.php' );

            $user = $DB->get_record('user', array('id' => $event->userid));
            $course = $DB->get_record('course', array('id' => $event->course));
            // create a ticket in OTRS
            $subject = 'User ' . $user->firstname . ' ' . $user->lastname . '(' . $user->username . ') completed course ' . $course->fullname;
            $message = 'User ' . $user->firstname . ' ' . $user->lastname . '(' . $user->username . ') has completed the course ' . $course->fullname;
        
            // update user record on OTRS.
            otrslib::userupdate($event);
        
            $otrssoap = new otrsgenericinterface();
            $Ticket = $otrssoap->TicketCreate( $user->username, $subject, $message, get_config('block_otrs','completion_queue'), 'system', 'note-report');
        }
    }
}

/**
 * An attempt was submitted.
 *
 * @param \core\event\base $event The event.
 * @return void
 */
function block_otrs_notifications_quiz_attempt_submitted($event) {
    global $DB, $CFG;

   // Does this block exist in this course?
    if ($block = block_otrs_notifications_get_block_info($event->courseid)) {
        if (!empty($block->config->selectedquizes)) {
            if (in_array($event->quizid, $block->config->selectedquizes)) {
                require_once( $CFG->dirroot.'/blocks/otrs/otrsgenericinterface.class.php' );
                require_once( $CFG->dirroot.'/blocks/otrs/otrslib.class.php' );
    
                $user = $DB->get_record('user', array('id' => $event->userid));
                $course = $DB->get_record('course', array('id' => $event->courseid));
                $quiz = $DB->get_record('quiz', array('id' => $event->quizid));
                $attempt = $DB->get_record('quiz_attempts', array('id' => $event->attemptid));
                $usergrade = $attempt->sumgrades / $quiz->sumgrades * $quiz->grade;
                $result = strip_tags($DB->get_field_sql("SELECT feedbacktext FROM {quiz_feedback}
                                              WHERE
                                              quizid = :quizid
                                              AND
                                              mingrade <= :mingrade
                                              AND
                                              :maxgrade <= maxgrade",
                                              array('quizid' => $quiz->id, 'mingrade' => $usergrade, 'maxgrade' => $usergrade)));

                // create a ticket in OTRS
                $subject = 'User ' . $user->firstname . ' ' . $user->lastname . '(' . $user->username . ') attempted quiz ' . $quiz->name;
                $message = 'User ' . $user->firstname . ' ' . $user->lastname . '(' . $user->username . ') in the course ' . $course->fullname;
                $message = ' with the result of ' . $result;
            
            
                // update user record on OTRS.
                otrslib::userupdate($event);
            
                $otrssoap = new otrsgenericinterface();
                $Ticket = $otrssoap->TicketCreate( $user->username, $subject, $message, get_config('block_otrs','quiz_queue'), 'system', 'note-report', 'text/html', 3, $dfields);
            }
        }
    }
}
