<?php

namespace App\Services\API\Search;

use App\Models\Base\Task as TaskEntity;

class TaskSearchService
{
    /**
     * Search and filter based on the given options.
     *
     * @param array $options
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchAll(array $options)
    {
        $options = array_merge([
            'is_asc' => false,
            'max' => 20,
            'status' => null,
            'with_project' => false,
        ], $options);

        $query = TaskEntity::query();

        if (!is_null($options['status'])) {
            $query->where('status', $options['status']);
        }

        if ($options['with_project'] === true)
        {
            $query->with('project');
        }

        $orderDirection = $options['is_asc'] ? 'asc' : 'desc';
        $query->orderBy('updated_at', $orderDirection);

        return $query->paginate($options['max']);
    }

    public function searchOne($id)
    {
        if (!isset($id)) {
            throw new \InvalidArgumentException('id is required');
        }

        $task = TaskEntity::where('id', $id)
            ->firstOrFail();

        return $task;
    }
}
