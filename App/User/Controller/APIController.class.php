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
                    "default" => (isset($player->default) && $player->default !== "") ? $player->default : null,
                    "slim" => (isset($player->slim) && $player->slim !== "") ? $player->slim : null,
                    "cape" => (isset($player->cape) && $player->cape !== "") ? $player->cape : null,
                    "elytra" => (isset($player->elytra) && $player->elytra !== "") ? $player->elytra : null
                ]
            ];
            if ($v1) {
                unset($profile);
                $profile = [
                    "username" => $player->player,
                    "skins" => [
                        "default" => (isset($player->default) && $player->default !== "") ? $player->default : null,
                        "slim" => (isset($player->slim) && $player->slim !== "") ? $player->slim : null
                    ],
                    "cape" => (isset($player->cape) && $player->cape !== "") ? $player->cape : null
                ];
                return $profile;
            }
            return $this->json($profile, null, 1);
        }
        return (!$v1) ? $this->response("[]", [], 404) : false;
    }

    public function cslv1($req) {
        $profile = $this->csl($req, true);
        return ($profile) ? $this->json($this->csl($req, true), null, 1) : $this->response("[]", [], 404);
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
                    "default" => (isset($player->default) && $player->default !== "") ? $player->default : null,
                    "slim" => (isset($player->slim) && $player->slim !== "") ? $player->slim : null,
                    "cape" => (isset($player->cape) && $player->cape !== "") ? $player->cape : null
                ],
                "cape" => (isset($player->cape) && $player->cape !== "") ? $player->cape : null
            ];
            if (isset($player->default) && $player->default !== "") $profile["model_preference"][] = "default";
            if (isset($player->slim) && $player->slim !== "") $profile["model_preference"][] = "slim";
            if (isset($player->cape) && $player->cape !== "") $profile["model_preference"][] = "cape";
            return $this->json($profile, null, 1);
        }
        return $this->response("[]", [], 404);
    }

    public function legacy($username, $type = "default") {
        $player = $this->getPlayerModel()->getPlayerByName($username);
        if (!$this->app->config["Yoshino"]["Textures"]["ReadFromDB"]) {
            if (isset($player->$type) && file_exists(TextureDir . $player->$type . ".png")) {
                return file_get_contents(TextureDir . $player->$type . ".png");
            }
        } else {
            if (isset($player->$type) && $player->$type !== "") {
                $texture = $this->model("User/TextureModel")->getTexture($player->$type);
                if (isset($texture->content) && $texture->content !== "") {
                    return base64_decode($texture->content);
                }
            }
        }
        return false;
    }

    public function legacySkin($req) {
        $data = $this->legacy($req->data->route->username, "default");
        if ($data) {
            return $this->response($data, ["Content-Type" => "image/png"]);
        } else {
            if (isset($req->data->get->default)) {
                return $this->response(base64_decode("iVBORw0KGgoAAAANSUhEUgAAAEAAAAAgCAYAAACinX6EAAAFgUlEQVRogdVYTWwUVRz/7fbtTmY626Ef2aXYArGlEvTQ0AQjEGJiAiE1pgdDIvEAGg948CAxHqzGEElUbob4cTBiTAycDAc1eDBEEw4KUZGPUhdLLVq26VKG3Z3Nm93ueni8mffma7cLhfJLJvNm3u+9ef+v37yZGBpgU3+qDgDVahWEEPA2ANByHHueHIwcf+TUH7FGz1hO1Ov1yP54M5NUq1WoShKJNpmuqDUAQInGYOhJ52zoyRaXe/9BmiGpCjOoTG0nC7z44vebrDHDTrv6U2hXor2/EtAwA3i6VxZrzj1CCFQlGeqMhwkNHeA1slqt+krhYUZTllQWa04m8HJohBs3rNZXdR/RVA5zEaws1lCmNmg5jlWr5KG7+lMBI1e+BjTlAEIIytR2rhW1JmnCwyB2YYgN9arS6gkhvhqvLNaQaItLpcC1QeSK/eJ8QPg+YvpWaVn3CY32AYEZwKPLjeb3Em1xdOsaACBftH38MPAS8nIVtQbcamTC8oIQQnxRdaPIrj98ZR80TRa/ebOAw1+d8GVF0HzN7CMeFOI8Nb3G81J4d98LAJjBlmXj7/9yAIBC7h+8tvMpJNrigWO5I1b6PiIOwFkoX+z+7ZtxcPc2dKgEWkLB6Nsf4fjpAQDAo2syOHoyjZc++x6pzFp0qAQHd2/D/u2bETTXSt9HOCLII0YIwd4tG9Gl6zAtG+nOFFKZtdASCr778WcAwPPPPoOpyYuYzefRFk/C0JK4WSzi618mnDnCykrcR1QWa7g0U3igIhjb1J+q80U/PTCAkaHVAIDZfB5m0cYjmU4kYzFMzxSlgb197SiWSjCLNgw9id7ubgDAuckbOH31qk/1+T6iWq06+4iV4ACyd8tGZlB3N2bzeQAApRRt8SQAG//mFlCiMazpTgAAzKKNrg4d5XIF5p03AeMyjAytlpzIx5w8P+lwFLWGnY+th6EnMT7z672xtEX4vL9n91nJZeenXpT6JyYmoiN29mz9jbdeDuw6cvhz4OjR6BUdOxY9//HjdQze+QeRzeLVT9/HrFlCr9GOWbOEb377Sxrf0j7gblGiy5jVg4PB7RaxcuS4FWSzUvR7jfYlT7EsGbCs3wbZ7D2JPEdseOPrdQCwaA6akkG6a0QizN085/QBkPqL5es485zw2ZvNAjt2AIkE3vv2E0lYx0cPMM70tLyCdesATXOvFYWdKWXny5eD+YrCON7+4WHpsj42FlmPcW58K9DVPtbI5dgxOAgYBqBpGB89IBvf2ckOkZ/LucbwwwuRC7hzAIBlyZwW4JQAj/CS4X2wYMT46AGgUpEjHMH33acUyGTkMZS6Yzo7/Rm1RNy9CBYKbjubdduiYWJb5IvtuTl2ptRtB8ESSm5hYWlrDUBTIqgpGUcHiuXrcmcqFWxIOs0ixK9Fo0Q+4Na7F4qCj6/95Fyal/7EQO1xYMqlXJ24CIN/qV67gp7arDzH2FikbYEZUCxflwyN1AjRmJTnt5homGH4Obxtmv55w5wCYP52yZ1WS8K07FBuIwRmgCNuArhG+PpSU/6IptPsbJqu4V6IjjAMxhXr2zSBdBqmZbsR9kB0RND9no7G+wIC3IUAAkykgtrN8DnChNAD7ogww0zLRk9EfxCa1oCmwaPvRZCRojPEcQFzRGVC2P1mQIzMOfaA3EgkkfM2PCHX5g/oYQ1ujCh2huG+zsKiLPLTaVlEKY00rqejHfPCP0XOnb9dYn0hJSLCyYAwA+mFC5ETDJ8owKIFaIoGi+awvndI6F0EYLEd4zvu/aFTTDM0RUO6S3cE98ybrl5sPTTJ9GZD8HO5kTwzojIkCvf0YyisVHS1D1sPsf8BwycKPq6u9jHOB2xTs/NL3Se2YnQ5vG+DVvA/HqN2mM1SAU4AAAAASUVORK5CYII="), ["Content-Type" => "image/png"]);
            }
            return $this->response("", ["Content-Type" => "image/png"], 404);
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
        if (!$this->app->config["Yoshino"]["Textures"]["ReadFromDB"]) {
            if (file_exists(TextureDir . $req->data->route->hash . ".png")) {
                $this->returnHeader($req, true, true);
                return $this->response(file_get_contents(TextureDir . $req->data->route->hash . ".png"), ["Content-Type" => "image/png"]);
            }
        } else {
            $texture = $this->model("User/TextureModel")->getTexture($req->data->route->hash);
            if (isset($texture->content) && $texture->content !== "") {
                return $this->response(base64_decode($texture->content), ["Content-Type" => "image/png"]);
            }
        }
        return $this->response("", [], 404);
    }

    private function returnHeader($req, $cache = false, $status = true, $modified = null) {
        if (!$status) {
            header('HTTP/1.1 404 Not Found');
            return;
        }
        if ($cache) {
            if (isset($req->data->server->HTTP_IF_MODIFIED_SINCE) && $modified !== null && $modified !== 0) {
                if (strtotime($req->data->server->HTTP_IF_MODIFIED_SINCE) > $modified) {
                    $this->response("", [], 304);
                    exit;
                }
            }
            if ($modified !== 0 && $modified !== null) header("Last-Modified: " . gmdate("D, d M Y H:i:s", $modified) . " GMT");
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