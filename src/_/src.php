<?php


namespace _;


use pocketmine\plugin\PluginBase;

class src extends PluginBase {
	public function onEnable() {
		require "impl.php";
		$this->getLogger()->warning("Bruh i think you like it");
	}
}