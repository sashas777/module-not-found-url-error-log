<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */
declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;
use TheSGroup\NotFoundUrlLog\Model\Cleanup;

/**
 * Class Clean
 */
class Clean
{
    const XML_PATH_LOG_LIFETIME = 'tsg_errorlog/cleanup/lifetime';

    /**
     * @var Cleanup
     */
    private $cleanup;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Cleanup $cleanup
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Cleanup $cleanup
    ) {
        $this->cleanup = $cleanup;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $lifetimeMinutes = $this->getLogLifetime();
        if (!$lifetimeMinutes) {
            return;
        }
        $this->cleanup->execute($lifetimeMinutes);
    }

    /**
     * Log entry lifetime
     *
     * Indicates how long log entry will stay in table
     *
     * @return int
     */
    private function getLogLifetime(): int
    {
        return  (int)$this->scopeConfig->getValue(static::XML_PATH_LOG_LIFETIME );
    }
}
