<?php

namespace App\Infrastructure\Model;

use App\Domain\Url\Url as DomainUrl;
use Carbon\Carbon;
use Database\Factories\UrlFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $uuid
 * @property string $origin
 * @property string $destination
 * @property int $visit_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static self|null find(string $uuid)
 * @method static Builder|Url newModelQuery()
 * @method static Builder|Url newQuery()
 * @method static Builder|Url query()
 * @method static Builder|Url whereCreatedAt($value)
 * @method static Builder|Url whereDestination($value)
 * @method static Builder|Url whereOrigin($value)
 * @method static Builder|Url whereUpdatedAt($value)
 * @method static Builder|Url whereUuid($value)
 * @method static Builder|Url whereVisitCount($value)
 */
class Url extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected static function newFactory(): UrlFactory
    {
        return new UrlFactory();
    }

    public function toDomainEntity(): DomainUrl
    {
        return new DomainUrl(
            $this->uuid,
            $this->origin,
            $this->destination,
            $this->visit_count,
            $this->created_at,
            $this->updated_at
        );
    }

    public function fillFromDomainEntity(DomainUrl $url): self
    {
        $this->origin = $url->origin;
        $this->destination = $url->destination;
        $this->visit_count = $url->visitCount;
        $this->created_at = $url->createdAt;
        $this->updated_at = $url->updatedAt;

        return $this;
    }
}
