<?php

namespace App\Http\Controllers;

class Filters
{
    private $result, $request;

    public function __construct($result, $request)
    {
        $this->result = $result->take($request->take ?? 100);
        $this->request = $request;
    }

    public function search(string $column)
    {
        if ($this->request->search) {
            $this->result->where($column, "like", "%{$this->request->search}%");
        }

        return $this;
    }

    public function afterDate()
    {
        if ($this->request->after_date) {
            $this->result->where("created_at", ">", $this->request->after_date . " 00:00:00");
        }

        return $this;
    }

    public function beforeDate()
    {
        if ($this->request->before_date) {
            $this->result->where("created_at", "<", $this->request->before_date . " 00:00:00");
        }

        return $this;
    }

    public function result()
    {
        return $this->result;
    }
}
