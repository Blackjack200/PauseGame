<?php


namespace blackjack200\pausegame;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class PauseGameCommand extends Command {
	public function __construct() {
		parent::__construct('pause', 'Pause Player Game', '/pause <pause/resume> <name>');
		$this->setPermission('blackjack200.pausegame.pause');
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if ($this->testPermission($sender)) {
			if (count($args) < 2) {
				throw new InvalidCommandSyntaxException();
			}
			[$flg, $name] = $args;
			if (!in_array($flg, ['pause', 'resume', 'p', 'r'])) {
				throw new InvalidCommandSyntaxException();
			}
			$player = Server::getInstance()->getPlayer($name);
			if ($player === null) {
				$sender->sendMessage(TextFormat::RED . "Player '$name' is not online");
				return;
			}
			$pk = new LevelEventPacket();
			$pk->evid = LevelEventPacket::EVENT_PAUSE_GAME;
			if ($flg === 'pause' || $flg === 'p') {
				$pk->data = 1;
			} else {
				$pk->data = 0;
			}
			$player->sendDataPacket($pk);
			$sender->sendMessage(TextFormat::GREEN . "Success $flg Player '{$player->getName()}' Game");
		}
	}
}