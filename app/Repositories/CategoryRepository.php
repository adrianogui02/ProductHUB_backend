<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class CategoryRepository implements CrudInterface
{
    public User | null $user;

    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    public function getAll(): Paginator
    {
        return $this->user->categories()
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate(10);
    }

    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 12;
        return Category::orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    public function searchCategory($keyword, $perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 10;

        return Category::where('name', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    public function create(array $data): Category
    {
        $data['user_id'] = $this->user->id;
        return Category::create($data);
    }

    public function delete(int $id): bool
    {
        $category = Category::find($id);
        if (empty($category)) {
            return false;
        }

        $category->delete();
        return true;
    }

    public function getByID(int $id): Category|null
    {
        return Category::with('user')->find($id);
    }

    public function update(int $id, array $data): Category|null
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return null;
        }

        $category->update($data);
        return $this->getByID($category->id);
    }
}
