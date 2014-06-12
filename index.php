<?php

/**
 * Calculates the blackjack of two cards represented as CLI inputs,
 * with values being {2-10,A,K,Q,J}{S,C,D,H}
 * author: Aleck Kulabukhov
 * date: 13-Jun-2014
 * version: 1.0.0
 *
 * Notes:
 * no test suits included, tested manually
 */

/**
 *
 * @param string $strCard - playing card
 * @return int - score or false in case of failure
 */
function getScore( $strCard ) {
    $strReg = "/^([2-9AKQJ]|10)([SCDH]$)/";
    $fValues = function($arParts) {// omiting the suit altogether
        return ($arParts[1] == "A") ? 11 :
                (in_array( $arParts[1], ['K', 'Q', 'J'] ) ? 10 : $arParts[1]);
    };
    $intFaceValue = preg_replace_callback( $strReg, $fValues, $strCard );
    if ($intFaceValue === NULL or $intFaceValue === $strCard)
        return false;
    return $intFaceValue;
}

/**
 *
 * @param array $cards - array of cards, currently two of them, sanitizing accordingly
 * @return int score or false for failure
 */
function getPairScore( $cards ) {
    if (count( $cards ) !== 2)
        return false;
    if ( ! array_walk( $cards, function(&$mxdCard) {
                $mxdCard = getScore( strtoupper( $mxdCard ) );
            } ))
        return false;
    if ($cards[0] === false or $cards[1] === false)
        return false;
    return $cards[0] + $cards[1];
}

$strUsage = "The program requires two inputs,\neach being a card with a value of 2-10,A,K,Q,J and a suit S,C,D,H.\n";
if ($argc === 3) {
    $intScore = getPairScore( array($argv[1], $argv[2]) );
    if ($intScore === false)
        echo $strUsage;
    else
        printf( "The score is: %d\n", $intScore );
} else
    echo $strUsage;


