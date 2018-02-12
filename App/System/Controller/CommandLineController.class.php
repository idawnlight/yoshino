<?php
    /**
     * Yoshino Project
     * 
     * @author Tianle Xu <xtl@xtlsoft.top>
     * @package Yoshino
     * @license GPL-V3
     * 
     */
    
    namespace Controller\System;
    
    use X\Controller;
    
    class CommandLineController extends Controller implements \X\Interfaces\Bootable {

        public function bootup(){
            $this->app->handler->cli->addArt($this->app->config['SysDir'] . $this->app->config['Path']['Template'] . '/default/System/cliart');
        }
        
        public function serve($req){

            $p = rand(20000, 30000);

            $this->app->handler->cli
                ->out("<bold>XPHP Development Server</bold>")
                ->inline("Listening On: ")
                ->red(isset($req->get()->data->param->p) ? $req->get()->data->param->p : $p)
                ->out("Press <bold><green>Ctrl + C</green></bold> to quit.\n");
            echo shell_exec("php -S 127.0.0.1:" . (isset($req->get()->data->param->p) ? $req->get()->data->param->p : $p ) . " ./Public/index.php");

            return $this->response("", [], "Failed to startup server.");

        }

        public function install($req){

            $cli = $this->app->handler->cli;

            $cli->clear();

            $cli->draw("install_welcome");

            $cli->input("Press 'Enter' to continue...")->prompt();

            $cli->clear();
            
            $cli->draw("select_dbtype");

            $dbtype = $cli->input("Select one from above: ")->accept(["1", "2", "3"])->prompt();

            switch($dbtype){

                case 1:
                    // SQLite
                    $cli->clear();
                    $dsn = "sqlite:";
                    $cli->draw("sqlite_input_path");
                    $path = $cli->input("Choose one path: ")->prompt();
                    $dsn .= $path;
                    $cli->clear();
                    $cli->draw("install_during");
                    $progress = $cli->progress()->total(3);
                    if(!is_file($path))
                        file_put_contents($path, "");
                    $sql = file_get_contents(SysDir . "Var/DBDump/sqlite.sql");
                    $progress->advance(1);
                    $pdo = new \PDO($dsn);
                    $pdo->exec($sql);
                    $progress->advance(1);
                    //////////////////////////////////////
                    // Place to add write configure.php //
                    //////////////////////////////////////
                    $progress->advance(1);
                    $cli->clear();
                    $cli->draw("install_success");
                    break;
                case 2:
                    //MySQL

                    break;
                case 3:
                    $cli->out("Sorry, we don't support your database.");
                    die;
                    break;

            }

            return $this->response("");

        }

    }
    