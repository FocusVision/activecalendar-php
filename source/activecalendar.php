<?php
/*
* @class: activeCalendar
* @project: Active Calendar
* @version: 1.2.0;
* @author: Giorgos Tsiledakis;
* @date: 23 Feb 2006;
* @copyright: Giorgos Tsiledakis;
* @license: GNU LESSER GENERAL PUBLIC LICENSE;
* Support, feature requests and bug reports please at : http://www.micronetwork.de/activecalendar/
* Special thanks to Corissia S.A (http://www.corissia.com) for the permission to publish the source code
* Thanks to Maik Lindner (http://nifox.com) for his help developing this class

* -------- You may remove all comments below to reduce file size -------- *

* This class generates calendars as a html table (XHTML Valid)
* Supported views: month and year view
* Supported dates:
* 1. Using PHP native date functions (default): 1902-2037 (UNIX) or 1971-2037 (Windows)
* 2. Using ADOdb Date Library : 100-3000 and later [limited by the computation time of adodb_mktime()].
* You can find the ADOdb Date Library at http://phplens.com/phpeverywhere/adodb_date_library
* To use the ADOdb Date Library just include it in your main script. The Active Calendar class will use the library functions automatically.
* Supported features:
* 1. Static calendar without any links
* 2. Calendar with month's or year's view navigation controls
* 3. Calendar with linkable days (url or javascript)
* 4. Calendar with a date picker (year or month mode)
* 5. Calendar with event days (css configutation) and event links
* 6. Calendar with optionally linkable event contents
* 7. Calendar with week number column optionally linked
* The layout of can be configured using css, as the class generates various html classes
* Please read the readme.html first and check the examples included in this package
*/

class activeCalendar
{
    /*
	----------------------
	@START CONFIGURATION
	----------------------
	*/
    /*
	********************************************************************************
	You can change below the month and day names, according to your language
	This is just the default configuration. You may set the month and day names by calling setMonthNames() and setDayNames()
	********************************************************************************
	*/
    private $jan = 'January';
    private $feb = 'February';
    private $mar = 'March';
    private $apr = 'April';
    private $may = 'May';
    private $jun = 'June';
    private $jul = 'July';
    private $aug = 'August';
    private $sep = 'September';
    private $oct = 'October';
    private $nov = 'November';
    private $dec = 'December';
    private $sun = 'Sun';
    private $mon = 'Mon';
    private $tue = 'Tue';
    private $wed = 'Wed';
    private $thu = 'Thu';
    private $fri = 'Fri';
    private $sat = 'Sat';
    /*
	********************************************************************************
	You can change below the default year's and month's view navigation controls
	********************************************************************************
	*/
    private $yearNavBack = ' &lt;&lt; '; // Previous year, this could be an image link
    private $yearNavForw = ' &gt;&gt; '; // Next year, this could be an image link
    private $monthNavBack = ' &lt;&lt; '; // Previous month, this could be an image link
    private $monthNavForw = ' &gt;&gt; '; // Next month, this could be an image link
    private $weekNavBack = ' &lt;&lt; '; // Previous week, this could be an image link
    private $weekNavForw = ' &gt;&gt; '; // Next week, this could be an image link
    private $selBtn = 'Go'; // value of the date picker button (if enabled)
    private $monthYearDivider = ' '; // the divider between month and year in the month`s title
    /*
	********************************************************************************
	$startOnSun = false: first day of week is Monday
	$startOnSun = true: first day of week is Sunday
	You may use the method setFirstWeekDay() instead
	********************************************************************************
	*/
    private $startOnSun = false;
    /*
	********************************************************************************
	$rowCount : defines the number of months in a row in yearview ( can be also set by the method showYear() )
	********************************************************************************
	*/
    private $rowCount = 4;
    /*
	********************************************************************************
	Names of the generated html classes. You may change them to avoid any conflicts with your existing CSS
	********************************************************************************
	*/
    private $cssYearTable = 'year'; // table tag: calendar year
    private $cssYearTitle = 'yearname'; // td tag: calendar year title
    private $cssYearNav = 'yearnavigation'; // td tag: calendar year navigation
    private $cssMonthTable = 'month'; // table tag: calendar month
    private $cssMonthTitle = 'monthname'; // td tag: calendar month title
    private $cssMonthNav = 'monthnavigation'; // td tag: calendar month navigation
    private $cssWeekTable = 'week'; // table tag: calendar week view
    private $cssWeekTitle = 'weekname'; // td tag: calendar week title
    private $cssWeekNav = 'weeknavigation'; // td tag: calendar week navigation
    private $cssWeekDay = 'dayname'; // td tag: calendar weekdays
    private $cssWeekDayClass = 'tb_weekday';
    private $cssWeekNumTitle = 'weeknumtitle'; // td tag: title of the week numbers
    private $cssWeekNum = 'weeknum'; // td tag: week numbers
    private $cssPicker = 'datepicker'; // td tag: date picker
    private $cssPickerForm = 'datepickerform'; // form tag: date picker form
    private $cssPickerMonth = 'monthpicker'; // select tag: month picker
    private $cssPickerYear = 'yearpicker'; // select tag: year picker
    private $cssPickerButton = 'pickerbutton'; // input (submit) tag: date picker button
    private $cssMonthDay = 'monthday'; // td tag: days, that belong to the current month
    private $cssNoMonthDay = 'nomonthday'; // td tag: days, that do not belong to the current month
    private $cssToday = 'today'; // td tag: the current day
    private $cssSelecDay = 'selectedday'; // td tag: the selected day
    private $cssSunday = 'sunday'; // td tag: all Sundays (can be disabled, see below)
    private $cssSaturday = 'saturday'; // td tag: all Saturdays (can be disabled, see below)
    private $cssEvent = 'event'; // td tag: event day set by setEvent(). Multiple class names can be generated
    private $cssPrefixSelecEvent = 'selected'; // prefix for the event class name if the event is selected
    private $cssPrefixTodayEvent = 'today'; //  prefix for the event class name if the event is the current day
    private $cssEventContent = 'eventcontent'; // table tag: calendar event content. Multiple class names can be generated
    private $crSunClass = true; // true: creates a td class on every Sunday (set above)
    private $crSatClass = true; // true: creates a td class on every Saturday (set above)
    /*
	********************************************************************************
	You can change below the GET VARS NAMES [url parameter names] (navigation + day links)
	You should modify the private method mkUrl() or mkWeekNum(), if you want to change the structure of the generated links
	********************************************************************************
	*/
    private $yearID = 'yearID';
    private $monthID = 'monthID';
    private $dayID = 'dayID';
    private $weekID = 'weekID';
    /*
	********************************************************************************
	Default start and end year for the date picker (can be changed, if using the ADOdb Date Library)
	********************************************************************************
	*/
    private $startYear = 1971;
    private $endYear = 2037;

    private $ajax = false;
    private $actyear = null;
    private $actmonth = null;
    private $actweek = null;
    private $actday = null;

    /*
	----------------------
	@START PUBLIC METHODS
	----------------------
	*/
    /*
	********************************************************************************
	PUBLIC activeCalendar() -> class constructor, does the initial date calculation
	$GMTDiff: GMT Zone for current day calculation, do not set to use local server time
	********************************************************************************
	*/
    public function __construct($year = false, $month = false, $day = false, $GMTDiff = "none")
    {
        $this->timetoday = time();
        $this->selectedday = -2;
        $this->selectedyear = $year;
        $this->selectedmonth = $month;
        if (!$month) {
            $month = 1;
        }
        if (!$day) {
            $day = 1;
        } else {
            $this->selectedday = $day;
        }
        $h = $this->mkActiveGMDate('H');
        $m = $this->mkActiveGMDate('i');
        $s = $this->mkActiveGMDate('s');
        $d = $this->mkActiveGMDate('j');
        $mo = $this->mkActiveGMDate('n');
        $y = $this->mkActiveGMDate('Y');
        $is_dst = $this->mkActiveDate('I');
        if ($GMTDiff != "none") {
            $this->timetoday = $this->mkActiveTime($h, $m, $s, $mo, $d, $y) + (3600 * ($GMTDiff + $is_dst));
        }
        $this->unixtime = $this->mkActiveTime($h, $m, $s, $month, $day, $year);
        if ($this->unixtime == -1 or !$year) {
            $this->unixtime = $this->timetoday;
        }
        $this->daytoday = $this->mkActiveDate('j');
        $this->monthtoday = $this->mkActiveDate('n');
        $this->yeartoday = $this->mkActiveDate('Y');
        if (!$day) {
            $this->actday = $this->daytoday;
        } else {
            $this->actday = $this->mkActiveDate('j', $this->unixtime);
        }
        $this->actweek = $this->mkActiveDate('W', $this->unixtime); // set the current week
        if (!$month) {
            $this->actmonth = $this->monthtoday;
        } else {
            $this->actmonth = $this->mkActiveDate('n', $this->unixtime);
        }
        if (!$year) {
            $this->actyear = $this->yeartoday;
        } else {
            $this->actyear = $this->mkActiveDate('Y', $this->unixtime);
        }
        $this->has31days = checkdate($this->actmonth, 31, $this->actyear);
        $this->isSchalt = checkdate(2, 29, $this->actyear);
        if ($this->isSchalt == 1 and $this->actmonth == 2) {
            $this->maxdays = 29;
        } elseif ($this->isSchalt != 1 and $this->actmonth == 2) {
            $this->maxdays = 28;
        } elseif ($this->has31days == 1) {
            $this->maxdays = 31;
        } else {
            $this->maxdays = 30;
        }
        $this->firstday = $this->mkActiveDate('w', $this->mkActiveTime(0, 0, 1, $this->actmonth, 1, $this->actyear));
        $this->GMTDiff = $GMTDiff;
        $this->uniqueid = uniqid();
    }

    /*
	********************************************************************************
	PUBLIC enableYearNav() -> enables the year's navigation controls
	********************************************************************************
	*/
    public function enableYearNav($link = false, $arrowBack = false, $arrowForw = false)
    {
        if ($link) {
            $this->urlNav = $link;
        } else {
            $this->urlNav = $_SERVER['PHP_SELF'];
        }
        if ($arrowBack) {
            $this->yearNavBack = $arrowBack;
        }
        if ($arrowForw) {
            $this->yearNavForw = $arrowForw;
        }
        $this->yearNav = true;
    }

    /*
	********************************************************************************
	PUBLIC enableMonthNav() -> enables the month's navigation controls
	********************************************************************************
	*/
    public function enableMonthNav($link = false, $arrowBack = false, $arrowForw = false)
    {
        if ($link) {
            $this->urlNav = $link;
        } else {
            $this->urlNav = $_SERVER['PHP_SELF'];
        }
        if ($arrowBack) {
            $this->monthNavBack = $arrowBack;
        }
        if ($arrowForw) {
            $this->monthNavForw = $arrowForw;
        }
        $this->monthNav = true;
    }

    /*
	********************************************************************************
	PUBLIC enableWeekNav() -> enables the month's navigation controls
	********************************************************************************
	*/
    public function enableWeekNav($link = false, $arrowBack = false, $arrowForw = false)
    {
        if ($link) {
            $this->urlNav = $link;
        } else {
            $this->urlNav = $_SERVER['PHP_SELF'];
        }
        if ($arrowBack) {
            $this->weekNavBack = $arrowBack;
        }
        if ($arrowForw) {
            $this->weekNavForw = $arrowForw;
        }
        $this->weekNav = true;
    }

    /*
	********************************************************************************
	PUBLIC enableDayLinks() -> enables the day links
	param javaScript: sets a Javascript function on each day link
	********************************************************************************
	*/
    public function enableDayLinks($link = false, $javaScript = false)
    {
        if ($link) {
            $this->url = $link;
        } else {
            $this->url = $_SERVER['PHP_SELF'];
        }
        if ($javaScript) {
            $this->javaScriptDay = $javaScript;
        }
        $this->dayLinks = true;
    }

    /*
	********************************************************************************
	PUBLIC enableDatePicker() -> enables the day picker control
	********************************************************************************
	*/
    public function enableDatePicker($startYear = false, $endYear = false, $link = false, $button = false)
    {
        if ($link) {
            $this->urlPicker = $link;
        } else {
            $this->urlPicker = $_SERVER['PHP_SELF'];
        }
        if ($startYear and $endYear) {
            if ($startYear >= $this->startYear and $startYear < $this->endYear) {
                $this->startYear = $startYear;
            }
            if ($endYear > $this->startYear and $endYear <= $this->endYear) {
                $this->endYear = $endYear;
            }
        }
        if ($button) {
            $this->selBtn = $button;
        }
        $this->datePicker = true;
    }

    /*
	********************************************************************************
	PUBLIC enableWeekNum() -> enables a week number column
	********************************************************************************
	*/
    public function enableWeekNum($title = "", $link = false, $javaScript = false)
    {
        // checking before enabling, as week number calulation works only if php version > 4.1.0 [php function: date ("W")]
        if (is_integer($this->getWeekNum($this->actday))) {
            $this->weekNum = true;
            $this->weekNumTitle = $title;
            $this->monthSpan++;
            if ($link) {
                $this->weekUrl = $link;
            } elseif ($javaScript) {
                $this->javaScriptWeek = $javaScript;
            }
        }
    }

    /*
	********************************************************************************
	PUBLIC setEvent() -> sets a calendar event, $id: the HTML class (css layout)
	********************************************************************************
	*/
    public function setEvent($year, $month, $day, $hour = false, $minute = false, $id = false, $url = false)
    {
        if (!$hour) {
            $hour = 0;
        }
        if (!$minute) {
            $minute = 0;
        }

        $eventTime = $this->mkActiveTime($hour, $minute, 1, $month, $day, $year);
        if (!$id) {
            $id = $this->cssEvent;
        }
        $this->calEvents[$eventTime] = $id;
        $this->calEventsUrl[$eventTime] = $url;
    }


    /**
     * Set the Ajax property
     *
     * @param bool $data
     *
     * @throws Exception if data is invalid
     */
    public function setAjax($data)
    {
        if (!is_bool($data)) {
            throw new Exception('Incoming data was not as expected: Boolean needed!');
        }
        $this->ajax = $data;
    }


    /**
     * Set the Unique ID that is added to all the fields (default is something random)
     *
     * @param mixed $data
     *
     * @throws Exception if data is invalid
     */
    public function setUniqueId($data)
    {
        if (!is_scalar($data)) {
            throw new Exception('Incoming data was not as expected: Integer or String needed!');
        }
        $this->uniqueid = $data;
    }


    /**
     * Set the Ajax function parameters
     *
     * @param array $data
     *
     * @throws Exception if data is invalid
     */
    public function setAjaxParams($data = false)
    {
        if (!is_array($data)) {
            throw new Exception('Incoming data was not as expected: Array needed!');
        }
        $this->ajaxParams = $data;
    }


    /**
     * Toggle the month/week view button (default: disabled)
     *
     * @param bool $data Button Data
     *
     * @throws Exception if data is invalid
     */
    public function setWeekViewToggle($data = false)
    {
        if (!is_string($data) and $data !== false) {
            throw new Exception('Incoming data was not as expected: String needed!');
        }
        $this->weekViewToggleData = $data;
    }


    /**
     * Set the time format (used in the time column for the week view)
     *
     * @param string $data Time Format string ('H:i','h:i A','G:i','g:i A')
     *
     * @throws Exception if data is invalid
     */
    public function setTimeFormat($data)
    {
        $validTimeFormats = array('H:i', 'h:i A', 'G:i', 'g:i A');
        if (!is_string($data)) {
            throw new Exception('Incoming data was not as expected: String needed!');
        }
        if (!in_array($data, $validTimeFormats)) {
            throw new Exception('Incoming data was not as expected! Valid formats are: ' . implode(', ', $validTimeFormats) . '!');
        }
        $this->timeFormat = $data;
    }


    /**
     * Set the loader code thats shown in the week/month head
     *
     * @param string $data
     *
     * @throws Exception if data is invalid
     */
    public function setloaderDIV($data)
    {
        if (!is_string($data)) {
            throw new Exception('Incoming data was not as expected: String needed!');
        }
        $this->loaderDIV = $data;
    }


    /**
     * This function sets a calendar event content
     *
     * @param int   $year    The year of the event
     * @param int   $month   The month of the event
     * @param int   $day     The day of the event
     * @param int   $hour    [optional] The hour of the event
     * @param int   $minute  [optional] The minute of the event
     * @param mixed $content Can be a string or an array
     * @param mixed $url     [optional] The URL (default:false)
     * @param mixed $class   [optional] The HTML class (default:false)
     * @param mixed $id      [optional] The HTML id (default:false)
     */
    public function setEventContent($year, $month, $day, $hour = false, $minute = false, $content, $url = false, $class = false, $id = false)
    {
        if (!$hour) {
            $hour = 0;
        }
        if (!$minute) {
            $minute = 0;
        }

        $eventTime = $this->mkActiveTime($hour, $minute, 1, $month, $day, $year);
        $eventContent[$eventTime] = $content;
        $this->calEventContent[] = $eventContent;
        if (!$class) {
            $class = $this->cssEventContent;
        }
        $this->calEventContentClass[] = $class;
        $this->calEventContentId[] = $id;
        if ($url) {
            $this->calEventContentUrl[] = $url;
        } else {
            $this->calEventContentUrl[] = $this->calInit++;
        }
    }


    /*
	********************************************************************************
	PUBLIC setMonthNames() -> sets the month names, $namesArray must be an array of 12 months starting with January
	********************************************************************************
	*/
    public function setMonthNames($namesArray)
    {
        if (!is_array($namesArray) or count($namesArray) != 12) {
            return false;
        } else {
            $this->monthNames = $namesArray;
        }
    }

    /*
	********************************************************************************
	PUBLIC setDayNames() -> sets the week day names, $namesArray must be an array of 7 days starting with Sunday
	********************************************************************************
	*/
    public function setDayNames($namesArray)
    {
        if (!is_array($namesArray) or count($namesArray) != 7) {
            return false;
        } else {
            $this->dayNames = $namesArray;
        }
    }

    /*
	********************************************************************************
	PUBLIC setFirstWeekDay() -> sets the first day of the week, currently only Sunday and Monday supported, $daynum=0 -> Sunday
	********************************************************************************
	*/
    public function setFirstWeekDay($daynum)
    {
        if ($daynum == 0) {
            $this->startOnSun = true;
        } else {
            $this->startOnSun = false;
        }
    }

    /*
	********************************************************************************
	PUBLIC showYear() -> returns the year's view as html table string
	Each private method returns a tr tag of the table as a string.
	You can change the calendar structure by simply calling these private methods in another order
	********************************************************************************
	*/
    public function showYear($rowCount = false, $startMonth = false)
    {
        if ($rowCount) {
            $this->rowCount = $rowCount;
        }
        $this->monthNav = false; // disables month navigation in yearview
        $out = $this->mkYearHead(); // this should remain first: opens table tag
        $out .= $this->mkYearTitle(); // tr tag: year title and navigation
        $out .= $this->mkDatePicker("yearonly"); // tr tag: year date picker (only year selection)
        $this->datePicker = false; // disables month date picker in yearview
        $out .= $this->mkYearBody($startMonth); // tr tag(s): year month (html tables)
        $out .= $this->mkYearFoot(); // this should remain last: closes table tag
        return $out;
    }


    /**
     * This Method returns the month's view as html table string
     * Each private method returns a tr tag of the table as a string.
     * You can change the calendar structure by simply calling these private methods in another order
     *
     * @param bool $showNoMonthDays [optional] true: days, that do not belong to the current month, will be displayed
     *
     * @return string Table HTML
     */
    public function showMonth($showNoMonthDays = false)
    {
        $this->showNoMonthDays = (bool)$showNoMonthDays;
        ob_start();
        echo $this->mkMonthHead();  // this should remain first: opens table tag
        echo $this->mkMonthTitle(); // tr tag: month title and navigation
        echo $this->mkDatePicker(); // tr tag: month date picker (month and year selection)
        echo $this->mkWeekDays();   // tr tag: the weekday names
        echo $this->mkMonthBody($this->showNoMonthDays); // tr tags: the days of the month
        echo $this->mkMonthFoot();  // this should remain last: closes table tag
        return ob_get_clean();
    }


    /**
     * This Method returns the weeks's view as html table string
     *
     * @return string Table HTML
     */
    public function showWeek()
    {
        ob_start();
        echo $this->mkWeekHead();  // this should remain first: opens table tag
        echo $this->mkWeekTitle(); // tr tag: month title and navigation
        echo $this->mkWeekBody(); // tr tags: the days of the month
        echo $this->mkWeekFoot();  // this should remain last: closes table tag
        return ob_get_clean();
    }


    /*
	----------------------
	@START PRIVATE METHODS
	----------------------
	*/
    /*
	********************************************************************************
	THE FOLLOWING METHODS AND VARIABLES ARE PRIVATE. PLEASE DO NOT CALL OR MODIFY THEM
	********************************************************************************
	*/
    private $version = "1.2.0";
    private $releaseDate = "23 Feb 2006";
    private $monthSpan = 7;
    private $timezone = false;
    private $yearNav = false;
    private $monthNav = false;
    private $dayLinks = false;
    private $datePicker = false;
    private $url = false;
    private $urlNav = false;
    private $urlPicker = false;
    private $calEvents = false;
    private $calEventsUrl = false;
    private $eventUrl = false;
    private $javaScriptDay = false;
    private $monthNames = false;
    private $dayNames = false;
    private $calEventContent = false;
    private $calEventContentUrl = false;
    private $calEventContentClass = false;
    private $calEventContentId = false;
    private $calInit = 0;
    private $weekNum = false;
    private $WeekUrl = false;
    private $javaScriptWeek = false;
    private $ajaxParams = array();
    private $yearJSname = 'switchYear';
    private $monthJSname = 'switchMonth';
    private $weekJSname = 'switchWeek';
    private $dayJSname = 'switchDay';
    private $uniqueid = null;
    private $weekViewToggleData = false;
    private $timeFormat = 'H:i';
    private $skipHalfHours = true;
    private $loaderDIV = null;
    private $counter = 0;

    /*
	********************************************************************************
	PRIVATE mkYearHead() -> creates the year table tag
	********************************************************************************
	*/
    private function mkYearHead()
    {
        return '<table class="' . $this->cssYearTable . '">';
    }

    /*
	********************************************************************************
	PRIVATE mkYearTitle() -> creates the tile and navigation tr tag of the year table
	********************************************************************************
	*/
    private function mkYearTitle()
    {
        if ($this->rowCount < 1 or $this->rowCount > 12) {
            $this->rowCount = 4;
        }
        if (!$this->yearNav) {
            $out = "<tr><td colspan=\"" . $this->rowCount . "\" class=\"" . $this->cssYearTitle . "\">";
            $out .= $this->actyear;
            $out .= "</td></tr>\n";
        } else {
            $out = "<tr><td colspan=\"" . $this->rowCount . "\" align=\"center\">";
            $out .= "<table><tr><td class=\"" . $this->cssYearNav . "\">";
            $out .= $this->mkUrl($this->actyear - 1);
            $out .= $this->yearNavBack . "</a></td>\n";
            $out .= "<td class=\"" . $this->cssYearTitle . "\">" . $this->actyear . "</td>\n";
            $out .= "<td class=\"" . $this->cssYearNav . "\">";
            $out .= $this->mkUrl($this->actyear + 1);
            $out .= $this->yearNavForw . "</a></td></tr></table></td></tr>\n";
        }
        return $out;
    }

    /*
	********************************************************************************
	PRIVATE mkYearBody() -> creates the tr tags of the year table
	********************************************************************************
	*/
    private function mkYearBody($stmonth = false)
    {
        if (!$stmonth or $stmonth > 12) {
            $stmonth = 1;
        }
        $TrMaker = $this->rowCount;
        $curyear = $this->actyear;
        $out = "<tr>\n";
        for ($x = 1; $x <= 12; $x++) {
            $this->activeCalendar($curyear, $stmonth, false, $this->GMTDiff);
            $out .= "<td valign=\"top\">\n" . $this->showMonth() . "</td>\n";
            if ($x == $TrMaker and $x < 12) {
                $out .= "</tr><tr>";
                $TrMaker = ($TrMaker + $this->rowCount);
            }
            if ($stmonth == 12) {
                $stmonth = 1;
                $curyear++;
            } else {
                $stmonth++;
            }
        }
        $out .= "</tr>\n";
        return $out;
    }

    /*
	********************************************************************************
	PRIVATE mkYearFoot() -> closes the year table tag
	********************************************************************************
	*/
    private function mkYearFoot()
    {
        return "</table>\n";
    }

    /*
	********************************************************************************
	PRIVATE mkMonthHead() -> creates the month table tag
	********************************************************************************
	*/
    private function mkMonthHead()
    {
        return '<table class="' . $this->cssMonthTable . '" border="0" cellpadding="0" cellspacing="1">';
    }

    /*
	********************************************************************************
	PRIVATE mkMonthTitle() -> creates the tile and navigation tr tag of the month table
	********************************************************************************
	*/
    private function mkMonthTitle()
    {
        ob_start();
        if (!$this->monthNav) {
            echo '<tr><td class="' . $this->cssMonthTitle . '" colspan="' . $this->monthSpan . '">';
            echo $this->getMonthName() . $this->monthYearDivider . $this->actyear;
            echo '</td></tr>' . "\n";
        } elseif ($this->ajax) {
            echo '<tr><td colspan="7"><div class="' . $this->cssMonthNav . '">';
            if ($this->actmonth == 1) {
                echo $this->mkUrlAJAX($this->actyear - 1, '12');
            } else {
                echo $this->mkUrlAJAX($this->actyear, $this->actmonth - 1);
            }
            echo $this->monthNavBack . '</span></div>';
            echo '<div class="' . $this->cssMonthTitle . '">';
            // loader
            echo $this->loaderDIV;
            echo $this->getMonthName() . $this->monthYearDivider . $this->actyear . '</div>';
            // using table construct here because of IE's weird behavior regarding floats
            echo '<div class="' . $this->cssMonthNav . '"><table border="0" cellspacing="0" cellpadding="0" style="width:100%;"><tr><td>';
            if ($this->actmonth == 12) {
                echo $this->mkUrlAJAX($this->actyear + 1, '1');
            } else {
                echo $this->mkUrlAJAX($this->actyear, $this->actmonth + 1);
            }
            echo $this->monthNavForw . '</span></td>';
            if ($this->weekViewToggleData !== false) {
                echo '<td style="text-align:right; width:35px;">' . $this->weekViewToggleData . '</td>';
            }
            echo '</tr></table></div></td></tr>' . "\n";
        } else {
            echo '<tr><td colspan="7">';
            echo '<div class="' . $this->cssMonthNav . '">';
            if ($this->actmonth == 1) {
                echo $this->mkUrl($this->actyear - 1, '12');
            } else {
                echo $this->mkUrl($this->actyear, $this->actmonth - 1);
            }
            echo $this->monthNavBack . '</a></div>';

            echo '<div class="' . $this->cssMonthTitle . '">';
            echo $this->getMonthName() . $this->monthYearDivider . $this->actyear . '</div>';

            echo '<div class="' . $this->cssMonthNav . '">';
            if ($this->actmonth == 12) {
                echo $this->mkUrl($this->actyear + 1, '1');
            } else {
                echo $this->mkUrl($this->actyear, $this->actmonth + 1);
            }
            echo $this->monthNavForw . '</a>';
            if ($this->weekViewToggleData !== false) {
                echo $this->weekViewToggleData;
            }
            echo '</div></td></tr>' . "\n";
        }
        return ob_get_clean();
    }

    /*
	********************************************************************************
	PRIVATE mkDatePicker() -> creates the tr tag for the date picker
	********************************************************************************
	*/
    private function mkDatePicker($yearpicker = false)
    {
        if ($yearpicker) {
            $pickerSpan = $this->rowCount;
        } else {
            $pickerSpan = $this->monthSpan;
        }
        if ($this->datePicker) {
            $out = "<tr><td class=\"" . $this->cssPicker . "\" colspan=\"" . $pickerSpan . "\">\n";
            $out .= "<form name=\"" . $this->cssPickerForm . "\" class=\"" . $this->cssPickerForm . "\" action=\"" . $this->urlPicker . "\" method=\"get\">\n";
            if (!$yearpicker) {
                $out .= "<select name=\"" . $this->monthID . "\" class=\"" . $this->cssPickerMonth . "\">\n";
                for ($z = 1; $z <= 12; $z++) {
                    if ($z == $this->actmonth) {
                        $out .= "<option value=\"" . $z . "\" selected=\"selected\">" . $this->getMonthName($z) . "</option>\n";
                    } else {
                        $out .= "<option value=\"" . $z . "\">" . $this->getMonthName($z) . "</option>\n";
                    }
                }
                $out .= "</select>\n";
            }
            $out .= "<select name=\"" . $this->yearID . "\" class=\"" . $this->cssPickerYear . "\">\n";
            for ($z = $this->startYear; $z <= $this->endYear; $z++) {
                if ($z == $this->actyear) {
                    $out .= "<option value=\"" . $z . "\" selected=\"selected\">" . $z . "</option>\n";
                } else {
                    $out .= "<option value=\"" . $z . "\">" . $z . "</option>\n";
                }
            }
            $out .= "</select>\n";
            $out .= "<input type=\"submit\" value=\"" . $this->selBtn . "\" class=\"" . $this->cssPickerButton . "\"></input>\n";
            $out .= "</form>\n";
            $out .= "</td></tr>\n";
        } else {
            $out = "";
        }
        return $out;
    }

    /*
	********************************************************************************
	PRIVATE mkWeekDays() -> creates the tr tag of the month table for the weekdays
	********************************************************************************
	*/
    private function mkWeekDays()
    {
        if ($this->startOnSun) {
            $out = "<tr>";
            if ($this->weekNum) {
                $out .= "<td class=\"" . $this->cssWeekNumTitle . "\">" . $this->weekNumTitle . "</td>\n";
            }
            for ($x = 0; $x <= 6; $x++) {
                $out .= "<td class=\"" . $this->cssWeekDay . "\">" . $this->getDayName($x) . "</td>\n";
            }
            $out .= "</tr>\n";
        } else {
            $out = "<tr>";
            if ($this->weekNum) {
                $out .= "<td  class=\"" . $this->cssWeekNumTitle . "\">" . $this->weekNumTitle . "</td>\n";
            }
            for ($x = 1; $x <= 6; $x++) {
                $out .= "<td class=\"" . $this->cssWeekDay . "\">" . $this->getDayName($x) . "</td>\n";
            }
            $out .= "<td class=\"" . $this->cssWeekDay . "\">" . $this->getDayName(0) . "</td>\n";
            $out .= "</tr>\n";
            $this->firstday = $this->firstday - 1;
            if ($this->firstday < 0) {
                $this->firstday = 6;
            }
        }
        return $out;
    }


    /**
     * This method creates the tr tags of the month table
     *
     * @param bool $showNoMonthDays [optional] False -> skip days that are outside the month
     *
     * @return string HTML
     */
    private function mkMonthBody($showNoMonthDays = false)
    {
        ob_start();
        if ($this->actmonth == 1) {
            $pMonth = 12;
            $nMonth = $this->actmonth + 1;
            $pYear = $this->actyear - 1;
            $nYear = $this->actyear;
        } elseif ($this->actmonth == 12) {
            $pMonth = $this->actmonth - 1;
            $nMonth = 1;
            $pYear = $this->actyear;
            $nYear = $this->actyear + 1;
        } else {
            $pMonth = $this->actmonth - 1;
            $nMonth = $this->actmonth + 1;
            $pYear = $this->actyear;
            $nYear = $this->actyear;
        }

        echo '<tr>';
        $cor = 0;
        if ($this->startOnSun) {
            $cor = 1;
        }
        if ($this->weekNum) {
            echo '<td class="' . $this->cssWeekNum . '">' . $this->mkWeekNum(1 + $cor) . '</td>' . "\n";
        }
        $monthday = 0;
        $nmonthday = 1;
        for ($x = 0; $x <= 6; $x++) {
            if ($x >= $this->firstday) {
                $monthday++;
                echo $this->mkDay($monthday);
            } else {
                if ($showNoMonthDays === false) {
                    echo '<td class="' . $this->cssNoMonthDay . '"></td>' . "\n";
                } else {
                    $val = $this->getMonthDays($pMonth, $pYear) - ($this->firstday - 1) + $x;
                    echo $this->mkDay($val, $pMonth, $pYear, true);
                }
            }
        }
        echo '</tr>' . "\n";
        $goon = $monthday + 1;
        $stop = 0;
        for ($x = 0; $x <= 6; $x++) {
            if ($goon > $this->maxdays) {
                break;
            }
            if ($stop == 1) {
                break;
            }
            echo '<tr>';
            if ($this->weekNum) {
                echo '<td class="' . $this->cssWeekNum . '">' . $this->mkWeekNum($goon + $cor) . '</td>' . "\n";
            }
            for ($i = $goon; $i <= $goon + 6; $i++) {
                if ($i > $this->maxdays) {
                    if ($showNoMonthDays == false) {
                        echo '<td class="' . $this->cssNoMonthDay . '"></td>' . "\n";
                    } else {
                        $val = $nmonthday++;
                        echo $this->mkDay($val, $nMonth, $nYear, true);
                    }
                    $stop = 1;
                } else {
                    echo $this->mkDay($i);
                }
            }
            $goon = $goon + 7;
            echo '</tr>' . "\n";
        }
        $this->selectedday = '-2';
        return ob_get_clean();
    }


    /**
     * This method creates each td tag of the month body
     *
     * @param int  $day   The day
     * @param int  $month [optional] The month
     * @param int  $year  [optional] The year
     * @param bool $year  [optional] wether it is a day of the current month or not
     *
     * @return string HTML
     */
    private function mkDay($day, $month = false, $year = false, $noMonth = false)
    {
        ob_start();
        if (!$month) {
            $month = $this->actmonth;
        }
        if (!$year) {
            $year = $this->actyear;
        }

        // make sure all variables are clean
        $day = (int)$day;
        $month = (int)$month;
        $year = (int)$year;

        $eventContent = $this->mkEventContent($day, $month, $year);
        $linkstr = $this->mkUrl($year, $month, $day);
        if ($this->javaScriptDay) {
            $linkstr = "<a href=\"javascript:" . $this->javaScriptDay . "(" . $year . "," . $month . "," . $day . ")\">" . $day . "</a>";
        }

        if ($noMonth !== false) {
            $class = $this->cssNoMonthDay;
        } elseif ($day == $this->selectedday and $month == $this->selectedmonth and $year == $this->selectedyear) {
            $class = $this->cssSelecDay;
        } elseif ($day == $this->daytoday and $month == $this->monthtoday and $year == $this->yeartoday) {
            $class = $this->cssToday;
        } elseif ($this->getWeekday($day) == 0 and $this->crSunClass) {
            $class = $this->cssSunday;
        } elseif ($this->getWeekday($day) == 6 and $this->crSatClass) {
            $class = $this->cssSaturday;
        } else {
            $class = $this->cssMonthDay;
        }

        $monthLZ = (($month) < 10 ? '0' . $month : $month);
        $dayLZ = (($day) < 10 ? '0' . $day : $day);

        $id = 'Y' . $year . 'M' . $monthLZ . 'D' . $dayLZ . 'R' . $this->uniqueid;

        if (!$this->dayLinks) {
            echo '<td class="' . $class . (($this->isEvent(
                    $day,
                    $month,
                    $year
                )) ? ' ' . $this->eventID : '') . '"><div class="dropbox" id="' . $id . '">' . (($this->eventUrl) ? '<a href="' . $this->eventUrl . '">' : '') . $day . (($this->eventUrl) ? '</a>' : '') . '<div>' . $eventContent . '</div></div></td>' . "\n";
        } else {
            echo '<td class="' . $class . '"><div class="dropbox" id="' . $id . '">' . $linkstr . '<div>' . $eventContent . '</div></div></td>' . "\n";
        }

        return ob_get_clean();
    }


    /**
     * This method creates an hour in a day for the week view
     *
     * @param int $var The day
     * @param int $m   The hour
     * @param int $h   The minute
     *
     * @return string HTML
     */
    private function mkWeekHour($day, $h, $m, $year, $month)
    {
        ob_start();

        // make sure all variables are clean
        $day = (int)$day;
        $month = (int)$month;
        $year = (int)$year;
        $h = (int)$h;
        $m = (int)$m;

        $eventContent = $this->mkEventContent($day, $month, $year, $h, $m);

        $class = 'dropbox2';
        if (date('Y-n-j') == $year . '-' . $month . '-' . $day) {
            $class .= ' ' . $this->cssToday;
        } else {
            $class .= ' ' . $this->cssWeekDayClass;
        }

        $monthLZ = (($month) < 10 ? '0' . $month : $month);
        $dayLZ = (($day) < 10 ? '0' . $day : $day);
        $hLZ = (($h) < 10 ? '0' . $h : $h);
        $mLZ = (($m) < 10 ? '0' . $m : $m);

        $id = 'Y' . $year . 'M' . $monthLZ . 'D' . $dayLZ . 'H' . $hLZ . 'M' . $mLZ . 'R' . $this->uniqueid;

        $class .= (($this->isEvent($day, $month, $year, $h, $m)) ? ' ' . $this->eventID : '');
        echo '<div class="' . $class . '" id="' . $id . '">';
        echo '<div>' . $eventContent . '</div>';
        echo '</div>';
        return ob_get_clean();
    }

    /*
	********************************************************************************
	PRIVATE mkMonthFoot() -> closes the month table
	********************************************************************************
	*/
    private function mkMonthFoot()
    {
        return '</table>' . "\n";
    }


    /**
     * This method creates the week's table tag
     *
     * @return string HTML
     */
    private function mkWeekHead()
    {
        return '<table class="' . $this->cssWeekTable . '" border="0" cellpadding="0" cellspacing="1">' . "\n";
    }


    private function mkWeekTitle()
    {
        $actDate = $this->actyear . 'W' . $this->actweek;
        $prevYear = (int)date('Y', strtotime($actDate . ' -1 week'));
        $prevWeek = (int)date('W', strtotime($actDate . ' -1 week'));
        $nextYear = (int)date('Y', strtotime($actDate . ' +1 week'));
        $nextWeek = (int)date('W', strtotime($actDate . ' +1 week'));
        ob_start();
        echo '<tr><td colspan="7"><div class="' . $this->cssWeekNav . '">';
        echo $this->mkUrlAJAX($prevYear, false, $prevWeek);
        echo $this->weekNavBack . '</span></div>';
        echo '<div class="' . $this->cssWeekTitle . '">';
        // loader
        echo $this->loaderDIV;

        echo $this->getWeekName();
        echo '</div>';
        echo '<div class="' . $this->cssWeekNav . '"><table border="0" cellspacing="0" cellpadding="0" style="width:100%;"><tr><td>';
        echo $this->mkUrlAJAX($nextYear, false, $nextWeek);
        echo $this->weekNavForw . '</span></td>';
        if ($this->weekViewToggleData !== false) {
            echo '<td style="text-align:right; width:35px;">' . $this->weekViewToggleData . '</td>';
        }
        echo '</tr></table></div></td></tr>' . "\n";
        return ob_get_clean();
    }


    /**
     * This method creates the half-hour tr tags of the week table
     *
     * @return string HTML
     */
    private function mkWeekBody()
    {
        ob_start();
        echo '<tr><td colspan="7">';

        // checking to see if our week starts on sunday or monday
        $cor = '';
        if ($this->startOnSun) {
            $cor = ' -1 day';
        }

        // generate scrollable div
        echo '<div id="SCROLL_' . $this->uniqueid . '" class="weekDIV">';
        echo '<table class="' . $this->cssWeekTable . '" border="0" cellpadding="0" cellspacing="0">';
        echo '<thead>';
        echo '<tr>';
        echo '<th class="th_time">TIME</th>';

        $starttime = strtotime($this->actyear . 'W' . $this->actweek . $cor);
        $date = date('Y-m-d', $starttime);
        for ($x = 0; $x <= 6; $x++) {
            $dateArray[] = date('D m/d', strtotime($date . ' +' . $x . ' day'));
        }

        foreach ($dateArray as $val) {
            echo '<th class="th_weekday">' . $val . '</th>';
        }

        echo '</tr>';
        echo '</thead>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<th class="tf_time">TIME</th>';

        foreach ($dateArray as $val) {
            echo '<th class="tf_weekday">' . $val . '</th>';
        }

        echo '</tr>';
        echo '</tfoot>';
        echo '<tbody>';


        // loop through all hours
        for ($h = 0; $h <= 23; $h++) {
            $hLZ = (($h < 10) ? '0' . $h : $h);

            // loop through minutes
            for ($m = 0; $m <= 59; $m += 30) {
                $mLZ = (($m < 10) ? '0' . $m : $m);

                // generate first day of this week
                $time_full = (($m >= 30) ? ' time_full' : '');
                $weekday_full = (($m >= 30) ? ' weekday_full' : '');

                echo '<tr>';

                echo '<td class="time' . $time_full . '"><div>';
                // time column
                if ($m == 0 and $this->skipHalfHours) {
                    switch ($this->timeFormat) {
                        case 'h:i A':
                            echo (($h > 12) ? ((($h - 12) >= 10) ? ($h - 12) : '0' . ($h - 12)) : (($h == 0) ? '12' : $hLZ)) . ':' . $mLZ . ' ' . (($h >= 12) ? 'PM' : 'AM');
                            break;
                        case 'G:i':
                            echo $h . ':' . $mLZ;
                            break;
                        case 'g:i A':
                            echo (($h > 12) ? ($h - 12) : (($h == 0) ? '12' : $h)) . ':' . $mLZ . ' ' . (($h >= 12) ? 'PM' : 'AM');
                            break;
                        default: // H:i
                            echo $hLZ . ':' . $mLZ;
                            break;
                    }
                } elseif ($this->skipHalfHours) {
                    echo '&nbsp;'; // put space in here to fix IE6 issues
                }
                echo '</div></td>';

                for ($x = 0; $x <= 6; $x++) {
                    $date = $starttime + (24 * 60 * 60 * $x);
                    $day = date('d', $date);

                    // if the hour matches the current hour and the minute is less or equal than now, add thick border
                    $weekday_now = (((date('Y-m-d', $date) . ' ' . $hLZ . ':' . $mLZ) == (date('Y-m-d H:') . ((date('i') <= 30) ? '30' : '00'))) ? ' weekday_now' : '');
                    // turn the background color to something else, if todays weekday matches
                    $weekday_selected = ((date('Y-m-d', $date) == date('Y-m-d')) ? ' weekdayselected' : '');

                    echo '<td class="weekday' . $weekday_full . $weekday_selected . $weekday_now . '">';
                    echo $this->mkWeekHour($day, $h, $m, date('Y', $date), date('n', $date));
                    echo '</td>';
                }
                echo '</tr>';
            }
        }
        echo '</table></div>';
        echo '</td></tr>' . "\n";
        return ob_get_clean();
    }


    /**
     * This method creates the week's table footer
     *
     * @return string HTML
     */
    private function mkWeekFoot()
    {
        return '</table>' . "\n";
    }


    /*
	********************************************************************************
	PRIVATE mkUrl() -> creates the day and navigation link structure
	********************************************************************************
	*/
    private function mkUrl($year, $month = false, $day = false)
    {
        if (strpos($this->url, "?") === false) {
            $glue = "?";
        } else {
            $glue = "&amp;";
        }
        if (strpos($this->urlNav, "?") === false) {
            $glueNav = "?";
        } else {
            $glueNav = "&amp;";
        }
        $yearNavLink = "<a href=\"" . $this->urlNav . $glueNav . $this->yearID . "=" . $year . "\">";
        $monthNavLink = "<a href=\"" . $this->urlNav . $glueNav . $this->yearID . "=" . $year . "&amp;" . $this->monthID . "=" . $month . "\">";
        $dayLink = "<a href=\"" . $this->url . $glue . $this->yearID . "=" . $year . "&amp;" . $this->monthID . "=" . $month . "&amp;" . $this->dayID . "=" . $day . "\">" . $day . "</a>";
        if ($year and $month and $day) {
            return $dayLink;
        }
        if ($year and !$month and !$day) {
            return $yearNavLink;
        }
        if ($year and $month and !$day) {
            return $monthNavLink;
        }
    }


    /**
     * This Method replaces the HTML Buttons for navigating through the months
     * with AJAX buttons, allowing for smooth browsing withoug page reloads.
     *
     * @param int $year
     * @param int $month [optional]
     * @param int $week  [optional]
     * @param int $day   [optional]
     *
     * @return string Button HTML
     */
    private function mkUrlAJAX($year, $month = false, $week = false, $day = false)
    {
        $ajaxParams = $this->ajaxParams;

        // generate links for year view
        $ajaxParams[] = (int)$year;
        if ($year and !$week and !$month and !$day) {
            return '<span class="button" style="display:inline-block; width:30px; cursor:pointer;" onClick="' . $this->yearJSname . '(\'' . implode('\',\'', $ajaxParams) . '\');">';
        }

        // generate links for week view
        if ($week !== false) {
            $ajaxParams[] = (int)$week;
            if ($year and $week) {
                return '<span class="button" style="display:inline-block; width:30px; cursor:pointer;" onClick="' . $this->weekJSname . '(\'' . implode('\',\'', $ajaxParams) . '\');">';
            }
        }

        // generate links for month view
        $ajaxParams[] = (int)$month;
        if ($year and $month and !$day) {
            return '<span class="button" style="display:inline-block; width:30px; cursor:pointer;" onClick="' . $this->monthJSname . '(\'' . implode('\',\'', $ajaxParams) . '\');">';
        }

        // generate links for day view
        $ajaxParams[] = (int)$day;
        if ($year and $month and $day) {
            return '<span class="button" style="display:inline-block; width:30px; cursor:pointer;" onClick="' . $this->dayJSname . '(\'' . implode('\',\'', $ajaxParams) . '\');">' . $day . '</span>';
        }
    }


    /**
     * This Method creates the table for the event content
     *
     * @param int $var
     * @param int $month [optional]
     * @param int $year  [optional]
     *
     * @return string Cell event content HTML
     */
    private function mkEventContent($var, $month = false, $year = false, $hour = false, $minute = false)
    {
        $hasContent = $this->hasEventContent($var, $month, $year, $hour, $minute);
        ob_start();
        if ($hasContent) {
            for ($x = 0; $x < count($hasContent); $x++) {
                foreach ($hasContent[$x] as $eventContentid => $eventContentData) {
                    foreach ($eventContentData as $eventContentUrl => $eventContent) {
                        if (is_string($eventContent['content'])) {
                            $id = (($eventContent['id']) ? 'id="' . $eventContent['id'] . '"' : '');
                            echo(($this->ajax) ? '<div class="' . $eventContentid . '" ' . $id . '>' : '<table class="' . $eventContentid . '">');
                            if (is_int($eventContentUrl)) {
                                echo (($this->ajax) ? '' : '<tr><td>') . $eventContent['content'] . (($this->ajax) ? '' : '</td></tr>' . "\n");
                            } else {
                                echo (($this->ajax) ? '' : '<tr><td>') . '<a href="' . $eventContentUrl . '">' . $eventContent['content'] . '</a>' . (($this->ajax) ? '' : '</td></tr>' . "\n");
                            }
                            echo(($this->ajax) ? '</div>' : '</table>');
                        } elseif (is_array($eventContent['content'])) {
                            $id = (($eventContent['id']) ? 'id="' . $eventContent['id'] . '"' : '');
                            echo(($this->ajax) ? '<div class="' . $eventContentid . '" ' . $id . '>' : '<table class="' . $eventContentid . '">');
                            foreach ($eventContent['content'] as $arrayContent) {
                                if (is_int($eventContentUrl)) {
                                    echo (($this->ajax) ? '' : '<tr><td>') . $arrayContent . (($this->ajax) ? '' : '</td></tr>' . "\n");
                                } else {
                                    echo (($this->ajax) ? '' : '<tr><td>') . '<a href="' . $eventContentUrl . '">' . $arrayContent . '</a>' . (($this->ajax) ? '' : '</td></tr>' . "\n");
                                }
                            }
                            echo(($this->ajax) ? '</div>' : '</table>');
                        }
                    }
                }
            }
        }
        return ob_get_clean();
    }


    /*
	********************************************************************************
	PRIVATE mkWeekNum() -> returns the week number and optionally creates a link
	********************************************************************************
	*/
    private function mkWeekNum($var)
    {
        $year = $this->actyear;
        $week = $this->getWeekNum($var);
        if ($week > 50 and $this->actmonth == 1) {
            $year = $this->actyear - 1;
        }
        $out = "";
        if (isset($this->weekUrl) and $this->weekUrl) {
            if (strpos($this->weekUrl, "?") === false) {
                $glue = "?";
            } else {
                $glue = "&amp;";
            }
            $out .= "<a href=\"" . $this->weekUrl . $glue . $this->yearID . "=" . $year . "&amp;" . $this->weekID . "=" . $week . "\">" . $week . "</a>";
        } elseif ($this->javaScriptWeek) {
            $out .= "<a href=\"javascript:" . $this->javaScriptWeek . "(" . $year . "," . $week . ")\">" . $week . "</a>";
        } else {
            $out .= $week;
        }
        return $out;
    }

    /*
	********************************************************************************
	PRIVATE getMonthName() -> returns the month's name, according to the configuration
	********************************************************************************
	*/
    private function getMonthName($var = false)
    {
        if (!$var) {
            $var = @$this->actmonth;
        }
        if ($this->monthNames) {
            return $this->monthNames[$var - 1];
        }
        switch ($var) {
            case 1:
                return $this->jan;
            case 2:
                return $this->feb;
            case 3:
                return $this->mar;
            case 4:
                return $this->apr;
            case 5:
                return $this->may;
            case 6:
                return $this->jun;
            case 7:
                return $this->jul;
            case 8:
                return $this->aug;
            case 9:
                return $this->sep;
            case 10:
                return $this->oct;
            case 11:
                return $this->nov;
            case 12:
                return $this->dec;
        }
    }

    private function getWeekName($month = false)
    {
        // print the month
        if (!$month) {
            $month = @$this->actmonth;
        }
        if ($this->monthNames) {
            echo $this->monthNames[$month - 1];
        } else {
            switch ($month) {
                case 1:
                    echo $this->jan;
                    break;
                case 2:
                    echo $this->feb;
                    break;
                case 3:
                    echo $this->mar;
                    break;
                case 4:
                    echo $this->apr;
                    break;
                case 5:
                    echo $this->may;
                    break;
                case 6:
                    echo $this->jun;
                    break;
                case 7:
                    echo $this->jul;
                    break;
                case 8:
                    echo $this->aug;
                    break;
                case 9:
                    echo $this->sep;
                    break;
                case 10:
                    echo $this->oct;
                    break;
                case 11:
                    echo $this->nov;
                    break;
                case 12:
                    echo $this->dec;
                    break;
            }
        }
        echo ' ' . $this->actyear . ' / Week ' . $this->actweek;
    }

    /*
	********************************************************************************
	PRIVATE getDayName() -> returns the day's name, according to the configuration
	********************************************************************************
	*/
    private function getDayName($var = false)
    {
        if ($this->dayNames) {
            return $this->dayNames[$var];
        }
        switch ($var) {
            case 0:
                return $this->sun;
            case 1:
                return $this->mon;
            case 2:
                return $this->tue;
            case 3:
                return $this->wed;
            case 4:
                return $this->thu;
            case 5:
                return $this->fri;
            case 6:
                return $this->sat;
        }
    }

    /*
	********************************************************************************
	PRIVATE getMonthDays() -> returns the number of days of the month specified
	********************************************************************************
	*/
    private function getMonthDays($month, $year)
    {
        $has31days = checkdate($month, 31, $year);
        $isSchalt = checkdate(2, 29, $year);
        if ($isSchalt == 1 and $month == 2) {
            $maxdays = 29;
        } elseif ($isSchalt != 1 and $month == 2) {
            $maxdays = 28;
        } elseif ($has31days == 1) {
            $maxdays = 31;
        } else {
            $maxdays = 30;
        }
        return $maxdays;
    }

    /*
	********************************************************************************
	PRIVATE getWeekday() -> returns the weekday's number, 0 = Sunday ... 6 = Saturday
	********************************************************************************
	*/
    private function getWeekday($var)
    {
        return $this->mkActiveDate("w", $this->mkActiveTime(0, 0, 1, $this->actmonth, $var, $this->actyear));
    }

    /*
	********************************************************************************
	PRIVATE getWeekNum() -> returns the week number, php version > 4.1.0, unsupported by the ADOdb Date Library
	********************************************************************************
	*/
    private function getWeekNum($var)
    {
        return date("W", $this->mkActiveTime(0, 0, 1, $this->actmonth, $var, $this->actyear)) + 0;
    }


    /**
     * This method checks if a date was set as an event and creates the eventID
     * (css layout) and eventUrl
     *
     * @param int $day   The day
     * @param int $month [optional] The month
     * @param int $year  [optional] The year
     * @param int $hour  [optional] The hour
     *
     * @return bool
     */
    private function isEvent($day, $month = false, $year = false, $hour = false, $minute = false)
    {
        if (!$month) {
            $month = $this->actmonth;
        }
        if (!$year) {
            $year = $this->actyear;
        }
        if (!$hour) {
            $hour = 0;
        }
        if (!$minute) {
            $minute = 0;
        }
        if ($this->calEvents) {
            $checkTime = $this->mkActiveTime($hour, $minute, 1, $month, $day, $year);
            $selectedTime = $this->mkActiveTime($hour, $minute, 1, $this->selectedmonth, $this->selectedday, $this->selectedyear);
            $todayTime = $this->mkActiveTime($hour, $minute, 1, $this->monthtoday, $this->daytoday, $this->yeartoday);
            foreach ($this->calEvents as $eventTime => $eventID) {
                if ($eventTime == $checkTime) {
                    if ($eventTime == $selectedTime) {
                        $this->eventID = $this->cssPrefixSelecEvent . $eventID;
                    } elseif ($eventTime == $todayTime) {
                        $this->eventID = $this->cssPrefixTodayEvent . $eventID;
                    } else {
                        $this->eventID = $eventID;
                    }
                    if ($this->calEventsUrl[$eventTime]) {
                        $this->eventUrl = $this->calEventsUrl[$eventTime];
                    }
                    return true;
                }
            }
            return false;
        }
    }


    /**
     * This method checks if an event content was set
     *
     * @param int $var   The day
     * @param int $month [optional] The month
     * @param int $year  [optional] The year
     *
     * @return bool|assoc Array if true, boolean false if no content set
     */
    private function hasEventContent($var, $month = false, $year = false, $hour = false, $minute = false)
    {
        if (!$month) {
            $month = $this->actmonth;
        }
        if (!$year) {
            $year = $this->actyear;
        }
        if (!$hour) {
            $hour = 0;
        }
        if (!$minute) {
            $minute = 0;
        }

        $hasContent = false;
        if ($this->calEventContent !== false and count($this->calEventContent) > 0) {
            $checkTime = $this->mkActiveTime($hour, $minute, 1, $month, $var, $year);
            foreach ($this->calEventContent as $key => $eventContent) {
                $eventContentUrl = $this->calEventContentUrl[$key];
                $eventContentClass = $this->calEventContentClass[$key];
                $eventContentId = $this->calEventContentId[$key];
                foreach ($eventContent as $eventTime => $eventContent) {
                    if ($eventTime == $checkTime) {
                        $array = array();
                        $array[$eventContentClass][$eventContentUrl] = array('content' => $eventContent, 'id' => $eventContentId);
                        $hasContent[] = $array;
                        // remove old data to save future checking cycles!
                        unset($this->calEventContent[$key]);
                        unset($this->calEventContentUrl[$key]);
                        unset($this->calEventContentClass[$key]);
                        unset($this->calEventContentId[$key]);
                    }
                }
            }
        }
        return $hasContent;
    }


    /*
	********************************************************************************
	PRIVATE mkActiveDate() -> checks if ADOdb Date Library is loaded and calls the date function
	********************************************************************************
	*/
    private function mkActiveDate($param, $acttime = false)
    {
        if (!$acttime) {
            $acttime = $this->timetoday;
        }
        if (function_exists("adodb_date")) {
            return adodb_date($param, $acttime);
        } else {
            return date($param, $acttime);
        }
    }

    /*
	********************************************************************************
	PRIVATE mkActiveGMDate() -> checks if ADOdb Date Library is loaded and calls the gmdate function
	********************************************************************************
	*/
    private function mkActiveGMDate($param, $acttime = false)
    {
        if (!$acttime) {
            $acttime = time();
        }
        if (function_exists("adodb_gmdate")) {
            return adodb_gmdate($param, $acttime);
        } else {
            return gmdate($param, $acttime);
        }
    }

    /*
	********************************************************************************
	PRIVATE mkActiveTime() -> checks if ADOdb Date Library is loaded and calls the mktime function
	********************************************************************************
	*/
    private function mkActiveTime($hr, $min, $sec, $month = false, $day = false, $year = false)
    {
        if (function_exists("adodb_mktime")) {
            return adodb_mktime($hr, $min, $sec, $month, $day, $year);
        } else {
            return mktime($hr, $min, $sec, $month, $day, $year);
        }
    }
}
