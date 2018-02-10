<?php
namespace Yoshino\Lib;

class EncryptController extends \X\Controller
{
    protected $encryption;
    protected $salt;

    public function encrypt($password) {
        $this->encryption = ($this->app->config["Yoshino"]["Password"]["Encryption"] === "") ? "sha256" : $this->app->config["Yoshino"]["Password"]["Encryption"];
        $this->salt = $this->app->config["Yoshino"]["Password"]["Salt"];

        return $this->{$this->encryption}($password);
    }

    public function verify($input, $password) {
        $this->encryption = $this->app->config["Yoshino"]["Password"]["Encryption"];
        $this->salt = $this->app->config["Yoshino"]["Password"]["Salt"];

        return $this->{$this->encryption}($input) === $password;
    }

    /**
     * Once MD5 hash
     */
    public function md5($value) {
        return md5($value);
    }

    /**
     * MD5 hash with salt
     */
    public function salted2md5($value) {
        return md5(md5($value).$this->salt);
    }

    /**
     * Once SHA256 hash
     */
    public function sha256($value)
    {
        return hash("sha256", $value);
    }

    /**
     * SHA256 hash with salt
     */
    public function salted2sha256($value)
    {
        return hash('sha256', hash('sha256', $value).$this->salt);
    }

    /**
     * Once SHA512 hash
     */
    public function sha512($value)
    {
        return hash('sha512', $value);
    }

    /**
     * SHA512 hash with salt
     */
    public function salted2sha512($value)
    {
        return hash('sha512', hash('sha512', $value).$this->salt);
    }

}