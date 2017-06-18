<?php

use yii\db\Migration;
use yii\db\Schema;


class m141145_145212_create_music_track_list_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('music_list', [
            'id' => Schema::TYPE_PK,
            'genre_id' => Schema::TYPE_INTEGER . '(11) NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'file' => Schema::TYPE_STRING . '(255) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . '(11) NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11) NULL',
        ], $tableOptions);

        $this->addForeignKey(
            'fk-music-list-to-genre',
            'music_list',
            'genre_id',
            'music_genres',
            'id',
            'SET NULL'
        );
    }

    public function down()
    {
        $this->dropTable('music_list');
    }
}