<?php

class m150529_073215_panorams_2015_05_01 extends CDbMigration
{
	public function up()
	{
		$this->execute("INSERT INTO `Panorama` (`createDate`, `swf`, `mov`, `visible`, `version`) VALUES ('2015-05-01', 'a.swf', '', 1, 2)");
		$this->execute("INSERT INTO `Panorama` (`createDate`, `swf`, `mov`, `visible`, `version`) VALUES ('2015-05-01', 'b.swf', '', 1, 2)");
		$this->execute("INSERT INTO `Panorama` (`createDate`, `swf`, `mov`, `visible`, `version`) VALUES ('2015-05-01', 'c-1.swf', '', 1, 2)");
		$this->execute("INSERT INTO `Panorama` (`createDate`, `swf`, `mov`, `visible`, `version`) VALUES ('2015-05-01', 'd2-1.swf', '', 1, 2)");
	}

	public function down()
	{
		$this->execute("DELETE FROM `Panorama` WHERE `createDate`='2015-05-01' AND `swf` IN ('a.swf', 'b.swf', 'c-1.swf', 'd2-1.swf')");
	}
}