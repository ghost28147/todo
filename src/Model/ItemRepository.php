<?php

namespace Todos\Model;

class ItemRepository
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /** @return array[Item] */
    public function findAll() {

        $statement = $this->db->prepare("select * from item order by created_at desc");
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_CLASS, Item::class );
        return $result;
    }

    public function save(Item $item)
    {
        $statement = $this->db->prepare("insert into item set content = ?");
        $statement->execute([$item->content]);
    }

    public function delete($id)
    {
        $statement = $this->db->prepare("delete from item where id = ?");
        $statement->execute([$id]);
    }

    public function deleteCompleted()
    {
        $statement = $this->db->prepare("delete from item where done is true");
        $statement->execute();
    }

    public function setAllCompleted() {
        $statement = $this->db->prepare("update item set done = true where done is false");
        $statement->execute();
    }

    public function setAllActive() {
        $statement = $this->db->prepare("update item set done = false where done is true");
        $statement->execute();
    }

    public function toggle($id) {
        $statement = $this->db->prepare("update item set done = if (done, 0, 1) where id = ?");
        $statement->execute([$id]);
    }

    public function updateContent($id, $content) {
        $statement = $this->db->prepare("update item set content = :content where id = :id");
        $statement->execute([":id" => $id, ":content" => $content]);
    }
}
