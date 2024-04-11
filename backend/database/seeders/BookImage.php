<?php

class BookImage
{
    public array $ImageUrl = [
        'https://m.media-amazon.com/images/I/51c4QW3+HfL.jpg',
        'https://m.media-amazon.com/images/I/71nsY8QKNCL._AC_UF894,1000_QL80_.jpg',
        'https://m.media-amazon.com/images/I/51uqS5M6KtL.jpg',
        'https://images.booksense.com/images/129/860/9798889860129.jpg  ',
        'https://m.media-amazon.com/images/I/41DUYpLnKAL.jpg',
        'https://notionpress.com/coveruploads/411799256resize_cover_498572.png',
        'https://m.media-amazon.com/images/I/61HwGVfo+oL._AC_UF1000,1000_QL80_.jpg',
        'https://dynamic.indigoimages.ca/v1/books/books/9798854216326/1.jpg?width=810&maxHeight=810&quality=85',
        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTRYdW0gjTSHgxQERYPKpMNodyQ5DhaWhQUYg&usqp=CAU',
        'https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2FHymnals-New-Dec102020.png?alt=media&token=8ffa8c28-abd1-4f98-b21a-d8c6b1a96841',
    ];

    public function getImageUrl()
    {
        $randomNumber = mt_rand(0, 8);
        return $this->ImageUrl[$randomNumber];
    }
}
