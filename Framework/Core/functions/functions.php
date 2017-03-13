<?php

/**
 * Render text using htmlspecialchars function to prevent XSS attacks
 * @param string $text
 * @return string
 */
function renderInView(string $text)
{
    return htmlspecialchars($text);
}

/**
 * Truncates text to specific word length. Add ellipsis to the end if text is longer.
 * @param string $text
 * @param int $minWords
 * @return string
 */
function truncateText(string $text, int $minWords)
{
    $matches = [];
    $matchesCount = preg_match_all("/[^\\s]+\\s?/", $text, $matches);
    if ($matchesCount <= $minWords) {
        return trim(implode("", $matches[0]));
    }

    return trim(
            implode("",
                array_splice($matches[0], 0, $minWords)), ",.!? ") . '...';
}