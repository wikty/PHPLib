<?php
function extract_head_sentences($text, $limit=2)
{
  // use regex to split into sentences
  $sentences = preg_split('/([.?!]["\']?\s)/', $text, $limit+1, PREG_SPLIT_DELIM_CAPTURE);
  if (count($sentences) > $limit * 2) {
    $remainder = array_pop($sentences);
  } else {
	$remainder = '';
  }
  $result = array();
  $result[0] = implode('', $sentences);
  $result[1] = $remainder;
  return $result;
}