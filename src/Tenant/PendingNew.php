<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Make;
use BinarCode\Tenantable\Models\Tenant;
use Illuminate\Contracts\Support\Arrayable;

class PendingNew implements Arrayable
{
    use Make;

    protected bool $create = true;

    protected string $name;

    protected string $database;

    protected string $subdomain;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function database(string $database)
    {
        $this->database = $database;

        return $this;
    }

    public function subdomain(string $subdomain)
    {
        $this->subdomain = $subdomain;

        return $this;
    }

    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Handle the object's destruction.
     *
     * @return void
     */
    public function __destruct()
    {
        if ($this->create) {
            /** * @var Tenant $query */
            $query = tenant();
            $query->create($this->toArray());
        }
    }


    public function toArray()
    {
        return [
            'name' => $this->name,
            'database' => $this->database,
            'subdomain' => $this->subdomain,
        ];
    }
}
