<?php

namespace lokiPM\RulesPM;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase implements Listener {

    private $playersConfig;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->playersConfig = new Config($this->getDataFolder() . "players.yml", Config::YAML);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "rules" && $sender instanceof Player) {
            $this->showRulesForm($sender);
            return true;
        }
        return false;
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $playerName = $player->getName();
        if (!$this->playersConfig->exists($playerName)) {
            $this->showRulesForm($player);
            $this->playersConfig->set($playerName, true);
            $this->playersConfig->save();
        }
    }

    private function showRulesForm(Player $player): void {
        $rules = $this->getConfig()->get("rules", []);
        $form = new SimpleForm(function (Player $player, ?int $data) {});
        $form->setTitle("Rules");
        $form->setContent(implode("\n", $rules));
        $player->sendForm($form);
    }
}
