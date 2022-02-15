<?php

namespace Unit;

use App\Models\Author;
use App\Models\Category;
use Tests\TestCase;

class ModuleTest extends TestCase
{

    private Author $author;
    private Category $category;
    private News $news;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $author = new Author();
        $author->name = 'DemoAuthor';
        $author->save();

        $category = new Category();
        $category->name = 'demoCategory';
        $category->save();

        $news = new News();
        $news->title = 'DemoTitle';
        $news->source = 'url';
        $news->author_id = $author->id;
        $news->description = 'DemoDescription';
        $news->url = 'demo.url?message=sdsdsdfsdkfjal;dkj;lkjalkdjsad;lgsajd;ldkgjsal;gkjas;dl';
        $news->image_url = 'demo.url?message=sdsdsdfsdkfjal;dkj;lkjsdsddsdsssssssssssssssssalkdjsad;lgsajd;ldkgjsal;gkjas;dl';

        $news->category_id = $category->id;
        $news->published_at = new DateTime('@' . strtotime('2021-10-28T12:21:33z')); //TZ time format
        $news->content = 'content                     cv                          end';

        $news->save();


        $this->author = $author;
        $this->category = $category;
        $this->news = $news;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFind(): void
    {
        $news2 = News::with(['author', 'category'])->where('title', 'DemoTitle')->first();

        $this->assertEquals('news', $news2->typename);
        $this->assertEquals('DemoAuthor', $news2->author->name);
        $this->assertEquals('demoCategory', $news2->category->name);
    }


    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setDown(): void
    {
        parent::setDown();

        $this->news->delete();
        $this->author->delete();
        $this->category->delete();
    }
}
