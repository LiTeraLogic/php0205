<?php


interface IDB
{
    const DB_ERROR = 13;

    public function find($sql);
    public function findAll($sql);

}