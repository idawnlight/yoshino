<?php

namespace Model\User;

use X\Model;

class PlayerModel extends Model
{
    protected $table = "yoshino_player";

    public function addPlayer($player, $id) {
        if (!$this->where("player", $player)->findOne()) {
            $i = $this->create();
            $i->player = $player;
            $i->id = $id;
            $i->save();
            return true;
        } else {
            return false;
        }
    }

    public function removePlayer($player) {
        $player = $this->where_equal("player", $player);
        if ($player->findOne()) {
            $player->delete_many();
            return true;
        } else {
            return false;
        }
    }

    public function getPlayersById($id) {
        return $this->where("id", $id)->findMany();
    }

    public function getPlayerByName($name) {
        return $this->where("player", $name)->findOne();
    }

    public function verifyPlayer($player, $id) {
        return $this->where("player", $player)->findOne()->id === $id;
    }
}