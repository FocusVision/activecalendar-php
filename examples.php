<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head><title>Active Calendar Project :: Code Examples</title>
<link rel="stylesheet" type="text/css" href="data/css/main.css" />
</head>
<body>
<?php
	if (!@include("activecalendar.php")) die("The structure of the Active Calendar Project package has been modified. Unable to proceed...\n</body>\n</html>");
$cal=new activeCalendar();
$version=$cal->version;
?>
<h1>Active Calendar Project :: Code Examples</h1>
<h2>class <i>activeCalendar</i> version <?php print $version;?> (<a href="data/showcode.php?page=../activecalendar.php">view source code</a>)</h2>
<h3>using subclass <i>activeCalendarWeek</i> (<a href="data/showcode.php?page=../activecalendarweek.php">view source code</a>)</h3>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta name="generator" content="HTML Tidy for Windows (vers 14 February 2006), see www.w3.org">
<title></title>
</head>
<body>
<table align="center" class="exampletbl">
<tr>
<th></th>
<th>Description</th>
<th>Layout</th>
<th>Code</th>
</tr>
<tr>
<td rowspan="5" id="monthexamples">Month<br>
Calendars</td>
<td>Current month calendar with week number column and week starting on Sunday</td>
<td><a href="data/m_1.php?css=css/default.css">[ Default ]</a><a href="data/m_1.php?css=css/antique.css">[ Antique ]</a><a href="data/m_1.php?css=css/ceramique.css">[ Ceramique ]</a><a href="data/m_1.php?css=css/plain.css">[ Black&amp;White ]</a></td>
<td><a href="data/showcode.php?page=m_1.php">php code</a></td>
</tr>

<tr>
<td>Current month calendar with navigation controls and date picker</td>
<td><a href="data/m_2.php?css=css/default.css">[ Default ]</a><a href="data/m_2.php?css=css/antique.css">[ Antique ]</a><a href="data/m_2.php?css=css/ceramique.css">[ Ceramique ]</a><a href="data/m_2.php?css=css/plain.css">[ Black&amp;White ]</a></td>
<td><a href="data/showcode.php?page=m_2.php">php code</a></td>
</tr>

<tr>
<td>Month calendar (November 2007) with linkable days and week numbers</td>
<td><a href="data/m_3.php?css=css/default.css">[ Default ]</a><a href="data/m_3.php?css=css/antique.css">[ Antique ]</a><a href="data/m_3.php?css=css/ceramique.css">[ Ceramique ]</a><a href="data/m_3.php?css=css/plain.css">[ Black&amp;White ]</a></td>
<td><a href="data/showcode.php?page=m_3.php">php code</a></td>
</tr>

<tr>
<td>Month calendar (November 2007) with multiple 'event days'</td>
<td><a href="data/m_4.php?css=css/default.css">[ Default ]</a><a href="data/m_4.php?css=css/antique.css">[ Antique ]</a><a href="data/m_4.php?css=css/ceramique.css">[ Ceramique ]</a><a href="data/m_4.php?css=css/plain.css">[ Black&amp;White ]</a></td>
<td><a href="data/showcode.php?page=m_4.php">php code</a></td>
</tr>

<tr>
<td>Month calendar (November 2007) with multiple 'event contents'</td>
<td><a href="data/m_5.php?css=css/default_wide.css">[ Default ]</a><a href="data/m_5.php?css=css/antique_wide.css">[ Antique ]</a><a href="data/m_5.php?css=css/ceramique_wide.css">[ Ceramique ]</a><a href="data/m_5.php?css=css/plain_wide.css">[ Black&amp;White ]</a> Wide</td>
<td><a href="data/showcode.php?page=m_5.php">php code</a></td>
</tr>

<tr>
<td rowspan="4" id="yearexamples">Year<br>
Calendars</td>
<td>Current year calendar with week number columns and 3 months in each row</td>
<td><a href="data/y_1.php?css=css/default.css">[ Default ]</a><a href="data/y_1.php?css=css/antique.css">[ Antique ]</a><a href="data/y_1.php?css=css/ceramique.css">[ Ceramique ]</a><a href="data/y_1.php?css=css/plain.css">[ Black&amp;White ]</a></td>
<td><a href="data/showcode.php?page=y_1.php">php code</a></td>
</tr>

<tr>
<td>Current year calendar with navigation controls and date picker</td>
<td><a href="data/y_2.php?css=css/default.css">[ Default ]</a><a href="data/y_2.php?css=css/antique.css">[ Antique ]</a><a href="data/y_2.php?css=css/ceramique.css">[ Ceramique ]</a><a href="data/y_2.php?css=css/plain.css">[ Black&amp;White ]</a></td>
<td><a href="data/showcode.php?page=y_2.php">php code</a></td>
</tr>

<tr>
<td>Current year calendar with linkable days and multiple 'event days'</td>
<td><a href="data/y_3.php?css=css/default.css">[ Default ]</a><a href="data/y_3.php?css=css/antique.css">[ Antique ]</a><a href="data/y_3.php?css=css/ceramique.css">[ Ceramique ]</a><a href="data/y_3.php?css=css/plain.css">[ Black&amp;White ]</a></td>
<td><a href="data/showcode.php?page=y_3.php">php code</a></td>
</tr>

<tr>
<td>Current 1 row year calendar starting on May</td>
<td><a href="data/y_4.php?css=css/default.css">[ Default ]</a><a href="data/y_4.php?css=css/antique.css">[ Antique ]</a><a href="data/y_4.php?css=css/ceramique.css">[ Ceramique ]</a><a href="data/y_4.php?css=css/plain.css">[ Black&amp;White ]</a></td>
<td><a href="data/showcode.php?page=y_4.php">php code</a></td>
</tr>

<tr>
<td rowspan="5" id="weekexamples">Week<br>
Calendars</td>
<td>Current 1 row week calendar with week number column</td>
<td><a href="data/w_1.php?css=css/default_wide.css">[ Default ]</a><a href="data/w_1.php?css=css/antique_wide.css">[ Antique ]</a><a href="data/w_1.php?css=css/ceramique_wide.css">[ Ceramique ]</a><a href="data/w_1.php?css=css/plain_wide.css">[ Black&amp;White ]</a> Wide</td>
<td><a href="data/showcode.php?page=w_1.php">php code</a></td>
</tr>

<tr>
<td>Current 12 rows week calendar with week number column</td>
<td><a href="data/w_2.php?css=css/default_wide.css">[ Default ]</a><a href="data/w_2.php?css=css/antique_wide.css">[ Antique ]</a><a href="data/w_2.php?css=css/ceramique_wide.css">[ Ceramique ]</a><a href="data/w_2.php?css=css/plain_wide.css">[ Black&amp;White ]</a> Wide</td>
<td><a href="data/showcode.php?page=w_2.php">php code</a></td>
</tr>
<tr>
<td>6 rows week calendar with multiple 'event contents' starting on 1 Feb 2010</td>
<td><a href="data/w_3.php?css=css/default_wide.css">[ Default ]</a><a href="data/w_3.php?css=css/antique_wide.css">[ Antique ]</a><a href="data/w_3.php?css=css/ceramique_wide.css">[ Ceramique ]</a><a href="data/w_3.php?css=css/plain_wide.css">[ Black&amp;White ]</a> Wide</td>
<td><a href="data/showcode.php?page=w_3.php">php code</a></td>
</tr>

<tr>
<td>Calendar without week number column of the 39th week 2008 starting on Sunday</td>
<td><a href="data/w_4.php?css=css/default_wide.css">[ Default ]</a><a href="data/w_4.php?css=css/antique_wide.css">[ Antique ]</a><a href="data/w_4.php?css=css/ceramique_wide.css">[ Ceramique ]</a><a href="data/w_4.php?css=css/plain_wide.css">[ Black&amp;White ]</a> Wide</td>
<td><a href="data/showcode.php?page=w_4.php">php code</a></td>
</tr>

<tr>
<td>8 rows calendar starting with the 39th week 2008 with week number column</td>
<td><a href="data/w_5.php?css=css/default_wide.css">[ Default ]</a><a href="data/w_5.php?css=css/antique_wide.css">[ Antique ]</a><a href="data/w_5.php?css=css/ceramique_wide.css">[ Ceramique ]</a><a href="data/w_5.php?css=css/plain_wide.css">[ Black&amp;White ]</a> Wide</td>
<td><a href="data/showcode.php?page=w_5.php">php code</a></td>
</tr>

<tr>
<td rowspan="4" id="specialexamples">Special<br>
Calendars</td>
<td>Month calendar with linkable 'event contents', using records from a flat file</td>
<td><a href="data/flatevents.php?css=css/default_wide.css">[ Default ]</a><a href="data/flatevents.php?css=css/antique_wide.css">[ Antique ]</a><a href="data/flatevents.php?css=css/ceramique_wide.css">[ Ceramique ]</a><a href="data/flatevents.php?css=css/plain_wide.css">[ Black&amp;White ]</a> Wide</td>
<td><a href="data/showcode.php?page=flatevents.php">[php]</a><a href="data/showcode.php?page=flatevents.txt">[flatfile]</a></td>
</tr>

<tr>
<td>Month calendar with linkable 'event contents', using records from an xml file</td>
<td><a href="data/xmlevents.php?css=css/default_wide.css">[ Default ]</a><a href="data/xmlevents.php?css=css/antique_wide.css">[ Antique ]</a><a href="data/xmlevents.php?css=css/ceramique_wide.css">[ Ceramique ]</a><a href="data/xmlevents.php?css=css/plain_wide.css">[ Black&amp;White ]</a> Wide</td>
<td><a href="data/showcode.php?page=xmlevents.php">[php]</a><a href="data/showcode.php?page=xmlevents.xml">[xml]</a></td>
</tr>
<tr>
<td>Month calendar with linkable 'event contents', using records from a MySQL database</td>
<td><a href="data/mysqlevents.php?css=css/default_wide.css">[ Default ]</a><a href="data/mysqlevents.php?css=css/antique_wide.css">[ Antique ]</a><a href="data/mysqlevents.php?css=css/ceramique_wide.css">[ Ceramique ]</a><a href="data/mysqlevents.php?css=css/plain_wide.css">[ Black&amp;White ]</a> Wide</td>
<td><a href="data/showcode.php?page=mysqlevents.php">php code</a></td>
</tr>

<tr>
<td>Month popup calendar as date selector in a form using JavaScript</td>
<td><a href="data/javascript.php?css=css/default.css">[ Default ]</a><a href="data/javascript.php?css=css/antique.css">[ Antique ]</a><a href="data/javascript.php?css=css/ceramique.css">[ Ceramique ]</a><a href="data/javascript.php?css=css/plain.css">[ Black&amp;White ]</a></td>
<td><a href="data/showcode.php?page=javascript.php">[php1]</a><a href="data/showcode.php?page=js.php">[php2]</a><br>
<a href="data/showcode.php?page=functions.js">[javascript]</a></td>
</tr>

</table>
</body>
</html>

<br />
<a href="index.php">Back to index.php</a>
</body>
</html>