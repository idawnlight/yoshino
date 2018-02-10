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
            $i->uid = $id;
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

    public function setTexture($player, $type = "default", $hash = "") {
        //print_r($this->where_equal("player", $player)->findOne()->default);exit();
        $player = $this->where("player", $player)->findOne();
        $player->{$type} = $hash;
        $player->last_modified = time();
        $player->save();
        return true;
    }

    public function getPlayersById($id) {
        return $this->where("uid", $id)->findMany();
    }

    public function getPlayerByName($name) {
        return $this->where("player", $name)->findOne();
    }

    public function verifyPlayer($player, $id) {
        return $this->where("player", $player)->findOne()->uid === $id;
    }
}