<?php
namespace App\Models;
use CodeIgniter\Model;
class SaleModel extends Model
{
    protected $table='sales'; protected $primaryKey='id'; protected $returnType='array';
    protected $allowedFields=['product_id','customer_id','sold_by','quantity','total_price']; protected $beforeInsert=['stampCreatedAt'];
    protected function stampCreatedAt(array $data): array { $data['data']['created_at'] ??= date('Y-m-d H:i:s'); return $data; }
}
