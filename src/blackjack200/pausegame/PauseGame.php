<?php


namespace blackjack200\pausegame;


use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class PauseGame extends PluginBase {
	public function onEnable() : void {
		Server::getInstance()->getCommandMap()->register($this->getName(), new PauseGameCommand());
	}
}