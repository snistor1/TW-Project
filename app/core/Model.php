<?php

/**
 * @property null|resource db
 */
class Model
{

    public function __construct()
    {
        $this->db=DataBase::getConnection();
    }
}