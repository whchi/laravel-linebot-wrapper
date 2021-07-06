<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinebotContextModel extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'room_id',
        'session_type',
        'last_activity',
    ];

    public function saveSession(array $data): void
    {
        switch ($data['source']['type']) {
            case 'room':
            case 'group':
                break;
            default:
                $this::create(
                    [
                        'user_id' => $data['source']['userId'],
                        'session_type' => $data['source']['type'],
                        'last_activity' => time(),
                    ]
                );
                break;
        }
    }

    /**
     * line event data
     *
     * @param array $data
     * @return void
     */
    public function getSession(array $data)
    {
        switch ($data['source']['type']) {
            case 'group':
            case 'room':
                // not implement yet
                break;
            default:
                return $this->where('user_id', $data['source']['userId'])
                            ->first();
        }
    }

    /**
     *
     * @return void
     */
    public function updateLastActivity(): void
    {
        $this->last_activity = now();
        $this->save();
    }
}
