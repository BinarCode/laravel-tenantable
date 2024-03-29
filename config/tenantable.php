<?php

use BinarCode\Tenantable\Models\Tenant;

return [
    /**
     * The name of the table in the database.
     */
    'table_name' => 'tenants',

    'related_tenant_column' => env('TENANTABLE_RELATED_TENANT_COLUMN', 'tenant_id'),

    /**
     * Allow the `tenant_id` to be null.
     *
     * If the entry does have null tenant_id, it will be considered as a global entry.
     */
    'allow_nullable_tenant' => env('ALLOW_NULLABLE_TENANT', false),

    /**
     * The base model for tenant.
     */
    'model' => Tenant::class,

    /*
    * Domain for the main application
    */
    'master_domain' => env('MASTER_DOMAIN', 'sample.test'),

    /**
     * Master full qualified name.
     */
    'master_fqdn' => env('MASTER_FQDN', 'admin.sample.test'),

    /**
     * The HTTP protocol.
     */
    'protocol' => env('PROTOCOL', 'https'),

    /*
    * The connection name to reach the a tenant database.
    *
    * Set to `null` to use the default connection.
    */
    'tenant_database_connection_name' => 'mysql',

    /*
     * The connection name to reach the a landlord database
     */
    'master_database_connection_name' => 'mysql',

    /*
     * Path to the migrations for the master connection
     */
    'master_migrations_path' => database_path('migrations/master'),

    /*
     * Whetever to create a new user per database or use the default tenants one
     */
    'create_database_user' => false,

    /*
     * Whetever to drop the database when deleting tenant
     */
    'drop_database' => env('APP_ENV') === 'local',

    /*
     * When creating a new tenant, whetever to drop the database if that already exist
     */
    'override_existing_database' => true,

    /*
     * This key will be used to bind the current tenant in the container.
     */
    'container_key' => 'tenant',


    /*
     * This key will be used to bind current database prefix key
     * Generated name: e.g. tenant_ . $tenant->key()
     */
    'database_name_prefix' => 'tenant_',

    /*
     * This is pipeline list of actions to perform when a new tenant was created
     */
    'created_pipeline' => [
        //
    ],

    /*
     * This is pipeline list of actions to perform when a tenant was removed
     */
    'deleted_pipeline' => [
        //
    ],

    /*
     * This is pipeline list of actions when a tenant becomes active
     */
    'activating_pipeline' => [
        BinarCode\Tenantable\Tenant\CachePipe::class,
        BinarCode\Tenantable\Tenant\ContainerPipe::class,
        BinarCode\Tenantable\Tenant\AuthGuardPipe::class,
    ],

];
