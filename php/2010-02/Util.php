<?php

class Util {
    function set($var_name, $default = NULL) {
        return !empty($_REQUEST[$var_name]) ? $_REQUEST[$var_name] : $default;
    }

    function generate_gallery($gallery_name, $max_items, $current_item) {
        Util::gallery_clamp_values($max_items, $current_item);

        $html = "<img src=\"_img/$gallery_name/$current_item.JPG\" />";
        $html .= Util::generate_gallery_nav($gallery_name, $max_items, $current_item);

        return $html;
    }

    function gallery_clamp_values(&$max_items, &$current_item) {
        $current_item = (int) $current_item;
        $current_item = ($current_item > $max_items) ? $max_items : $current_item;
        $current_item = ($current_item < 1) ? 1 : $current_item;
        return $current_item;
    }

    function generate_gallery_nav($gallery_name, $max_items, $current_item) {
        $previous = $current_item > 1 ? $current_item - 1 : NULL;
        $next = $current_item < $max_items ? $current_item + 1 : NULL;

        $previous_html = $previous ? "<a href=\"$gallery_name.php?current=$previous\">&laquo;</a>" : "&laquo";
        $next_html = $next ? "<a href=\"$gallery_name.php?current=$next\">&raquo;</a>" : "&raquo";

        $html = "<div id=\"nav-gallery\">$previous_html $current_item of $max_items $next_html</div>";

        return $html;
    }
}
