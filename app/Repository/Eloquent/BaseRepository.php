<?php 

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface {

    protected $model;

    public function __construct(Model $model) {
        
        $this->model = $model;
    }

    public function get(array $relations = []) {

        return $this->model->with($relations)->get();
    }

    public function find(int $model_id , array $relations = []) {

        return $this->model->with($relations)->findOrFail($model_id);
    }

    public function store(array $data) {

        $model = $this->model->create($data);
        return $model->fresh();
    }

    public function update(int $model_id , array $data) {

        $model = $this->model->findOrFail($model_id);
        $model->update($data);
        return $model->fresh();
    }

    public function destroy(int $model_id) {

        $model = $this->model->findOrFail($model_id);
        return $model->delete($model_id);
    }



}