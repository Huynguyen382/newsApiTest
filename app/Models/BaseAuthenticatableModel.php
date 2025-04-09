<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class BaseAuthenticatableModel extends Authenticatable
{
    /**
     * Get all records
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return static::all();
    }

    /**
     * Find a record by ID
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function findById($id)
    {
        return static::find($id);
    }

    /**
     * Create a new record
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function createRecord(array $data)
    {
        return static::create($data);
    }

    /**
     * Update a record
     *
     * @param int $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function updateRecord($id, array $data)
    {
        $record = static::find($id);
        if ($record) {
            $record->update($data);
        }
        return $record;
    }

    /**
     * Delete a record
     *
     * @param int $id
     * @return bool
     */
    public static function deleteRecord($id)
    {
        $record = static::find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    /**
     * Find records by a specific column value
     *
     * @param string $column
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function findByColumn($column, $value)
    {
        return static::where($column, $value)->get();
    }
} 