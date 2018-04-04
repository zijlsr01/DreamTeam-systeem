<?php

  $date      = $_GET['date'];
  $startTime = $_GET['startTime'];
  $endTime   = $_GET['endTime'];
  $subject   = $_GET['subject'];
  $location   = $_GET['location'];
  $desc      = $_GET['desc'];

  $ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
TZID:Europa/Amsterdam
BEGIN:VEVENT
UID:" . md5(uniqid(mt_rand(), true)) . "example.com
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:".$date."T".$startTime."00
DTEND:".$date."T".$endTime."00
LOCATION:".$location."
SUMMARY:".$subject."
DESCRIPTION:".$desc."
END:VEVENT
END:VCALENDAR";

  //set correct content-type-header
  header('Content-type: text/calendar; charset=utf-8');
  header('Content-Disposition: inline; filename=calendar.ics');
  echo $ical;
  exit;
?>
