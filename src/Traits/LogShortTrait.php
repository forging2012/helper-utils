<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/9/21
 * Time: 下午11:26
 */

namespace Toolkit\Traits;

use MyLib\Helpers\Helper\PhpHelper;
use MyLib\Helpers\Helper\Req;
use Monolog\Logger;

/**
 * Class LogShortTrait
 * @package Sws\Components
 */
trait LogShortTrait
{
    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public static function emergency($message, array $context = array())
    {
        self::log(Logger::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public static function alert($message, array $context = array())
    {
        self::log(Logger::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public static function critical($message, array $context = array())
    {
        self::log(Logger::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public static function error($message, array $context = array())
    {
        self::log(Logger::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public static function warning($message, array $context = array())
    {
        self::log(Logger::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public static function notice($message, array $context = array())
    {
        self::log(Logger::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public static function info($message, array $context = array())
    {
        self::log(Logger::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public static function debug($message, array $context = array())
    {
        self::log(Logger::DEBUG, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public static function trace($message, array $context = array())
    {
        if (!isset($context['_called_at'])) {
            $tce = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

            if ($info = $tce[1] ?? null) {
                $context['_called_at'] = sprintf('%s::%s Line %d', $info['class'], $info['function'], $tce[0]['line']);
            }
        }

        $context['_stats'] = PhpHelper::runtime(Req::server('request_time_float'), Req::server('request_memory'));

        self::log(Logger::DEBUG, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    abstract public static function log($level, $message, array $context = array());
}
