<?php
/**
 * Created by PhpStorm.
 * User: m1255
 * Date: 2018/2/12
 * Time: 15:43
 */

namespace Controller\Dashboard;

class DashboardController extends \X\Controller
{
    public function dashboard($req) {
        $this->data = [
            "index" => true,
            "reg-user" => $this->getUserModel()->getUserCount(),
            "upload-texture" => $this->getTextureModel()->getTextureCount()
        ];
        return $this->view("Dashboard/dashboard");
        return $this->json(["msg" => "You are in dashboard now!"], "succeed", 1);
    }

    private function getUserModel() {
        return $this->model("Dashboard/UserModel");
    }

    private function getTextureModel() {
        return $this->model("Dashboard/TextureModel");
    }

}