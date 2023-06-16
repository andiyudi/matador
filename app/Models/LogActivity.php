<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'user_id'
    ];

    public function logActivityLists($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function addToLog($subject, $url, $method, $ip, $agent, $userId)
    {
        $this->create([
            'subject' => $subject,
            'url' => $url,
            'method' => $method,
            'ip' => $ip,
            'agent' => $agent,
            'user_id' => $userId,
        ]);
    }
}
