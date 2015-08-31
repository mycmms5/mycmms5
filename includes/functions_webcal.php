<?php
/**
* WebCalendar functions 
* 
* @author Werner Huysmans
* @version 1.0
* @package webcalendar
* @subpackage standard
* @filesource
* CVS
* $Id: functions_webcal.php,v 1.2 2013/04/27 09:39:46 werner Exp $
* $Source: /var/www/cvs/mycmms_wc/myCMMS_WC/includes/functions_webcal.php,v $
* $Log: functions_webcal.php,v $
* Revision 1.2  2013/04/27 09:39:46  werner
* Inserted CVS variables Id,Source and Log
*
*/
/**
* Generates a list of weeks
* @param mixed $webcal_date
*/
function weeks($webcal_date) {
    if (!empty($webcal_date)) {
        $m=substr($webcal_date,4,2);
        $y=substr($webcal_date,0,4);
        $d=substr($webcal_date,6,2);
    } else {
        $m=date('m');
        $y=date('Y');
        $d=date('d');
    }
    $d_time=mktime(0,0,0,$m,$d,$y );
    $thisdate=date('Ymd',$d_time);
    $thisweek=date('W',$d_time);
    $wkstart=strtotime('Last Monday',$d_time);
    $selectedWeek=date('W',$wkstart);   // This Week
    for ($i=-5; $i<=9; $i++) {
      $twkstart=$wkstart+(604800*$i);
      $twkend=$twkstart+(86400*6);  # 4 if DISPLAY_WEEKEND='N'
      $dateW=date('W',$twkstart);
      $dateSYmd = date ( 'Ymd', $twkstart );
      $dateEYmd = date ('Ymd', $twkend );
      $dateW=date('W',strtotime('Last Monday',$twkstart));
      if ( $twkstart > 0 && $twkend < 2146021200 ) {
        $weeks[$i]['option']=$dateSYmd;
        $weeks[$i]['value']=date("M d",$twkstart)." - ".date("M d",$twkend);
        if ($selectedWeek==$dateW) {
            $weeks[$i]['selected']=true;
        } else {
            $weeks[$i]['selected']=false;
        }
      }
    }
    return $weeks;
} // EO weeks
/**
* Generates a list of months
* 
* @param mixed $webcal_date
*/
function months($webcal_date) {
    if (!empty($webcal_date)) {
        $m=substr($webcal_date,4,2);
        $y=substr($webcal_date,0,4);
        $d=substr($webcal_date,6,2);
    } else {
        $m=date('m');
        $y=date('Y');
        $d=date('d');
    }
    $d_time=mktime(0,0,0,$m,1,$y);
    $thisdate=date('Ymd',$d_time);
    $selectedMonth=date('M Y',$d_time);
    // $months[0]['selected']=date_format("Ymd",$d_time);
    $m -= 7;
    for ( $i = 0; $i < 25; $i++ ) {
        $m++;
        if ( $m > 12 ) {
            $m = 1;
            $y++; }
        if ( $y >= 1970 && $y < 2038 ) {
            $d=mktime(0,0,0,$m,1,$y );
            $months[$i]['option']=date('Ymd',$d);
            $months[$i]['value']=date('M Y',$d);
            if ($selectedMonth==date('M Y',$d)) {
                $months[$i]['selected']=true;
            } else {
                $months[$i]['selected']=false;
            }
        }
    }
    return $months;
} // EO months
/**
* Generates a list of years
* 
* @param mixed $webcal_date
*/
function years($webcal_date) {
    if (!empty($webcal_date)) {
        $y=substr($webcal_date,0,4);
    } else {
        $y=date('Y');
    }
    $selectedYear=$y;
    for ( $i = $y - 2; $i < $y + 6; $i++ ) {
        if ( $i >= 1970 && $i < 2038 ) {
            $d=mktime(0,0,0,1,1,$i);
            $years[$i]['option']=$i;
            $years[$i]['value']=$i;
            if ($selectedYear==date('Y',$d)) {
                $years[$i]['selected']=true;
            } else {
                $years[$i]['selected']=false;
            }
        }
    }
    return $years;
} // EO years
/* Converts a date in YYYYMMDD format into "Friday, December 31, 1999",
 * "Friday, 12-31-1999" or whatever format the user prefers.
 *
 * @param string $indate        Date in YYYYMMDD format
 * @param string $format        Format to use for date
 *                              (default is "__month__ __dd__, __yyyy__")
 * @param bool   $show_weekday  Should the day of week also be included?
 * @param bool   $short_months  Should the abbreviated month names be used
 *                              instead of the full month names?
 * @param bool   $forceTranslate Check to see if there is a translation for
 *            the specified data format.  If there is, then use
 *            the translated format from the language file, but
 *            only if $DATE_FORMAT is language-defined.
 *
 * @return string  Date in the specified format.
 *
 * @global string Preferred date format
 * @TODO Add other date () parameters like ( j, n )
 */
function date_to_str2 ($indate,$format,$show_weekday=tru,$short_months=false,$froceTranslate=false) {
    if ( strlen ( $indate ) == 0 ) {
        $indate=date('Ymd'); 
    } else {
        $y = intval ( $indate / 10000 );
        $m = intval ( $indate / 100 ) % 100;
        $d = $indate % 100;
    }
    return $y.$m.$d;
}
function date_to_str ( $indate, $format = '', $show_weekday = true, $short_months = false, $forceTranslate = false ) {
  global $DATE_FORMAT;

  if ( strlen ( $indate ) == 0 )
    $indate = date ( 'Ymd' );

  // If they have not set a preference yet...
  if ( $DATE_FORMAT == '' || $DATE_FORMAT == 'LANGUAGE_DEFINED' )
    $DATE_FORMAT = translate ( '__month__ __dd__, __yyyy__' );
  else if ( $DATE_FORMAT == 'LANGUAGE_DEFINED' &&
    $forceTranslate && $format != '' && translation_exists ( $format ) ) {
    $format = gettext ( $format );
  }

  if ( empty ( $format ) )
    $format = $DATE_FORMAT;

  $y = intval ( $indate / 10000 );
  $m = intval ( $indate / 100 ) % 100;
  $d = $indate % 100;
  $wday = strftime ( "%w", mktime ( 0, 0, 0, $m, $d, $y ) );
  if ( $short_months ) {
    $month = month_name ( $m - 1, 'M' );
    $weekday = weekday_name ( $wday, 'D' );
  } else {
    $month = month_name ( $m - 1 );
    $weekday = weekday_name ( $wday );
  }

  $ret = str_replace ( '__dd__', $d, $format );
  $ret = str_replace ( '__j__', intval ( $d ), $ret );
  $ret = str_replace ( '__mm__', $m, $ret );
  $ret = str_replace ( '__mon__', $month, $ret );
  $ret = str_replace ( '__month__', $month, $ret );
  $ret = str_replace ( '__n__', sprintf ( "%02d", $m ), $ret );
  $ret = str_replace ( '__yy__', sprintf ( "%02d", $y % 100 ), $ret );
  $ret = str_replace ( '__yyyy__', $y, $ret );

  return ( $show_weekday ? "$weekday, $ret" : $ret );
}
/* Prints out a minicalendar for a month.
 *
 * @todo Make day.php NOT be a special case
 *
 * @param int    $thismonth      Number of the month to print
 * @param int    $thisyear       Number of the year
 * @param bool   $showyear       Show the year in the calendar's title?
 * @param bool   $show_weeknums  Show week numbers to the left of each row?
 * @param string $minical_id     id attribute for the minical table
 * @param string $month_link     URL and query string for month link that should
 *                               come before the date specification (e.g.
 *                               month.php?  or  view_l.php?id=7&amp;)
 */
function display_small_month ( $thismonth, $thisyear, $showyear) {
  $monthstart=date('Ymd',mktime(0,0,0,$thismonth,1,$thisyear));
  $monthend=date('Ymd',mktime(0,0,0,$thismonth+1,1,$thisyear));
  $wkstart=get_weekday_before($thisyear,$thismonth,1);
  $month_ago=date ( 'Ymd', mktime ( 0, 0, 0, $thismonth - 1, $thisday, $thisyear ) );
  $month_ahead=date ( 'Ymd', mktime ( 0, 0, 0, $thismonth + 1, $thisday, $thisyear ) );
 
  for ($i=$wkstart; date('Ymd',$i) <= $monthend; $i += 604800) {
      for ( $j = 0; $j < 7; $j++ ) {
            $date=$i+($j*86400+43200);  
            $days[$i][$j]['WEEKNUM']=date("W",$date);
            $days[$i][$j]['EVENTS']=false;
            $days[$i][$j]['DAY']=date("j",$date);
            $days[$i][$j]['RAW']=$date;
            $days[$i][$j]['WEEKDAY']=date("w",$date);
      }
  } // EO for
  $tpl=new smarty_mycmms();
  $tpl->caching=false;
  $tpl->debugging=false;
  $tpl->assign("thisyear",$thisyear);
  $tpl->assign("thismonth",$thismonth);
  $tpl->assign("days",$days);
  $tpl->assign("monthname",month_name($thismonth,'L'));
  return $tpl->fetch("minical.tpl");
} // EO 
/* Returns the either the full name or the abbreviation of the specified month.
 *
 * @param int     $m       Number of the month (0-11)
 * @param string  $format  'F' = full, 'M' = abbreviation
 *
 * @return string The name of the specified month.
 */
function month_name ( $m, $format = 'L' ) {
    static $local_lang, $month_names, $monthshort_names;
    if (empty($month_names[0]) || empty($monthshort_names[0])) {
        $month_names = array (
            gettext('January'),
            gettext('February'),
            gettext('March'),
            gettext('April'),
            gettext('May_'), // needs to be different than "May",
            gettext('June'),
            gettext('July'),
            gettext('August'),
            gettext('September'),
            gettext('October'),
            gettext('November'),
            gettext('December'));
        $monthshort_names = array (
            gettext ( 'Jan' ),
            gettext ( 'Feb' ),
            gettext ( 'Mar' ),
            gettext ( 'Apr' ),
            gettext ( 'May' ),
            gettext ( 'Jun' ),
            gettext ( 'Jul' ),
            gettext ( 'Aug' ),
            gettext ( 'Sep' ),
            gettext ( 'Oct' ),
            gettext ( 'Nov' ),
            gettext ( 'Dec' ));
  } // EO if empty array
  if ( $m >= 0 && $m < 12 )
    return ( $format == 'L' ? $month_names[$m] : $monthshort_names[$m] );
  return gettext ( 'unknown-month' ) . " ($m)";
}

/* Determines what the day is and sets it globally.
 * All times are in the user's timezone
 *
 * The following global variables will be set:
 * - <var>$thisyear</var>
 * - <var>$thismonth</var>
 * - <var>$thisday</var>
 * - <var>$thisdate</var>
 * - <var>$today</var>
 *
 * @param string $date  The date in YYYYMMDD format
 */
function set_today ( $date = '' ) {
    global $day, $month, $thisdate, $thisday, $thismonth, $thisyear, $today, $year;
    $today = time ();
    if (empty($date)) {
        $thisyear = (empty($year) ? date('Y',$today) : $year );
        $thismonth = ( empty ( $month ) ? date ( 'm', $today ) : $month );
        $thisday = ( empty ( $day ) ? date ( 'd', $today ) : $day );
    } else {
        $thisyear = substr ( $date, 0, 4 );
        $thismonth = substr ( $date, 4, 2 );
        $thisday = substr ( $date, 6, 2 );
    }
    $thisdate = sprintf ( "%04d%02d%02d", $thisyear, $thismonth, $thisday );
}
/* Gets the previous weekday of the week containing the specified date.
 *
 * If the date specified is a Sunday, then that date is returned.
 *
 * @param int $year   Year
 * @param int $month  Month (1-12)
 * @param int $day    Day (1-31)
 *
 * @return int  The date (in UNIX timestamp format).
 */
function get_weekday_before ( $year, $month, $day = 2 ) {
global $DISPLAY_WEEKENDS, $WEEK_START, $weekday_names;
    // Construct string like 'last Sun'.
    $laststr = 'last Monday'; //$weekday_names[$WEEK_START];
    // We default day=2 so if the 1ast is Sunday or Monday it will return the 1st.
    $newdate=strtotime($laststr,mktime ( 0, 0, 0, $month, $day, $year ) + $GLOBALS['tzOffset'] );
    // Check DST and adjust newdate.
    while ( date ( 'w', $newdate ) == date ( 'w', $newdate + 86400 ) ) {
        $newdate += 3600;
    }
    return $newdate;
}
/* Returns either the full name or the abbreviation of the day.
 *
 * @param int     $w       Number of the day in the week (0=Sun,...,6=Sat)
 * @param string  $format  'l' (lowercase L) = Full, 'D' = abbreviation.
 *
 * @return string The weekday name ("Sunday" or "Sun")
 */
function weekday_name ( $w, $format = 'l' ) {
  global $lang;
  static $local_lang, $week_names, $weekday_names;

  // We may have switched languages.
  if ( $local_lang != $lang )
    $week_names = $weekday_names = array ();

  $local_lang = $lang;

  // We may pass $DISPLAY_LONG_DAYS as $format.
  if ( $format == 'N' )
    $format = 'D';

  if ( $format == 'Y' )
    $format = 'l';

  if ( empty ( $weekday_names[0] ) || empty ( $week_names[0] ) ) {
    $weekday_names = array (
      gettext ( 'Sunday' ),
      gettext ( 'Monday' ),
      gettext ( 'Tuesday' ),
      gettext ( 'Wednesday' ),
      gettext ( 'Thursday' ),
      gettext ( 'Friday' ),
      gettext ( 'Saturday' )
      );

    $week_names = array (
      gettext ( 'Sun' ),
      gettext ( 'Mon' ),
      gettext ( 'Tue' ),
      gettext ( 'Wed' ),
      gettext ( 'Thu' ),
      gettext ( 'Fri' ),
      gettext ( 'Sat' )
      );
  }

  if ( $w >= 0 && $w < 7 )
    return ( $format == 'l' ? $weekday_names[$w] : $week_names[$w] );

  return gettext ( 'unknown-weekday' ) . " ($w)";
}
/* Determine if date is a weekend
 *
 * @param int $date  Timestamp of subject date OR a weekday number 0-6
 *
 * @return bool  True = Date is weekend
 */
function is_weekend ( $date ) {
  global $WEEKEND_START;

  // We can't test for empty because $date may equal 0.
  if ( ! strlen ( $date ) )
    return false;

  if ( ! isset ( $WEEKEND_START ) )
    $WEEKEND_START = 6;

  // We may have been passed a weekday 0-6.
  if ( $date < 7 )
    return ( $date == $WEEKEND_START % 7 || $date == ( $WEEKEND_START + 1 ) % 7 );

  // We were passed a timestamp.
  $wday = date ( 'w', $date );
  return ( $wday == $WEEKEND_START % 7 || $wday == ( $WEEKEND_START + 1 ) % 7 );
}
?>
