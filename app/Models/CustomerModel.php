<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['full_name', 'email', 'phone'];
    protected $useTimestamps = false;
    protected $beforeInsert = ['stampCreatedAt'];
    protected function stampCreatedAt(array $data): array { $data['data']['created_at'] ??= date('Y-m-d H:i:s'); return $data; }
}
