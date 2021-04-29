<?php

namespace App\Models;

use CodeIgniter\Model;

class PotlatchItem extends Model {
    protected $table = 'item';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = ['potlatch_id', 'title', 'description', 'expiration', 'published'];
}

?>