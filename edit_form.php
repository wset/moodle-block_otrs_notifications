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

require_once( $CFG->dirroot . "/blocks/otrs_notifications/lib.php" );
/**
 * Form for editing HTML block instances.
 *
 * @package   block_otrs_notifications
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Form for editing HTML block instances.
 *
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_otrs_notifications_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG, $DB, $COURSE;

        // Get options for course and quiz completion notifications.
        $block = $this->block;
        otrs_notifications::initialise_config( $block );
        
        // Fields course completion and quiz notifications.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('checkbox', 'config_coursenotify', get_string('coursenotify', 'block_otrs_notifications'));
        $mform->setDefault('config_coursenotify', $block->config->config_coursenotify);
        
        $availablequizes = otrs_notifications::get_quizes();
        $quizselect = $mform->addElement('select', 'config_selectedquizes', get_string('selectquizes', 'block_otrs_notifications'), $availablequizes);
        $quizselect->setMultiple(true);
        $mform->setDefault('config_selectedquizes', $block->config->config_selectedquizes);
         

    }

/*    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {
            $text = $this->block->config->text;
            $draftid_editor = file_get_submitted_draft_itemid('config_text');
            if (empty($text)) {
                $currenttext = '';
            } else {
                $currenttext = $text;
            }
            $defaults->config_text['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_otrs_notifications', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_text['itemid'] = $draftid_editor;
            $defaults->config_text['format'] = $this->block->config->format;
        } else {
            $text = '';
        }

        if (!$this->block->user_can_edit() && !empty($this->block->config->title)) {
            // If a title has been set but the user cannot edit it format it nicely
            $title = $this->block->config->title;
            $defaults->config_title = format_string($title, true, $this->page->context);
            // Remove the title from the config so that parent::set_data doesn't set it.
            unset($this->block->config->title);
        }

        // have to delete text here, otherwise parent::set_data will empty content
        // of editor
        unset($this->block->config->text);
        parent::set_data($defaults);
        // restore $text
        if (!isset($this->block->config)) {
            $this->block->config = new stdClass();
        }
        $this->block->config->text = $text;
        if (isset($title)) {
            // Reset the preserved title
            $this->block->config->title = $title;
        }
    } */
}
