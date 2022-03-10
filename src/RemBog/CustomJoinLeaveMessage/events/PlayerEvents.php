<?php

namespace RemBog\CustomJoinLeaveMessage\events;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Config;
use RemBog\CustomJoinLeaveMessage\Main;

class PlayerEvents implements Listener
{
   public function onJoin(PlayerJoinEvent $event) 
   {
       $player = $event->getPlayer();
       $name = $player->getName();
       $online = count(Server::getInstance()->getOnlinePlayers()); 
       $max_online = Server::getInstance()->getMaxPlayers();
       $config = Main::getConfigFile();
       
       $event->setJoinMessage(" ");
       
       if(!$player->hasPlayedBefore())
       {
           $message = str_replace("&", "§", strval($config->get("join-message-new-player")));
           $message = str_replace("{player}", $name, $message);
           $message = str_replace("{name}", $name, $message);
           $message = str_replace("{line}", "\n", $message);
           
           Server::getInstance()->broadcastMessage($message);
       }else{
           $message = str_replace("&", "§", strval($config->get("join-message")));
           $message = str_replace("{player}", $name, $message);
           $message = str_replace("{name}", $name, $message);
           $message = str_replace("{line}", "\n", $message);
           $message = str_replace("{online}", $online, $message);
           $message = str_replace("{max_online}", $max_online, $message);
           
           Server::getInstance()->broadcastMessage($message);
       }
   }
   
   public function onQuit(PlayerQuitEvent $event)
   {
       $player = $event->getPlayer();
       $name = $player->getName();
       $online = count(Server::getInstance()->getOnlinePlayers()); 
       $max_online = Server::getInstance()->getMaxPlayers();
       $config = Main::getConfigFile();
       
       $event->setQuitMessage(" ");
       
       $message = str_replace("&", "§", strval($config->get("leave-message")));
       $message = str_replace("{player}", $name, $message);
       $message = str_replace("{name}", $name, $message);
       $message = str_replace("{line}", "\n", $message);
       $message = str_replace("{online}", $online, $message);
       $message = str_replace("{max_online}", $max_online, $message);
       
       Server::getInstance()->broadcastMessage($message);
   }
}
