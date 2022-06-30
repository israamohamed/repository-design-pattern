<?php 

namespace App\Repository;

interface EloquentRepositoryInterface {

    public function get(array $relations = []);

    public function find(int $model_id , array $relation = []);

    public function store(array $data);

    public function update(int $model_id , array $data);

    public function destroy(int $model_id);

}