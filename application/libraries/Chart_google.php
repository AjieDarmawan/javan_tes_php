<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Chart_google
{

    // init vars
    var $CI;
 // CI instance
    var $columns = array();

    var $rows = array();

    function Chart_google()
    {
        // init vars
        $this->CI = & get_instance();
    }

    public function draw_pie_chart($columns, $rows)
    {}

    public function draw_bar_chart()
    {}
}