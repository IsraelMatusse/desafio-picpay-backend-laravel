<?php
namespace App\Repository;

use App\Model\Usuario;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
  
   public function create(array $data);
   public function all();
   public function find();
 
}


?>