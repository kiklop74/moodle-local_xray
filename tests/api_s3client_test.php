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

require_once(__DIR__.'/api_data_export_base.php');

/**
 * Class local_xray_api_s3client_testcase
 * @group local_xray
 */
class local_xray_api_s3client_testcase extends local_xray_api_data_export_base_testcase {

    public function test_inits3_php52() {
        if (!$this->plugin_present('local_aws_sdk')) {
            $this->markTestSkipped('Aws SDK not present!');
        }

        $this->expectException('Exception');

        local_xray\local\api\s3client::phpmajor(5);
        local_xray\local\api\s3client::phpminor(2);

        $this->assertNull(local_xray\local\api\s3client::create());
    }

    public function test_inits3_php54() {
        if (!$this->plugin_present('local_aws_sdk')) {
            $this->markTestSkipped('Aws SDK not present!');
        }

        if ((PHP_MAJOR_VERSION != 5) and (PHP_MINOR_VERSION != 4)) {
            $this->expectException('Exception');
        }

        local_xray\local\api\s3client::phpmajor(5);
        local_xray\local\api\s3client::phpminor(4);

        $this->assertNotNull(local_xray\local\api\s3client::create());
    }

    public function test_inits3_php55() {
        if (!$this->plugin_present('local_aws_sdk')) {
            $this->markTestSkipped('Aws SDK not present!');
        }

        if ((PHP_MAJOR_VERSION == 5) and (PHP_MINOR_VERSION < 5)) {
            $this->expectException('Exception');
        }

        local_xray\local\api\s3client::phpmajor(5);
        local_xray\local\api\s3client::phpminor(5);

        $this->assertNotNull(local_xray\local\api\s3client::create());
    }

    public function test_inits3_php56() {
        if (!$this->plugin_present('local_aws_sdk')) {
            $this->markTestSkipped('Aws SDK not present!');
        }

        if ((PHP_MAJOR_VERSION == 5) and (PHP_MINOR_VERSION < 5)) {
            $this->expectException('Exception');
        }

        local_xray\local\api\s3client::phpmajor(5);
        local_xray\local\api\s3client::phpminor(6);

        $this->assertNotNull(local_xray\local\api\s3client::create());
    }

    public function test_inits3_php70() {
        if (!$this->plugin_present('local_aws_sdk')) {
            $this->markTestSkipped('Aws SDK not present!');
        }

        if ((PHP_MAJOR_VERSION == 5) and (PHP_MINOR_VERSION < 5)) {
            $this->expectException('Exception');
        }

        local_xray\local\api\s3client::phpmajor(7);
        local_xray\local\api\s3client::phpminor(0);

        $this->assertNotNull(local_xray\local\api\s3client::create());
    }

    public function test_inits3_php71() {
        if (!$this->plugin_present('local_aws_sdk')) {
            $this->markTestSkipped('Aws SDK not present!');
        }

        if ((PHP_MAJOR_VERSION == 5) and (PHP_MINOR_VERSION < 5)) {
            $this->expectException('Exception');
        }

        local_xray\local\api\s3client::phpmajor(7);
        local_xray\local\api\s3client::phpminor(1);

        $this->assertNotNull(local_xray\local\api\s3client::create());
    }

}
