<?php
    /**
     * Yoshino
     * @description A lite and fast Minecraft Skin Server
     * @author Dawn <i@emiria.moe>
     * @version 1.0.0
     */
    
    namespace Controller\Home;
    
    use X\Controller;

    class IndexController extends Controller
    {

        public function index($req){
            $this->data = [
                "index" => true
            ];

            return $this->view("Home/index");
        }
        
    }