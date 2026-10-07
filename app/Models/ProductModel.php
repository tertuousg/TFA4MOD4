<?php
namespace App\Models;
use CodeIgniter\Model;
class ProductModel extends Model
{
    protected $table='products'; protected $primaryKey='id'; protected $returnType='array';
    protected $allowedFields=['name','price','stock_quantity','image']; protected $beforeInsert=['stampCreatedAt'];
    protected function stampCreatedAt(array $data): array { $data['data']['created_at'] ??= date('Y-m-d H:i:s'); return $data; }
}
