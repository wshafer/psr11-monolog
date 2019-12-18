<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog;

use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Exception\InvalidContainerException;

class MonologFactory
{
    protected static $channelChanger;

    protected static $channelName = 'default';

    public function __invoke(ContainerInterface $container)
    {
        $channelChanger = static::getChannelChanger($container);
        $configKey = static::getChannelName();
        return $channelChanger->get($configKey);
    }

    public static function __callStatic($name, $arguments)
    {
        if (
            empty($arguments[0])
            || !$arguments[0] instanceof ContainerInterface
        ) {
            throw new InvalidContainerException(
                'Argument 0 must be an instance of a PSR-11 container'
            );
        }

        $factory = new static();
        $factory->setChannelName($name);
        return $factory($arguments[0]);
    }

    /**
     * @return string
     */
    public static function getChannelName(): string
    {
        return self::$channelName;
    }

    /**
     * @param string $channelName
     */
    public static function setChannelName(string $channelName)
    {
        self::$channelName = $channelName;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return mixed
     */
    public static function getChannelChanger(ContainerInterface $container): ChannelChanger
    {
        // @codeCoverageIgnoreStart
        if (!static::$channelChanger) {
            $factory = new ChannelChangerFactory();
            static::setChannelChanger($factory($container));
        }
        // @codeCoverageIgnoreEnd

        return static::$channelChanger;
    }

    /**
     * @param ChannelChanger $channelChanger
     */
    public static function setChannelChanger(ChannelChanger $channelChanger)
    {
        static::$channelChanger = $channelChanger;
    }
}
