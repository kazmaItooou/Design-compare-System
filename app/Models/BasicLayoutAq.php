<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicLayoutAq extends Model
{
    use HasFactory;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'basic_layout_aq';
    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = 'token';

    protected $guarded = [];
}
