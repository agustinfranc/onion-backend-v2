<?php

namespace App\Repositories;

use App\Models\CommerceBranch;

class CommerceBranchRepository
{
    public function getOne(CommerceBranch|int $commerceBranch): CommerceBranch
    {
        if (is_int($commerceBranch)) {
          return CommerceBranch::find($commerceBranch);
        }

        return $commerceBranch;
    }
}