<?php
// @codingStandardsIgnoreFile
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
 * Steps definitions for behat theme.
 *
 * @package   local_xray
 * @category  test
 * @copyright Copyright (c) 2015 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Gherkin\Node\TableNode as TableNode;
use Behat\Mink\Exception\ExpectationException as ExpectationException;

/**
 * Behat Local Xray
 *
 * @package   local_xray
 * @category  test
 * @copyright Copyright (c) 2015 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class bbase_local_xray extends behat_base {


    public $courseshortname = '';

    /**
     * Create an express design based on an express template.
     *
     * @Given /^I use express template "(?P<username_string>(?:[^"]|\\")*)" for xray$/
     * @param string $template
     * @return void
     */
    public function i_use_express_template_for_xray($template) {
        global $CFG;

        $plugins = \core_plugin_manager::instance()->get_enabled_plugins('block');

        if (!in_array('express', $plugins)) {
            return;
        }

        require_once("$CFG->dirroot/blocks/express/model/design.php");

        // Create express paths.
        make_upload_directory('express');
        make_upload_directory('express/tmp');

        // Add design at site context.
        $contextcourse = context_course::instance(SITEID);
        $parentcontextid = $contextcourse->id;
        $design = new block_express_model_design($parentcontextid);
        $data = new stdClass();
        $data->name = 'xrayheadlintest';
        $data->template = $template;
        $data->variant  = 'green';
        $data->iconpack  = 'serene';
        $data->resetimages = 0;
        $data->roundedcorners = 0;
        $data->hideui = 0;
        $data->analyticcode = '';
        $data->customcss = '';
        $design->create($data);
        $design->save($data);
    }

    /**
     * Allow guest access in course
     *
     * @Given /^I allow guest access for xray in course "(?P<shortname_string>(?:[^"]|\\")*)"$/
     * @param string $shortname
     * @return void
     * @throws ExpectationException
     */
    public function i_allow_guest_access_for_xray_in_course($shortname) {
        global $DB;
        $session = $this->getSession();
        // Get course id.
        $courseid = $DB->get_field('course', 'id', array('shortname' => $shortname));
        if (!$courseid) {
            throw new ExpectationException('The course with shortname '.$shortname.' does not exist', $session);
        }
        // Get enrol id for guest user.
        $enrolid = $DB->get_field('enrol', 'id', array('enrol' => 'guest', 'courseid' => $courseid));
        if (!$enrolid) {
            throw new ExpectationException('The course with courseid '.$courseid.' has not guest enrollment', $session);
        }
        // Add status 0 for guest user.
        $record = new stdClass();
        $record->id = $enrolid;
        $record->status = 0;
        $DB->update_record('enrol', $record);
    }

    /**
     * Test Headline.
     *
     * @Given /^I test Headline view "(?P<shortname_string>(?:[^"]|\\")*)"$/
     * @param string $shortname
     * @param TableNode $pages
     * @return void
     */
    public function i_test_headline_view($shortname, TableNode $pages) {
        /** @var behat_admin $admincontext */
        $admincontext = behat_context_helper::get('behat_admin');
        $this->courseshortname = $shortname;
        // Get themes and the course format for each one.
        $themes = array();
        $templates = array();
        foreach ($pages->getHash() as $elementdata) {
            if ($elementdata['type'] == 'template') {
                $templates[$elementdata['theme']] = explode(',', $elementdata['formats']);
            } else {
                $themes[$elementdata['theme']] = explode(',', $elementdata['formats']);
            }
        }
        // Test themes.
        foreach ($themes as $theme => $formats) {
            $this->local_xray_test_headline_themes($theme, $formats, $shortname);
        }

        // Test express theme only when present.
        $plugins = \core_plugin_manager::instance()->get_installed_plugins('theme');
        if (in_array('express', $plugins)) {
            // Test express templates.
            // Add express template.
            if (get_config('core', 'theme') != 'express') {
                $table = new \Behat\Gherkin\Node\TableNode([['theme', 'express']]);
                $admincontext->the_following_config_values_are_set_as_admin($table);
            }
            foreach ($templates as $template => $formats) {
                $this->local_xray_test_headline_themes($template, $formats, $shortname, true);
            }
        }

    }

    /**
     * @param $theme
     * @param $formats
     * @param $shortname
     * @param bool|false $template
     * @return void
     */
    private function local_xray_test_headline_themes($theme, $formats, $shortname, $template = false) {
        /** @var behat_general $generalcontext */
        $generalcontext = behat_context_helper::get('behat_general');
        /** @var behat_admin $admincontext */
        $admincontext = behat_context_helper::get('behat_admin');

        if ($template) {
            // Express theme should be activated for this option.
            $this->i_use_express_template_for_xray($theme);
        } else {
            // Add theme.
            $table = new \Behat\Gherkin\Node\TableNode([['theme', $theme]]);
            $admincontext->the_following_config_values_are_set_as_admin($table);
        }

        // Tests formats.
        foreach ($formats as $format) {
            $this->i_set_course_format_in_course_for_xray($format, $shortname);
            $generalcontext->reload();
            $generalcontext->wait_until_the_page_is_ready();
            $this->headline_elements(true);
            // Test headline in flexpages.
            if ($theme == 'express' && $format == 'flexpage') {
                $this->add_flexpage();
                $this->headline_elements(true);
            }
        }
    }

    /**
     * Add a Flexpage
     */
    private function add_flexpage () {
        /** @var behat_general $generalcontext */
        $generalcontext = behat_context_helper::get('behat_general');
        /** @var behat_forms $behatformscontext */
        $behatformscontext = behat_context_helper::get('behat_forms');

        $generalcontext->click_link("Turn editing on");
        $generalcontext->wait_until_the_page_is_ready();
        $generalcontext->i_click_on('a[href^="/course/format/flexpage/view.php?controller=ajax&action=addpages&"]', "css_element");
        $generalcontext->i_wait_seconds(3);
        $behatformscontext->i_set_the_field_to("name[]", "Xray Flexpage 01");
        $behatformscontext->press_button("Add flexpages");
        $generalcontext->wait_until_the_page_is_ready();
        $generalcontext->i_click_on("a#format_flexpage_next_page-button", "css_element");
        $generalcontext->wait_until_the_page_is_ready();
    }

    /**
     * See all Headline Elements
     *
     * @param bool $positive
     */
    private function headline_elements ($positive) {
        /** @var behat_general $generalcontext */
        $generalcontext = behat_context_helper::get('behat_general');
        if ($positive) {// Test headline is present.
            $generalcontext->should_exist("#xray-nav-headline", "css_element");
            $generalcontext->should_exist("img.x-ray-icon-title", "css_element");
            $generalcontext->should_exist("#xray-headline-risk p.xray-headline-number", "css_element");
            $generalcontext->should_exist("#xray-headline-activity p.xray-headline-number", "css_element");
            $generalcontext->should_exist("#xray-headline-gradebook p.xray-headline-number", "css_element");
            $generalcontext->should_exist("#xray-headline-discussion p.xray-headline-number", "css_element");
        } else { // Test headline is not present.
            $generalcontext->should_not_exist("#xray-nav-headline", "css_element");
            $generalcontext->should_not_exist("img.x-ray-icon-title", "css_element");
            $generalcontext->should_not_exist("#xray-headline-risk p.xray-headline-number", "css_element");
            $generalcontext->should_not_exist("#xray-headline-activity p.xray-headline-number", "css_element");
            $generalcontext->should_not_exist("#xray-headline-gradebook p.xray-headline-number", "css_element");
            $generalcontext->should_not_exist("#xray-headline-discussion p.xray-headline-number", "css_element");
        }
    }

    /**
     * Change course format.
     *
     * @Given /^I set course format "(?P<format_string>(?:[^"]|\\")*)" in course "(?P<shortname_string>(?:[^"]|\\")*)" for xray$/
     * @param  string $format
     * @param  string $shortname
     * @return void
     * @throws ExpectationException
     */
    public function i_set_course_format_in_course_for_xray($format, $shortname) {
        global $DB;
        $session = $this->getSession();
        // Get course id.
        $courseid = $DB->get_field('course', 'id', array('shortname' => $shortname));
        if (!$courseid) {
            throw new ExpectationException('The course with shortname '.$shortname.' does not exist', $session);
        }
        // Add format.
        $record = new stdClass();
        $record->id = $courseid;
        $record->format = $format;
        $DB->update_record('course', $record);
    }

    /**
     * Test the info message when the email feature are turned off.
     *
     * @Given /^Xray email alerts are turned off$/
     * @return void
     */
    public function xray_email_alerts_are_turned_off() {
        /** @var behat_admin $admincontext */
        $admincontext = behat_context_helper::get('behat_admin');
        /** @var behat_general $generalcontext */
        $generalcontext = behat_context_helper::get('behat_general');

        $table = new \Behat\Gherkin\Node\TableNode([['emailfrequency', 'weekly', 'local_xray']]);
        $admincontext->the_following_config_values_are_set_as_admin($table);
        $generalcontext->reload();
        $generalcontext->should_not_exist('.alert.alert-info', 'css_element');
        $generalcontext->assert_page_not_contains_text(get_string('emailsdisabled', 'local_xray'));
        $table = new \Behat\Gherkin\Node\TableNode([['emailfrequency', 'never', 'local_xray']]);
        $admincontext->the_following_config_values_are_set_as_admin($table);
        $generalcontext->reload();
        $generalcontext->should_exist('.alert.alert-info', 'css_element');
        $generalcontext->assert_page_contains_text(get_string('emailsdisabled', 'local_xray'));
        $table = new \Behat\Gherkin\Node\TableNode([['emailfrequency', 'daily', 'local_xray']]);
        $admincontext->the_following_config_values_are_set_as_admin($table);
        $generalcontext->reload();
        $generalcontext->should_not_exist('.alert.alert-info', 'css_element');
        $generalcontext->assert_page_not_contains_text(get_string('emailsdisabled', 'local_xray'));
    }

    /**
     * Change Global Subscription
     *
     * @Given /^Global subscription type is changed to "(?P<type_string>(?:[^"]|\\")*)" by "(?P<username_string>(?:[^"]|\\")*)"$/
     * @param string $type courselevel/all/none
     * @param string $username
     * @return void
     * @throws ExpectationException
     */
    public function xray_global_subscription($type, $username) {
        global $DB;
        $session = $this->getSession();

        if ($userid = $DB->get_field('user', 'id', array('username' => $username), IGNORE_MULTIPLE)) {
            switch ($type) {
                case "courselevel":
                    $type = 0;
                    break;
                case "all":
                    $type = 1;
                    break;
                case "none":
                    $type = 2;
                    break;
                default:
                    throw new ExpectationException('Invalid type '.$type, $session);
            }

            $data = new stdClass();
            $data->userid = $userid;
            $data->type = $type;
            if ($currentvalue = $DB->get_record('local_xray_globalsub', array('userid' => $userid), 'id, type', IGNORE_MULTIPLE)) {
                $data->id = $currentvalue->id;
                $DB->update_record('local_xray_globalsub', $data);
            } else {
                $DB->insert_record('local_xray_globalsub', $data);
            }
        } else {
            throw new ExpectationException("The username ".$username." doesn't exist", $session);
        }
    }

}

// Missing elements in pre Moodle 3.2.
trait local_xray_29 {

    /**
     * Finds a node in the Navigation or Administration tree and clicks on it.
     *
     * @param string $nodetext
     * @param array $parentnodes
     * @throws ExpectationException
     */
    protected function select_node_in_navigation($nodetext, $parentnodes) {
        $nodetoclick = $this->find_node_in_navigation($nodetext, $parentnodes);
        // Throw exception if no node found.
        if (!$nodetoclick) {
            throw new ExpectationException('Navigation node "' . $nodetext . '" not found under "' .
                implode($parentnodes, ' > ') . '"', $this->getSession());
        }

        $nodetoclick->click();
    }

    /**
     * Helper function to get top navigation node in tree.
     *
     * TODO: add missing behat_context_helper::escape .
     *
     * @throws ExpectationException if note not found.
     * @param string $nodetext name of top navigation node in tree.
     * @return NodeElement
     */
    protected function get_top_navigation_node($nodetext) {

        // Avoid problems with quotes.
        $nodetextliteral = behat_context_helper::escape($nodetext);
        $exception = new ExpectationException('Top navigation node "' . $nodetext . ' not found in "', $this->getSession());

        // First find in navigation block.
        $xpath = "//div[contains(concat(' ', normalize-space(@class), ' '), ' content ')]" .
            "/ul[contains(concat(' ', normalize-space(@class), ' '), ' block_tree ')]" .
            "/li[contains(concat(' ', normalize-space(@class), ' '), ' contains_branch ')]" .
            "/ul/li[contains(concat(' ', normalize-space(@class), ' '), ' contains_branch ')]" .
            "[p[contains(concat(' ', normalize-space(@class), ' '), ' branch ')]" .
            "[span[normalize-space(.)=" . $nodetextliteral ."] or a[normalize-space(.)=" . $nodetextliteral ."]]]" .
            "|" .
            "//div[contains(concat(' ', normalize-space(@class), ' '), ' content ')]/div" .
            "/ul[contains(concat(' ', normalize-space(@class), ' '), ' block_tree ')]" .
            "/li[contains(concat(' ', normalize-space(@class), ' '), ' contains_branch ')]" .
            "/ul/li[contains(concat(' ', normalize-space(@class), ' '), ' contains_branch ')]" .
            "[p[contains(concat(' ', normalize-space(@class), ' '), ' branch ')]" .
            "/span[normalize-space(.)=" . $nodetextliteral ."]]" .
            "|" .
            "//div[contains(concat(' ', normalize-space(@class), ' '), ' content ')]/div" .
            "/ul[contains(concat(' ', normalize-space(@class), ' '), ' block_tree ')]" .
            "/li[p[contains(concat(' ', normalize-space(@class), ' '), ' branch ')]" .
            "/span[normalize-space(.)=" . $nodetextliteral ."]]" .
            "|" .
            "//div[contains(concat(' ', normalize-space(@class), ' '), ' content ')]/div" .
            "/ul[contains(concat(' ', normalize-space(@class), ' '), ' block_tree ')]" .
            "/li[p[contains(concat(' ', normalize-space(@class), ' '), ' branch ')]" .
            "/a[normalize-space(.)=" . $nodetextliteral ."]]";

        $node = $this->find('xpath', $xpath, $exception);

        return $node;
    }

    /**
     * Returns the steps list to add a new discussion to a forum.
     *
     * Abstracts add a new topic and add a new discussion, as depending
     * on the forum type the button string changes.
     *
     * @param string $forumname
     * @param TableNode $table
     * @param string $buttonstr
     */
    protected function add_new_discussion($forumname, TableNode $table, $buttonstr) {

        // Navigate to forum.
        $this->execute('behat_general::click_link', $this->escape($forumname));
        $this->execute('behat_forms::press_button', $buttonstr);

        if ($this->running_javascript()) {
            $this->i_follow_href(get_string('useadvancededitor', 'hsuforum'));
        }

        // Fill form and post.
        $this->execute('behat_forms::i_set_the_following_fields_to_these_values', $table);
        $this->execute('behat_forms::press_button', get_string('posttoforum', 'hsuforum'));
        $this->execute('behat_general::i_wait_to_be_redirected');
    }

    /**
     * Adds a discussion to the forum specified by it's name with the provided table data (usually Subject and Message). The step begins from the forum's course page.
     *
     * @Given /^I add a new discussion to "(?P<hsuforum_name_string>(?:[^"]|\\")*)" Moodlerooms forum with:$/
     * @param string $forumname
     * @param TableNode $table
     */
    public function i_add_a_forum_discussion_to_forum_with($forumname, TableNode $table) {
        $this->add_new_discussion($forumname, $table, get_string('addanewtopic', 'hsuforum'));
    }

    /**
     * Go to current page setting item
     *
     * This can be used on front page, course, category or modules pages.
     *
     * @Given /^I navigate to "(?P<nodetext_string>(?:[^"]|\\")*)" in current page administration$/
     *
     * @throws ExpectationException
     * @param string $nodetext navigation node to click, may contain path, for example "Reports > Overview"
     * @return void
     */
    public function i_navigate_to_in_current_page_administration($nodetext) {
        $parentnodes = array_map('trim', explode('>', $nodetext));
        // Find the name of the first category of the administration block tree.
        $xpath = '//div[contains(@class,\'block_settings\')]//div[@id=\'settingsnav\']/ul/li[1]/p[1]/span';
        $node = $this->find('xpath', $xpath);
        array_unshift($parentnodes, $node->getText());
        $lastnode = array_pop($parentnodes);
        $this->select_node_in_navigation($lastnode, $parentnodes);
    }

    /**
     * Checks that current page administration contains text
     *
     * @Given /^"(?P<element_string>(?:[^"]|\\")*)" "(?P<selector_string>[^"]*)" should exist in current page administration$/
     *
     * @throws ExpectationException
     * @param string $element The locator of the specified selector.
     *     This may be a path, for example "Subscription mode > Forced subscription"
     * @param string $selectortype The selector type (link or text)
     * @return void
     */
    public function should_exist_in_current_page_administration($element, $selectortype) {
        $parentnodes = array_map('trim', explode('>', $element));
        // Find the name of the first category of the administration block tree.
        $xpath = '//div[contains(@class,\'block_settings\')]//div[@id=\'settingsnav\']/ul/li[1]/p[1]/span';
        $node = $this->find('xpath', $xpath);
        array_unshift($parentnodes, $node->getText());
        $lastnode = array_pop($parentnodes);

        if (!$this->find_node_in_navigation($lastnode, $parentnodes, strtolower($selectortype))) {
            throw new ExpectationException(ucfirst($selectortype) . ' "' . $element .
                '" not found in current page administration"', $this->getSession());
        }
    }

    /**
     * Checks that current page administration contains text
     *
     * @Given /^"(?P<element_string>(?:[^"]|\\")*)" "(?P<selector_string>[^"]*)" should not exist in current page administration$/
     *
     * @throws ExpectationException
     * @param string $element The locator of the specified selector.
     *     This may be a path, for example "Subscription mode > Forced subscription"
     * @param string $selectortype The selector type (link or text)
     * @return void
     */
    public function should_not_exist_in_current_page_administration($element, $selectortype) {
        $parentnodes = array_map('trim', explode('>', $element));
        // Find the name of the first category of the administration block tree.
        $xpath = '//div[contains(@class,\'block_settings\')]//div[@id=\'settingsnav\']/ul/li[1]/p[1]/span';
        $node = $this->find('xpath', $xpath);
        array_unshift($parentnodes, $node->getText());
        $lastnode = array_pop($parentnodes);

        if ($this->find_node_in_navigation($lastnode, $parentnodes, strtolower($selectortype))) {
            throw new ExpectationException(ucfirst($selectortype) . ' "' . $element .
                '" found in current page administration"', $this->getSession());
        }
    }

    /**
     * Finds a node in the Navigation or Administration tree
     *
     * @param string $nodetext
     * @param array $parentnodes
     * @param string $nodetype node type (link or text)
     * @return NodeElement|null
     * @throws ExpectationException when one of the parent nodes is not found
     */
    protected function find_node_in_navigation($nodetext, $parentnodes, $nodetype = 'link') {
        // Site admin is different and needs special treatment.
        $siteadminstr = get_string('administrationsite');

        // Create array of all parentnodes.
        $countparentnode = count($parentnodes);

        // If JS is disabled and Site administration is not expanded we
        // should follow it, so all the lower-level nodes are available.
        if (!$this->running_javascript()) {
            if ($parentnodes[0] === $siteadminstr) {
                // We don't know if there if Site admin is already expanded so
                // don't wait, it is non-JS and we already waited for the DOM.
                $siteadminlink = $this->getSession()->getPage()->find('named_exact', array('link', "'" . $siteadminstr . "'"));
                if ($siteadminlink) {
                    $siteadminlink->click();
                }
            }
        }

        // Get top level node.
        $node = $this->get_top_navigation_node($parentnodes[0]);

        // Expand all nodes.
        for ($i = 0; $i < $countparentnode; $i++) {
            if ($i > 0) {
                // Sub nodes within top level node.
                $node = $this->get_navigation_node($parentnodes[$i], $node);
            }

            // The p node contains the aria jazz.
            $pnodexpath = "/p[contains(concat(' ', normalize-space(@class), ' '), ' tree_item ')]";
            $pnode = $node->find('xpath', $pnodexpath);

            // Keep expanding all sub-parents if js enabled.
            if ($pnode && $this->running_javascript() && $pnode->hasAttribute('aria-expanded') &&
                ($pnode->getAttribute('aria-expanded') == "false")) {

                $this->js_trigger_click($pnode);

                // Wait for node to load, if not loaded before.
                if ($pnode->hasAttribute('data-loaded') && $pnode->getAttribute('data-loaded') == "false") {
                    $jscondition = '(document.evaluate("' . $pnode->getXpath() . '", document, null, '.
                        'XPathResult.ANY_TYPE, null).iterateNext().getAttribute(\'data-loaded\') == "true")';

                    $this->getSession()->wait(self::EXTENDED_TIMEOUT * 1000, $jscondition);
                }
            }
        }

        // Finally, click on requested node under navigation.
        $nodetextliteral = behat_context_helper::escape($nodetext);
        $tagname = ($nodetype === 'link') ? 'a' : 'span';
        $xpath = "/ul/li/p[contains(concat(' ', normalize-space(@class), ' '), ' tree_item ')]" .
            "/{$tagname}[normalize-space(.)=" . $nodetextliteral . "]";
        return $node->find('xpath', $xpath);
    }

}

class behat_local_xray extends bbase_local_xray {

}

/*
if ($CFG->version < 2016052300) {

    // Moodle 2.9 - 3.0.

    class behat_local_xray extends bbase_local_xray {
        use local_xray_29;
    }

} else {

    // Moodle 3.1+

    class behat_local_xray extends bbase_local_xray {

    }

}
*/