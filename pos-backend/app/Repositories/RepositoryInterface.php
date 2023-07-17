<?php
namespace App\Repositories;

interface RepositoryInterface
{
    public function all($columns = ['*']);

    public function paginate($columns = ['*'], $conditions = null, $relations = [], $limit = null);

    public function getAll($columns = ['*'], $conditions = null, $relations = [], $ordeBy = []);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function toggleStatus($id);

    public function show($id, $columns = ['*'], $relations);

    public function with($relations);

}
