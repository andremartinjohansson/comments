<?php

namespace Anax\Comments;

use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    public function testBBCODE()
    {
        $filter = new Filter();
        $html = $filter->bbcode2html("[p]test[/p]");
        $this->assertEquals("<p>test</p>", $html);
    }
}
