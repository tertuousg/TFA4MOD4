<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['username', 'full_name', 'password', 'avatar'];
    protected $useTimestamps = false;
    protected $beforeInsert = ['stampCreatedAt'];
    protected function stampCreatedAt(array $data): array { $data['data']['created_at'] ??= date('Y-m-d H:i:s'); return $data; }
}
