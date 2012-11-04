<?php
/**
 * @file
 * Template to display a view as a calendar year.
 * 
 * @see template_preprocess_calendar_year.
 *
 * $view: The view.
 * $months: An array with a formatted month calendar for each month of the year.
 * $min_date_formatted: The minimum date for this calendar in the format YYYY-MM-DD HH:MM:SS.
 * $max_date_formatted: The maximum date for this calendar in the format YYYY-MM-DD HH:MM:SS.
 * 
 */
//dsm('Display: '. $display_type .': '. $min_date_formatted .' to '. $max_date_formatted);
?>

<div class="calendar-calendar">
  <div class="year-view">
    <?php
      for ($i = 1; $i <= 12; $i++) {
        print $months[$i];
      }
    ?>
</div></div>