<?php

namespace M2i\Mvc\Model;

use M2i\Mvc\Database;

class Book extends Model
{
    public $id;
    public $title;
    public $price;
    public $discount;
    public $isbn;
    public $author;
    public $published_at;
    public $image;

    public function save($fields)
    {
        $table = static::getTable();

        $columns = implode(',', $fields); //[name, age] devient une chaine "name, age"
        $values = [];

        foreach ($fields as $field) {
            $values[':'.$field] = $this->$field;
        }

        $parameters = implode(',', array_keys($values)); //donne le tableau de :name et :age

        $sql = "INSERT INTO $table ($columns) VALUES ($parameters)";
        $query = Database::get()->prepare($sql);

        return $query->execute($values);
    }
}
