<?php

namespace App\Repositories;

use App\LineBotSession;

class LineBotSessionRepository
{
    /**
     * line data['source']
     *
     * @param array $data
     */
    public function saveSession(array $data): void
    {
        switch ($data['source']['type']) {
            case 'group':
                break;
            case 'room':
                break;
            default:
                LineBotSession::create([
                    'user_id' => $data['source']['userId'],
                    'type' => $data['source']['type'],
                    'last_activity' => time(),
                ]);
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
                return LineBotSession::where('user_id', $data['source']['userId'])->first();
        }
    }

    /**
     *
     * @param LineBotSession $model
     * @return void
     */
    public function modifyLastActivity(LineBotSession $model): void
    {
        $model->last_activity = time();
        $model->save();
    }
}
