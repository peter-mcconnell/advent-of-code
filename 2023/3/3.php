#!/usr/bin/env php
<?php


$path = "input.txt";
$f = fopen($path, "r");
$content = fread($f, filesize($path));
$data = explode("\n", $content);

print_r($data) . "\n---\n";

$len = sizeof($data);

$total = 0;

$digits = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
$not_symbols = array_merge($digits, array("."));

function row_in_range($row_idx, $c_row_idx) {
  global $data;
  $rows_len = sizeof($data);
  if($row_idx + $c_row_idx < 0 || $row_idx + $c_row_idx >= $rows_len) {
    return false;
  }
  return true;
}

function col_in_range($row_idx, $c_col_idx) {
  global $data;
  $row_len = strlen($data[$row_idx]);
  if($c_col_idx < 0 || $c_col_idx >= $row_len) {
    return false;
  }
  return true;
}

function search_surround_for_symbol($row_idx, $col_idx) {
  global $data;
  global $not_symbols;
  $row_len = strlen($data[$row_idx]);
  for($r = -1; $r <= 1; $r++) { // search row -1, row, row + 1
    if(!row_in_range($row_idx, $r)) {
      continue;
    }
    for($i = -1; $i <= 1; $i++) { // search col -1, col, col + 1
      $c_col_idx = $col_idx + $i;
      if(!col_in_range($row_idx + $r, $c_col_idx)) {
        continue;
      }
      if(!in_array($data[$row_idx+$r][$c_col_idx], $not_symbols)) {
        return true;
      }
    }
  }
  return false;
}

function int_if_valid($str_digit, $row_idx, $col_start_idx, $col_end_idx) {
  for($i = $col_start_idx; $i < $col_end_idx; $i++) {
    // check top, right, bottom, left for each char. bail on first detection
    if(search_surround_for_symbol($row_idx, $i)) {
      return intval($str_digit, 10);
    }
  }
  return -1; // this int isn't in a valid position
}

function parse_line_to_int($row_idx) {
  global $data;
  global $digits;
  $row_total = 0;
  $row_len = strlen($data[$row_idx]);
  $in_digit_idx = -1;
  $cur_digit = "";
  for($col_idx = 0; $col_idx < $row_len; $col_idx++)
  {
    $is_dig = in_array($data[$row_idx][$col_idx], $digits);
    if($is_dig) {
      $cur_digit .= $data[$row_idx][$col_idx];
      if($in_digit_idx == -1) {
        $in_digit_idx = $col_idx; // record the starting position (reading ltr)
      }
    }
    // did we finish reading a digit, or come to the end of the line?
    if ((!$is_dig && $in_digit_idx != -1) || (($col_idx == $row_len-1) && $in_digit_idx != -1)) {
      $result = int_if_valid($cur_digit, $row_idx, $in_digit_idx, $col_idx);
      if($result != -1) {
        echo "adding " . $result . "\n";
        $row_total += $result;
      }
      $cur_digit = "";
      $in_digit_idx = -1;
    }
  }
  return $row_total;
}

for($i = 0; $i < $len; $i++) {
  if($data[$i] == "") {
    continue;
  }
  $total += parse_line_to_int($i);
}

echo $total . "\n";

fclose($f);
