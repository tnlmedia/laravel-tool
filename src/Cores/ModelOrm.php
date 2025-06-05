<?php

namespace TNLMedia\LaravelTool\Cores;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ModelOrm extends Model
{
    /**
     * @see Model::$table
     */
    protected $table;

    /**
     * @see Model::$primaryKey
     */
    protected $primaryKey = 'id';

    /**
     * @see Model::$keyType
     */
    protected $keyType = 'int';

    /**
     * @see Model::$incrementing
     */
    public $incrementing = true;

    /**
     * @see Model::$perPage
     */
    protected $perPage = 10;

    /**
     * @see HasAttributes::$attributes
     */
    protected $attributes = [];

    /**
     * @see HasAttributes::$casts
     */
    protected $casts = [];

    /**
     * @see HasAttributes::$dateFormat
     */
    protected $dateFormat = 'U';

    /**
     * @see HasTimestamps::$timestamps
     */
    public $timestamps = true;

    /**
     * @see GuardsAttributes::$fillable
     */
    protected $fillable = [];

    /**
     * Presenter instance
     *
     * @var Presenter|null
     */
    protected ?Presenter $presenterInstance = null;

    /**
     * Presenter classname
     *
     * @var string
     */
    protected string $presenter = Presenter::class;

    /**
     * @return string
     * @see HasRelationships::getMorphClass()
     */
    public function getMorphClass()
    {
        return $this->getTable();
    }

    /**
     * Prepare a new or cached presenter instance
     *
     * @return Presenter
     */
    public function present(): Presenter
    {
        if (!$this->presenterInstance) {
            $this->presenterInstance = new $this->presenter($this);
        }
        return $this->presenterInstance;
    }
}
