<?php
/*
__PocketMine Plugin__
name=AliasCommand
description=Custom alias
version=1.2
author=kgdwhsk
class=AliasCommand
apiversion=11,12
*/
class AliasCommand implements Plugin{
	private $api ,$list;
	public function __construct(ServerAPI $api, $server = false)
	{	
		$this->api = $api;
	}

	public function init()
	{
		$this->api->console->register("addalias", "[command] [custom alias]", array($this, "commandHandler"));
		$this->api->console->register("aliaslist", "List command alias", array($this, "list"));
		$this->api->console->alias("aa", "addalias");
		$this->api->console->alias("al", "aliaslist");
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
						if(count($params) === 2)
						{
							//$cm = array($params[0] => $params[1]);
							$this->api->plugin->writeYAML($this->path."config.yml",array($params[0] => $params[1]));
							$this->init();
							//$len = count($params);
							return "Set command ".$params[0]." with alias ".$params[1]." succeed !";
						}
						/*elseif(count($params) === 3)
						{
							$ma = $params[0]." ".$params[1];
							$this->api->plugin->writeYAML($this->path."config.yml",array($ma => $params[2]));
							$this->init();
							return "Set command ".$ma." with alias ".$params[2]." succeed !";
						}*/
						else
						{
							$la = count($params) - 1;
							$lb = $la - 1;
							$par = $params[0]." ".$params[1];
							$pa = "";
							for ($q = 2;$q <= $lb;$q++)
							{
								$pab = " $params[$q]";
								$pa .= $pab;
							}
							$par .= $pa;
							$this->api->plugin->writeYAML($this->path."config.yml",array($par => $params[$la]));
							$this->init();
							return "Set command ".$par." with alias ".$params[$la]." succeed !";
						}
						/*$this->api->plugin->writeYAML($this->path."config.yml",array($params[0] => $params[1]));
						$this->init();
						$len = count($params);
						return "Set command ".$params[0]." with alias ".$params[1]." succeed !".$len;
						$len = count($params);
						if($len = 2)
						{
							//$cm = array($params[0] => $params[1]);
							$this->api->plugin->writeYAML($this->path."config.yml",array($params[0] => $params[1]));
							$this->init();
							//$len = count($params);
							return "Set command ".$params[0]." with alias ".$params[1]." succeed !";
						}
						else
						{
						}
						$len = count($params);
						$la = $len - 1;
						do
						{
							$ma =+ "$parmas[0]";
						}while($la >= );
						foreach($params as $l => $cm)
						{
							if($l = $la)
							{
								continue;
							}
								$ma =+ " ".$cm;
							console("$ma");
						}
						console("1111".$ma."fad");
						$this->api->plugin->writeYAML($this->path."config.yml",array($ma => $params[$la]));
						$this->init();
						return "Set command ".$ma." with alias ".$params[$len - 1]." succeed !".$len;*/
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
	
	public function list($cmd, $params, $issuer, $alias )
	{
		$this->list = "---Alias Command List---\n";
		foreach($this->command as $co => $al)
		{
			$this->list .= "Command: $co ---Alias: $al\n";
		}
	}
	
	public function __destruct(){
	}
}
	//$this->server->api->console->alias("pardon-ip", "banip remove");
