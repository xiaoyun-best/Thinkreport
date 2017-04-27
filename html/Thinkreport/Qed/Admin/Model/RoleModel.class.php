<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model
{
    public function getRolelist()
    {
        $role = $this->field('tblrole_ID,tblrole_name')->select();
        return $role;
    }
}