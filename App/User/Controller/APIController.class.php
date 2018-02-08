<?php
namespace Controller\User;

use X\Controller;

define("TextureDir", SysDir . "Var/Textures/");

class APIController extends Controller
{
    public function csl($req, $v1 = false) {
        $player = $this->getPlayerModel()->getPlayerByName($req->data->route->username);
        if ($player) {
            $this->returnHeader($req, true, true, $player->last_modified);
            $profile = [
                "username" => $player->player,
                "textures" => [
                    "default" => (isset($player->skin) && $player->skin !== "") ? $player->skin : null,
                    "slim" => (isset($player->slim) && $player->slim !== "") ? $player->slim : null,
                    "cape" => (isset($player->cape) && $player->cape !== "") ? $player->cape : null,
                    "elytra" => (isset($player->elytra) && $player->elytra !== "") ? $player->elytra : null
                ]
            ];
            if ($v1) {
                $profile = [
                    "username" => $player->player,
                    "skins" => [
                        "default" => (isset($player->skin) && $player->skin !== "") ? $player->skin : null,
                        "slim" => (isset($player->slim) && $player->slim !== "") ? $player->slim : null
                    ],
                    "cape" => (isset($player->cape) && $player->cape !== "") ? $player->cape : null
                ];
                return $profile;
            }
            return $this->json($profile, null, 1);
        }
        return $this->json();
    }

    public function cslv1($req) {
        return $this->json($this->csl($req, true), null, 1);
    }

    public function usm($req) {
        $player = $this->getPlayerModel()->getPlayerByName($req->data->route->username);
        if ($player) {
            $this->returnHeader($req, true, true, $player->last_modified);
            $profile = [
                "player_name" => $player->player,
                "last_update" => $player->last_modified,
                "model_preference" => [],
                "skins" => [
                    "default" => (isset($player->skin) && $player->skin !== "") ? $player->skin : null,
                    "slim" => (isset($player->slim) && $player->slim !== "") ? $player->slim : null,
                    "cape" => (isset($player->cape) && $player->cape !== "") ? $player->cape : null
                ],
                "cape" => (isset($player->cape) && $player->cape !== "") ? $player->cape : null
            ];
            if (isset($player->skin) && $player->skin !== "") $profile["model_preference"][] = "default";
            if (isset($player->slim) && $player->slim !== "") $profile["model_preference"][] = "slim";
            if (isset($player->cape) && $player->cape !== "") $profile["model_preference"][] = "cape";
            return $this->json($profile, null, 1);
        }
        return $this->json();
    }

    public function legacy($username, $type = "skin") {
        $player = $this->getPlayerModel()->getPlayerByName($username);
        if (isset($player->$type) && file_exists(TextureDir . $player->$type . ".png")) {
            return file_get_contents(TextureDir . $player->$type . ".png");
        } else {
            return false;
        }
    }

    public function legacySkin($req) {
        $data = $this->legacy($req->data->route->username, "skin");
        if ($data) {
            return $this->response($data, ["Content-Type" => "image/png"]);
        } else {
            return $this->response("", [], 404);
        }
    }

    public function legacyCape($req) {
        $data = $this->legacy($req->data->route->username, "cape");
        if ($data) {
            return $this->response($data, ["Content-Type" => "image/png"]);
        } else {
            return $this->response("", [], 404);
        }
    }

    public function textures($req) {
        if (file_exists(TextureDir . $req->data->route->hash . ".png")) {
            $this->returnHeader($req, true, true);
            return $this->response(file_get_contents(TextureDir . $req->data->route->hash . ".png"), ["Content-Type" => "image/png"]);
        } else {
            $this->returnHeader($req, "", false, false);
            return $this->response("", [], 404);
        }
    }

    private function returnHeader($req, $cache = false, $status = true, $modified = null) {
        if (!$status) {
            header('HTTP/1.1 404 Not Found');
            return;
        }
        if ($cache) {
            if (isset($req->data->server->HTTP_IF_MODIFIED_SINCE) && $modified !== null && $modified !== 0) {
                if (strtotime($req->data->server->HTTP_IF_MODIFIED_SINCE) > $modified) {
                    header('HTTP/1.1 304 Not Modified');
                    $this->response("", [], 304);
                    exit;
                }
            }
            header("Cache-Control: max-age=600");
            header("Date: " . gmdate("D, d M Y H:i:s", time()) . " GMT");
            header("Expires: " . gmdate("D, d M Y H:i:s", time() + 600) . " GMT");
            header_remove("Pragma");
        }
    }

    private function getPlayerModel() {
        return $this->model("User/PlayerModel");
    }
}