<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class HashIdTest extends TestCase
{
    /** @test */
    public function we_get_at_least_six_characters_back_as_the_hashid()
    {
        $fakeUser1 = new FakeUser(1);

        $this->assertTrue(strlen($fakeUser1->getIdHashAttribute()) >= 6);
    }

    /** @test */
    public function we_get_a_different_six_char_string_back_for_different_model_ids()
    {
        $fakeUser1 = new FakeUser(1);
        $fakeUser2 = new FakeUser(2);

        $this->assertNotEquals($fakeUser1->getIdHashAttribute(), $fakeUser2->getIdHashAttribute());
    }

    /** @test */
    public function we_get_the_same_hashid_back_each_time_for_the_same_model()
    {
        $fakeUser1 = new FakeUser(1);

        $this->assertEquals($fakeUser1->getIdHashAttribute(), $fakeUser1->getIdHashAttribute());
    }
}
