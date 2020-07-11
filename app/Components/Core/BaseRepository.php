<?php
namespace App\Components\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    /**
     * @var static|mixed Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function get($params = [], $with = [], $callable=null)
    {
        $q = $this->model->with($with);

        // call the function if provided
        if(!is_null($callable)) $q = call_user_func_array($callable,[&$q]);

        $q->orderBy($params['order_by'] ?? 'id', $params['order_sort'] ?? 'desc');

        if(array_key_exists('per_page', $params) && ($params['per_page']==-1)) $params['per_page'] = 999999999999;

        return $q->paginate($params['per_page'] ?? 10);
    }

    /**
     * @param array $data
     * @return Model|boolean
     */
    public function create(array $data = [])
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes)
    {
        $model = $this->find($id);

        if(!$model) return false;

        return $model->update($attributes);
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws \Exception
     */
    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * @param int $id
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|Model[]|null|static
     */
    public function find(int $id, $with = [])
    {
        return $this->model->with($with)->find($id);
    }

    /**
     * @param int $id
     * @return mixed|Model|boolean
     */
    public function findWithTrash(int $id)
    {
        return $this->model->withTrashed()->find($id);
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return mixed|Model|static
     */
    public function findBy($field, $value)
    {
        return $this->model->where($field,$value)->first();
    }
}