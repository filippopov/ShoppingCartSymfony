<?php


namespace AppBundle\Service\Contracts;

interface StorageInterface
{
    public function get($index);
    public function set($index,$value);
    public function all();
    public function exists($index);
    public function unsetIndex($index);
    public function clear();
}
