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
 * Version details
 *
 * @package    block_otrs_notifications
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2015101904;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014051200;        // Requires Moodle 2.7
$plugin->component = 'block_otrs_notifications';      // Full name of the plugin (used for diagnostics)
$plugin->dependencies = array(
    'block_otrs' => 2015101900,
);
$plugin->release   = '2.0 for Moodle 2.7+ and OTRS v4.0+';
