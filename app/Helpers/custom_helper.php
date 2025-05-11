<?php
// app/Helpers/custom_helper.php

if (!function_exists('timeAgo')) {
    function timeAgo($timestamp)
    {
        $time_difference = time() - strtotime($timestamp);
        $seconds = $time_difference;
        $minutes = round($seconds / 60);
        $hours = round($seconds / 3600);
        $days = round($seconds / 86400);
        $weeks = round($seconds / 604800);
        $months = round($seconds / 2629440);
        $years = round($seconds / 31553280);


        if ($seconds <= 60) {
            return "Just Now";
        } else if ($minutes <= 60) {
            return ($minutes == 1) ? "1 minute ago" : "$minutes minutes ago";
        } else if ($hours <= 24) {
            return ($hours == 1) ? "1 hour ago" : "$hours hours ago";
        } else if ($days <= 7) {
            return ($days == 1) ? "1 day ago" : "$days days ago";
        } else if ($weeks <= 4.3) {  // ~ 30 days
            return ($weeks == 1) ? "1 week ago" : "$weeks weeks ago";
        } else if ($months <= 12) {
            return ($months == 1) ? "1 month ago" : "$months months ago";
        } else {
            return ($years == 1) ? "1 year ago" : "$years years ago";
        }
    }
}

if (!function_exists('truncateText')) {
    function truncateText($text, $maxLength = 100)
    {
        if (strlen($text) > $maxLength) {
            return substr($text, 0, $maxLength) . '...';
        }
        return $text;
    }
}