<?php

function search_objects_get_first($objects, $key, $value, $coloumn)
{ // might contain bugs as I typed in in SO on the go
    $return = array();
    foreach ($objects as $object) {
        $objVars = get_object_vars($object);
        if (isset($objVars[$key]) && $objVars[$key] == $value) {
            $return[] = $object;
        }
    }
    if (! empty($return)) {
        $show = reset($return);
        return $show->$coloumn;
    } else {
        return false;
    }
}

function sort_object_by_column_get_first($objects, $column, $column_result)
{
    if (! empty($objects)) {
        usort($objects, function ($a, $b) use ($column) {
            return strcmp($a->$column, $b->$column);
        });
        
        $result = array_reverse($objects);
        return reset($result)->$column_result;
    } else {
        return "-";
    }
}

function getDatesFromRange($start, $end, $format = 'Y-m-d', $includeWeekend = 0)
{
    $array = array();
    $count = 1;
    $interval = new DateInterval('P1D');
    $realEnd = new DateTime($end);
    $realEnd->add($interval);
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
    
    foreach ($period as $key => $date) {
        if ($includeWeekend == 0) {
            $weekDay = $date->format('w');
            $weekDay = ($weekDay == 0 || $weekDay == 6);
            if (! $weekDay) {
                $array['name'][$key] = $date;
                $array['count'] = $count ++;
            }
        } else {
            $array['name'][$key] = $date;
            $array['count'] = $count ++;
        }
    }
    return $array;
}

// https://stackoverflow.com/questions/16776061/get-php-dateinterval-in-total-minutes
function getTotalMinutes(DateInterval $int)
{
    return ($int->d * 24 * 60) + ($int->h * 60) + $int->i;
}

function getTotalHours(DateInterval $int)
{
    return ($int->d * 24) + $int->h + $int->i / 60;
}

function dynamic_select_attribute($field, $array)
{
    return array_map(function ($ar) use ($field) {
        foreach ($field as $co) {
            $data[$co] = $ar[$co];
        }
        return $data;
    }, $array);
}

function iteration_datatable_ajax($pageSize, $skip, $iteration)
{
    return ($skip / $pageSize * $pageSize) + $iteration + 1;
}