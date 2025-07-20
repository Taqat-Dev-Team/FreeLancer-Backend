<?php

namespace Tests\Feature\API\User;

class DeleteUserTest extends BaseUserTest
{
    public function testDeleteItemTestUserByGuest()
    {
        $user = $this->createUser();
        $item = $this->makeItem($user);
        $item->save();

        $this->deleteJson($this->makeURI($item->id))
            ->assertStatus(404);
    }

    public function testDeleteItemTestUserByUser()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        $item = $this->makeItem($user);
        $item->save();

        $this->deleteJson($this->makeURI($item->id))
            ->assertStatus(404);
    }
}
