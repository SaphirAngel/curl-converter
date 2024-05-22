<?php
$headers = [
    "One: ","header\n",
    "Two: header\n\tlines\n",
    "Three",": header\n lines\n here\n",
    "More: than one header\n",
    "More: ", "than: ", "you: ", "expect\n",
    "\n",
];

$states = [-1=>"FAILURE",0=>"START","KEY","VALUE","VALUE_EX","HEADER_DONE","DONE"];
$parser = new http\Header\Parser;
do {
    $state = $parser->parse($part = array_shift($headers), 
        $headers ? 0 : http\Header\Parser::CLEANUP, 
        $result);
    printf("%2\$-32s | %1\$s\n", $states[$state], addcslashes($part, "\r\n\t\0"));
} while ($headers && $state !== http\Header\Parser::STATE_FAILURE);

var_dump($result);
