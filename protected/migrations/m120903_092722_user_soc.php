<?php

class m120903_092722_user_soc extends CDbMigration
{

    public function up()
    {
        $this->addColumn('user', 'google_oauth_id', 'varchar(200) DEFAULT NULL');
        $this->addColumn('user', 'twitter_id', 'varchar(200) DEFAULT NULL');
    }

    public function down()
    {
        echo "m120903_092722_user_soc does not support migration down.\n";
        return false;
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
