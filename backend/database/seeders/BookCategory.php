<?php

class BookCategory
{
    public string $FICTION = 'Fiction';
    public string $NOVEL = 'Novel';
    public string $TEXT_BOOK = 'Text-Book';
    public string $HISTORY = 'History';
    public string $SCIENCE = 'Science';
    public string $FANTASY = 'Fantasy';
    public array $Category = ['Fiction', 'Novel', 'Text-Book', 'History', 'Science', 'Fantasy'];

    public function getCategory()
    {
        $randomNumber = mt_rand(0, 5);
        return $this->Category[$randomNumber];
    }
}
