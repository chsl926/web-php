<?php
// $Id$
$_SERVER['BASE_PAGE'] = 'conferences/index.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/prepend.inc';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/pregen-events.inc';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/pregen-news.inc';


site_header("PHP Conferences around the world", array(
    'headtags' => '<link rel="alternate" type="application/atom+xml" title="PHP: Conference announcements" href="' . $MYSITE . 'feed.atom" />',
    'current'  => 'community',
    'css' => array('home.css'),
));

$content = "<div class='home-content'>";
$frontpage = array();
foreach($NEWS_ENTRIES as $entry) {
    foreach($entry["category"] as $category) {
        if ($category["term"] == "cfp") {
            $frontpage[] = $entry;
            break;
        }
        if ($category["term"] == "conferences") {
            $frontpage[] = $entry;
            break;
        }
    }
}
$panels = "";
foreach($frontpage as $entry) {
    $link = substr($entry["id"], 15); // Strip http://php.net/
    $date = date_format(date_create($entry["updated"]), 'Y-m-d');
    $content .= '<div class="newsentry">';
    $content .= '<h3 class="newstitle"><a href="'. $MYSITE.$link .'">' . $entry["title"] . '</a></h3>';
    $content .= '<div class="newsimage">';
    $content .= sprintf('<a href="%s"><img src="/images/news/%s"></a>', $entry["newsImage"]["link"], $entry["newsImage"]["content"]);
    $content .= '</div>';
    $content .= '<div class="newscontent">';
    $content .= $entry["content"];
    $content .= '</div>';
    $content .= '</div>';

    $panels .= sprintf('<p class="panel"><a href="%s">%s</a></p>', $entry["newsImage"]["link"], $entry["title"]);
}
$content .= "</div>";

echo $content;

site_footer(
    array(
        "atom" => "/feed.atom",
        "elephpants" => true,
        "sidebar" => $panels,
    )
);

