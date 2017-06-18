<?php

use yii\db\Migration;
use yii\db\Schema;


class m141145_145211_create_music_genres_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('music_genres', [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER . ' unsigned NULL',
            'name' => Schema::TYPE_STRING . '(80) NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'image' => Schema::TYPE_STRING . '(80) NULL',
            'position' => Schema::TYPE_SMALLINT . '(10) unsigned NULL',
            'is_active' => 'tinyint(1) NULL',
            'created_at' => Schema::TYPE_INTEGER . '(11) NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11) NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('music_genres');
    }
}