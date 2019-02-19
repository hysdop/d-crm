<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 27.06.17
 * Time: 22:24
 */

namespace common\components;


class Icons
{
    const CLIENT = 1;
    const COMING = 2;
    const MEASUREMENT = 3;
    const DOG = 4;
    const SETTINGS = 5;
    const USERS = 6;
    const USER = 7;
    const CALENDAR = 8;
    const LEFT = 9;
    const RIGHT = 10;
    const CANCEL = 11;
    const TIMER = 12;
    const MOVED = 13;
    const WAIT = 14;
    const LISTS = 15;

    const EDIT = 101;
    const DELETE = 102;
    const OPEN = 103;
    const PHONE = 104;

    private static $icons = [
        self::CLIENT => 'fa fa-user',
        self::COMING => 'fa fa-bullhorn',
        self::MEASUREMENT => 'fa fa-crop',
        self::DOG => 'fa fa-briefcase',
        self::SETTINGS => 'fa fa-cog',
        self::USERS => 'fa fa-users',
        self::USER => 'fa fa-user',
        self::CALENDAR => 'fa fa-calendar',
        self::LEFT => 'fa fa-arrow-left',
        self::RIGHT => 'fa fa-arrow-right',
        self::CANCEL => 'fa fa-remove',
        self::TIMER => 'fa fa-clock-o',
        self::WAIT => 'fa fa-hourglass-half',
        self::MOVED => 'fa fa-chevron-circle-right',
        self::LISTS => 'fa fa-list',

        self::EDIT => 'fa fa-pencil',
        self::DELETE => 'fa fa-trash',
        self::OPEN => 'glyphicon glyphicon-eye-open',
        self::PHONE => 'fa fa-phone',
    ];

    public static function get($i, $color = null)
    {
        if (isset(self::$icons[$i])) {
            $styles = null;
            if ($color) $styles = 'color: ' . $color . ';';
            return '<span class="' . self::$icons[$i] . '" style="' . $styles . '"></span>';
        }

        return null;
    }

    public static function getClass($i)
    {
        if (isset(self::$icons[$i])) {
            return self::$icons[$i];
        }

        return null;
    }
}