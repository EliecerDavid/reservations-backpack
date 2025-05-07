<?php

namespace App\Models;

use App\Observers\RoomObserver;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([RoomObserver::class])]
class Room extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function isAvailableInDateRange(Carbon $start, Carbon $end): bool
    {
        $existsReservations = $this->reservations()
            ->notRejected()
            ->where(function (Builder $query) use ($start, $end) {
                $query->whereBetween('reservation_start', [$start, $end])
                    ->orWhereBetween('reservation_end', [$start, $end]);
            })
            ->exists();

        return $existsReservations === false;
    }
}
