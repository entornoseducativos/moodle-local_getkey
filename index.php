<?php
// This file is part of Moodle - http://vidyamantra.com/
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
 * Authentication key
 *
 * @package    local
 * @subpackage get_key
 * @copyright  2014 Pinky Sharma
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('key_form.php');

$k = optional_param('k', 0, PARAM_NOTAGS);

require_login();
require_capability('moodle/site:config', context_system::instance());
admin_externalpage_setup('getkey');

$PAGE->set_url(new moodle_url('/local/getkey/index.php'));


$mform = new local_getkey_key_form(null, array('email'=>$USER->email, 'firstname'=>$USER->firstname , 'lastname'=>$USER->lastname ,'domain'=>$CFG->wwwroot));  

if ($mform->is_cancelled()) {
	//redirect($returnurl);
} else if ($fromform = $mform->get_data()) {
	//redirect($nexturl);
}


echo $OUTPUT->header();


if($DB->record_exists('config_plugins', array ('plugin' => 'local_getkey', 'name' => 'keyvalue')) ){
	$result= $DB->get_field('config_plugins', 'value', array ('plugin' => 'local_getkey', 'name' => 'keyvalue'), $strictness=IGNORE_MISSING);
	echo $OUTPUT->heading(get_string('keyis', 'local_getkey').$result, 3, 'box generalbox', 'jpoutput');;	
}elseif($k){
	//echo $key;
	
	
	$record = new stdClass();
	$record->plugin         = 'local_getkey';
	$record->name = 'keyvalue';
	$record->value = $k;
	$DB->insert_record('config_plugins',$record);
	echo $OUTPUT->heading(get_string('keyis', 'local_getkey').$k, 3, 'box generalbox', 'jpoutput');
}else{

	$jsmodule = array(
                'name' => 'local_getkey',
                'fullpath' => '/local/getkey/module.js',
                'requires' => array('json','jsonp', 'jsonp-url', 'io-base','node','io-form')); //on this line you are loading three other YUI modules
   $PAGE->requires->js_init_call('M.local_getkey.init',null, false, $jsmodule);
   $PAGE->requires->string_for_js('keyis', 'local_getkey');



	echo $OUTPUT->box(get_string('message','local_getkey'), "generalbox center clearfix");
	$mform->display();
}


echo $OUTPUT->footer();


