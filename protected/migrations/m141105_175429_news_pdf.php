<?php

class m141105_175429_news_pdf extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('News', 'docs', "TEXT NOT NULL COMMENT 'Документы в JSON'");
    }

    public function safeDown()
    {
        $this->dropColumn('News', 'docs');
    }
}