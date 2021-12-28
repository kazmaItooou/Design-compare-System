<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeforeAqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('before_aq', function (Blueprint $table) {
            $table->char('student_id')->primary()->comment('学籍番号');
            $table->char('token')->unique()->comment('one time トークン');
            $table->dateTime('experimet_datetime')->unique()->comment('実験日時');
            $table->char('e-mail')->nullable()->comment('メールアドレス');
            $table->integer('grade')->comment('学年（5はその他）');
            $table->char('exam_state')->comment('情報処理技術者学習状況');
            $table->char('is_phone')->comment('アクセス端末がスマホ');
        });

        Schema::create('end_aq', function (Blueprint $table) {
            $table->char('token')->primary()->comment('one time トークン');
            $table->char('selected_layout')->comment('良いと思ったレイアウト');
            $table->text('reason')->comment('選択理由');

            $table->foreign('token')->references('token')->on('before_aq');
        });

        Schema::create('basic_layout_aq', function (Blueprint $table) {
            $table->char('token')->primary()->comment('one time トークン');
            $table->integer('striking_symbol')->comment('最も目を引く要素');
            $table->integer('usability_num')->comment('集中のしやすさ');
            $table->text('positive_impression')->comment('デザインの良いと思った点');
            $table->text('negative_impression')->comment('デザインの悪いと思った点');
            $table->text('other_impression')->comment('その他感想');

            $table->foreign('token')->references('token')->on('before_aq');
        });

        Schema::create('bad_layout_aq', function (Blueprint $table) {
            $table->char('token')->primary()->comment('one time トークン');
            $table->integer('striking_symbol')->comment('最も目を引く要素');
            $table->integer('usability_num')->comment('集中のしやすさ');
            $table->text('positive_impression')->comment('デザインの良いと思った点');
            $table->text('negative_impression')->comment('デザインの悪いと思った点');
            $table->text('other_impression')->comment('その他感想');

            $table->foreign('token')->references('token')->on('before_aq');
        });

        Schema::create('test_result', function (Blueprint $table) {
            $table->char('token')->comment('one time トークン');
            $table->char('first_layout')->comment('初めにテストするレイアウト');
            $table->char('layout')->comment('使用レイアウト');
            $table->integer('qpat')->comment('問題パターン');
            $table->integer('qnum')->comment('問題番号');
            $table->boolean('iscorrect')->comment('正答か否か(1なら正答)');
            $table->double('time_required')->comment('回答に掛かった時間/s');

            $table->foreign('token')->references('token')->on('before_aq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('basic_layout_aq');

        Schema::dropIfExists('bad_layout_aq');
        Schema::dropIfExists('end_aq');

        Schema::dropIfExists('test_result');

        Schema::drop('before_aq');

    }
}
