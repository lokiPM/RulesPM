<?php

namespace lokiPM\RulesPM;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public function onEnable(): void {
        // Speichere die config.yml
        $this->saveDefaultConfig();
    }
}
