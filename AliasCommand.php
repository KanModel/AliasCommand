<?php
/*
__PocketMine Plugin__
name=AliasCommand
description=Custom alias
version=1.5
author=kgdwhsk
class=AliasCommand
apiversion=11,12,13
*/
class AliasCommand implements Plugin{
	private $api ,$list;
	//public $prefix = "[AC]";
	public function __construct(ServerAPI $api, $server = false)
	{	
		$this->api = $api;
	}

	public function init()
	{
		$this->api->console->register("addalias", "[command] [custom alias]", array($this, "commandHandler"));
		$this->api->console->register("aliaslist", "List command alias", array($this, "aliaslist"));
		$this->api->console->register("aliasdelete", "c/ca [command/custom alias]", array($this, "aliasdelete"));
		$this->api->console->alias("aa", "addalias");
		$this->api->console->alias("al", "aliaslist");
		$this->api->console->alias("ad", "aliasdelete");
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
	
	public function aliasdelete($cmd, $params, $issuer, $alias )
	{
		if(isset($params[0]))
		{
			switch($params[0])
			{
				case "c":
					if(isset($params[1]))
					{
						if(count($params) > 2)
						{
							$geshu = count($params);
							$com = $params[1];
							for($i = 2;$i < $geshu;$i++)
							{
								$com .= " $params[$i]";
							}
						}
						if(array_key_exists($com ,$this->command))
						{
							unset($this->command[$com]);
							$this->api->plugin->writeYAML($this->path."config.yml",$this->command);
							$this->init();
							return "$com is already delete.";
						}
						else
						{
							return "Not found $com";
						}
					}
					else
					{
					return "Please enter command";
					}
				case "ca":
					if(isset($params[1]))
					{
						if(array_search($params[1] ,$this->command))
						{
							$ke = array_search($params[1] ,$this->command);
							unset($this->command[$ke]);
							$this->api->plugin->writeYAML($this->path."config.yml",$this->command);
							/*foreach($this->command as $k=>$v)
							{
								if($k == $params[1])
								{
									unset($arr[$K]);
									//unset($k);
								}
							}*/
							$this->init();
							return "$params[1] is already delete.";
						}
						else
						{
							return "Not found $params[1]";
						}
					}
					else
					{
					return "Please enter alias command";
					}
				default:
					return "Please enter c/ca.";
			}
		}
		else
		{
			return "Please enter c/ca.";
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
							//$this->api->plugin->writeYAML($this->path."config.yml",array($params[0] => $params[1]));
							$dat = array($params[0] => $params[1]);
							$this->overwriteConfig($dat);
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
							$dat = array($par => $params[$la]);
							$this->overwriteConfig($dat);
							//$this->api->plugin->writeYAML($this->path."config.yml",array($par => $params[$la]));
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
	
	private function overwriteConfig($dat)
	{
		//$cfg = array();
		//$cfg = $this->api->plugin->readYAML($this->path."config.yml");
		$result = array_merge($this->command, $dat);
		$this->api->plugin->writeYAML($this->path."config.yml", $result);
	}
	
	public function aliaslist($cmd, $params, $issuer, $alias )
	{
		$this->list = "---Alias Command List---\n";
		foreach($this->command as $co => $al)
		{
			$this->list .= "Command: $co ---Alias: $al\n";
		}
		return $this->list;
	}
	
	public function __destruct(){
	}
}
	//$this->server->api->console->alias("pardon-ip", "banip remove");
