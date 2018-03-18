<?php

namespace Todos\Model;

class ItemModel {

    private $itemRepository;

    /** @param $itemRepository ItemRepository */
    public function __construct($itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function findAll() {

        $allItems = $this->itemRepository->findAll();

        $activeItemsCount = 0;
        $completedItemsCount = 0;
        foreach ($allItems as $item) {
            if ($item->done) {
                ++$completedItemsCount;
            }
            else {
                ++$activeItemsCount;
            }
        }

        $itemsList = new ItemsList();
        $itemsList->items = $allItems;
        $itemsList->activeItemsCount = $activeItemsCount;
        $itemsList->completedItemsCount = $completedItemsCount;

        return $itemsList;
    }

    public function create($content)
    {
        if (trim($content) == '')
        {
            throw new IllegalArgumentException("Содержимое не может быть пустым");
        }

        $item = new Item();
        $item->content = $content;

        $this->itemRepository->save($item);
    }

    public function update($id, $content, $state)
    {
        if ($id && trim($content) != '') {
            $this->itemRepository->updateContent($id, $content);
        }
        elseif ($id && $state == 'toggle') {
            $this->itemRepository->toggle($id);
        }
        elseif ($state == 'active') {
            $this->itemRepository->setAllActive();
        }
        elseif ($state == 'completed') {
            $this->itemRepository->setAllCompleted();
        }
        else {
            throw new IllegalArgumentException("Неверные входные параметры");
        }
    }

    public function remove($id) {
        $this->itemRepository->delete($id);
    }

    public function removeCompleted() {
        $this->itemRepository->deleteCompleted();
    }
}
