<?php
/*  Copyright 2016 Dai Fujihara  (email : daipresents[at]gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define("RAIRA_DEBUG", true);

function debug($message) {
  if (RAIRA_DEBUG) {
    echo $message . "<br>";
  }
}

function debug_obj($obj) {
  if (RAIRA_DEBUG) {
    echo "<pre>" . var_dump($obj) . "</pre>";
  }
}

function get_start_time() {
  if (RAIRA_DEBUG) {
    return microtime(true);
  }
}

function display_performance_time($start) {
  if (RAIRA_DEBUG) {
    echo microtime(true) - $start . "sec";
  }
}

?>
