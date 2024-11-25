<?php

namespace App\Controllers;

use App\Models\User;
use App\Requests\Request;
use App\Responses\JsonResponse;
use Database\Connection;

class UserController
{
    public function create(Request $request): JsonResponse
    {
        $name = $request->getQueryParam('name') ?? $request->getPostParam('name');
        $surname = $request->getQueryParam('surname') ?? $request->getPostParam('surname');

        if (!$name || !$surname) {
            return new JsonResponse(['error' => 'Name and surname are required'], 400);
        }

        $user = new User(['name' => $name, 'surname' => $surname]);
        $user->save();
        
        return new JsonResponse([
            'message' => 'User created successfully',
            'user' => $user->toArray()
        ]);
    }

    public function read(Request $request): JsonResponse
    {
        $id = $request->getRouteParams()[0];
        
        $user = User::find($id);
        
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }
        
        return new JsonResponse(['user' => $user->toArray()]);
    }

    public function update(Request $request): JsonResponse
    {
        $id = $request->getRouteParams()[0]; 
        
        $user = User::find($id);
        
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }
        
        $name = $request->getQueryParam('name') ?? $request->getPostParam('name');
        $surname = $request->getQueryParam('surname') ?? $request->getPostParam('surname');

        if ($name) $user->name = $name;
        if ($surname) $user->surname = $surname;
        
        $user->save();
        
        return new JsonResponse([
            'message' => 'User updated successfully',
            'user' => $user->toArray()
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->getRouteParams()[0]; 
        
        $user = User::find($id);
        
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }
        
        $connection = Connection::getInstance();
        $connection->getPDO()->prepare("DELETE FROM users WHERE id = :id")
            ->execute(['id' => $id]);
            
        return new JsonResponse(['message' => 'User deleted successfully']);
    }
}
