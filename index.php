<?php
require_once('includes/simplepie.inc');
$feed = new Simplepie('http://api.flickr.com/services/feeds/photos_public.gne?id=28211532@N07&lang=en-us&format=rss_200');
$feed->handle_content_type();

function image_from_description($data) {
    preg_match_all('/<img src="([^"]*)"([^>]*)>/i', $data, $matches);
    return $matches[1][0];
}

function select_image($img, $size) {
    $img = explode('/', $img);
    $filename = array_pop($img);
    
    $s = array(
        '_s.', // square
        '_t.', // thumb
        '_m.', // small
        '.',   // medium
        '_b.'  // large
    );
    
    $img[] = preg_replace('/(_(s|t|m|b))?\./i', $s[$size], $filename);
    return implode('/', $img);
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Flickr Album: <?php echo $feed->get_title(); ?></title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" href="thickbox.css" />
<script type="text/javascript" src="jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="thickbox-compressed.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>

<body>
    <div class="page-wrapper">
        <div class="header">
            <h1><img class="feedIcon" src="<?php echo $feed->get_image_url(); ?>" border="0" /> <?php echo $feed->get_title(); ?></h1>
        </div>
        <div class="album-wrapper">
            <?php foreach ($feed->get_items() as $item): ?>
                <div class="photo">
                    <?php
                        if ($enclosure = $item->get_enclosure()) {
                            echo '<h2>' . $enclosure->get_title() . '</h2>'."\n";
                            $img = image_from_description($item->get_description());
                            $full_url = select_image($img, 4);
                            $thumb_url = select_image($img, 0);
                            echo '<a href="' . $full_url . '" class="thickbox" title="' . $enclosure->get_title() . '"><img id="photo_' . $i . '" src="' . $thumb_url . '" /></a>'."\n";
                        }
                    ?>
                    <p><small><?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
