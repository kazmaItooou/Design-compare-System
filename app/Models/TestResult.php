<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'test_result';
    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = 'student_id';

    protected $guarded = [];
}
