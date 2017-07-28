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

    /**
     * @return array
     */
    public function versions_provider() {
        return [
            [5, 2, false],
            [5, 4, true ],
            [5, 5, true ],
            [5, 6, true ],
            [7, 0, true ],
            [7, 1, true ],
        ];
    }

    /**
     * @param $major
     * @param $minor
     * @param $notnull
     * @param $versions
     *
     * @dataProvider versions_provider
     */
    public function test_inits3($major, $minor, $notnull) {
        if (!$this->plugin_present('local_aws_sdk')) {
            $this->markTestSkipped('Aws SDK not present!');
        }

        if (
            (((PHP_MAJOR_VERSION == 5) and (PHP_MINOR_VERSION == 4)) and ((($major == 5) and ($minor > 4)) or ($major > 5))) or
            ((((PHP_MAJOR_VERSION == 5) and (PHP_MINOR_VERSION > 4)) or (PHP_MAJOR_VERSION > 5)) and (($major == 5) and ($minor <=4)) )
           ) {
            $this->manage_exception('Exception');
        }

        local_xray\local\api\s3client::phpmajor($major);
        local_xray\local\api\s3client::phpminor($minor);

        $result = local_xray\local\api\s3client::create();
        if ($notnull) {
            $this->assertNotNull($result);
        } else {
            $this->assertNull($result);
        }
    }

}
