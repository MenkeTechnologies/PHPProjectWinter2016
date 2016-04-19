<?php

/**
 * Calendar Class Definitions
 * 
 * Create your class definition in this file
 * 
 */
class Calendar {

    private $month;
    private $year;
    private $events = array();

    public function __construct($month, $year) {
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * return String of month number for display
     * @return string
     */
    public function monthString() {
        switch ($this->month) {
            case '1': return "January";
            case '2': return "February";
            case '3': return "March";
            case '4': return "April";
            case '5': return "May";
            case '6': return "June";
            case '7': return "July";
            case '8': return "August";
            case '9': return "September";
            case '10': return "October";
            case '11': return "November";
            case '12': return "December";
            default : return "Error";
        }
    }

    /**
     * add event to array of events
     * @param type $event
     */
    public function addEvent($event) {
        array_push($this->events, $event);
    }

    /**
     * getter method for events array
     * @return events
     */
    public function getEvents() {
        return $this->events;
    }

    /**
     * determines if year is leap year or not
     * @return boolean
     */
    public function isLeapYear() {
        if ($this->year % 100 != 0 && $this->year % 4 == 0) {
            return true;
        } else if ($this->year % 100 == 0 && $this->year % 400 == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * returns number of days in month
     * @return int
     */
    public function daysInMonth() {

        switch ($this->month) {

            case 1: return 31;
            case 2: if ($this->isLeapYear() == true) {
                    return 29;
                } else
                    return 28;

            case 3: return 31;
            case 4: return 30;
            case 5: return 31;
            case 6: return 30;
            case 7: return 31;
            case 8: return 31;
            case 9: return 30;
            case 10: return 31;
            case 11: return 30;
            case 12: return 31;
        }
    }

    /**
     * returns month code from current month for purposes of algorithm calculating
     * the day of the week the month starts on
     * @return int
     */
    public function getMonthCode() {
        switch ($this->month) {
            case 1: return 0;
            case 2: return 3;
            case 3: return 3;
            case 4: return 6;
            case 5: return 1;
            case 6: return 4;
            case 7: return 6;
            case 8: return 2;
            case 9: return 5;
            case 10: return 0;
            case 11: return 3;
            case 12: return 5;
        }
    }

    /**
     * returns century code from current year for purposes of algorithm calculating
     * the day of the week the month starts on
     * @return int
     */
    public function getCenturyCode() {
        switch (substr($this->year, 0, 2)) {
            case 17: return 4;
            case 18: return 2;
            case 19: return 0;
            case 20: return 6;
            case 21: return 4;
            case 22: return 2;
            case 23: return 0;
            default: echo "Century is out of range";
        }
    }

    /**
     * algorith for calculating the starting day of the week of the month
     * @return int
     */
    public function getStartingDay() { //function to determine the day of the week each month starts on using formula from http://blog.artofmemory.com/how-to-calculate-the-day-of-the-week-4203.html
        $last2digits = substr($this->year, 2, 4);

        $yearCode = ($last2digits + ($last2digits / 4)) % 7;

        $monthCode = $this->getMonthCode();

        $centuryCode = $this->getCenturyCode();


        if ($this->isLeapYear() == true && ($this->month == 1 || $this->month == 2)) {
            $leapYearCode = 1;
        } else {
            $leapYearCode = 0;
        }

        $startingDayOfTheWeek = ($yearCode + $monthCode + $centuryCode + 1 - $leapYearCode) % 7; //Main algorithm


        return $startingDayOfTheWeek; //0 is Sunday, 1 is Monday...
    }

    /**
     * get the day from the starting date and time
     * @param type $date
     * @return string
     */
    public function getDayFromStartingDateTime($date) {


        $dateNoTIme = preg_split("/\s/", $date);

        $day = substr($dateNoTIme[0], 8, 9);

        return $day;
    }

    /**
     * get year from starting date and time
     * @param type $date
     * @return string
     */
    public function getYearFromStartingDateTime($date) {

        $dateNoTIme = preg_split("/\s/", $date);

        $year = substr($dateNoTIme[0], 0, 4);

        return $year;
    }

    /**
     * get month from starting date and time
     * @param type $date
     * @return string
     */
    public function getMonthFromStartingDateTime($date) {

        $dateNoTIme = preg_split("/\s/", $date);

        $month = substr($dateNoTIme[0], 5, 7);

        return $month;
    }

    /**
     * draw calendar
     */
    public function draw() {

        //calendar header
        echo "<table border='2' padding='5'>
        <tr>
        <th colspan='7' style='font-size:1.5em'> " . $this->monthString() . " " . $this->year . "</th>
        </tr>
        <tr>
        <th> Sunday </th>
        <th> Monday </th>
        <th> Tuesday </th>
        <th> Wednesday </th>
        <th> Thursday </th>
        <th> Friday </th>
        <th> Saturday </th>
        </tr>
        <tr>";

        //sort the array by start time.  convert start day and time to timestamp and then sort using cmp func
        function cmp($a, $b) {
            if (strtotime($a->getStart()) == strtotime($b->getStart())) {
                return 0;
            }
            return (strtotime($a->getStart()) < strtotime($b->getStart())) ? -1 : 1;
        }

        usort($this->events, "cmp");

        $counter = 0; //counter for counting days in month drawn
        $counterIterations = 0; //counter for counting the total number of table cells drawn


        for ($r = 0; $r < 6; $r++) { //nested for loops for creating days in month
            for ($c = 0; $c < 7; $c++) {
                $counterIterations++; //outside the month, empty days will be filled with solid color at end of loop

                if ($counterIterations > $this->getStartingDay()) { //inside the month
                    $counter++;
                    if ($counter <= $this->daysInMonth()) { //get data for each day
                        echo "<td>$counter<br>"; // start cell and echo day number

                        for ($i = 0; $i < count($this->getEvents()); $i++) { //get sorted events array
                            //get date from each event
                            $date = $this->getEvents()[$i]->getStart();

                            //get day, month and year from each event
                            $day = $this->getDayFromStartingDateTime($date);
                            $month = $this->getMonthFromStartingDateTime($date);
                            $year = $this->getYearFromStartingDateTime($date);

                            //if this is proper cell for each event then get the details and echo them
                            if ($counter == $day && $year == $this->year && $month == $this->month) {
                                echo "<strong>" . $this->getEvents()[$i]->getTitle() . "</strong><br>";
                                echo $this->getEvents()[$i]->getLocation() . "<br>";
                                echo $this->getEvents()[$i]->getFormattedStart() . " to ";
                                echo $this->getEvents()[$i]->getFormattedEnd() . "<br>";

                                //if event is cancelled then echo this
                                if ($this->getEvents()[$i]->isCancelled() == true) {
                                    echo "<strong>(Canceled.)</strong><br>";
                                }
                            }
                        }
                        //end cell
                        echo "</td>";
                    } else {
                        echo "<td bgcolor='#666666'>&nbsp;</td>"; //the unused calendar days after the end of the month/  Fill cell with gray
                    }
                } else {
                    echo "<td bgcolor='#666666'>&nbsp;</td>"; //these are the unused calendar days before the beginning of month.  Fill cell with gray
                }
            }

            echo "</tr>";
            echo "<tr>";
        }
        echo "</tr>";
    }

    public function getEventsByName($name) {
        $eventArray = array();
        for ($i = 0; $i < count($this->getEvents()); $i++) {

            if ($name == $this->getEvents()[$i]->getTitle()) {

                array_push($eventArray, $this->getEvents()[$i]);
            }
        }
        return $eventArray;
    }

}

class CalendarEvent {

    //properties
    private $title;
    private $location;
    private $start;
    private $end;
    private $cancelled = false;

    //methods - setters
    public function setTitle($title) {
        $this->title = $title;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    public function setEnd($end) {
        $this->end = $end;
    }

    public function setCancelled($bool) {

        $this->cancelled = $bool;
    }

    public function setNotCancelled() {
        $this->cancelled = false;
    }

    //methods - getters
    public function getTitle() {
        return $this->title;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getStart() {

        return $this->start;
    }

    public function getEnd() {
        return $this->end;
    }

    /**
     * start date and time - convert to timestamp and then get formatted date and time
     * @return date
     */
    public function getFormattedStart() {
        $timestamp = strtotime($this->start);
        $formatted = date("g:i a", $timestamp);


        return $formatted;
    }

    /**
     * end date and time - convert to timestamp and then get formatted date and time
     * @return date
     */
    public function getFormattedEnd() {
        $timestamp = strtotime($this->end);
        $formatted = date("g:i a", $timestamp);


        return $formatted;
    }

    public function isCancelled() {
        return $this->cancelled;
    }

}
