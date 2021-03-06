<?php

namespace Bookkeeper\Finance;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Nicolaslopezj\Searchable\SearchableTrait;

class Transaction extends Eloquent {

    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'amount', 'account_id', 'job_id',
        'received', 'excluded', 'notes', 'created_at'
    ];

    /**
     * Searchable columns.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name' => 10
        ]
    ];

    /**
     * Scope for request filter
     *
     * @param Builder $query
     * @param string $type
     * @return Builder
     */
    public function scopeFilteredByType(Builder $query, $type = null)
    {
        $type = $type ?: request('f', 'all');

        if (in_array($type, ['income', 'expense', 'income-i', 'expense-i']))
        {
            $received = ends_with($type, '-i') ? 0 : 1;
            $type = rtrim($type, '-i');

            $query
                ->whereType($type)
                ->whereReceived($received);
        }

        return $query;
    }

    /**
     * Tags relation
     *
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Accounts relation
     *
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Jobs relation
     *
     * @return BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Presents the amount
     *
     * @return string
     */
    public function presentAmount()
    {
        return currency_string_for($this->amount, $this->account_id);
    }

}
