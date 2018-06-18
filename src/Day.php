<?php

namespace Betterde\Support;

class Day
{
    /**
     * @var
     * Date: 21/04/2018
     * @author George
     */
    public $days;

    /**
     * @var
     * Date: 21/04/2018
     * @author George
     */
    protected $start;

    /**
     * @var
     * Date: 21/04/2018
     * @author George
     */
    protected $end;

    /**
     * @var bool
     * Date: 21/04/2018
     * @author George
     */
    public $collection;

    /**
     * 初始化类
     *
     * Days constructor.
     * @param $start
     * @param $end
     * @param $collection
     */
    public function __construct($start, $end, $collection = false)
    {
        $this->days = 0;
        $this->start = $start;
        $this->end = $end;
        $this->collection = $collection ? collect([]) : [];
    }

    /**
     * 获取给定日期范围内的所有日期
     *
     * Date: 22/04/2018
     * @author George
     * @param string $start
     * @param string $end
     * @param bool $collection
     * @return Day
     */
    public static function all(string $start, string $end, bool $collection = false)
    {
        $instance = new self($start, $end, $collection);
        $start_date = strtotime($start);
        $end_date = strtotime($end);
        while ($start_date <= $end_date) {
            $instance->days += 1;
            if ($collection) {
                $instance->collection->push(date('Y-m-d', $start_date));
            } else {
                $instance->collection[] = date('Y-m-d', $start_date);
            }
            $start_date = strtotime('+1 day', $start_date);
        }
        return $instance;
    }

    /**
     * 获取当前月的每一天
     *
     * Date: 30/04/2018
     * @author George
     * @return Day
     */
    public static function month()
    {
        $start = date('Y-m-01');
        $end = date('Y-m-t');
        return self::all($start, $end);
    }

    /**
     * 获取日期
     *
     * Date: 05/05/2018
     * @author George
     * @param string $date
     * @return string
     */
    public static function toWeek(string $date)
    {
        $week = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];
        $timestamp = strtotime($date);
        $weekDay = array_get($week, date('w', $timestamp));
        return date('m月d日', $timestamp) . ' ' . $weekDay;
    }

    /**
     * 获取给定日期周
     *
     * Date: 2018/5/25
     * @author George
     * @param string $date
     * @return string
     */
    public static function getWeek(string $date)
    {
        $week = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];
        $timestamp = strtotime($date);
        return array_get($week, date('w', $timestamp));
    }

    /**
     * 获取当前周的日期范围
     *
     * Date: 06/05/2018
     * @author George
     * @param bool $date
     * @param int $start
     * @return array
     */
    public static function getWeekDays($date = false, $start = 0)
    {
        if (! $date) {
            $date = date('Y-m-d');
        }
        $numberOfWeek = date('w', strtotime($date));
        $number = $numberOfWeek ? $numberOfWeek - $start : 6;
        $startDay = date ( "Y-m-d", strtotime ( "$date  - " . $number . " days " ) );
        $endDay = date ( "Y-m-d", strtotime ( "$startDay +6 days " ) );
        return [
            'start' => $startDay,
            'end' => $endDay
        ];
    }

    /**
     * 获取指定日期的月初和月末
     *
     * Date: 09/05/2018
     * @author George
     * @param bool $date
     * @return array
     */
    public static function getMonthStartAndEnd($date = false)
    {
        if ($date) {
            $month = substr($date, 0, 7);
            $range = [
                'start' => date($month . '-01'),
                'end' => date($month . '-t'),
            ];
        } else {
            $range = [
                'start' => date('Y-m-01'),
                'end' => date('Y-m-t'),
            ];
        }

        return $range;
    }

    /**
     * 获取月初时间
     *
     * Date: 09/05/2018
     * @author George
     * @param bool $date
     * @param bool $datetime
     * @return false|string
     */
    public static function firstDayOfMonth($date = false, $datetime = false)
    {
        if ($date) {
            $month = substr($date, 0, 7);
            $firstDay = $month . '-01';
        } else {
            $firstDay = date('Y-m-01');
        }

        if ($datetime) {
            $firstDay = $firstDay . ' ' . '00:00:01';
        }

        return $firstDay;
    }

    /**
     * 获取月末时间
     *
     * Date: 09/05/2018
     * @author George
     * @param bool $date
     * @param bool $datetime
     * @return false|string
     */
    public static function lastDayOfMonth($date = false, $datetime = false)
    {
        if ($date) {
            $month = substr($date, 0, 7);
            $lastDay = date($month . '-t');
        } else {
            $lastDay = date('Y-m-t');
        }

        if ($datetime) {
            $lastDay = $lastDay . ' ' . '23:59:59';
        }

        return $lastDay;
    }
}
