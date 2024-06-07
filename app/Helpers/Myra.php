<?php

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Exception\CommonMarkException;

function minutes_to_hours($minutes): string
{
  $is_neg = ($minutes<0);
  if ($is_neg) $minutes = $minutes*-1;
  $hours 		= floor($minutes/60);
  $minutes 	= $minutes - ($hours*60);
  return (($is_neg) ? '-' : '').$hours.':'.substr('00'.$minutes,-2,2);
}

function minutes_to_units($minutes): string {
  $quarters = ceil($minutes / 15) * 15;
  $mins = $quarters / 60;
  return number_format($mins, 2, ',', '.');
}

/**
 * @throws CommonMarkException
 */
function md ($markdown): string {
  $converter = new CommonMarkConverter([
    'html_input' => 'strip',
    'allow_unsafe_links' => false,
  ]);

  return $converter->convert($markdown);
}

?>
