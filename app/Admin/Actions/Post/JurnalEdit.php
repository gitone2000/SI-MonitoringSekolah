<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class JurnalEdit extends RowAction
{
    public $name = 'Jurnal';

    // public function handle(Model $model)
    // {
    //     // $model ...

    //     return $this->response()->success('Success message.')->refresh();
    // }

    public function href(){
        return route('admin.jadwal.edit',$this->getKey());
    }

}
