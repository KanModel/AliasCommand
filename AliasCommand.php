<?php
/*
__PocketMine Plugin__
name=AliasCommand
description=Custom alias
version=1.0
author=kgdwhsk
class=AliasCommand
apiversion=11,12
*/
class AliasCommand implements Plugin{
	private $api;
	public function __construct(ServerAPI $api, $server = false)
	{	
		$this->api = $api;
	}

	public function init()
	{
		$this->api->console->register("addalias", "[command] [custom alias]", array($this, "commandHandler"));
		$this->api->console->alias("aa", "addalias");
		//$this->path = $this->api->plugin->configPath($this);
		//$this->msgs = $this->api->plugin->readYAML($this->path . "chatsend.yml");
		$this->config = new Config($this->api->plugin->configPath($this)."config.yml", CONFIG_YAML, array());
		$this->path = $this->api->plugin->configPath($this);
		$this->command = $this->api->plugin->readYAML($this->path."config.yml");
		foreach($this->command as $co => $al)
		{
			$this->api->console->alias("$al", "$co");
		}
	}
		
	function commandHandler($cmd, $params, $issuer, $alias )
	{
		switch($cmd)
		{
			case "addalias":
				//$this->api->plugin->writeYAML("$this->path ". "config.yml","");
				if(isset($params[0]))
				{
					if(isset($params[1]))
					{
						//$cm = array($params[0] => $params[1]);
						$this->api->plugin->writeYAML($this->path."config.yml",array($params[0] => $params[1]));
						$this->init();
						return "Set command ".$params[0]." with alias ".$params[1]." succeed !";
					}
					else
					{
						return "Please enter a custom alias.";
					}
				}
				else
				{
					return "Please enter the command you want to add the custom alias.";
				}
				break;
			default:
				break;
		}
	}
		
	public function __destruct(){
	}
}
	//$this->server->api->console->alias("pardon-ip", "banip remove");
