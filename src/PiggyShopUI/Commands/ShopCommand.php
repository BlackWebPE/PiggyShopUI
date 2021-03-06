<?php

namespace PiggyShopUI\Commands;

use jojoe77777\FormAPI\FormAPI;
use PiggyShopUI\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

/**
 * Class BuyCommand
 * @package PiggyShopUI\Commands
 */
class ShopCommand extends PluginCommand
{
    /**
     * BuyCommand constructor.
     * @param string $name
     * @param Main $plugin
     */
    public function __construct(string $name, Main $plugin)
    {
        parent::__construct($name, $plugin);
        $this->setDescription("");
        $this->setPermission("piggyshopui.command.buy");
        $this->setUsage("/shop");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed|void
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $plugin = $this->getPlugin();
        if ($plugin instanceof Main) {
            $formapi = $plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
            if ($formapi instanceof FormAPI && $formapi->isEnabled()) {
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        if (isset($plugin->buyCategories[$args[0]])) {
                            $plugin->openBuyCategoryMenu($sender, $args[0]);
                            return;
                        }
                        $sender->sendMessage(TextFormat::RED . "Invalid Category");
                        return;
                    }
                    $plugin->openBuyMainMenu($sender);
                    return;
                }
                $sender->sendMessage(TextFormat::RED . "Please use this in-game.");
                return;
            }
            $sender->sendMessage(TextFormat::RED . "FormAPI is required.");
        }
    }
}
