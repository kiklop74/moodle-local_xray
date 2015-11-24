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
 * Local xray lang file
 *
 * @package   local_xray
 * @author    Pablo Pagnone
 * @author    German Vitale
 * @copyright Copyright (c) 2015 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') or die();

/* @var string[] $string */
$string['navigation_xray'] = 'X-Ray Learning Analytics ';
$string['navitationcourse_xray'] = 'X-Ray Learning Analytics';
$string['pluginname'] = 'X-Ray Learning Analytics';
$string['reports'] = 'Reports';
$string['analytics'] = 'Course Analytics';
$string['xraydisplayheading'] = 'Course Integration';
$string['xraydisplayheading_desc'] = 'Control the display of information and report links on the course frontpage.';
$string['displaymenu'] = 'Show reports menu';
$string['displaymenu_desc'] = 'Control the display reports menu on the course frontpage.';
$string['displayheaderdata'] = 'Show Analytics';
$string['displayheaderdata_desc'] = 'Control the display course analytics on the course frontpage.';
$string['debuginfo'] = 'Debug information';

/* Capabilities */
$string['xray:activityreportindividual_view'] = 'View Activity Report Individual';
$string['xray:activityreport_view'] = 'View Activity Report';
$string['xray:dashboard_view'] = 'View Dashboard Report';
$string['xray:discussionreport_view'] = 'View Discussion Report';
$string['xray:discussionreportindividual_view'] = 'View Discussion Report Individual';
$string['xray:discussionreportindividualforum_view'] = 'View Discussion Report Individual Forum';
$string['xray:discussionendogenicplagiarism_view'] = 'View Discussion Plagiarism';
$string['xray:discussiongrading_view'] = 'View Discussion Grading';
$string['xray:gradebookreport_view'] = 'View Gradebook Report';
$string['xray:gradebookreportindividualquiz_view'] = 'View Gradebook Report Indivisual Quiz';
$string['xray:risk_view'] = 'View Risk Report';
$string['xray:view'] = 'X-Ray Learning Analytics View';

/* Categories for numbers values */
$string['high'] = 'High';
$string['low'] = 'Low';
$string['medium'] = 'Medium';

$string['highlyregularity'] = 'Highly regularity';
$string['irregular'] = 'Irregular';
$string['somewhatregularity'] = 'Somewhat regularity';

/* Report Activity Report*/
$string['activityreport'] = 'Activity';
/* Report Activity Report Individual*/
$string['activityreportindividual'] = 'Activity Report Individual';
/* Discussion report*/
$string['discussionreport'] = 'Discussions';
/* Discussion report individual*/
$string['discussionreportindividual'] = 'Discussion Report Individual';
/* Discussion report individual forum*/
$string['discussionreportindividualforum'] = 'Discussion Report Individual Forum';
/* Discussion report Endogenic Plagiarism*/
$string['discussionendogenicplagiarism'] = 'Discussion Plagiarism';
/* Risk report*/
$string['risk'] = 'Risk Status';
/* Discussiongrading report*/
$string['discussiongrading'] = 'Discussion Grading';
/* Gradebook report*/
$string['gradebookreport'] = 'Gradebook';

/* Columns reports */
$string['reportdate'] = 'Date of report';
$string['weeks'] = 'Weeks';
$string['week'] = 'Week';

/* Error to load tables and images */
$string['error_loadimg'] = 'Error to load image, please try again reloading the page. If error persist, contact '.
                           'with the administrator please.';

/* Error Webservice */
$string['error_xray'] = 'Error to connect with X-Ray Learning Analytics, please try again reloading the page. If error persist, '.
                        'contact with the administrator please.';

$string['error_compress'] = 'Unable to create compressed file. Please check with your administrator.';

$string['error_generic'] = '{$a}';

/* Settings */
$string['enabledreports'] = 'Enabled Reports';
$string['enabledreports_desc'] = 'Reports enabled for view in moodle.';
$string['xrayclientid'] = 'Identifier client';
$string['xrayclientid_desc'] = 'Identifier client for X-Ray Learning Analytics';
$string['xraypassword'] = 'X-Ray Learning Analytics Password';
$string['xraypassword_desc'] = 'Password for logging into X-Ray Learning Analytics server.';
$string['xrayurl'] = 'X-Ray Learning Analytics Url';
$string['xrayurl_desc'] = 'Location of X-Ray Learning Analytics';
$string['xrayusername'] = 'X-Ray Learning Analytics Username';
$string['xrayusername_desc'] = 'User for logging into X-Ray Learning Analytics server.';
$string['xrayawsheading'] = 'Data Synchronization';
$string['xrayawsheading_desc'] = 'In this section you can configure automated data synchronization with X-Ray Learning Analytics.';
$string['enablesync'] = 'Data Sync';
$string['enablesync_desc'] = 'Enable automated data synchronization with X-Ray Learning Analytics.';
$string['awskey'] = 'AWS Key';
$string['awskey_desc'] = 'Access key for AWS web services';
$string['awssecret'] = 'AWS Secret';
$string['awssecret_desc'] = 'Access key for AWS web services';
$string['s3bucket'] = 'S3 bucket';
$string['s3bucket_desc'] = 'Name of the bucket to use for storing data uploads.';
$string['s3bucketregion'] = 'S3 region';
$string['s3bucketregion_desc'] = 'Region of the destination bucket.';
$string['enablepacker'] = 'Use native compression';
$string['enablepacker_desc'] = 'If enabled permits the use of OS native compression tools.';
$string['packertar'] = 'GNU tar executable';
$string['packertar_desc'] = 'Configure location of <a href="http://www.gnu.org/software/tar/" target="_blank" '.
                            'title="GNU tar">GNU tar</a> executable on your server. Make sure to install '.
                            '<a href="http://www.gnu.org/software/gzip/" target="_blank" title="GNU Gzip">GNU Gzip</a> as well.';
$string['exportlocation'] = 'Export location';
$string['exportlocation_desc'] = 'Configure local directory for temporary storage of exported data. If left empty '.
                                 '(or if path not valid) Moodle tempdir is used.';

$string['xrayadminserver'] = 'X-Ray Learning Analytics Administration server';
$string['xrayadminserver_desc'] = 'Server location.';
$string['xrayadmin'] = 'Admin user';
$string['xrayadmin_desc'] = 'User for logging into admin server.';
$string['xrayadminkey'] = 'Admin key';
$string['xrayadminkey_desc'] = 'Access key for logging into admin server.';

$string['useast1'] = 'US Standard (N. Virginia)';
$string['uswest2'] = 'US West (Oregon)';
$string['uswest1'] = 'US West (N. California)';
$string['euwest1'] = 'EU (Ireland)';
$string['eucentral1'] = 'EU (Frankfurt)';
$string['apsoutheast1'] = 'Asia Pacific (Singapore)';
$string['apsoutheast2'] = 'Asia Pacific (Sydney)';
$string['apnortheast1'] = 'Asia Pacific (Tokyo)';
$string['saeast1'] = 'South America (Sao Paulo)';

/* webservice api */
$string['xrayws_error_nocurl'   ] = 'cURL module must be present and enabled!';
$string['xrayws_error_nourl'    ] = 'You must specify URL!';
$string['xrayws_error_nomethod' ] = 'You must specify request method!';

/* Web service errors returned from XRay*/
$string['xrayws_error_server'] = '{$a}';
$string['xrayws_error_curl'] = '{$a}';

/* Scheduled task */
$string['datasync'] = 'Data Synchronization';
$string['syncfailed'] = 'X-Ray Learning Analytics data sync failed';
$string['unexperror'] = 'Unexpected error';
$string['syncfailedexplanation'] = 'Failed to synchronize data with X-Ray Learning Analytics.';
$string['synclog'] = 'X-Ray Learning Analytics data sync info message';
$string['synclogexplanation'] = 'Regular log entry for data sync.';
$string['getreportfailed'] = 'Error to get report from X-Ray Learning Analytics';

/* Course Header */
$string['atrisk'] = 'At risk';
$string['dashboard'] = 'Dashboard';
$string['fromlastweek'] = '{$a}% change from last week';
$string['of'] = ' of ';
$string['studentatrisk'] = 'students at risk';
$string['studentvisitslastdays'] = 'student visits in the last 7 days';
$string['visitors'] = 'Visitors';

/* Jquery Tables (with plugin datatables) */
$string['error_datatables'] = 'Error to get data for this table. Please try again reloading the page. '.
                              'If error persist, contact with the administrator please.';
$string['sProcessingMessage'] = 'Fetching Data, Please wait...';
$string['sFirst'] = 'First';
$string['sLast'] = 'Last';
$string['sNext'] = 'Next';
$string['sPrevious'] = 'Previous';
$string['sProcessing'] = 'Processing...';
$string['sLengthMenu'] = 'Show _MENU_ entries';
$string['sZeroRecords'] = 'No matching records found';
$string['sEmptyTable'] = 'No data available in table';
$string['sInfo'] = 'Showing _START_ to _END_ of _TOTAL_ entries';
$string['sInfoEmpty'] = 'Showing 0 to 0 of 0 entries';
$string['sLoadingRecords'] = 'Loading...';
$string['sSortAscending'] = ': activate to sort column ascending';
$string['sSortDescending'] = ': activate to sort column descending';

/* Close modal */
$string['close'] = 'Close';
/* Close Report Tables */
$string['closetable'] = 'Close table';

/*Accessible data */
$string['accessibledata'] = 'Accessible Data';
$string['accessible_view_data'] = 'View data';
$string['accessible_emptydata'] = 'Without data available for Accessible version.';
$string['accessible_error'] = 'Accessible version for this graph was not found in X-Ray Learning Analytics.';

/* Cut-off points settings */
/* Header Title */
$string['cutoff_title'] = 'Cut-off points values for ranges';
$string['cutoff_desc'] = 'Define cut-off values for the ranges. These ranges will be used to display more intuitive results.';
/* Risk Report */
/* low - medium - high */
$string['risk1_name'] = 'Cut-off point between low and medium ranges for Risk Report';
$string['risk1_desc'] = 'Define the cut-off point between low and medium ranges. For example, '.
                        'if the cut off point is 0.2, anything 0.2 and higher is in the medium risk range and anything lower is in the low risk range. '.
                        'This setting affects the Academic Risk, Social Risk and Total Risk columns in the Risk Measures table in the Risk Report.';
$string['risk2_name'] = 'Cut-off point between medium and high ranges for Risk Report';
$string['risk2_desc'] = 'Define cut-off point between medium and high ranges. For example, '.
                        'if the cut off point is 0.3, anything 0.3 and higher is in the high risk range and anything lower is in the medium risk range. '.
                        'This setting affects the Academic Risk, Social Risk and Total Risk columns in the Risk Measures table in the Risk Report.';
/* Activity Report */
/* highly regular - somewhat regular - irregular */
$string['visitreg1_name'] = 'Cut-off point between "highly regular" and "somewhat regular" ranges for Activity Report';
$string['visitreg1_desc'] = 'Define cut-off value between "highly regular" and "somewhat regular" ranges. For example, '.
                            'if the cut off value is 1, anything 1 and higher is somewhat regular and anything lower is highly regular. '.
                            'This setting affects the Visit regularity (weekly) column in the Student Activity table in the Activity Report.';
$string['visitreg2_name'] = 'Cut-off point between "somewhat regular" and "irregular" ranges for Activity Report';
$string['visitreg2_desc'] = 'Define cut-off value between "somewhat regular" and "irregular" ranges. For example, '.
                            'if the cut off value is 2, anything 2 and higher is irregular and anything lower is somewhat regular. '.
                            'This setting affects the Visit regularity (weekly) column in the Student Activity table in the Activity Report.';
/* Discussion Report */
/* highly regular - somewhat regular - irregular */
$string['partreg1_name'] = 'Cut-off point between "highly regular" and "somewhat regular" ranges for Discussion Report';
$string['partreg1_desc'] = 'Define cut-off value between "highly regular" and "somewhat regular" ranges. For example, '.
                           'if the cut off value is 2, anything 2 and higher is somewhat regular and anything lower is highly regular. '.
                           'This setting affects the Regularity of contributions and Regularity of CTC columns in the Participation Metrics table and '.
                           'the Regularity of contributions column in the Student Grades Based on Discussions table in the Discussion Report.';
$string['partreg2_name'] = 'Cut-off point between "somewhat regular" and "irregular" ranges for Discussion Report';
$string['partreg2_desc'] = 'Define cut-off value between "somewhat regular" and "highly regularity" ranges. For example, '.
                           'if the cut off value is 4, anything 4 and higher is irregular and anything lower is somewhat regular. '.
                           'This setting affects the Regularity of contributions and Regularity of CTC columns in the Participation Metrics table and '.
                           'the Regularity of contributions column from the Student Grades Based on Discussions table in the Discussion Report.';
/* low - medium - high */
$string['partc1_name'] = 'Cut-off point between "low" and "medium" ranges for Discussion Report';
$string['partc1_desc'] = 'Define cut-off point between "low" and "medium" ranges. For example, '.
                         'if the cut off point is 33, anything 33 and higher is in the medium risk range and anything lower is in the low risk range. '.
                         'This setting affects the Contribution and CTC columns in the Participation Metrics table and the CTC column '.
                         'in the Student Grades Based on Discussions table in the Discussion Report.';
$string['partc2_name'] = 'Cut-off point between "medium" and "high" ranges for Discussion Report';
$string['partc2_desc'] = 'Define cut-off point between "medium" and "high" ranges. For example, '.
                         'if the cut off point is 66, anything 66 and higher is in the high risk range and anything lower is in the medium risk range. '.
                         'This setting affects the Contribution and CTC columns in the Participation Metrics table and the CTC column '.
                         'in the Student Grades Based on Discussions table in the Discussion Report.';