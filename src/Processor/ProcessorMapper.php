<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use WShafer\PSR11MonoLog\MapperInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ProcessorMapper implements MapperInterface
{
    /**
     * @param string $type
     * @return null|string
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function map(string $type)
    {
        $type = strtolower($type);

        switch ($type) {
            case 'psrlogmessage':
                return PsrLogMessageProcessorFactory::class;
            case 'introspection':
                return IntrospectionProcessorFactory::class;
            case 'web':
                return WebProcessorFactory::class;
            case 'memoryusage':
                return MemoryUsageProcessorFactory::class;
            case 'memorypeak':
                return MemoryPeakUsageProcessorFactory::class;
            case 'processid':
                return ProcessIdProcessorFactory::class;
            case 'uid':
                return UidProcessorFactory::class;
            case 'git':
                return GitProcessorFactory::class;
            case 'mercurial':
                return MercurialProcessorFactory::class;
        }

        return null;
    }
}
